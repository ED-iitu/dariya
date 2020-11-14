<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>{{ config('app.name', 'Laravel') }} - Панель администратора</title>
    <!-- bootstrap 4.x is supported. You can also use the bootstrap css 3.3.x versions -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css">
    <!-- if using RTL (Right-To-Left) orientation, load the RTL CSS file after fileinput.css by uncommenting below -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/css/fileinput-rtl.min.css" media="all" rel="stylesheet" type="text/css">
    <!-- the font awesome icon library if using with `fas` theme (or Bootstrap 4.x). Note that default icons used in the plugin are glyphicons that are bundled only with Bootstrap 3.x. -->
{{--    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css">--}}
{{--    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">--}}
    <link href="/css/admin_styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    @yield('tinymce-cdn')
</head>
<body>
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand" href="index.html">{{ config('app.name', 'Laravel') }}</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
    <!-- Navbar Search-->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <div class="input-group">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" />
            <div class="input-group-append">
                <button class="btn btn-primary" type="button"><i class="fas fa-search"></i></button>
            </div>
        </div>
    </form>
    <!-- Navbar-->
    <ul class="navbar-nav ml-auto ml-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">Settings</a>
                <a class="dropdown-item" href="#">Activity Log</a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="login.html">Logout</a>
            </div>
        </li>
    </ul>
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <div class="sb-sidenav-menu-heading">Core</div>
                    <a class="nav-link" href="index.html">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Контент</div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                        Книги
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{route('booksPage')}}">Книги</a>
                            <a class="nav-link" href="{{route('authorsPage')}}">Авторы</a>
                            <a class="nav-link" href="{{route('publishersPage')}}">Издатели</a>
                            <a class="nav-link" href="{{route('genresPage')}}">Жанры</a>
                        </nav>
                    </div>
                    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#aricleContent" aria-expanded="false" aria-controls="aricleContent">
                        <div class="sb-nav-link-icon"><i class="fas fa-book"></i></div>
                        Статьи
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="aricleContent" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="{{route('categoriesPage')}}">Категории</a>
                            <a class="nav-link" href="{{route('articlesPage')}}">Статьи</a>
                            <a class="nav-link" href="{{route('videosPage')}}">Видео материалы</a>
                        </nav>
                    </div>
                    <a class="nav-link" href="{{route('tariffsPage')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-money"></i></div>
                        Тарифы
                    </a>
                    <a class="nav-link" href="{{route('transactionsPage')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-bank"></i></div>
                        Транзакции
                    </a>
                    <a class="nav-link" href="{{route('bannersPage')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-link"></i></div>
                        Баннеры
                    </a>
                    <a class="nav-link" href="{{route('infoPage')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-info"></i></div>
                        Инфо
                    </a>
                    <a class="nav-link" href="{{route('supportTicketsPage')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-envelope"></i></div>
                        Сообщения от пользователей
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                {{ Auth::user()->name }}
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                <h1 class="mt-4">Static Navigation</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Static Navigation</li>
                </ol>
                <div class="card mb-4 p-4">
                    @yield('admin-content')
                </div>
                <div style="height: 100vh;"></div>
                <div class="card mb-4"><div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div></div>
            </div>
        </main>
        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2020</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
<script src="/js/jquery-ui.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/plugins/piexif.min.js" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview.
    This must be loaded before fileinput.min.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/plugins/sortable.min.js" type="text/javascript"></script>
<!-- popper.min.js below is needed if you use bootstrap 4.x (for popover and tooltips). You can also use the bootstrap js
   3.3.x versions without popper.min.js. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- bootstrap.min.js below is needed if you wish to zoom and preview file content in a detail modal
    dialog. bootstrap 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
<!-- the main fileinput plugin file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/fileinput.min.js"></script>
<!-- following theme script is needed to use the Font Awesome 5.x theme (`fas`) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/themes/fas/theme.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.0.9/js/locales/ru.js"></script>
<link href="http://hayageek.github.io/jQuery-Upload-File/4.0.11/uploadfile.css" rel="stylesheet">
<script src="http://hayageek.github.io/jQuery-Upload-File/4.0.11/jquery.uploadfile.min.js"></script>
<script src="/js/admin_scripts.js"></script>
</body>
</html>
