
@extends('layouts.app')
@section('title', $title)
@section('content')
@include('site.blocks.breadcrumb', ['breadcrumb' => $breadcrumb])
<!-- End Bradcaump area -->
<!-- Start My Account Area -->
<section class="my_account_area pt--80 pb--55 bg--white">
    <div class="container">
        <div class="row">
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
                            <div class="form-group">
                                <button class="btn btn-primary">Создать аккаунт</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 col-12 right-wrapper"></div>
        </div>
    </div>
</section>
@endsection