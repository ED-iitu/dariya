@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Обновление видео < {{ $video->youtube_video_id }} ></h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('videosPage') }}"> Вернуться назад</a>
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

        <form action="{{ route('videos.update',$video->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')


                <div class="row mt-5">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Название" value="{{ $video->name }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="preview_text" class="form-control" placeholder="Краткое описание" value="{{ $video->preview_text }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <textarea class="form-control tiny_editor" style="height:150px" name="detail_text" placeholder="Детальное описание">{{ $video->detail_text }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="categories">Выберите категорию</label>
                            <select multiple="multiple" class="form-control" id="categories" name="categories[]">
                                @foreach($categories as $category)
                                    @if(array_key_exists($category->id,$video->categories->pluck('name','id')->toArray()))
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
                                <option @if($video->lang == 'ru')selected="selected"@endif value="ru">Русский</option>
                                <option @if($video->lang == 'kz')selected="selected"@endif value="kz">Казахский</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="author">Автор</label>
                            <input type="text" name="author" class="form-control" value="{{ $video->author }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                @if($video->image_link)
                                    <img src="{{ url($video->image_link) }}" alt="..." class="img-thumbnail" style="width:530px;height:290px;">
                                @endif
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="image_link" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" value="{{ asset($video->image_link) }}">
                                        <label class="custom-file-label" for="inputGroupFile01">Загрузите картинку</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                @if($video->local_video_link)
                                    <video width="530" height="290" controls>
                                        <source src="{{ url($video->local_video_link) }}" type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @endif
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="local_video_link" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" value="{{ asset($video->local_video_link) }}">
                                        <label class="custom-file-label" for="inputGroupFile01">Загрузите видео</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="for_all" name="for_all" @if($video->for_all)checked="checked"@endif>
                                <label class="form-check-label" for="for_all">Для всех</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <iframe width="560" height="315" src="https://www.youtube.com/embed/{{$video->youtube_video_id}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        <div class="form-group">
                            <input type="text" name="youtube_video_id" class="form-control" placeholder="ID видео с ютуба" value="{{ $video->youtube_video_id }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Обновить Видео</button>
                    </div>
                </div>


        </form>
    </div>
@endsection