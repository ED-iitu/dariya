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

        <div class="row mt-5">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <img width="500px" height="500px" src="{{ asset($book->image_link) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <a href="{{asset($book->book_link)}}">File</a>
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
                    @if($book->genres)
                        <ul>
                            @foreach($book->genres as $genre)
                                <li>{{$genre->name}}</li>
                            @endforeach
                        </ul>
                    @else
                    Жанр не задан
                    @endif
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Издател:</strong>
                    @if($book->publishers)
                        {{ $book->publishers->name }}
                    @else
                        Издатель не задан
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection