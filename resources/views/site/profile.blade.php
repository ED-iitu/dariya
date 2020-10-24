@extends('layouts.app')
@section('title', $title)
@section('content')
    <style>
        .card-text a{
            color: white;
        }
    </style>
    @include('site.blocks.breadcrumb', ['breadcrumb' => $breadcrumb])
    <!-- Start Tab Box -->
    <section id="tabs_box">
        <div class="container mb-5">
            <div class="tabs">
                <ul class="mb-2">
                    <li data-tab-content-box="content_item_1" class="active">Профиль</li>
                    <li data-tab-content-box="content_item_2">Мои покупки</li>
                    <li data-tab-content-box="content_item_3">Мои подписки</li>
                    <li data-tab-content-box="content_item_4">Помощь</li>
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
                                <div class="col-md-4">
                                    <div class="profile-img" style="background-image: url({{url('uploads/'.$userData->profile_photo_path)}})"></div>
                                </div>
                                <div class="col-md-8">
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
                        <div class="row">
                            @foreach($userData->books as $book)
                                <div class="col-md-3">
                                    @include('site.blocks.book')
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div id="content_item_3">
                    <div class="subscription">
                        <div class="row">
                            @if($userData->tariff)
                                <div class="item premium col-lg-6 mb-3 mb-lg-0">
                                    <div class="p-3">
                                        <img src="{{ url($userData->tariff->image_url) }}">
                                        <form action="/">
                                            @foreach($userData->tariff->tariffPriceLists as $price_list)
                                                <div class="mb-2">
                                                    <label for="">
                                                        <span>{{$price_list->duration}} месяц</span>
                                                        <span>{{ \Akaunting\Money\Money::KZT($price_list->price)->format() }}/мес</span>
                                                    </label>
                                                    <input id="" type="text">
                                                </div>
                                            @endforeach
                                            <button>Перейти к оплате</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div id="content_item_4">
                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1">Контакты</label>
                                    <input readonly="readonly" type="text" value="{{$userData->email}}" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlInput2">Тема</label>
                                    <input type="text" class="form-control" id="exampleFormControlInput2">
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1">Сообщения</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Отправить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Tab Box -->
@endsection