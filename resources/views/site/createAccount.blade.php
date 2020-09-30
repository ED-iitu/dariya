
@extends('layouts.app')

@section('content')
<div class="ht__bradcaump__area bg-image--6">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="bradcaump__inner text-center">
                    <h2 class="bradcaump-title">Создание аккаунта</h2>
                    <nav class="bradcaump-content">
                        <a class="breadcrumb_item" href="index.html">Главная</a>
                        <span class="brd-separetor">/</span>
                        <span class="breadcrumb_item active">Создание аккаунта</span>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Bradcaump area -->
<!-- Start My Account Area -->
<section class="my_account_area pt--80 pb--55 bg--white">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-12">
                <div class="my__account__wrapper">
                    <h3 class="account__title">Авторизация</h3>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="account__form">
                            <div class="input__box">
                                <label>Email <span>*</span></label>
                                <input type="email" name="email">
                            </div>
                            <div class="input__box">
                                <label>Пароль<span>*</span></label>
                                <input type="password" name="password">
                            </div>
                            <div class="form__btn">
                                <button>Войти</button>
                                <label class="label-for-checkbox">
                                    <input id="rememberme" class="input-checkbox" name="rememberme" value="forever" type="checkbox">
                                    <span>Запомнить?</span>
                                </label>
                            </div>
                            <a class="forget_pass" href="#">Забыли пароль?</a>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-12">
                <div class="my__account__wrapper">
                    <h3 class="account__title">Регистрация</h3>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="account__form">
                            <div class="input__box">
                                <label>Имя <span>*</span></label>
                                <input type="text" name="name">
                            </div>
                            <div class="input__box">
                                <label>Email <span>*</span></label>
                                <input type="email" name="email">
                            </div>
                            <div class="input__box">
                                <label>Пароль<span>*</span></label>
                                <input type="password" name="password">
                            </div>
                            <div class="input__box">
                                <label>Подтвердите пароль<span>*</span></label>
                                <input type="password" name="password_confirmation">
                            </div>
                            <div class="form__btn">
                                <button>Создать аккаунт</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection