<script type="text/javascript">
    var config = {
        page: {{ (!empty($data['page'])) ? $data['page'] : 1 }},
        book_id: {{ $book->id }},
        totalPage: {{ $book_pages->total() }},
        zoom: {{ (!empty($data['zoom'])) ? $data['zoom'] : 1 }},
        light: {{ (!empty($data['light'])) ? $data['light'] : 0 }},
        font: '{{ (!empty($data['font'])) ? $data['font'] : "'PT Sans', sans-serif" }}',
        hash: '{{ $hash }}'
    };
    var abt = document.getElementById('add-to-bookmark');
    var observerCallback = (entries, observer, header) => {
        entries.forEach((entry, i) => {
            if (entry.isIntersecting) {
                setPage(entry.target.dataset.pageNumber);
            }else{
                console.log('out')
            }
        });
    };
    const observer = new IntersectionObserver(
        observerCallback,
        {
            root: null,
            threshold: 0.2
        });
    @php
        $functions = [];
    @endphp
    @foreach(array_values($url_range) as $key=>$url)
    @if($key > 0)
    @php
        $functions[] = 'load_page_' . $key . '()';
    @endphp
    function load_page_{{$key}}() {
        let key = 'page_{{ $book->id }}_{{$key}}';
        let pages = localStorage.getItem(key);
        let page_content = $('#page-content');
        if(pages){
            page_content.append(pages);
            document.getElementById('page-content').querySelectorAll('.page').forEach( p => {
                setTimeout(() => observer.observe(p), 100);
            })
            return  true;
        }else{
            return $.get("{{$url}}", function(data) {
                page_content.append(data);
                document.getElementById('page-content').querySelectorAll('.page').forEach( p => {
                    setTimeout(() => observer.observe(p), 100);
                })
                localStorage.setItem(key, data);
            });
        }
    }
    @endif
    @endforeach

    function process() {
        $.when({!! implode(', ', $functions) !!}).then(function(){
            $('#page-content').attr('data-full', true);
        });
    }

    function saveConfig() {
        localStorage.setItem(config.hash, JSON.stringify(config));
    }

    function getConfig() {
        let conf = localStorage.getItem(config.hash);
        return (conf) ? JSON.parse(conf) : {};
    }

    function saveState(){
        let conf = getConfig();
        $.ajax({
            type: "POST",
            url: '{{ route('save_book_state') }}',
            data: conf,
            success: function (data) {
                console.log(data.message);
            }
        });
    }

    function applyZoom() {
        let el = document.getElementById('page-content');
        if(screen.orientation.type === 'landscape-primary'){
            document.querySelector('.setting-panel-header').style.display = 'none';
        }else{
            document.querySelector('.setting-panel-header').style.display = 'block';
        }
        el.style.width = ((window.screen.width /config.zoom) - 32) + 'px';
        transformOrigin = [0,0];
        el = el || instance.getContainer();
        var p = ["webkit", "moz", "ms", "o"],
            s = "scale(" + config.zoom + ")",
            oString = (transformOrigin[0] * 100) + "% " + (transformOrigin[1] * 100) + "%";

        for (var i = 0; i < p.length; i++) {
            el.style[p[i] + "Transform"] = s;
            el.style[p[i] + "TransformOrigin"] = oString;
        }
        document.getElementById('page-content');
        el.style["transform"] = s;
        el.style["transformOrigin"] = oString;
        document.getElementById('page-' + config.page).scrollIntoView()
        saveConfig();
    }

    function setPage(page) {
        abt.innerHTML = page + ' из ' + config.totalPage;
        config.page = page;
        if(typeof window.ReactNativeWebView !== 'undefined') {
            window.ReactNativeWebView.postMessage(JSON.stringify({ "action": "page","page" : page }));
        }
        if(page == config.totalPage){
            if(typeof window.ReactNativeWebView !== 'undefined') {
                window.ReactNativeWebView.postMessage(JSON.stringify({ "action": "end"}));
            }
        }
        saveConfig();
    }

    function flashMessage(message, textonly = true) {
        $.mobile.loading("show", {
            text: message,
            textVisible: true,
            textonly: textonly,
            theme: "b",
            inline: true
        });
        setTimeout(function () {
            $.mobile.loading("hide");
        }, 1300);
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
        navigator.clipboard.writeText(text).then(function () {
            console.log('Async: Copying to clipboard was successful!');
        }, function (err) {
            console.error('Async: Could not copy text: ', err);
        });
    }

    function selectText(menu) {
        var s = document.getSelection(),
            r = s.getRangeAt(0);
        if (r && s.toString()) {
            $('input[name="text"]').val(s.toString().trim());
            var p = r.getBoundingClientRect();
            if (p.left || p.top) {
                let left = (p.left + (p.width / 2)) - (menu.width() / 2);
                menu.css({
                    left: (left > 0) ? left : 0,
                    top: ((p.top + window.scrollY) - menu.height() - 10),
                    display: 'block',
                    opacity: 0
                })
                    .animate({
                        opacity: 1
                    }, 300);

                setTimeout(function () {
                    menu.addClass('highlight_menu_animate');
                }, 10);
                return;
            }
        }
        menu.animate({opacity: 0}, function () {
            menu.hide().removeClass('highlight_menu_animate');
        });
    }

    $( window ).on( "orientationchange", function( event ) {
        console.log( "This device is in " + event.orientation + " mode!" );
        if(event.orientation === 'landscape'){
            $('.setting-panel-header').hide();
        }else{
            $('.setting-panel-header').show();
        }
        applyZoom();
    });

    document.getElementById('close-app').addEventListener('click', function () {
        if(typeof window.ReactNativeWebView !== 'undefined') {
            window.ReactNativeWebView.postMessage(JSON.stringify({ "action": "close" }));
        }
    });
    document.addEventListener('DOMContentLoaded', function () {
        let full = $('#page-content').data('full');
        if(full === false){
            process();
        }
        let storage_config = getConfig();
        config = Object.assign(config, storage_config);

        document.querySelectorAll('.page').forEach(p => {
            setTimeout(() => observer.observe(p), 100);
            // $(p).on('mouseup taphold', function (evt) {
            //
            //     let menu = $('#highlight_menu');
            //     //console.log(menu);
            //     selectText(menu);
            // });
        });
        applyZoom();
        setPage(config.page);
        document.location.href = "#page-" + config.page;
        // var tracks = [];
        // $('#page-content').on("touchmove", function (event) {
        //     if (event.originalEvent.touches.length === 2) {
        //         tracks.push([ [event.originalEvent.touches[0].pageX, event.originalEvent.touches[0].pageY], [event.originalEvent.touches[1].pageX, event.originalEvent.touches[1].pageY] ]);
        //     }
        // }).on("touchstart", function (event) {
        //     tracks = [];
        // }).on("touchend", function ()
        //
        // });
        setInterval(() => saveState(), 10000);
    });
    document.onselectionchange = () => {
        //let menu = $('#highlight_menu');
        //console.log('onselection');
        setTimeout(showMenu, 100);
    };
    $("body").on("taphold",function(){
        setTimeout(showMenu, 100);
    });

    document.addEventListener("message", message => {
        var event = JSON.parse(message.data);
        if (event.action === 'page') {
            localStorage.setItem(event.page, event.content);
        }
        if (event.action === 'process') {
            process();
        }
        if (event.action === 'get_config') {
            if(typeof window.ReactNativeWebView !== 'undefined') {
                window.ReactNativeWebView.postMessage(JSON.stringify({ "config": getConfig() }));
            }
        }
    });

    $(function () {
        var pc = $('#page-content');
        var bp = $("#barsPanel");
        var sp = $("#settingPanel");
        var atq = $('#add-to-quote');
        var atb = $('#add-to-bookmark');
        var p_i = $('input[name="page"]');
        var h_i = $('input[name="hash"]');
        var menu = $('#highlight_menu');
        var lz = $('.lazy');

        // pc.find('.page').each(function () {
        //     $(this).on('mouseup taphold', function (evt) {
        //         selectText(menu);
        //     });
        // });
        $('body').on('click', '#bookmarks-list li', function () {
            bp.panel( "close" );
            let to_page = $(this).data('to-page');
            document.location.href = "#page-" + to_page;
        });
        $('body').on('click', '#quotes-list li', function () {
            bp.panel( "close" );
            let to_page = $(this).data('to-page');
            document.location.href = "#page-" + to_page;
        });
        $('.background_settings').on('click', function () {
            let bgcolor = $(this).data('background');
            let color = $(this).data('color');

            pc.css('background', bgcolor);
            pc.css('color', color);
        });
        atq.on('click', function () {
            var highlight = getHighlight();
            let page = $(highlight.parent).closest('.page').data('page-number');
            let hash = config.hash;
            flashMessage('идет сохранение ...', false);
            $.ajax({
                type: "POST",
                url: '{{ route('add_quote') }}',
                data: {
                    text: highlight.text,
                    page: page,
                    hash: hash
                },
                success: function (data) {
                    flashMessage(data.message);
                    let q = $('#quotes-list ul');
                    q.append('<li data-to-page="' + page + '"><a href="#page-' + page + '">&#171;' + highlight.text + '&#187;</a></li>');
                    q.listview("refresh");
                },
                error: function (data) {
                    flashMessage(data.responseJSON.message);
                }
            });
            menu.hide().removeClass('highlight_menu_animate');
        });
        $('#copy-selected-text').on('click', function () {
            let text = $(this).data('text');
            copyTextToClipboard(text);
            menu.hide().removeClass('highlight_menu_animate');
        });
        atb.on('click', function () {
            let page = config.page;
            let hash = config.hash;
            $.ajax({
                type: "POST",
                url: '{{ route('add_book_marks') }}',
                data: {
                    page: page,
                    hash: hash
                },
                success: function (data) {
                    flashMessage(data.message);
                    let bm = $('#bookmarks-list ul');
                    bm.append('<li data-to-page="' + page + '"><a href="#page-' + page + '">' + data.data.name + ' [ ' + page + ' - страница]</a></li>');
                    bm.listview("refresh");
                },
                error: function (data) {
                    flashMessage(data.responseJSON.message);
                }
            });

        });
        $('#font').change(function () {
            var optionSelected = $(this).find('option:selected');
            var optValueSelected = optionSelected.val();
            config.font = optValueSelected;
            pc.css('font-family', optValueSelected);
            saveConfig();
        });
        $('#zoom button').bind('click', function () {
            let type = $(this).data('zoom');
            if (type === 'increase') {
                if (Number(config.zoom) < 2.5) {
                    config.zoom = Number(config.zoom) + 0.1;
                }
            } else {
                if (Number(config.zoom) > 0.5) {
                    config.zoom = Number(config.zoom) - 0.1;
                }
            }
            applyZoom();
        });
    });

    function getHighlight() {
        var selection = window.getSelection();
        var object = {
            parent : null,
            text   : '',
            rect   : null,
            doc: null
        };
        if (selection.rangeCount > 0) {
            object = {
                text   : selection.toString().trim(), // get the text.
                parent : selection.anchorNode.parentNode, // get the element wrapping the text.
                rect   : selection.getRangeAt(0).getBoundingClientRect(), // get the bounding box.
                doc    : document.body.parentNode.getBoundingClientRect()
            };
        }
        return object;
    }
    var sharing = document.querySelector('.sharing');

    function showMenu() {
        var highlight = getHighlight();
        if (highlight.text === '') {
            sharing.setAttribute('class', 'sharing');
            sharing.style.left = 0;
            sharing.style.top  = 0;
            return;
        }
        var buttonsWidth = 115;
        var width = (highlight.rect.width/2) - buttonsWidth/2;
        sharing.setAttribute('class', 'sharing sharing--shown sharing_animate');
        var left = highlight.rect.left + width > 0 ? highlight.rect.left + width : highlight.rect.left;
        if (left + buttonsWidth > window.screen.width - 55) left = window.screen.width - buttonsWidth - 115;
        sharing.style.left = left + 'px';
        sharing.style.top = (highlight.rect.top - highlight.doc.top - 55) + 'px';
    };
    function hideMenu() {
        sharing.setAttribute('class', 'sharing sharing_animate');
        sharing.style.left = 0;
        sharing.style.top  = 0;
        window.getSelection().empty();
        window.getSelection().removeAllRanges();
        //document.selection.empty();
    };

    function hasClass( target, className ) {
        return new RegExp('(\\s|^)' + className + '(\\s|$)').test(target.className);
    }

    document.addEventListener('touchmove', function(e) {
        if(sharing.style.display === 'block'){
            setTimeout(hideMenu(), 100);
        }
    }, true);
    window.addEventListener('scroll', function(e) {
        if(hasClass(sharing, 'sharing--shown')){
            setTimeout(hideMenu(), 100);
        }
    }, true);
</script>
