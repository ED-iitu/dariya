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
                        <h2 class="bradcaump-title">Обновление профиля</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('home')}}">Главная</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Обновление профиля</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5 mb-5">
        <h1>Обновление профиля</h1>
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
                    <div class="p-3 py-5">
                        <form action="{{route('updateProfile', Auth::user())}}" method="POST">
                            @csrf

                            <div class="row mt-2">
                                <div class="col-md-6"><input type="text" class="form-control" name="username" placeholder="Имя" value="{{$user->name}}"></div>
                                <div class="col-md-6"><input type="date" class="form-control" name="date_of_birth" placeholder="Дата рождения" value="{{$user->date_of_birth}}"></div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-6"><input type="text" class="form-control" name="email" placeholder="Email" value="{{$user->email}}"></div>
                                <div class="col-md-6"><input type="text" class="form-control" name="phone" placeholder="Телефон" value="{{$user->phone}}"></div>
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
@endsection