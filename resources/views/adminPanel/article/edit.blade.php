@extends('layouts.admin-app')
@section('tinymce-cdn')
    <script src="https://cdn.tiny.cloud/1/buh9cjvfxrwjgckznhj8pq3xwwxdx6my7sggxzipwou72sb2/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
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
                        <textarea class="form-control tiny_editor" style="height:150px" name="detail_text" placeholder="Детальное описание">{{ $article->detail_text }}</textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="categories">Выберите категорию</label>
                        <select multiple="multiple" class="form-control" id="categories" name="categories[]">
                            @foreach($categories as $category)
                                @if(array_key_exists($category->id,$article->categories->pluck('name','id')->toArray()))
                                    <option selected="selected" value="{{$category->id}}">{{$category->name}}</option>
                                @else
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="lang">Выберите язык</label>
                        <select class="form-control" id="lang" name="lang">
                            <option @if($article->lang == 'ru')selected="selected"@endif value="ru">Русский</option>
                            <option @if($article->lang == 'kz')selected="selected"@endif value="kz">Казахский</option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="author">Автор</label>
                        <input type="text" name="author" class="form-control" value="{{ $article->author }}">
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
                            <input class="form-check-input" type="checkbox" id="in_home_screen" name="in_home_screen" value="1"  @if($article->in_home_screen)checked="checked"@endif>
                            <label class="form-check-label" for="in_home_screen">Показать на главном экране</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="in_home_screen" name="in_list" value="1" @if($article->in_list)checked="checked"@endif>
                            <label class="form-check-label" for="in_home_screen">Показать в спике</label>
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