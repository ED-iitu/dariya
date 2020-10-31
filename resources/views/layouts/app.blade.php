<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('css/custom.css') }}" defer></script>
    <script src="{{ asset('js/vendor/modernizr-3.5.0.min.js') }}" defer></script>
    <script src="{{ asset('js/vendor/jquery-3.2.1.min.js') }}" defer></script>
    <script src="{{ asset('js/popper.min.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/plugins.js') }}" defer></script>
    <script src="{{ asset('js/active.js') }}" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
    <script src="{{ asset('js/share.js') }}"></script>


    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    {{--<link href="{{ asset('css/app.css') }}" rel="stylesheet">--}}
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <!-- Header -->
        <header id="wn__header" class="header__area header__absolute sticky__header">
            <div class="container">
                <div id="site_search">
                    <div class="search-box">
                        <a class="search">
                            <img src="https://img.icons8.com/ios-glyphs/25/search.png" alt="">
                        </a>
                        <input name="search" type="text" placeholder="Поиск...">
                        <a class="close">
                            <img src="https://img.icons8.com/ios/35/multiply.png" alt="">
                        </a>
                    </div>
                    <div class="results-box">
                        <a href="#" class="result p-2 p-md-3">
                            <div class="image mr-3" style="background-image: url('/images/bg/7.jpg');"></div>
                            <div class="content">
                                <div class="info">
                                    <h6 class="title mb-1">Title</h6>
                                    <span class="label">Label</span>
                                    <p class="text mb-0">Lorem ipsum dolor sit amet, consectetur adipisicing.</p>
                                </div>
                                <div class="price">
                                    <span>1 559 ₸</span>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-6 col-lg-2">
                        <div class="logo">
                            <a href="{{route('home')}}">
                                <img src="../../images/logo/logo1.png" alt="logo images">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 d-none d-lg-block">
                        <nav class="mainmenu__nav">
                            <ul class="meninmenu d-flex justify-content-start mx-auto my-0">
                                <li class="drop with--one--item"><a href="{{route('home')}}">Главная</a></li>
                                <li class="drop"><a href="{{route('articles')}}">Статьи</a></li>
                                <li class="drop"><a href="{{route('books')}}">Книги</a></li>
                                <li class="drop"><a href="{{route('audio_books')}}">Аудиокниги</a></li>
                                <li class="drop"><a href="{{route('videos')}}">Видео</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-6 col-6 col-lg-2">
                        <ul class="header__sidebar__right d-flex justify-content-end align-items-center mb-0">
                            <li class="shop_search"><a class="search__active" href="#"></a></li>
                            <li class="wishlist">
                                <a href="{{route('favorite')}}">
                                    @if(!Auth::guest() && Auth::user()->favorites()->count() > 0)
                                    <span>{{ Auth::user()->favorites()->count() }}</span>
                                    @endif
                                </a></li></li>
                            @if(!Auth::guest())
                                <li id="profile_dropdown" class="setting__bar__icon">
                                    <span class="profile-initial">{{Auth::user()->shortUpperInitial()}}</span>
                                    <ul>
                                        <li>
                                            <a href="{{ route('profile') }}">Профиль</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Выйти</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @else
                                <li class="setting__bar__icon"><a href="{{route('signin')}}"></a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <!-- Start Mobile Menu -->
                <div class="row d-none">
                    <div class="col-lg-12 d-none">
                        <nav class="mobilemenu__nav">
                            <ul class="meninmenu">
                                <li><a href="{{route('home')}}">Главная</a></li>
                                <li><a href="{{route('articles')}}">Статьи</a></li>
                                <li><a href="{{route('books')}}">Книги</a></li>
                                <li><a href="{{route('audio_books')}}">Аудиокниги</a></li>
                                <li><a href="{{route('videos')}}">Видео</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- End Mobile Menu -->
                <div class="mobile-menu d-block d-lg-none">
                </div>
                <!-- Mobile Menu -->
            </div>
            <div id="blackout-box" class="d-none"></div>
        </header>

        <!-- Start Search Popup -->
        <div class="brown--color box-search-content search_active block-bg close__top">
            <form id="search_mini_form" class="minisearch" method="GET" action="{{route('search')}}">
                <div class="field__search">
                    <input type="text" name="q" placeholder="Введите название книги или автора...">
                    <div class="action">
                        <a href="{{route('search')}}"><i class="zmdi zmdi-search"></i></a>
                    </div>
                </div>
            </form>
            <div class="close__wrap">
                <span>закрыть</span>
            </div>
        </div>
        <!-- End Search Popup -->
        <main>
            @yield('content')
        </main>
        <!-- Footer Area -->
        <footer id="wn__footer" class="footer__area bg--white bg__cat--8 brown--color mt--30">
            <div class="footer-static-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer__widget footer__menu">
                                <div class="ft__logo">
                                    <a href="{{ route('home') }}">
                                        <img src="../../images/logo/logo1.png" alt="logo">
                                    </a>
                                    <p>Dariya.org</p>
                                    <p>Мы в соц сетях</p>
                                </div>
                                <div class="footer__content">
                                    <ul class="social__net social__net--2 d-flex justify-content-center">
                                        <li><a target="_blank" href="https://www.facebook.com/ilimdariyasy"><i class="fa fa-facebook"></i></a></li>
                                        <li><a target="_blank" href="https://www.instagram.com/dariya_damytu/"><i class="fa fa-instagram"></i></a></li>
                                        <li><a target="_blank" href="mailto:yerbolatsoltamurat@gmail.com"><i class="fa fa-envelope"></i></a></li>
                                        <li><a target="_blank" href="https://t.me/ilimdariyasy"><i class="fa fa-telegram"></i></a></li>
                                        <li><a target="_blank" href="https://www.youtube.com/channel/UCaq5z_dkV4OD77SqxC3ZLDQ/videos?view_as=subscriber"><i class="fa fa-youtube"></i></a></li>
                                    </ul>
                                    <ul class="mainmenu d-flex justify-content-center">
                                        <li><a href="{{route('home')}}">Главная</a></li>
                                        <li><a href="{{route('articles')}}">Статьи</a></li>
                                        <li><a href="{{route('books')}}">Книги</a></li>
                                        <li><a href="{{route('books')}}">Аудиокниги</a></li>
                                        <li><a href="{{route('videos')}}">Видео</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copyright__wrapper">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="copyright">
                                <div class="copy__right__inner text-left">
                                    <p>Copyright <i class="fa fa-copyright"></i> <a href="#">Dariya.</a> Все права защищены</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="payment text-right">
                                <img src="images/icons/payment.png" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div class="call-buttons">
        <a target="_blank" href="https://api.whatsapp.com/send?phone=+77757652460" id="call-to-whatsapp"><i class="fa fa-whatsapp"></i></a>
        <a href="tel:+77757652460" id="call-to-whatsapp"><i class="fa fa-phone"></i></a>
    </div>
</body>
</html>
