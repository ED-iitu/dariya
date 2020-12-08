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
    </style>
</head>
<body>
<div data-role="page" id="home" data-theme="a" data-fullscreen="true">
    <div data-role="popup" id="settingPopup" data-theme="a" class="ui-corner-all">
            <div style="padding:10px 20px;">
                <h3>Настройки</h3>
                <div class="ui-field-contain">
                    <label for="light">Яркость</label>
                    <input type="range" name="light" id="light" value="100" min="0" max="200" oninput="setLight(this.value)" onchange="setLight(this.value)">
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
                        <div id="page-{{$page->page}}" data-page-number="{{$page->page}}" data-book-id="{{$page->book->id}}" class="page @if(in_array($page->page,$bookmarks)) marked @endif" @if(in_array($page->page,$bookmarks)) style="position: relative" @endif>
                            @if(in_array($page->page,$bookmarks)) <img style="position: absolute;right: 2px;top: 2px;" width="14" height="18" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAASCAYAAABrXO8xAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAOVJREFUOI3tkz9KA3EQRt/MT8VgFTb+KVYv4AHMFazFVqxSiXgEj2DEyspeLLxE2FVbL2ACIqidGGJmxiYRExQ2rfjq7/ENw4wMb+vb4noO5FSjF+otsTLrziCN6c6NpbT1IlUMK7MA1nXGpi/+xT8uRievRSevVRbjZnnNysaxp/6Dp/dHK7J23NU3pnMyuj3UaXqKI0J2gPmp3AcSV2py4koxIX5jIMi1qLWx1Hf1FiF7wOKPjcATcKERZ9J87U2MX6ysutg+cMDom2RYZCUqp2np+VI2Gfy2DIC4Z8HeGrt4HH4CmWBVnyRr+ycAAAAASUVORK5CYII=" alt="active-book-mark"> @endif
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
                    <a href="#bars" data-icon="bullets" data-transition="slide">
                        Меню
                    </a>
                </li>
                <li>
                    <a href="#quations" id="page-navigator" data-total-page="{{ $book_pages->total() }}" data-icon="check" data-transition="slide">
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
<div data-role="page" id="bars" data-theme="a">
    <div data-role="header" data-position="fixed" data-add-back-btn="true" data-back-btn-text="Назад" data-theme="a">
        <h1>{{ $book->name }}</h1>
    </div>
    <div data-role="main" class="ui-content" data-theme="a">
        <div data-role="tabs" id="tabs">
            <div data-role="navbar">
                <ul>
                    <li><a href="#one" data-ajax="false">one</a></li>
                    <li><a href="#two" data-ajax="false">two</a></li>
                </ul>
            </div>
            <div id="one" class="ui-body-d ui-content">
                <ul data-role="listview" data-inset="true">
                        
                    <li><a href="home#page-1">Acura</a></li>
                        
                    <li><a href="home#page-2">Audi</a></li>
                        
                    <li><a href="#">BMW</a></li>
                        
                    <li><a href="#">Cadillac</a></li>
                        
                    <li><a href="#">Ferrari</a></li>
                </ul>
            </div>
            <div id="two">
                <h1>Second tab contents</h1>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    let zoom = 1;
    let light = 0;
    function applyZoom(){
        $('#page-content').css('zoom',zoom);
    }
    function applyLight(){
        if(light > 0){
            $('#page-content').css('filter','brightness(' + light + '%)');
        }
    }

    function setLight(value){
        light = value;
        applyLight();
    }
    $('#font').change(function () {
        var optionSelected = $(this).find('option:selected');
        var optValueSelected = optionSelected.val();
        $('#page-content').css('font-family', optValueSelected);
    });
    $('#zoom button').bind('click', function () {
        let type = $(this).data('zoom');
        if(type === 'increase'){
            if(Number(zoom) < 2.5){
                zoom = Number(zoom) + 0.2;
            }
        }else{
            if(Number(zoom) > 0.5){
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

                .on('scrollfy:scroll:begin', function(e) {
                    $(this).removeClass('up down').addClass(e.scrollfy.direction);
                })

                .on('scrollfy:inView', function(e) {
                    console.log('inview');
                    if ( !$(this).hasClass('inview') ) {
                        let page = $(this).data('page-number');
                        let total_page = $('#page-navigator').data('total-page');
                        let hash = $('input[name="hash"]').val();
                        $('#page-navigator').text(page + ' из ' + total_page);
                        $('input[name="page"]').val(page);
                        if(page > 0){
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

                .on('scrollfy:offView', function(e) {
                    console.log('offview');
                    if ( $(this).hasClass('inview') ) {
                        $(this).removeClass('inview');
                    }
                })

                .on('scrollfy:scroll:end', function(e) {
                    $(this).removeClass('up down');
                })

                .scrollfy();
        });
    });

    $(window).on('scrollfy:scroll',function(e) {
        if ( e.scrollfy.direction =='up' ) {
            $('body').removeClass('down').addClass('up');
        }else if ( e.scrollfy.direction =='down' ) {
            $('body').removeClass('up').addClass('down');
        }
    });

    $('body').on('pageinit', '#home', function( evt, ui ) {

    });
    $(function() {
        $('.lazy').Lazy({
            afterLoad: function(element) {
                $(element).find('div.page').each(function () {
                    $(this).addClass('down')

                        .on('scrollfy:scroll:begin', function(e) {
                            $(this).removeClass('up down').addClass(e.scrollfy.direction);
                        })

                        .on('scrollfy:inView', function(e) {
                            console.log('inview');
                            if ( !$(this).hasClass('inview') ) {
                                let page = $(this).data('page-number');
                                let total_page = $('#page-navigator').data('total-page');
                                let hash = $('input[name="hash"]').val();
                                $('#page-navigator').text(page + ' из ' + total_page);
                                $('input[name="page"]').val(page);
                                if(page > 0){
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

                        .on('scrollfy:offView', function(e) {
                            console.log('offview');
                            if ( $(this).hasClass('inview') ) {
                                $(this).removeClass('inview');
                            }
                        })

                        .on('scrollfy:scroll:end', function(e) {
                            $(this).removeClass('up down');
                        })

                        .scrollfy();
                });
            },
        });
        var instance = $('.lazy').data("ajax");
    });
</script>
</body>
</html>
