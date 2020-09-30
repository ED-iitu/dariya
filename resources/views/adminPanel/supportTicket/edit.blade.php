@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Обновление сообщения от пользователя < {{ $supportTicket->credential }} ></h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('supportTicketsPage') }}"> Вернуться назад</a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('supportTickets.update',$supportTicket->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Название" value="{{ $supportTicket->title }}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" name="credential" class="form-control" placeholder="Данные о пользователе" value="{{ $supportTicket->credential }}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" name="description" class="form-control" placeholder="Описание" value="{{ $supportTicket->description }}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Обновить Вопрос</button>
                </div>
            </div>
        </form>
    </div>
@endsection