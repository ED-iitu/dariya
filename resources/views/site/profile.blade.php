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
    <div class="container mt-5 mb-5">
        <h1>{{Auth::user()->name}}, Добро пожаловать в личный кабинет Читателя</h1>
        <div class="card-columns mt-5">
            <div class="card bg-primary">
                <div class="card-body text-center">
                    <p class="card-text"><a href="{{route('favorite')}}">Мои избранные книги</a></p>
                </div>
            </div>
            <div class="card bg-primary">
                <div class="card-body text-center">
                    <p class="card-text"><a href="">Мои полки</a></p>
                </div>
            </div>
            <div class="card bg-primary">
                <div class="card-body text-center">
                    <p class="card-text"><a href="">Мои тариф</a></p>
                </div>
            </div>
            <div class="card bg-primary">
                <div class="card-body text-center">
                    <p class="card-text"><a href="">Мои покупки</a></p>
                </div>
            </div>
            <div class="card bg-primary">
                <div class="card-body text-center">
                    <p class="card-text"><a href="{{route('profileEdit', Auth::user())}}">Обновить профиль</a></p>
                </div>
            </div>
            <div class="card bg-primary">
                <div class="card-body text-center">
                    <p class="card-text"><a href="">Настройки</a></p>
                </div>
            </div>
        </div>
    </div>
@endsection