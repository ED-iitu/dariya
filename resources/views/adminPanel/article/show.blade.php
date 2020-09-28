@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Статья: {{$article->name}}</h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('articlesPage') }}"> Вернуться назад</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <img width="500px" height="500px" src="{{ asset($article->image_link) }}">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Название:</strong>
                    {{ $article->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Текст превью:</strong>
                    {{ $article->preview_text }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Детальный Текст:</strong>
                    {{ $article->detail_text }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Автор:</strong>
                    {{ $article->authors->name }} {{ $article->authors->surname }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Жанр:</strong>
                    @if($article->genres)
                        <ul>
                            @foreach($article->genres as $genre)
                                <li>{{$genre->name}}</li>
                            @endforeach
                        </ul>
                    @else
                        Жанр не задан
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection