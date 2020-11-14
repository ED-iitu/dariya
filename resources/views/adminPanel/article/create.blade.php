@extends('layouts.admin-app')
@section('tinymce-cdn')
    <script src="https://cdn.tiny.cloud/1/buh9cjvfxrwjgckznhj8pq3xwwxdx6my7sggxzipwou72sb2/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Добавление новой статьи</h2>
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

        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" name="name" class="form-control" placeholder="Название">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" name="preview_text" class="form-control" placeholder="Краткое описание">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <textarea class="form-control tiny_editor" style="height:150px" name="detail_text" placeholder="Детальное описание"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="category">Выберите категорию</label>
                        <select multiple="multiple" class="form-control" id="category" name="categories[]">
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="lang">Выберите язык</label>
                        <select class="form-control" id="lang" name="lang">
                            <option value="ru">Русский</option>
                            <option value="kz">Казахский</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="author">Автор</label>
                        <input type="text" name="author" class="form-control">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image_link" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" >
                            <label class="custom-file-label" for="inputGroupFile01">Загрузите картинку</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="for_all" name="for_all" value="0">
                            <label class="form-check-label" for="is_free">Для всех</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Добавить статью</button>
                </div>
            </div>

        </form>
    </div>
@endsection