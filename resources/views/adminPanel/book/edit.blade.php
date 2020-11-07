@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Обновление книги < {{ $book->name }} ></h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('booksPage') }}"> Вернуться назад</a>
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

        <form action="{{ route('books.update',$book->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')


                <div class="row mt-5">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Название" value="{{ $book->name }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <textarea name="preview_text" class="form-control" placeholder="Краткое описание">{{ $book->preview_text }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <textarea class="form-control tiny_editor" style="height:250px" name="detail_text" placeholder="Детальное описание">{{ $book->detail_text }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="genre">Выберите жанр</label>
                            <select multiple class="form-control" id="genre" name="genres[]">
                                @foreach($genres as $genre)
                                    <option @if(in_array($genre->id, $book->getGenresIds())) selected="selected" @endif value="{{$genre->id}}">{{$genre->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="lang">Выберите язык</label>
                            <select class="form-control" id="lang" name="lang">
                                <option value="ru" @if($book->lang == 'ru')selected="selected"@endif>Русский</option>
                                <option value="kz" @if($book->lang == 'ru')selected="selected"@endif>Казахский</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="publisher">Выберите издателя</label>
                            <select class="form-control" id="publisher" name="publisher_id">
                                <option value="{{$book->publisher->id}}">{{$book->publisher->name}}</option>
                                @foreach($publishers as $publisher)
                                    <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="price" class="form-control" placeholder="Цена" value="{{ $book->price }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="author">Выберите автора</label>
                            <select class="form-control" id="author" name="author_id">
                                <option value="{{$book->author->id}}">{{$book->author->name}}</option>
                                @foreach($authors as $author)
                                    <option value="{{$author->id}}">{{$author->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" value="{{ $book->background_color }}" name="background_color" class="form-control" placeholder="Цвет фона">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image_link" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" value="{{ asset($book->image_link) }}">
                                <label class="custom-file-label" for="inputGroupFile01">Загрузите картинку</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="0">
                                <label class="form-check-label" for="is_free">Платная</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="1">
                                <label class="form-check-label" for="is_free">Бесплатная</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#pdf" role="tab" aria-controls="pdf" aria-selected="true">PDF</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#audio" role="tab" aria-controls="audio" aria-selected="false">Аудио-файлы</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 p-4">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="pdf" role="tabpanel" aria-labelledby="home-tab">
                                @if($book->book_link)
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <p><a href="{{ url($book->book_link) }}" target="_blank"><i class="fa fa-file-pdf"></i> PDF</a> {{$book->name}}
                                            <a href="{{route('booksPages', $book->id)}}" target="_blank">Открыть HTML формат</a></p>
                                    </div>
                                @endif
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" name="book_link" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" value="{{$book->book_link}}">
                                            <label class="custom-file-label" for="inputGroupFile01">Загрузите книгу (PDF)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="audio" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col">Файл</th>
                                                <th>Зазаловок</th>
                                            </tr>
                                            </thead>
                                            <tbody class="audio-files-table-body">
                                            @foreach($book->audio_files as $file)
                                                <tr data-id="{{ $file->id }}">
                                                    <th>
                                                        <input type="text" value="{{ $file->id }}" name="order">
                                                        <audio controls>
                                                            <source src="{{ url($file->audio_link) }}" type="audio/mpeg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    </th>
                                                    <th>
                                                        <input name="audio_files[{{$file->id}}]title" type="text" value="{{ $file->title }}">
                                                    </th>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
{{--                            <script type="text/javascript">--}}
{{--                                var footerTemplate = '<div class="file-thumbnail-footer" style ="height:94px">\n' +--}}
{{--                                    '  <input class="kv-input kv-new form-control input-sm form-control-sm text-center {TAG_CSS_NEW}" value="{caption}" placeholder="Enter caption...">\n' +--}}
{{--                                    '  <input class="kv-input kv-init form-control input-sm form-control-sm text-center {TAG_CSS_INIT}" name="file_title[]" value="{TAG_VALUE}" placeholder="Введите загаловок ...">\n' +--}}
{{--                                    '   <div class="small" style="margin:15px 0 2px 0">{size}</div> {progress}\n{indicator}\n{actions}\n' +--}}
{{--                                    '</div>';--}}
{{--                                var fileinput_params = {--}}
{{--                                    uploadAsync: false,--}}
{{--                                    maxFileCount: 30,--}}
{{--                                    overwriteInitial: false,--}}
{{--                                    showPreview:true,--}}
{{--                                    layoutTemplates: {footer: footerTemplate},--}}
{{--                                    allowedFileTypes:['audio'],--}}
{{--                                    theme:'fas',--}}
{{--                                    // previewThumbTags: {--}}
{{--                                    //     '{TAG_VALUE}': '',        // no value--}}
{{--                                    //     '{TAG_CSS_NEW}': '',      // new thumbnail input--}}
{{--                                    //     '{TAG_CSS_INIT}': 'kv-hidden'  // hide the initial input--}}
{{--                                    // },--}}
{{--                                    // initialPreview: [--}}
{{--                                    //     '<img class="file-preview-image kv-preview-data" src="http://lorempixel.com/800/460/city/1">',--}}
{{--                                    //     '<img class="file-preview-image kv-preview-data" src="http://lorempixel.com/800/460/city/2">',--}}
{{--                                    // ],--}}
{{--                                    // initialPreviewConfig: [--}}
{{--                                    //     {caption: "City-1.jpg", size: 327892, url: "/site/file-delete", key: 1},--}}
{{--                                    //     {caption: "City-2.jpg", size: 438828, url: "/site/file-delete", key: 2},--}}
{{--                                    // ],--}}
{{--                                    // initialPreviewThumbTags: [--}}
{{--                                    //     {'{TAG_VALUE}': 'City-1.jpg', '{TAG_CSS_NEW}': 'kv-hidden', '{TAG_CSS_INIT}': ''},--}}
{{--                                    //     {--}}
{{--                                    //         '{TAG_VALUE}': function() { // callback example--}}
{{--                                    //             return 'City-2.jpg';--}}
{{--                                    //         },--}}
{{--                                    //         '{TAG_CSS_NEW}': 'kv-hidden',--}}
{{--                                    //         '{TAG_CSS_INIT}': ''--}}
{{--                                    //     }--}}
{{--                                    // ],--}}
{{--                                    uploadExtraData: function() {  // callback example--}}
{{--                                        var out = {}, key, i = 0;--}}
{{--                                        $('.kv-input:visible').each(function() {--}}
{{--                                            var $thumb = $(this).closest('.file-preview-frame'); // gets the thumbnail--}}
{{--                                            var fileId = $thumb.data('fileid'); // gets the file identifier for file thumb--}}
{{--                                            out[fileId] = $("#book_audio_files_input").val();--}}
{{--                                        });--}}
{{--                                        return out;--}}
{{--                                    }--}}
{{--                                };--}}
{{--                                @if($book->audio_files())--}}
{{--                                    fileinput_params.initialPreviewConfig = [--}}
{{--                                    @foreach($book->audio_files()->get() as $file)--}}
{{--                                        {--}}
{{--                                            'caption': "{{ $file->original_name }}",--}}
{{--                                            'size': {{ $file->file_size }},--}}
{{--                                            'url': "{{ $file->audio_link }}",--}}
{{--                                            "key": {{$file->id }}--}}
{{--                                        },--}}
{{--                                    @endforeach--}}
{{--                                    ];--}}
{{--                                    fileinput_params.initialPreview = [--}}
{{--                                    @foreach($book->audio_files()->get() as $file)--}}
{{--                                          '<audio style="width: 100%; height: 30px;" controls="" class="kv-preview-data file-preview-audio"><source src="{{ url($file->audio_link) }}" type="audio/mpeg"></audio>',--}}
{{--                                    @endforeach--}}
{{--                                    ];--}}

{{--                                    fileinput_params.initialPreviewThumbTags = [--}}
{{--                                        @foreach($book->audio_files()->get() as $file)--}}
{{--                                        {--}}
{{--                                            '{TAG_VALUE}': '{{ $file->title }}',--}}
{{--                                            '{TAG_CSS_NEW}': 'kv-hidden',--}}
{{--                                            '{TAG_CSS_INIT}': ''--}}
{{--                                        },--}}
{{--                                        @endforeach--}}
{{--                                    ];--}}
{{--                                @endif--}}
{{--                            </script>--}}
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Обновить книгу</button>
                    </div>
                </div>


        </form>
    </div>
@endsection