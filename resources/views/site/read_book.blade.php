<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$book->name}}</title>
    <script src="{{ asset('js/vendor/jquery-3.2.1.min.js') }}"></script>
{{--    <script src="{{ asset('js/vendor/on-scrolled-to.min.js') }}"></script>--}}
    <script src="{{ asset('js/vendor/jquery.scrollfy.min.js') }}"></script>
    <script type="text/javascript">

        var page = {!! $data['current_page'] !!};
        var zoom = 1;
        var quotes = {!! json_encode($quotes) !!};
        window.addEventListener("message", message => {
            if (message.data.text === 'setting') {
                document.showBookReaderSettings();
            }
            if (message.data.text === 'setting_close') {
                document.hideBookReaderSettings();
            }
            if (message.data.text === 'init') {
                page = message.data.page;
            }
        });
        document.showBookReaderSettings = function(){
            document.getElementById('book-settings').style.display = 'block';
        };
        document.hideBookReaderSettings = function(){
            document.getElementById('book-settings').style.display = 'none';
        };
        document.toggleBookReaderSettings = function () {
            $('#book-bar').hide();
            $('#book-settings').toggle();
        };
        document.toggleBookReaderBar = function () {
            $('#book-settings').hide();
            $('#book-bar').toggle();
        };
        function setReadPage(element){
            let currentPage = element.parentElement.getAttribute('data-page');
            page = currentPage;
            console.log(page);
            if(typeof window.ReactNativeWebView !== 'undefined') {
                window.ReactNativeWebView.postMessage(
                    JSON.stringify({  "page": page, "close" : true }));
            }
        }

        document.addEventListener("DOMContentLoaded", function(event) {
            $('html, body').animate({
                scrollTop: $("#page_" + page).offset().top
            }, 1000);
            jQuery.extend({
                highlight: function (node, re, nodeName, className) {
                    if (node.nodeType === 3) {
                        var match = node.data.match(re);
                        if (match) {
                            var highlight = document.createElement(nodeName || 'span');
                            highlight.className = className || 'highlight';
                            var wordNode = node.splitText(match.index);
                            wordNode.splitText(match[0].length);
                            var wordClone = wordNode.cloneNode(true);
                            highlight.appendChild(wordClone);
                            wordNode.parentNode.replaceChild(highlight, wordNode);
                            return 1; //skip added node in parent
                        }
                    } else if ((node.nodeType === 1 && node.childNodes) && // only element nodes that have children
                        !/(script|style)/i.test(node.tagName) && // ignore script and style nodes
                        !(node.tagName === nodeName.toUpperCase() && node.className === className)) { // skip if already highlighted
                        for (var i = 0; i < node.childNodes.length; i++) {
                            i += jQuery.highlight(node.childNodes[i], re, nodeName, className);
                        }
                    }
                    return 0;
                }
            });

            jQuery.fn.unhighlight = function (options) {
                var settings = { className: 'highlight', element: 'span' };
                jQuery.extend(settings, options);

                return this.find(settings.element + "." + settings.className).each(function () {
                    var parent = this.parentNode;
                    parent.replaceChild(this.firstChild, this);
                    parent.normalize();
                }).end();
            };

            jQuery.fn.highlight = function (words, options) {
                var settings = { className: 'highlight', element: 'span', caseSensitive: false, wordsOnly: false };
                jQuery.extend(settings, options);

                if (words.constructor === String) {
                    words = [words];
                }
                words = jQuery.grep(words, function(word, i){
                    return word != '';
                });
                words = jQuery.map(words, function(word, i) {
                    return word.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
                });
                if (words.length == 0) { return this; };

                var flag = settings.caseSensitive ? "" : "i";
                var pattern = "(" + words.join("|") + ")";
                if (settings.wordsOnly) {
                    pattern = "\\b" + pattern + "\\b";
                }
                var re = new RegExp(pattern, flag);

                return this.each(function () {
                    jQuery.highlight(this, re, settings.element, settings.className);
                });
            };
            var book_content = $('.book_content');
            book_content.highlight(quotes);
            $('#light-settings').change( function() {
                let value = $(this).val();
                $('.book_content').css('filter','brightness(' + value + '%)');
                console.log(value);
            });
            $('.zoom_settings').click(function () {
                let type = $(this).data('to');
                console.log(zoom);
                if(type === 'increase'){
                    console.log(Number(zoom));
                    zoom = Number(zoom) + 0.1;
                }else{
                    zoom = Number(zoom) - 0.1;
                }
                console.log(zoom);
                applyZoom();
            });
            $('.background_settings').click(function () {
                let bgcolor = $(this).data('background');
                let color = $(this).data('color');

                book_content.css('background',bgcolor);
                book_content.css('color',color);
            });
            book_content.bind("mouseup", function () {
                showMenu(event);
            });
            $('span').bind("pointerup", function (event) {
                showMenu(event);
            });

            $( '#add-to-quote' ).on('click', function () {
                let text = $('input[name="text"]').val();
                console.log(text);
                let page = $('input[name="page"]').val();
                let hash = $('input[name="hash"]').val();
                $.ajax({
                    type: "POST",
                    url: '{{ route('add_quote') }}',
                    data: {
                        text: text,
                        page: page,
                        hash: hash
                    },
                    success: function (data) {
                        console.log(text);
                        $('#quotes-list ul').append('<li>' + text + '</li>');
                        book_content.highlight(text);
                    }
                });
                $(this).closest('#select-menu').hide();
            });
            $('#copy-selected-text').on('click', function () {
                let text = $(this).data('text');
                copyTextToClipboard(text);
                $(this).closest('#select-menu').hide();
            });

            $('#add-bookmark').on('click', function () {
                $('#book-bar').hide();
                $('#book-settings').hide();
                $('#bookmark-input').toggle();
                $('#bookmark-input input').focus();
            });

            $('#save-bookmark').on('click', function () {
                let name = $('#bookmark-input input').val();
                let page = $('input[name="page"]').val();
                let hash = $('input[name="hash"]').val();
                console.log(name);
                if(name !== ''){
                    $.ajax({
                        type: "POST",
                        url: '{{ route('add_book_marks') }}',
                        data: {
                            page: page,
                            hash: hash,
                            name: name
                        },
                        success: function (data) {
                            console.log(data.message);
                            $('#bookmark-input input').val('');
                            $('#bookmark-input').hide();
                            $('#bookmarks-list ul').append('<li>' + name + ' [' + page + ' - страница]</li>');
                        }
                    });
                }
            });

            $('.book-bar-nav-list li:first-child').on('click', function () {
                $('.book-bar-nav-list li').removeClass('active')
                $(this).addClass('active');
                $('#bookmarks-list').toggle();
                $('#quotes-list').toggle();
            });
            $('.book-bar-nav-list li:last-child').on('click', function () {
                $('.book-bar-nav-list li').removeClass('active')
                $(this).addClass('active');
                $('#bookmarks-list').toggle();
                $('#quotes-list').toggle();
            });

            $('div.page')
                .addClass('down')

                .on('scrollfy:scroll:begin', function(e) {
                    $(this).removeClass('up down').addClass(e.scrollfy.direction);
                })

                .on('scrollfy:inView', function(e) {
                    if ( !$(this).hasClass('inview') ) {
                        let page = $(this).data('page');
                        let hash = $('input[name="hash"]').val();
                        $('#current-page').text(page);
                        $('input[name="page"]').val(page);
                        $.ajax({
                            type: "POST",
                            url: '{{ route('save_book_state') }}',
                            data: {
                                page: page,
                                hash: hash
                            },
                            success: function (data) {
                                console.log(data.message);
                            }
                        });
                        $(this).delay(100).addClass('inview');
                    }
                })

                .on('scrollfy:offView', function(e) {
                    if ( $(this).hasClass('inview') ) {
                        $(this).removeClass('inview');
                    }
                })

                .on('scrollfy:scroll:end', function(e) {
                    $(this).removeClass('up down');
                })

                .scrollfy();
            $(window).on('scrollfy:scroll',function(e) {
                if ( e.scrollfy.direction =='up' ) {
                    $('body').removeClass('down').addClass('up');
                }else if ( e.scrollfy.direction =='down' ) {
                    $('body').removeClass('up').addClass('down');
                }
            });
        });

        function messageFlash(message) {
            $('#message p').text(message);
            $('#message').show();
            setTimeout(function () {
                $('#message').hide()
            },1500);
        }

        function applyZoom(){
            $('.book_content').css('zoom',zoom);
        }

        function fallbackCopyTextToClipboard(text) {
            var textArea = document.createElement("textarea");
            textArea.value = text;

            // Avoid scrolling to bottom
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                console.log('Fallback: Copying text command was ' + msg);
            } catch (err) {
                console.error('Fallback: Oops, unable to copy', err);
            }

            document.body.removeChild(textArea);
        }
        function copyTextToClipboard(text) {
            if (!navigator.clipboard) {
                fallbackCopyTextToClipboard(text);
                return;
            }
            navigator.clipboard.writeText(text).then(function() {
                console.log('Async: Copying to clipboard was successful!');
            }, function(err) {
                console.error('Async: Could not copy text: ', err);
            });
        }

        function getHighlight() {

            var selection = window.getSelection(); // 1.

            var object = {
                parent : null,
                text   : '',
                rect   : null
            };
            // If selection is not empty.
            if ( selection.rangeCount > 0 ) {
                object = {
                    text   : selection.toString().trim(), // get the text.
                    parent : selection.anchorNode.parentNode, // get the element wrapping the text.
                    rect   : selection.getRangeAt(0).getBoundingClientRect() // get the bounding box.
                };
            }

            return object; // 2.
        }



        function showMenu(event) {
            var select_menu = $( '#select-menu' );
            // 1.
            var highlight = getHighlight();
            // console.log(highlight);
            // 2.
            if ( highlight.text === '' ) {

                select_menu.hide();
                select_menu.css('left', 0);
                select_menu.css('top', 0);

                return;
            }

            // 4.
            var width = ( highlight.rect.width / 2 ) - 55;
            /**
             * The "42" is acquired from our select_menu buttons width devided by 2.
             */
            var left = Math.abs((screen.width - $('#select-menu').width()) - highlight.rect.width) + 'px';
            //var left = ( highlight.rect.left + width ) + 'px';
            var top = ( event.currentTarget.offsetTop - 40 ) + 'px';

            let page = $(highlight.parent).closest('.page').data('page');
            let text = highlight.text;

            $( '#select-menu' ).find('li').each(function () {
                $('input[name="text"]').val(text);
                $('input[name="page"]').val(page);
            });

            select_menu.show();
            select_menu.css('left',left);
            select_menu.css('top', top);
            /**
             * "40" is the height of our select_menu buttons.
             * Herein, we lift it up above the higlighted area top position.
             */
        }

        function checkVisible(elm) {
            var rect = elm.getBoundingClientRect();
            var viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
            return !(rect.bottom < 0 || rect.top - viewHeight >= 0);
        }
    </script>
</head>
<body>
    <style type="text/css">
        body{
            position: relative;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        .book_content{
            padding: 15px;
        }
        .book_content .marked{
           border: 2px solid #fdcc22;
            padding: 5px;
        }
        #bookmark-input{
            position: fixed;
            background: #ffffff;
            left: 30px;
            right: 30px;
            bottom: 70px;
            font-size: 22px;
            padding: 0px;
            box-shadow: 0px -4px 10px rgba(0, 0, 0, 0.1);
            z-index: 1500;
            display: none;
        }
        #bookmark-input ul{
            margin: 0;
            padding: 0;
        }
        #bookmark-input ul li{
            list-style-type: none;
            border-bottom: 1px solid #E8E8E8;
            line-height: inherit;
            font-size: 16px;
            padding: 10px;
        }
        #bookmark-input ul li:first-child{
            text-align: center;
        }
        #bookmark-input ul li input{
            width: 95%;
            padding: 5px;
            border: 1px solid #ccc;
        }
        #bookmark-input ul li:last-child{
            text-align: right;
        }
        #bookmark-input ul li button{
            padding: 8px 10px;
            text-align: center;
            background: #606B8B;
            color: #FFFFFF;
            border-radius: 5px;
            font-family: SF UI Display;
            font-style: normal;
            font-weight: 600;
            font-size: 14px;
            border: 0;
        }
        #book-bar{
            position: fixed;
            background: #ffffff;
            top: 0;
            left: 0;
            right: 0;
            bottom: 40px;
            font-size: 22px;
            padding: 0px;
            box-shadow: 0px -4px 10px rgba(0, 0, 0, 0.1);
            z-index:1500;
            display: none;
        }
        .bar-block{
            margin: 0;
            padding: 0;
        }
        .bar-item{
            list-style-type: none;
            border-bottom: 1px solid #E8E8E8;
        }
        .bar-item:first-child{
            text-align: center;
            line-height: inherit;
            font-size: 16px;
            padding: 10px;
        }
        .bar-item:last-child{
            overflow-y: auto;
            height: 82vh;
        }
        .book-bar-nav-list ul{
            padding: 0;
            margin: 0px auto;
            display: table;
            width: 90%;
            border-spacing: 5px;
        }
        .book-bar-nav-list ul li{
            list-style-type: none;
            display: table-cell;
            padding: 5px;
            text-align: center;
            color: #3E4D64;
            background: #F3F3F3;
            border-radius: 5px;
            font-family: SF UI Display;
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 20px;
        }
        .book-bar-nav-list ul li.active{
            background: #606B8B;
            color: #FFFFFF;
        }
        #quotes-list{
            overflow-y: auto;
        }
        #quotes-list ul{
            margin: 0;
            padding: 0;
        }
        #quotes-list ul li{
            list-style-type: none;
            padding: 5px;
            text-align: left;
            color: #3E4D64;
            background: #F3F3F3;
            border-radius: 5px;
            font-family: SF UI Display;
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 20px;
            margin: 10px;
        }
        #bookmarks-list{
            overflow-y: auto;
            display: none;
        }
        #bookmarks-list ul{
            margin: 0;
            padding: 0;
        }
        #bookmarks-list ul li{
            list-style-type: none;
            padding: 5px;
            text-align: left;
            color: #3E4D64;
            background: #F3F3F3;
            border-radius: 5px;
            font-family: SF UI Display;
            font-style: normal;
            font-weight: 400;
            font-size: 16px;
            line-height: 20px;
            margin: 10px;
        }
        #book-settings{
            position: fixed;
            background: #ffffff;
            left: 0;
            right: 0;
            bottom: 40px;
            font-size: 22px;
            padding: 0px;
            box-shadow: 0px -4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 35px 35px 0px 0px;
            z-index:10;
            display: none;
        }
        .settings-block{
            margin: 0;
            padding: 0;
        }
        .settings-item{
            list-style-type: none;
            border-bottom: 1px solid #E8E8E8;
            height: 47px;
            line-height: 47px;
        }
        .settings-item:first-child{
            text-align: center;
            line-height: inherit;
        }
        .settings-item ul{
            padding: 0px;
            margin: 0px;
            display: flex;
        }
        .settings-item ul li{
            list-style-type: none;
        }
        .settings-item ul li:first-child{
            width: 35%;
            font-family: SF UI Display;
            font-style: normal;
            font-weight: normal;
            font-size: 14px;
            color: #3E4D64;
            padding-left: 20px;
        }
        .settings-item ul li:last-child{
            width: 65%;
            text-align: right;
            padding-right: 20px;
        }
        .settings-item ul li:last-child .setting-element{
            font-style: normal;
            font-weight: 600;
            font-size: 18px;
            line-height: 20px;
            /* identical to box height, or 111% */
            padding: 5px 15px;
            align-items: center;
            text-align: center;
            letter-spacing: -0.24px;
        }
        .background-white-setting{
            background: #FFFFFF;
            border: 1px solid #EBEBF2;
            box-sizing: border-box;
            border-radius: 5px;
            transform: matrix(-1, 0, 0, 1, 0, 0);
            color: #3E4D64;
        }
        .background-grey-setting{
            background: #F3F3F3;
            border-radius: 5px;
            color: #3E4D64;
        }
        .background-dark-blue-setting{
            background: #606B8B;
            border-radius: 5px;
            color: #FFFFFF;
        }
        .settings-item ul li:last-child .font{
            font-style: normal;
            font-weight: normal;
            font-size: 18px;
            line-height: 18px;
        /* identical to box height */

            text-align: justify;

            color: #3E4D64;
        }
        .book_top_bar{
            position: fixed;
            /* height: 40px; */
            width: 100%;
            margin: 0;
            padding: 0;
            left: 0;
            right: 0;
            bottom: -1px;
            z-index: 10;
            background: #ffffff;
            line-height: 40px;
            /*border-top: 1px solid #E8E8E8;*/
            box-shadow: 0px -4px 10px rgba(0, 0, 0, 0.1);
        }
        .book_top_bar ul{
            margin: 0;
            padding: 0;
        }
        .book_top_bar ul li{
            list-style-type: none;
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            font-family: SF UI Display;
        }
        .book_top_bar ul li img{
            margin: 0 2px -3px;
        }
        #select-menu {
            display: none;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 500;
        }
        #select-menu ul{
            margin: 0;
            padding: 0;
        }
        #select-menu ul li{
            display: inline-block;
            list-style-type: none;
            padding: 9px 10px;
            color: #FFFFFF;
            background-color: #474747;
            margin-right: -3px;
            font-family: SF UI Display;
            font-style: normal;
            font-weight: normal;
            font-size: 15px;
            line-height: 22px;
            cursor: pointer;
        }
        #select-menu ul li:first-child{
            border-radius: 10px 0px 0px 10px;
        }
        #select-menu ul li:last-child{
            border-radius: 0px 10px 10px 0px;
        }
        #message{
            display: none;
            position: fixed;
            top: 0;
            bottom: 40px;
            left: 0;
            right: 0;
            z-index: 1000;
            background-color: rgb(0 0 0 / 83%);
        }
        #message p{
            text-align: center;
            background-color: #FFFFFF;
            display: block;
            margin-top: 50%;
            width: 70%;
            margin-left: auto;
            margin-right: auto;
            color: #474747;
            padding: 10px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: bold;
        }
        .highlight{
            background-color: yellow;
        }
    </style>
    <input type="hidden" name="hash" value="{{ $hash }}">
    <input type="hidden" name="text" value="">
    <input type="hidden" name="page" value="">
    <div id="message">
        <p></p>
    </div>
    <div id="select-menu">
        <ul>
            <li id="add-to-quote">Цитата</li>
            <li id="copy-selected-text">Копировать</li>
        </ul>
    </div>
    <div id="bookmark-input">
        <ul>
            <li>
                5 страница
                <img style="float: right" onclick="document.toggleBookReaderBar()" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAbklEQVQ4T2NkoDJgpLJ5DEPQQGV5hf93Hz4gyuXY1GLVSIyhuNTgdAk+Q/HJ4fUaNo2EXE8wrJANIGQYKAkSNBCkCGQQiCYmsuhvIFW9TNVIoWqyISY2iU7YxBgGK6GIznqUFGlEJRtSLBj8BgIA3WFYFSSf+yIAAAAASUVORK5CYII=">
            </li>
            <li>
                <input type="text">
            </li>
            <li>
                <button id="save-bookmark">Добавить</button>
            </li>
        </ul>
    </div>
    <div id="book-bar">
        <ul class="bar-block">
            <li class="bar-item book-bar-close">
                {{ $book->name }}
                <img style="float: right" onclick="document.toggleBookReaderBar()" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAAbklEQVQ4T2NkoDJgpLJ5DEPQQGV5hf93Hz4gyuXY1GLVSIyhuNTgdAk+Q/HJ4fUaNo2EXE8wrJANIGQYKAkSNBCkCGQQiCYmsuhvIFW9TNVIoWqyISY2iU7YxBgGK6GIznqUFGlEJRtSLBj8BgIA3WFYFSSf+yIAAAAASUVORK5CYII=">
            </li>
            <li class="bar-item book-bar-nav-list">
                <ul>
{{--                    <li>Оглавление</li>--}}
                    <li class="active">Цитаты</li>
                    <li>Закладки</li>
                </ul>
            </li>
            <li class="bar-item">
                <div id="quotes-list">
                    <ul>
                        @foreach($quotes as $quote)
                            <li>&#171;{{ $quote }}&#187;</li>
                        @endforeach
                    </ul>
                </div>
                <div id="bookmarks-list">
                    <ul>
                        @foreach($bookmarks as $p=>$bookmark)
                            <li>{{ $bookmark }} [ {{$p}} - страница]</li>
                        @endforeach
                    </ul>
                </div>
            </li>
        </ul>
    </div>
    <div id="book-settings">
        <ul class="settings-block">
            <li class="settings-item book-settings-close" onclick="document.hideBookReaderSettings()">
                <svg xmlns="http://www.w3.org/2000/svg" width="38" height="4" viewBox="0 0 38 4" fill="none">
                    <rect width="38" height="4" rx="2" fill="#DDDCE1"/>
                </svg>
            </li>
            <li class="settings-item" style="padding: 0 20px">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" viewBox="0 0 20 19" fill="none">
                    <path d="M1.00468 10.1303H4.84468C4.84468 8.8573 5.35039 7.6364 6.25057 6.73622C7.15074 5.83605 8.37164 5.33033 9.64468 5.33033C10.9177 5.33033 12.1386 5.83605 13.0388 6.73622C13.939 7.6364 14.4447 8.8573 14.4447 10.1303H18.2847C18.5393 10.1303 18.7835 10.2315 18.9635 10.4115C19.1435 10.5915 19.2447 10.8357 19.2447 11.0903C19.2447 11.3449 19.1435 11.5891 18.9635 11.7692C18.7835 11.9492 18.5393 12.0503 18.2847 12.0503H1.00468C0.75007 12.0503 0.50589 11.9492 0.325855 11.7692C0.14582 11.5891 0.0446777 11.3449 0.0446777 11.0903C0.0446777 10.8357 0.14582 10.5915 0.325855 10.4115C0.50589 10.2315 0.75007 10.1303 1.00468 10.1303ZM12.5247 10.1303C12.5247 9.36651 12.2213 8.63397 11.6811 8.09387C11.141 7.55376 10.4085 7.25033 9.64468 7.25033C8.88085 7.25033 8.14831 7.55376 7.60821 8.09387C7.06811 8.63397 6.76468 9.36651 6.76468 10.1303H12.5247ZM9.64468 0.530334L11.9391 3.81353C11.2287 3.55433 10.4511 3.41033 9.64468 3.41033C8.83828 3.41033 8.06068 3.55433 7.35028 3.81353L9.64468 0.530334ZM1.33108 5.33033L5.32468 4.99433C4.74868 5.48393 4.23028 6.07913 3.82708 6.77033C3.40468 7.48073 3.16468 8.21033 3.03028 8.96873L1.33108 5.33033ZM17.9487 5.33033L16.2495 8.96873C16.1151 8.21033 15.8559 7.47113 15.4527 6.77033C15.0495 6.07913 14.5407 5.47433 13.9647 4.98473L17.9487 5.33033ZM10.3263 18.4919L13.3119 15.5063C13.6863 15.1319 13.6863 14.5175 13.3119 14.1431C12.9375 13.7687 12.3327 13.7687 11.9583 14.1431L9.64468 16.4567L7.33108 14.1431C6.95668 13.7687 6.35188 13.7687 5.97748 14.1431C5.60308 14.5175 5.60308 15.1319 5.97748 15.5063L8.96308 18.4919C9.16468 18.6743 9.39508 18.7703 9.64468 18.7703C9.89428 18.7703 10.1247 18.6743 10.3263 18.4919Z" fill="#7C7C7C"/>
                </svg>
                <input id="light-settings" style="width: 82%" max="200" value="100" type="range">
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="19" viewBox="0 0 21 19" fill="none">
                    <path d="M1.86527 10.1303H5.70527C5.70527 8.8573 6.21099 7.6364 7.11116 6.73622C8.01134 5.83605 9.23223 5.33033 10.5053 5.33033C11.7783 5.33033 12.9992 5.83605 13.8994 6.73622C14.7996 7.6364 15.3053 8.8573 15.3053 10.1303H19.1453C19.3999 10.1303 19.6441 10.2315 19.8241 10.4115C20.0041 10.5915 20.1053 10.8357 20.1053 11.0903C20.1053 11.3449 20.0041 11.5891 19.8241 11.7692C19.6441 11.9492 19.3999 12.0503 19.1453 12.0503H1.86527C1.61067 12.0503 1.36649 11.9492 1.18645 11.7692C1.00642 11.5891 0.905273 11.3449 0.905273 11.0903C0.905273 10.8357 1.00642 10.5915 1.18645 10.4115C1.36649 10.2315 1.61067 10.1303 1.86527 10.1303ZM13.3853 10.1303C13.3853 9.36651 13.0818 8.63397 12.5417 8.09387C12.0016 7.55376 11.2691 7.25033 10.5053 7.25033C9.74145 7.25033 9.00891 7.55376 8.46881 8.09387C7.9287 8.63397 7.62527 9.36651 7.62527 10.1303H13.3853ZM10.5053 0.530334L12.7997 3.81353C12.0893 3.55433 11.3117 3.41033 10.5053 3.41033C9.69887 3.41033 8.92127 3.55433 8.21087 3.81353L10.5053 0.530334ZM2.19167 5.33033L6.18527 4.99433C5.60927 5.48393 5.09087 6.07913 4.68767 6.77033C4.26527 7.48073 4.02527 8.21033 3.89087 8.96873L2.19167 5.33033ZM18.8093 5.33033L17.1101 8.96873C16.9757 8.21033 16.7165 7.47113 16.3133 6.77033C15.9101 6.07913 15.4013 5.47433 14.8253 4.98473L18.8093 5.33033ZM11.1869 14.2583L14.1725 17.2439C14.5469 17.6183 14.5469 18.2231 14.1725 18.5975C13.7981 18.9719 13.1933 18.9719 12.8189 18.5975L10.5053 16.2839L8.19167 18.5975C7.81727 18.9719 7.21247 18.9719 6.83807 18.5975C6.46367 18.2231 6.46367 17.6183 6.83807 17.2439L9.82367 14.2583C10.0253 14.0663 10.2557 13.9703 10.5053 13.9703C10.7549 13.9703 10.9853 14.0663 11.1869 14.2583Z" fill="#3B435B"/>
                </svg>
            </li>
            <li class="settings-item" id="backround-settings">
                <ul>
                    <li>Фон</li>
                    <li>
                        <span class="background_settings setting-element background-white-setting" data-background="#FFFFFF" data-color="#3E4D64">Aa</span>
                        <span class="background_settings setting-element background-grey-setting" data-background="#F3F3F3" data-color="#3E4D64">Aa</span>
                        <span class="background_settings setting-element background-dark-blue-setting" data-background="#606B8B" data-color="#FFFFFF">Aa</span>
                    </li>
                </ul>
            </li>
            <li class="settings-item">
                <ul>
                    <li>Шрифт</li>
                    <li>
                        <span class="setting-element font">PT Sans <svg xmlns="http://www.w3.org/2000/svg" width="10" height="15" viewBox="0 0 12 20" fill="none">
<path fill-rule="evenodd" clip-rule="evenodd" d="M2.46286 19.5928L11.7078 10.6788C12.0974 10.3036 12.0974 9.69738 11.7078 9.32117L2.46286 0.407154C1.90053 -0.135718 0.985625 -0.135718 0.422297 0.407154C-0.140034 0.950026 -0.140034 1.8311 0.422297 2.37397L8.33087 10.0005L0.422297 17.6251C-0.140034 18.1689 -0.140034 19.05 0.422297 19.5928C0.985625 20.1357 1.90053 20.1357 2.46286 19.5928Z" fill="#3B435B"/>
</svg></span>
                    </li>
                </ul>
            </li>
            <li class="settings-item">
                <ul>
                    <li>Размер шрифт</li>
                    <li>
                        <span data-to="decrease" class="zoom_settings setting-element background-white-setting">- Aa</span>
                        <span data-to="increase" class="zoom_settings setting-element background-white-setting">+ Aa</span>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="book_top_bar">
        <ul>
            <li style="width: 40px; text-align: center" onclick="document.toggleBookReaderBar()">
                <img width="18" height="18"src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAAACXBIWXMAAACEAAAAhAEwqx0lAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAONJREFUOI3N0zFKQ0EUheFvQkDtFDVqlqALUEGX4g6EoAuwErVObWulbVBEUNAughswtY1EIcb2WcwIL2Ax7yHigcvcC8OZOf8w/DcF7GAPFzjCOrpYyPT4xAm8oUjVxlVpzq1hA4/JeYBX9Gsk6wdMYxNPeE9xt7CcaTLCbY3Df1bAmgi8h3sRcgetTI8xTolsCpH+LM5Uh/3cSI3SWkdFwGop2gPmU7SlTJOP72i/ooAZbJh8/u0KNxrhDm5EPgNM4VB12NdMfpEVXNYwGjaxi32c4wUHmMNiZrQxjjP3/qG+AIifYesogav3AAAAAElFTkSuQmCC" alt="list">
            </li>
            <li style="width: calc(100% - 100px)">
                <span id="current-page">1</span> из {{$book_pages->count()}}
            </li>
            <li style="width: 44px">
                <img id="add-bookmark" width="14" height="18" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAUCAYAAACEYr13AAAA+klEQVQ4T+2UvUoDQRSFv5OZ+AhpNml309nYptBO0N43UAT1TUQCQVmw8RGsBS0stfQPLKIEfAAR1MS5slkjyYo/WwqZaph7zwdzOecKwCeNQ7Dl7F7inJvYlovrbYmNEsLx1if5pG7DFzFfCmIcD2XjgMF17+SvkJFuCpgO8R8YqRpHs0hz/ZveftHiP1rZxY0VydaB1ofwEWxnUPG7XN095CsgD+FkGs0WQKtA7btQSTowUwrhdBJQVEhHFui8hXDmnTaBLWDmS9tnnPNKMKPjQmXv9fb+sthcTaI1QxmoOarlXzAuJNL+i0/pdp9/2wmuGS3JlM1o8R22H5Ldf06SkAAAAABJRU5ErkJggg==" alt="bookmark">
                <img onclick="document.toggleBookReaderSettings()" width="18" height="18" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABIAAAASCAYAAABWzo5XAAACxUlEQVQ4T42UX4hVVRTGf99tIhGCoCKdew5CyTm3t8pQgx5GCEM5ewYHisqIyggR8R8M1EvNPAX9GyhFNLIJDCKp7J6bURT6YEQYKIJ0z9XKOudOBD4IQQ/VvSv2mXuH28z0Z7/szdrr+/Ze3/7WFv8wgjg5iukORAh0QZehe6HIGo8uBdFSwaCWjGA6CZxasD9SZOmSmPlgECWTHlS0GpNBnGwFHfVERZZu8PEgdp54pILu/Smrf9nLt6LVmPL7JVG15hIZae/0WWC4t15E1ItfAW7ya+t27mxfPHFO1dXjgYb+OIkRGDwrmPY3EZrIs/o3g6WF8ejdZjaDuBHTc8gOA8eLLN2isOZeNWOvxHTeTPetun185Y/ffvCzJxiOxu6rVOxWGX92OpydvVQ/O0jcL1doTEHsTOIXumzPW+nxfmKpgfT8APA3zF7yGvZj1TjZLnSwrGAQIDGRN9OXB2Lfy3jF4HfEVi+2ZPfnzcZnQew+BTYCv2L2UCl2Hyhji79VELn3EeOGHmxn9WNlTs29gPEMYlfRTF8PYzdtsAfZhqLZOLWASA/nrfq71ci9JfE4xuailX4yd5h7CvGG0LY8qx8JIncI8fQ80TyofEub9L4I49EnDXsT4xLYO1R0Hcb6sjRjbd5Kz4S10bfN7LESJpyqsftBsNzMHmm3Gl/8i9j+oKlBscM4ecLQETNmFEZuh4kDwGtFlu4evm0snP3uo9wThrVko6FYXTomnS6y+vnSFsNuuZ8r1/M5cI+/pVas3nTz0DXXngaLMNuPtNPgMmKq3Uxn/mbIyO3oignBLZi92LPHnCHnXqRsUi/qMuD/tMhV4AbgqmloXbv5YWugad0msHVeg2o8+oCw95ZqWrqd9cXFE18HcTIh2fm8+bH301zTLhwD38iivf/8RhaRRcmkpLsM1vgeF/qqi471Dbow/y/dc0H3dCTXegAAAABJRU5ErkJggg==" alt="settings">
            </li>
        </ul>
    </div>
    <div class="book_content">
        @foreach($book_pages as $k=>$page)
            <div id="page_{{$page->page}}" data-page="{{$page->page}}" data-book-id="{{$page->book->id}}" class="page @if(in_array($page->page,$bookmarks)) marked @endif" @if(in_array($page->page,$bookmarks)) style="position: relative" @endif>
                @if(in_array($page->page,$bookmarks)) <img style="position: absolute;right: 2px;top: 2px;" width="14" height="18" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAASCAYAAABrXO8xAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAOVJREFUOI3tkz9KA3EQRt/MT8VgFTb+KVYv4AHMFazFVqxSiXgEj2DEyspeLLxE2FVbL2ACIqidGGJmxiYRExQ2rfjq7/ENw4wMb+vb4noO5FSjF+otsTLrziCN6c6NpbT1IlUMK7MA1nXGpi/+xT8uRievRSevVRbjZnnNysaxp/6Dp/dHK7J23NU3pnMyuj3UaXqKI0J2gPmp3AcSV2py4koxIX5jIMi1qLWx1Hf1FiF7wOKPjcATcKERZ9J87U2MX6ysutg+cMDom2RYZCUqp2np+VI2Gfy2DIC4Z8HeGrt4HH4CmWBVnyRr+ycAAAAASUVORK5CYII=" alt="active-book-mark"> @endif
                {!! str_replace(['<body>', '</body>'],'',$page->content) !!}
                <hr>
            </div>
        @endforeach
    </div>

</body>
</html>