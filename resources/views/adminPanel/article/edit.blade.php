@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Обновление статьи < {{ $article->name }} ></h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('articlesPage') }}"> Вернуться назад</a>
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

        <form action="{{ route('articles.update',$article->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')


            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Название" value="{{ $article->name }}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" name="preview_text" class="form-control" placeholder="Краткое описание" value="{{ $article->preview_text }}">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <textarea class="form-control" style="height:150px" name="detail_text" placeholder="Детальное описание">{{ $article->detail_text }}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="genre">Выберите жанр</label>
                        <select class="form-control" id="genre" name="genre">
                            @foreach($genres as $genre)
                                <option value="{{$genre->id}}">{{$genre->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="lang">Выберите язык</label>
                        <select class="form-control" id="lang" name="lang">
                            <option value="ru">Русский</option>
                            <option>Казахский</option>
                            <option>Английский</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="author">Выберите автора</label>
                        <select class="form-control" id="author" name="author_id">
                            @foreach($authors as $author)
                                <option value="{{$author->id}}">{{$author->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image_link" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" value="{{ asset($article->image_link) }}">
                            <label class="custom-file-label" for="inputGroupFile01">Загрузите картинку</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="0">
                            <label class="form-check-label" for="is_free">Для всех</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Обновить статью</button>
                </div>
            </div>


        </form>
    </div>
@endsection