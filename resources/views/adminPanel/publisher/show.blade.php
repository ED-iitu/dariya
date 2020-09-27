@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Издатель: {{$publisher->name}}</h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('publishersPage') }}"> Вернуться назад</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Имя:</strong>
                    {{ $publisher->name }}
                </div>
            </div>
        </div>
    </div>
@endsection