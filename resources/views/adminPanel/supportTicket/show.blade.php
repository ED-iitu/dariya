@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Сообщения от пользователя: {{$supportTicket->credential}}</h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('supportTicketsPage') }}"> Вернуться назад</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Название:</strong>
                    {{ $supportTicket->title }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Данные пользователя:</strong>
                    {{ $supportTicket->credential }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Сообщение:</strong>
                    {{ $supportTicket->description }}
                </div>
            </div>
        </div>
    </div>
@endsection