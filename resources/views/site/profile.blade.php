@extends('layouts.app')

@section('content')
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
    <div class="container">
        <h1>Добро пожаловать в личный кабинет Читателя</h1>
        <div class="row">
            <div class="col-md-12">
                <ul>
                    <li><a href="">Мои книги</a></li>
                    <li><a href="">Мой тарифный план</a></li>
                    <li><a href="">Обновить профиль</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection