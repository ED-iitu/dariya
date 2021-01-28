@extends('layouts.admin-app')
@section('tinymce-cdn')
    <script src="https://cdn.tiny.cloud/1/buh9cjvfxrwjgckznhj8pq3xwwxdx6my7sggxzipwou72sb2/tinymce/5/tinymce.min.js"
            referrerpolicy="origin"></script>
@endsection
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Обновление курса < {{ $course->name }} ></h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('coursesPage') }}"> Вернуться назад</a>
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
        <div class="row mt-5">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="main-tab-tab" data-bs-toggle="tab" href="#main-tab" role="tab"
                       aria-controls="main-tab" aria-selected="true">Описание</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="lessons-tab-tab" data-bs-toggle="tab" href="#lessons-tab" role="tab"
                       aria-controls="lessons-tab" aria-selected="false">Уроки</a>
                </li>
            </ul>
        </div>
        <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="main-tab" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row mt-5">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="text" value="{{ $course->name }}" name="name" class="form-control"
                                       placeholder="Название">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <textarea class="form-control tiny_editor" style="height:150px" name="description"
                                          placeholder="Описание курса">{{ $course->description }}</textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="author">Автор</label>
                                <input type="text" value="{{ $course->author }}" name="author" class="form-control">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" @if($course->is_free)checked="checked"
                                           @endif type="checkbox" id="is_free" name="is_free" value="1">
                                    <label class="form-check-label" for="is_free">Бесплатный курс</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" @if($course->is_vip) checked="checked" @endif id="is_vip" name="is_vip" value="1">
                                    <label class="form-check-label" for="is_vip">VIP</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6 col-sm-12 col-md-6">
                            <div class="form-group">
                                <div class="custom-file">
                                    <div style="width: 100%;
                                            height: 20em;
                                            background-color: #cccccc;
                                            margin-top: 45px;
                                            background-image: url({{url($course->image_link)}});
                                            background-repeat: no-repeat;
                                            background-size: cover;
                                            "></div>
                                    <input type="file" class="custom-file-input" name="image_link" id="inputGroupFile01"
                                           aria-describedby="inputGroupFileAddon01">
                                    <label class="custom-file-label" for="inputGroupFile01">Загрузите картинку</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="lessons-tab" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="accordion mt-5" id="lesson-accordion">
                        @foreach($course->lessons as $lesson)
                            <div class="card">
                                <div class="card-header" id="heading_{{$lesson->id}}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link btn-block text-left" type="button"
                                                data-toggle="collapse" data-target="#collapse_{{$lesson->id}}"
                                                aria-expanded="true" aria-controls="collapse_{{$lesson->id}}">
                                            {{$lesson->name}}
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapse_{{$lesson->id}}" class="collapse show"
                                     aria-labelledby="heading_{{$lesson->id}}" data-parent="#lesson-accordion">
                                    <div class="card-body">
                                        <div class="row mt-5 lesson-detail" data-index="{{$lesson->id}}">
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                                    <input type="text" value="{{$lesson->name}}"
                                                           name="lessons[{{$lesson->id}}][name]" class="form-control"
                                                           placeholder="Название">
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="form-group">
                                <textarea class="form-control tiny_editor" style="height:150px"
                                          name="lessons[{{$lesson->id}}][lesson]"
                                          placeholder="Урок">{{$lesson->lesson}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <ul class="nav nav-tabs" id="lessonMaterialTab" role="tablist">
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link active" id="video-tab-tab"
                                                           data-bs-toggle="tab" href="#video-tab" role="tab"
                                                           aria-controls="video-tab" aria-selected="true">Видео</a>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <a class="nav-link" id="file-tab-tab" data-bs-toggle="tab"
                                                           href="#file-tab" role="tab" aria-controls="file-tab"
                                                           aria-selected="false">Файлы</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-xs-12 col-sm-12 col-md-12">
                                                <div class="tab-content" id="lessonMaterialTabContent">
                                                    <div class="tab-pane fade show active" id="video-tab"
                                                         role="tabpanel" aria-labelledby="home-tab">
                                                        @foreach($lesson->videos as $video)
                                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                                <p>{{$video->video_title}} <a href="javascript:;"
                                                                                              data-id="{{$video->id}}"
                                                                                              class="remove-lesson-video btn btn-link">удалить</a>
                                                                </p>
                                                                <video width="100%" height="300" controls="controls"
                                                                       poster="video/duel.jpg">
                                                                    <source src="@if($video->is_external) {{$video->video_link}} @else {{url($video->video_link)}} @endif"
                                                                            type='video/mp4; codecs="avc1.42E01E, mp4a.40.2"'>
                                                                    Тег video не поддерживается вашим браузером.
                                                                    {{--                                                    <a href="video/duel.mp4">Скачайте видео</a>.--}}
                                                                </video>
                                                            </div>
                                                        @endforeach
                                                        <div class="col-md-12 video-files">
                                                            <div class="row" data-index="0">
                                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="custom-file">
                                                                            <input type="file"
                                                                                   class="custom-file-input"
                                                                                   name="lessons[{{$lesson->id}}][video_link][]">
                                                                            <label class="custom-file-label">Загрузите
                                                                                видео</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                                    <a href="javascript:;"
                                                                       class="btn btn-success add-more-video">добавить
                                                                        еще ...</a>
                                                                </div>
                                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                                    <a href="javascript:;"
                                                                       class="btn btn-light set-as-external">Указать
                                                                        на
                                                                        внешний ресурс</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="file-tab" role="tabpanel"
                                                         aria-labelledby="profile-tab">
                                                        @foreach($lesson->files as $file)
                                                            <div class="col-xs-6 col-sm-6 col-md-6">
                                                                <p>{{$file->title}} <a href="javascript:;"
                                                                                              data-id="{{$file->id}}"
                                                                                              class="remove-lesson-video remove-lesson-file btn btn-link">удалить</a>
                                                                </p>
                                                            </div>
                                                        @endforeach
                                                        <div class="col-md-12 mt-4 lesson-files">
                                                            <div class="row" data-index="0">
                                                                <div class="col-xs-6 col-sm-6 col-md-6">
                                                                    <div class="form-group">
                                                                        <div class="custom-file">
                                                                            <input type="file"
                                                                                   class="custom-file-input"
                                                                                   name="lessons[{{$lesson->id}}][file_link][]">
                                                                            <label class="custom-file-label">Загрузите файл</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                                    <a href="javascript:;"
                                                                       class="btn btn-success add-more-file">добавить еще ...</a>
                                                                </div>
                                                                <div class="col-xs-3 col-sm-3 col-md-3">
                                                                    <a href="javascript:;"
                                                                       class="btn btn-light set-as-external-file">Указать на внешний ресурс</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <a href="javascript:;" class="btn btn-success add-more-lesson">добавить еще один урок</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection