<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

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
                <div class="row">
                    <div class="col-md-6 col-sm-6 col-6 col-lg-2">
                        <div class="logo">
                            <a href="/">
                                <img src="../../images/logo/logo1.png" alt="logo images">
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-8 d-none d-lg-block">
                        <nav class="mainmenu__nav">
                            <ul class="meninmenu d-flex justify-content-start mb-0">
                                <li class="drop with--one--item"><a href="{{route('home')}}">Главная</a></li>
                                <li class="drop"><a href="{{route('books')}}">Книги</a></li>
                                <li class="drop"><a href="{{route('audioBooks')}}">Аудио книги</a></li>
                                <li class="drop"><a href="{{route('articles')}}">Статьи</a></li>
                                <li class="drop"><a href="{{route('contacts')}}">Контакты</a></li>
                                <li class="drop"><a style="color: red" href="{{route('tariff')}}">Получить подписку</a></li>
                            </ul>
                        </nav>
                    </div>
                    <div class="col-md-6 col-sm-6 col-6 col-lg-2">
                        <ul class="header__sidebar__right d-flex justify-content-end align-items-center mb-0">
                            <li class="shop_search"><a class="search__active" href="#"></a></li>
                            <li class="wishlist"><a href="{{route('favorite')}}"></a></li></li>
                            <li class="setting__bar__icon"><a class="setting__active" href="#"></a>
                                <div class="searchbar__content setting__block">
                                    <div class="content-inner">
                                        <div class="switcher-currency">
                                            <div class="switcher-options">
                                                <div class="switcher-currency-trigger">
                                                    <div class="setting__menu">
                                                    @guest
                                                        @if (Route::has('register'))
                                                        <span><a href="{{route('createAccount')}}">Создать аккаунт</a></span>
                                                        @endif

                                                        @else
                                                        <span><a href="{{route('profile', Auth::user()->id)}}">{{ Auth::user()->name }}</a></span>
                                                            <hr>
                                                        <span><a href="#">Избранные</a></span>
                                                        <span><a href="#">Мои полки</a></span>
                                                        <span>
                                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Выйти
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                                        </span>

                                                    @endguest
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Start Mobile Menu -->
                <div class="row d-none">
                    <div class="col-lg-12 d-none">
                        <nav class="mobilemenu__nav">
                            <ul class="meninmenu">
                                <li><a href="{{route('home')}}">Главаная</a></li>
                                <li><a href="{{route('books')}}">Книги</a></li>
                                <li><a href="{{route('audioBooks')}}">Аудио книги</a></li>
                                <li><a href="{{route('articles')}}">Статьи</a></li>
                                <li><a href="{{route('contacts')}}">Контакты</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- End Mobile Menu -->
                <div class="mobile-menu d-block d-lg-none">
                </div>
                <!-- Mobile Menu -->
            </div>
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
        <footer id="wn__footer" class="footer__area bg--white bg__cat--8 brown--color">
            <div class="footer-static-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer__widget footer__menu">
                                <div class="ft__logo">
                                    <a href="index.html">
                                        <img src="../../images/logo/logo1.png" alt="logo">
                                    </a>
                                    <p>Dariya.org</p>
                                </div>
                                <div class="footer__content">
                                    <ul class="social__net social__net--2 d-flex justify-content-center">
                                        <li><a href="#"><i class="bi bi-facebook"></i></a></li>
                                        <li><a href="#"><i class="bi bi-google"></i></a></li>
                                        <li><a href="#"><i class="bi bi-twitter"></i></a></li>
                                        <li><a href="#"><i class="bi bi-linkedin"></i></a></li>
                                        <li><a href="#"><i class="bi bi-youtube"></i></a></li>
                                    </ul>
                                    <ul class="mainmenu d-flex justify-content-center">
                                        <li><a href="{{route('home')}}">Главная</a></li>
                                        <li><a href="{{route('books')}}">Книги</a></li>
                                        <li><a href="{{route('articles')}}">Статьи</a></li>
                                        <li><a href="{{route('contacts')}}">Контакты</a></li>
                                        @if(Auth::user())
                                        <li><a href="{{route('profile', Auth::user()->id)}}">Личный кабинет</a></li>
                                        @else
                                        <li><a href="{{route('createAccount')}}">Личный кабинет</a></li>
                                        @endif
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
                                    <p>Copyright <i class="fa fa-copyright"></i> <a href="#">Dariya.</a> All Rights Reserved</p>
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
</body>
</html>
