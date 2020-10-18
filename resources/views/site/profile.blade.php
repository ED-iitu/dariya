@extends('layouts.app')

@section('content')
    <style>
        .card-text a{
            color: white;
        }
    </style>
    <div class="ht__bradcaump__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Профиль</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('home')}}">Главная</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Профиль</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Start Tab Box -->
    <section id="tabs_box">
        <div class="container mb-5">
            <div class="tabs">
                <ul class="mb-2">
                    <li data-tab-content-box="content_item_1" class="active">Профиль</li>
                    <li data-tab-content-box="content_item_2">Мои покупки</li>
                    <li data-tab-content-box="content_item_3">Мои тариф</li>
                    <li data-tab-content-box="content_item_3">Помощь</li>
                </ul>
            </div>
            <div class="tabs-content">
                <div id="content_item_1" class="active">
                    <div class="container mt-5 mb-5">
                        <div class="mt-3 mb-2">
                            @if ($message = Session::get('success'))
                                <div class="alert alert-success">
                                    <p>{{ $message }}</p>
                                </div>
                            @elseif ($message = Session::get('error'))
                                <div class="alert alert-warning">
                                    <p>{{ $message }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="container rounded bg-white mt-2">
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="{{route('updateProfile', Auth::user())}}" method="POST">
                                        @csrf

                                        <div class="row mt-2">
                                            <div class="col-md-6"><input type="text" class="form-control" name="username" placeholder="Имя" value="{{$userData->name}}"></div>
                                            <div class="col-md-6"><input type="date" class="form-control" name="date_of_birth" placeholder="Дата рождения" value="{{$userData->date_of_birth}}"></div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6"><input type="text" class="form-control" name="email" placeholder="Email" value="{{$userData->email}}"></div>
                                            <div class="col-md-6"><input type="text" class="form-control" name="phone" placeholder="Телефон" value="{{$userData->phone}}"></div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-md-6"><input type="password" name="oldPassword" class="form-control" placeholder="Текущий пароль" value=></div>
                                            <div class="col-md-6"><input type="password" name="newPassword" class="form-control" placeholder="Новый пароль"></div>
                                        </div>

                                        <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="submit">Save Profile</button></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="content_item_2">
                    <div id="my_books_slider">
                        <div class="owl-carousel">
                            @foreach($userData->books as $book)
                                <div class="item">
                                    <a href="#" class="image mb-2" style="background-image: url('{{ url($book->image_link) }}');">
                                        <span class="sale mt-2">BEST SALLER</span>
                                    </a>
                                    <h6 class="title mb-2"><a href="#">{{$book->name}}</a></h6>
                                    <div class="info mb-2">
                                        <span>18 октября 2020</span>
                                        <ul class="mb-0">
                                            <li class="mr-2">
                                                <i class="bi bi-chat-bubble"></i>
                                                576
                                            </li>
                                            <li>
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"></path>
                                                    <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                                                </svg>
                                                39
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="description mb-2">
                                        <p><a href="#">{{ $book->detail_desription }}.</a></p>
                                    </div>
                                    <div class="final">
                                        <a href="#" class="order">Купить</a>
                                        <div class="price">
                                            <small>2750.00 KZT</small>
                                            <span>2000.00 KZT</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="content_item_3">

                </div>
                <div id="content_item_4">

                </div>
            </div>
        </div>
    </section>
    <!-- End Tab Box -->
@endsection