<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Caveat&family=Libre+Baskerville&family=PT+Sans&family=Roboto:wght@100&family=Ubuntu:wght@300&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/jquery.mobile-1.4.5.min.css') }}"/>
    <script src="{{ asset('js/jquery-1.11.1.min.js') }}"></script>
    <script src="{{ asset('js/vendor/jquery.scrollfy.min.js') }}"></script>
    <script src="{{ asset('js/jquery.mobile-1.4.5.min.js') }}"></script>
    <script src="{{ asset('js/jquery.lazy.min.js') }}"></script>
    <script src="{{ asset('js/jquery.lazy.ajax.min.js') }}"></script>

    <title>Document</title>
    <style type="text/css">
        #page-content {
            font-family: 'PT Sans', sans-serif;
        }

        #settingPopup-popup {
            width: 90%;
            left: 5%;
            right: 5%
        }

        #barsPopup-popup {
            width: 90%;
            left: 5%;
            right: 5%;
        }

        .ui-tabs {
            height: 500px;
        }

        .ui-tabs-panel {
            height: 80%;
            overflow-y: auto !important;
            padding: 16px;
        }

        #highlight_menu {
            font-size: 18px;
            color: #fff;
            border-radius: 5px;
            background: rgba(0,0,0,.8);
            position: absolute;
            user-select: none;
            -moz-user-select: none;
            -webkit-user-select: none;
            z-index: 10;
        }

        .highlight_menu_animate {
            transition: top 75ms ease-out,left 75ms ease-out;
        }

        .social-share {
            width: 100%;
            padding:0;
            margin:10px;
            margin-top:14px;
        }

        .social-share li {
            display: inline;
            padding: 10px;
        }

        .caret {
            border-style: solid;
            border-width: 10px 10px 0px 10px;
            border-bottom-color: transparent;
            border-left-color: transparent;
            border-top-color: rgba(0,0,0,.8);
            border-right-color: transparent;
            width: 0px;
            height: 0px;
            display: block;
            position: absolute;
            top: 53px;
            left: 45%;
        }
    </style>
</head>
<body>
<div data-role="page" id="home" data-theme="a" data-fullscreen="true">
    <div id="highlight_menu" style="display:none;">

        <ul class="social-share">
            <li id="add-to-quote">Цитата</li>
            <li id="copy-selected-text">Копировать</li>
        </ul>

        <div class="caret">
        </div>

    </div>
    <div data-role="popup" id="barsPopup" data-theme="a" class="ui-corner-all">
        <div style="padding:10px 20px;">
            <a href="#" data-rel="back"
               class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
            <h3 style="text-align: center;margin: 5px;">Меню</h3>
            <div data-role="tabs" id="tabs">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#quotes-list" data-ajax="false">Цитаты</a></li>
                        <li><a href="#bookmarks-list" data-ajax="false">Закладки</a></li>
                    </ul>
                </div>
                <div id="quotes-list" class="ui-body-d ui-content">

                    <ul data-role="listview" data-inset="true">
                        @foreach($quotes as $p => $quote)
                            <li><a href="#page-{{$p}}">&#171;{{ $quote }}&#187;</a></li>
                        @endforeach 
                    </ul>
                </div>
                <div id="bookmarks-list">
                    <ul data-role="listview" data-inset="true">
                        @foreach($bookmarks as $p=>$bookmark)
                            <li><a href="#page-{{$p}}">{{ $bookmark }} [ {{$p}} - страница]</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div data-role="popup" id="settingPopup" data-theme="a" class="ui-corner-all">
        <div style="padding:10px 20px;">
            <a href="#" data-rel="back"
               class="ui-btn ui-corner-all ui-shadow ui-btn-a ui-icon-delete ui-btn-icon-notext ui-btn-right">Close</a>
            <h3 style="text-align: center;margin: 5px;">Настройки</h3>
            <div class="ui-field-contain">
                <label for="light">Яркость</label>
                <input type="range" name="light" id="light" value="100" min="0" max="200" oninput="setLight(this.value)"
                       onchange="setLight(this.value)">
            </div>
            <div class="ui-field-contain">
                <label for="background">Фон</label>
                <div class="ui-field-contain">
                    <fieldset data-role="controlgroup" data-type="horizontal">
                        <button class="ui-shadow ui-btn ui-corner-all">Aa</button>
                        <button class="ui-shadow ui-btn ui-corner-all">Aa</button>
                        <button class="ui-shadow ui-btn ui-corner-all">Aa</button>
                    </fieldset>
                </div>
            </div>
            <div class="ui-field-contain">
                <label for="font" class="select">Шрифт</label>
                <select name="font" id="font" data-native-menu="false">
                    <option value="'PT Sans', sans-serif">PT Sans</option>
                    <option value="'Caveat', cursive">Caveat</option>
                    <option value="'Libre Baskerville', serif">Libre Baskerville</option>
                    <option value="'Roboto', sans-serif">Roboto</option>
                    <option value="'Ubuntu', sans-serif">Ubuntu</option>
                </select>
            </div>
            <div class="ui-field-contain">
                <label for="zoom">Размер шрифта</label>
                <div class="ui-field-contain">
                    <fieldset id="zoom" data-role="controlgroup" data-type="horizontal">
                        <button data-zoom="decrease" class="ui-shadow ui-btn ui-corner-all">-Aa</button>
                        <button data-zoom="increase" class="ui-shadow ui-btn ui-corner-all">+Aa</button>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
    <div data-role="main" id="page-content" class="ui-content" data-theme="a">
        <input type="hidden" name="hash" value="{{ $hash }}">
        <input type="hidden" name="text" value="1">
        <input type="hidden" name="page" value="">
        @foreach($url_range as $p => $url)
            @if($book_pages->currentPage() == $p)
                <div>
                    @foreach($book_pages as $k =>$page)
                        <div id="page-{{$page->page}}" data-page-number="{{$page->page}}"
                             data-book-id="{{$page->book->id}}"
                             class="page @if(in_array($page->page,$bookmarks)) marked @endif"
                             @if(in_array($page->page,$bookmarks)) style="position: relative" @endif>
                            @if(in_array($page->page,$bookmarks)) <img style="position: absolute;right: 2px;top: 2px;"
                                                                       width="14" height="18"
                                                                       src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAASCAYAAABrXO8xAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAOVJREFUOI3tkz9KA3EQRt/MT8VgFTb+KVYv4AHMFazFVqxSiXgEj2DEyspeLLxE2FVbL2ACIqidGGJmxiYRExQ2rfjq7/ENw4wMb+vb4noO5FSjF+otsTLrziCN6c6NpbT1IlUMK7MA1nXGpi/+xT8uRievRSevVRbjZnnNysaxp/6Dp/dHK7J23NU3pnMyuj3UaXqKI0J2gPmp3AcSV2py4koxIX5jIMi1qLWx1Hf1FiF7wOKPjcATcKERZ9J87U2MX6ysutg+cMDom2RYZCUqp2np+VI2Gfy2DIC4Z8HeGrt4HH4CmWBVnyRr+ycAAAAASUVORK5CYII="
                                                                       alt="active-book-mark"> @endif
                            {!! str_replace(['<body>', '</body>'],'',$page->content) !!}
                            <hr>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="lazy" data-loader="ajax" data-src="{{ $url }}"></div>
            @endif
        @endforeach
    </div>
    <div data-role="footer" data-id="main-menu" data-position="fixed" data-theme="a">
        <div data-role="navbar">
            <ul>
                <li>
                    <a href="#barsPopup" data-rel="popup" data-icon="bullets" data-position-to="window"
                       data-transition="pop">
                        Меню
                    </a>
                </li>
                <li>
                    <a href="javascript:;" id="add-to-bookmark" data-total-page="{{ $book_pages->total() }}"
                       data-icon="check" data-transition="slide">
                        1 из {{ $book_pages->total() }}
                    </a>
                </li>
                <li>
                    <a href="#settingPopup" data-rel="popup" data-position-to="window" data-icon="gear"
                       data-transition="slide">
                        Настройки
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<script type="text/javascript">
    let zoom = 1;
    let light = 0;

    function applyZoom() {
        $('#page-content').css('zoom', zoom);
    }

    function applyLight() {
        if (light > 0) {
            $('#page-content').css('filter', 'brightness(' + light + '%)');
        }
    }

    function setLight(value) {
        light = value;
        applyLight();
    }

    function flashMessage(message, textonly = true){
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
        navigator.clipboard.writeText(text).then(function() {
            console.log('Async: Copying to clipboard was successful!');
        }, function(err) {
            console.error('Async: Could not copy text: ', err);
        });
    }

    function selectText(menu){
        var s = document.getSelection(),
            r = s.getRangeAt(0);
        if (r && s.toString()) {
            $('input[name="text"]').val(s.toString().trim());
            var p = r.getBoundingClientRect();
            if (p.left || p.top) {
                menu.css({
                    left: (p.left + (p.width / 2)) - (menu.width() / 2),
                    top: (p.top - menu.height() - 10),
                    display: 'block',
                    opacity: 0
                })
                    .animate({
                        opacity:1
                    }, 300);

                setTimeout(function() {
                    menu.addClass('highlight_menu_animate');
                }, 10);
                return;
            }
        }
        menu.animate({ opacity:0 }, function () {
            menu.hide().removeClass('highlight_menu_animate');
        });
    }

    var menu = $('#highlight_menu');
    $('#add-to-bookmark').on('click', function () {
        let page = $('input[name="page"]').val();
        let hash = $('input[name="hash"]').val();
        $.ajax({
            type: "POST",
            url: '{{ route('add_book_marks') }}',
            data: {
                page: page,
                hash: hash,
                name: name
            },
            success: function (data) {
                flashMessage(data.message);
                let bm= $('#bookmarks-list ul');
                bm.append('<li><a href="#page-' + page + '">' + data.data.name + ' [ ' + page + ' - страница]</a></li>');
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
        $('#page-content').css('font-family', optValueSelected);
    });
    $('#zoom button').bind('click', function () {
        let type = $(this).data('zoom');
        if (type === 'increase') {
            if (Number(zoom) < 2.5) {
                zoom = Number(zoom) + 0.2;
            }
        } else {
            if (Number(zoom) > 0.5) {
                zoom = Number(zoom) - 0.2;
            }
        }
        applyZoom();
    });
    $(document).ready(function () {
        applyZoom();
        applyLight();
        $('#page-content').find('div.page').each(function () {
            $(this).addClass('down')

                .on('scrollfy:scroll:begin', function (e) {
                    $(this).removeClass('up down').addClass(e.scrollfy.direction);
                })

                .on('scrollfy:inView', function (e) {
                    console.log('inview');
                    if (!$(this).hasClass('inview')) {
                        let page = $(this).data('page-number');
                        let atb = $('#add-to-bookmark');
                        let total_page = atb.data('total-page');
                        let hash = $('input[name="hash"]').val();
                        atb.text(page + ' из ' + total_page);
                        $('input[name="page"]').val(page);
                        if (page > 0) {
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
                        }
                        $(this).delay(100).addClass('inview');
                    }
                })

                .on('scrollfy:offView', function (e) {
                    console.log('offview');
                    if ($(this).hasClass('inview')) {
                        $(this).removeClass('inview');
                    }
                })

                .on('scrollfy:scroll:end', function (e) {
                    $(this).removeClass('up down');
                })

                .scrollfy();
        });
    });

    $(window).on('scrollfy:scroll', function (e) {
        if (e.scrollfy.direction == 'up') {
            $('body').removeClass('down').addClass('up');
        } else if (e.scrollfy.direction == 'down') {
            $('body').removeClass('up').addClass('down');
        }
    });
    var bp = $("#barsPopup");
    bp.on("popupafterclose", function (event, ui) {
        $('body').css('overflow-y', 'auto');
    });
    bp.on("popupafteropen", function (event, ui) {
        $('body').css('overflow-y', 'hidden');
    });
    var sp = $("#settingPopup");
    sp.on("popupafterclose", function (event, ui) {
        $('body').css('overflow-y', 'auto');
    });
    sp.on("popupafteropen", function (event, ui) {
        $('body').css('overflow-y', 'hidden');
    });

    $(function () {

        $('#page-content').find('.page').each(function () {
            $(this).on('mouseup taphold', function (evt) {
                selectText(menu);
            });
        });

        $( '#add-to-quote' ).on('click', function () {
            let text = $('input[name="text"]').val();
            let page = $('input[name="page"]').val();
            let hash = $('input[name="hash"]').val();
            flashMessage('идет сохранение ...', false);
            $.ajax({
                type: "POST",
                url: '{{ route('add_quote') }}',
                data: {
                    text: text,
                    page: page,
                    hash: hash
                },
                success: function (data) {
                    flashMessage(data.message);
                    let q = $('#quotes-list ul');
                    q.append('<li>' + text + '</li>');
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

        var lz = $('.lazy');
        lz.Lazy({
            afterLoad: function (element) {
                $(element).find('div.page').each(function () {
                    $(this).on('mouseup taphold', function (evt) {
                        selectText(menu);
                    });
                    $(this).addClass('down')

                        .on('scrollfy:scroll:begin', function (e) {
                            $(this).removeClass('up down').addClass(e.scrollfy.direction);
                        })

                        .on('scrollfy:inView', function (e) {
                            console.log('inview');
                            if (!$(this).hasClass('inview')) {
                                let page = $(this).data('page-number');
                                let total_page = $('#add-to-bookmark').data('total-page');
                                let hash = $('input[name="hash"]').val();
                                $('#add-to-bookmark').text(page + ' из ' + total_page);
                                $('input[name="page"]').val(page);
                                if (page > 0) {
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
                                }
                                $(this).delay(100).addClass('inview');
                            }
                        })

                        .on('scrollfy:offView', function (e) {
                            console.log('offview');
                            if ($(this).hasClass('inview')) {
                                $(this).removeClass('inview');
                            }
                        })

                        .on('scrollfy:scroll:end', function (e) {
                            $(this).removeClass('up down');
                        })

                        .scrollfy();
                });
            },
        });
    });
</script>
</body>
</html>
