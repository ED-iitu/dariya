@extends('layouts.admin-app')
@section('tinymce-cdn')
<script src="https://cdn.tiny.cloud/1/buh9cjvfxrwjgckznhj8pq3xwwxdx6my7sggxzipwou72sb2/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
@endsection
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
                            <label for="book_id">@if($book->type == \App\Book::BOOK_TYPE)Есть аудио-книга @else Есть электронная-книга @endif</label>
                            <select class="form-control" id="book_id" name="book_id">
                                <option></option>
                                @foreach($books as $b)
                                    <option value="{{$b->id}}" @if($b->id == $book->book_id)selected="selected"@endif>{{$b->name}}</option>
                                @endforeach
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
                            <label for="status">Статус</label>
                            <select class="form-control" id="status" name="status">
                                <option value="0" @if(!$book->status) selected="selected" @endif>Отключен</option>
                                <option value="1" @if($book->status) selected="selected" @endif>Включен</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="in_home_screen" name="in_home_screen" value="1"  @if($book->in_home_screen)checked="checked"@endif>
                                <label class="form-check-label" for="in_home_screen">Показать на главном экране</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="in_home_screen" name="in_list" value="1" @if($book->in_list)checked="checked"@endif>
                                <label class="form-check-label" for="in_home_screen">Показать в спике</label>
                            </div>
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
                                <input class="form-check-input" type="checkbox" @if(!$book->is_free) checked="checked" @endif id="is_free" name="is_free" value="0">
                                <label class="form-check-label" for="is_free">По подписке</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" @if($book->is_free) checked="checked" @endif id="is_free" name="is_free" value="1">
                                <label class="form-check-label" for="is_free">Бесплатная</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @if(\App\Book::BOOK_TYPE == $book->type) checked @endif type="radio" id="type" name="type" value="{{\App\Book::BOOK_TYPE}}">
                                <label class="form-check-label" for="type">Книга</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" @if(\App\Book::AUDIO_BOOK_TYPE == $book->type) checked @endif type="radio" id="type" name="type" value="{{ \App\Book::AUDIO_BOOK_TYPE }}">
                                <label class="form-check-label" for="type">Аудио-книга</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if($book->type == \App\Book::BOOK_TYPE) active @endif" id="home-tab" data-toggle="tab" href="#pdf" role="tab" aria-controls="pdf" aria-selected="true">PDF</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($book->type == \App\Book::AUDIO_BOOK_TYPE) active @endif" id="profile-tab" data-toggle="tab" href="#audio" role="tab" aria-controls="audio" aria-selected="false">Аудио-файлы</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 p-4">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade @if($book->type == \App\Book::BOOK_TYPE) show active @endif" id="pdf" role="tabpanel" aria-labelledby="home-tab">
                                @if($book->book_link)
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <p><a href="{{ url($book->book_link) }}" target="_blank"><i class="fa fa-file-pdf"></i> PDF</a> {{$book->name}}
                                            <a href="{{route('booksPages', $book->id)}}" target="_blank">Открыть HTML формат</a></p>
                                        <p><input type="checkbox" name="generate_html"> Пересоздать HTML формат
                                            <select name="pdf_to_html">
                                                <option @if($book->pdf_to_html == \App\Book::X_PDF_TO_HTML)selected="selected"@endif value="{{ \App\Book::X_PDF_TO_HTML }}">X_PDF_TO_HTML</option>
                                                <option @if($book->pdf_to_html == \App\Book::PDF_TO_HTML)selected="selected"@endif value="{{ \App\Book::PDF_TO_HTML }}">PDF_TO_HTML</option>
                                            </select>
                                        </p>
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
                            <div class="tab-pane fade @if($book->type == \App\Book::AUDIO_BOOK_TYPE) show active @endif" id="audio" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Файл</th>
                                                <th>Статус</th>
                                                <th colspan="2">Зазаловок</th>
                                            </tr>
                                            </thead>
                                            <tbody class="audio-files-table-body" data-book-id = "{{ $book->id }}">
                                            @csrf
                                            @foreach($book->audio_files as $file)
                                                <tr data-id="{{ $file->id }}">
                                                    <th>
                                                        <audio controls>
                                                            <source src="{{ url($file->audio_link) }}" type="audio/mpeg">
                                                            Your browser does not support the audio element.
                                                        </audio>
                                                    </th>
                                                    <th>
                                                        @if($file->status)
                                                            <span class="badge badge-success">Включен</span>
                                                        @else
                                                            <span class="badge badge-secondary">Отключен</span>
                                                        @endif
                                                    </th>
                                                    <th>
                                                        <input name="audio_file_titles[{{$file->id}}][title]" type="text" value="{{ $file->title }}">
                                                    </th>
                                                    <th>
                                                        <button type="button" class="btn btn-danger remove-audio-file" data-id="{{ $file->id }}">Удалить</button>
                                                    </th>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div class="form-group">
                                        <div class="custom-file">
                                            <input type="file" multiple class="custom-file-input" name="audio_files[]" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                            <label class="custom-file-label" for="inputGroupFile01">Загрузите аудио-файлы (MP3)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Обновить книгу</button>
                    </div>
                </div>


        </form>
    </div>
@endsection