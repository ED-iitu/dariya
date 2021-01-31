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
    @include('site.jquery_mobile.style')
    @include('site.jquery_mobile.jquery_js')
    @include('site.jquery_mobile.jquery_mobile_js')
    @include('site.jquery_mobile.custom_style')
    <title>{{ $book->name }}</title>
</head>
<body>
<div id="highlight_menu" class="sharing" style="z-index: 10000;">

    <ul class="social-share">
        <li id="add-to-quote">Цитата</li>
        <li id="copy-selected-text">Копировать</li>
    </ul>

    <div class="caret">
    </div>

</div>
<div data-role="page" id="home" data-theme="a" data-fullscreen="true">

    <div data-role="panel" id="barsPanel" data-theme="a" class="ui-corner-all" data-position-fixed="true">
        <div>
            <h3 style="text-align: center;margin: 5px;">Меню</h3>
            <div data-role="tabs" id="tabs">
                <div data-role="navbar">
                    <ul>
                        <li><a href="#quotes-list" data-ajax="false" class="ui-btn-active">Цитаты</a></li>
                        <li><a href="#bookmarks-list" data-ajax="false">Закладки</a></li>
                    </ul>
                </div>
                <div id="quotes-list" class="ui-body-d ui-content">

                    <ul data-role="listview" data-inset="true">
                        @foreach($quotes as $p => $quote)
                            <li data-to-page="{{ $p }}"><a href="#page-{{$p}}">&#171;{{ $quote }}&#187;</a></li>
                        @endforeach
                    </ul>
                </div>
                <div id="bookmarks-list">
                    <ul data-role="listview" data-inset="true">
                        @foreach($bookmarks as $p=>$bookmark)
                            <li data-to-page="{{ $p }}" data-page-block=""><a href="#page-{{$p}}">[ {{$p}}-стр.] {{ $bookmark }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div data-role="panel" id="settingPanel" data-theme="a" class="ui-corner-all" data-position="right" data-display="overlay" data-position-fixed="true">
        <div>
            <div class="setting-panel-header" style='background-color:{{ $book->background_color }};background-image: url("{{$book_image}}")'>
                <p>{{ $book->name }}</p>
            </div>
            <h3 style="text-align: center;margin: 5px;">Настройки</h3>
            <div class="ui-field-contain">
                <label for="background">Фон</label>
                <div class="ui-field-contain">
                    <fieldset data-role="controlgroup" data-type="horizontal">
                        <button class="background_settings ui-shadow ui-btn ui-corner-all"
                                style="background-color: #FFFFFF;color: #3E4D64;" data-background="#FFFFFF"
                                data-color="#3E4D64">Aa
                        </button>
                        <button class="background_settings ui-shadow ui-btn ui-corner-all"
                                style="background-color: #F3F3F3; color: #3E4D64;" data-background="#F3F3F3"
                                data-color="#3E4D64">Aa
                        </button>
                        <button class="background_settings ui-shadow ui-btn ui-corner-all"
                                style="background-color: #606B8B;color: #FFFFFF;" data-background="#606B8B"
                                data-color="#FFFFFF">Aa
                        </button>
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
    <div data-role="header" data-position="fixed" data-fullscreen="true">
        <a href="#" id="close-app" class="ui-btn ui-shadow ui-corner-all ui-icon-carat-l ui-btn-icon-notext">Закрыть</a>
        <h1>{{ $book->name }}</h1>
    </div>
    <div data-role="main" id="page-content" class="ui-content" data-theme="a" data-full="false">
        <input type="hidden" name="hash" value="{{ $hash }}">
        <input type="hidden" name="text" value="">
        <input type="hidden" name="page" value="{{ (!empty($data['page'])) ? $data['page'] : 1 }}">
        @foreach($book_pages->items() as $page)
            <div id="page-{{$page->page}}" data-page-number="{{$page->page}}"
                 data-book-id="{{$page->book->id}}"
                 @if(in_array($page->page,$bookmarks)) class="page marked" @else class="page" @endif>
                @php
                    echo $page->content;
                @endphp
                <hr>
            </div>
        @endforeach
    </div>
    <div data-role="footer" data-id="main-menu" data-position="fixed" data-theme="a">
        <div data-role="navbar">
            <ul>
                <li>
                    <a href="#barsPanel" data-rel="panel" data-icon="bullets" data-position-to="window"
                       data-transition="pop">
                        Меню
                    </a>
                </li>
                <li>
                    <a href="javascript:;" id="add-to-bookmark" data-total-page="{{ $book_pages->total() }}"
                       data-icon="tag" data-transition="slide">
                        1 из {{ $book_pages->total() }}
                    </a>
                </li>
                <li>
                    <a href="#settingPanel" data-rel="panel" data-position-to="window" data-icon="gear"
                       data-transition="slide">
                        Настройки
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
{{--@include('site.jquery_mobile.script')--}}
<script>
    (function( $ ){
        var config = {};
        var abt, container;
        var methods = {
            init : function( options ) {
                config = $.extend(options, methods.getStorageConfig());
                container = this;
                abt = document.getElementById('add-to-bookmark');
                methods.applyZoom();
                this.find('.page').each(function (){
                    observer.observe(this);
                });
                methods.loadPages();
                methods.setPage(config.page);
            },
            getStorageConfig : () => {
                let conf = localStorage.getItem(config.hash);
                return (conf) ? JSON.parse(conf) : {};
            },
            saveStorageConfig : () => {
                localStorage.setItem(config.hash, JSON.stringify(config));
            },
            observerCallback : (entries, observer, header) => {
                entries.forEach((entry, i) => {
                    if (entry.isIntersecting) {
                        methods.setPage(entry.target.dataset.pageNumber);
                    }
                });
            },
            setPage: (page) => {
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
                methods.saveStorageConfig();
            },
            needHide : (page) => {
                let current_page = config.page;
                if(page > (current_page + 10)){
                    return true;
                }
                return false;
            },
            loadPages : () => {
                var q = config.urlRanges.reduce(function (prev, item) {
                    let page_group = (new URL(item)).searchParams.get('page');
                    let key = 'page_'+ config.book_id + '_' + page_group;
                    let pages = localStorage.getItem(key);
                    if(pages){
                        pages = $(pages);
                        pages.each(function (){
                            if((this instanceof jQuery && this.length) || this instanceof HTMLElement) {
                                let page = this.attributes['data-page-number'].value;
                                if (methods.needHide(page)){
                                    this.hidden = true;
                                }
                                observer.observe(this);
                            }
                        });
                        container.append(pages);
                        return  true;
                    }else{
                        return prev
                            .then(function (results) {
                                return $.ajax(item)
                                    .then(function (result) {
                                        localStorage.setItem(key, result);
                                        let pages = $(result);
                                        pages.each(function (){
                                            if((this instanceof jQuery && this.length) || this instanceof HTMLElement) {
                                                observer.observe(this);
                                            }
                                        });
                                        container.append(pages);
                                        results.push(result)
                                        return results
                                    })
                            });
                    }
                }, $.when([]).then(function(){
                    console.log('when then');
                    $('#page-content').attr('data-full', true);
                }));
            },
            saveState : () => {
                $.ajax({
                    type: "POST",
                    url: config.saveBookStateUrl,
                    data: config,
                    success: function (data) {
                        console.log(data.message);
                    }
                });
            },
            applyZoom : () => {
                // if(screen.orientation.type === 'landscape-primary'){
                //     document.querySelector('.setting-panel-header').style.display = 'none';
                // }else{
                //     document.querySelector('.setting-panel-header').style.display = 'block';
                // }
                //
                // container.css('width', ((window.screen.width /config.zoom) - 32) + 'px');
                // transformOrigin = [0,0];
                // container = container || instance.getContainer();
                // var p = ["webkit", "moz", "ms", "o"],
                //     s = "scale(" + config.zoom + ")",
                //     oString = (transformOrigin[0] * 100) + "% " + (transformOrigin[1] * 100) + "%";
                //
                // for (var i = 0; i < p.length; i++) {
                //     container.css("-" + p[i] + "-transform",s);
                //     container.css("-" + p[i] + "-transformOrigin",oString);
                // }
                // container.css('transform', s);
                // container.css('transformOrigin', oString);
                // let current_page = document.getElementById('page-' + config.page);
                // if(current_page){
                //     current_page.scrollIntoView()
                // }
                // methods.saveStorageConfig();
            },
            update : function( content ) {
                // !!!
            }
        };
        var observer = new IntersectionObserver(
            methods.observerCallback,
            {
                root: container,
                threshold: 0.2
            }
        );
        $.fn.dariyaBookReader = function( method ) {

            // логика вызова метода
            if ( methods[method] ) {
                return methods[ method ].apply( this, Array.prototype.slice.call( arguments, 1 ));
            } else if ( typeof method === 'object' || ! method ) {
                return methods.init.apply( this, arguments );
            } else {
                $.error( 'Метод с именем ' +  method + ' не существует для jQuery.tooltip' );
            }
        };

    })( jQuery );
    var config = {
        page: {{ (!empty($data['page'])) ? $data['page'] : 1 }},
        book_id: {{ $book->id }},
        totalPage: {{ $book_pages->total() }},
        zoom: {{ (!empty($data['zoom'])) ? $data['zoom'] : 1 }},
        light: {{ (!empty($data['light'])) ? $data['light'] : 0 }},
        font: '{{ (!empty($data['font'])) ? $data['font'] : "'PT Sans', sans-serif" }}',
        hash: '{{ $hash }}',
        urlRanges: {!! $url_range !!},
        saveBookStateUrl: '{{ route('save_book_state') }}'
    };
{{--    @foreach(array_values($url_range) as $url)--}}
{{--        confi--}}
{{--    @endforeach--}}
    $('#page-content').dariyaBookReader(config);
</script>
</body>
</html>
