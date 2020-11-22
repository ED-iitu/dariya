@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Жанр: {{$info->title}}</h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('infoPage') }}"> Вернуться назад</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Название:</strong>
                    {{ $info->title }}
                </div>
                <div class="form-group">
                    <strong>Тип:</strong>
                    {{ isset(App\Info::getTypeLabels()[$info->type]) ? App\Info::getTypeLabels()[$info->type] : $info->type }}
                </div>
                <div class="form-group">
                    <strong>Текст:</strong>
                    {{ $info->text }}
                </div>
                <div class="form-group">
                    <strong>Тип:</strong>
                    {{ $info->type }}
                </div>
            </div>
        </div>
    </div>
@endsection