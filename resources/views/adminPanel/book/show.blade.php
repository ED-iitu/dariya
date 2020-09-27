@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Книга: {{$book->name}}</h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('booksPage') }}"> Вернуться назад</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <img width="100px" height="100px" src="{{ asset('/images/booksImages'.$book->image_link) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Название:</strong>
                    {{ $book->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Текст превью:</strong>
                    {{ $book->preview_text }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Детальный Текст:</strong>
                    {{ $book->detail_text }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Цена:</strong>
                    {{ $book->price }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Автор:</strong>
                    {{ $book->authors->name }} {{ $book->authors->surname }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Жанр:</strong>
                    @foreach($book->genres as $genre)
                        {{ $genre->name }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection