@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Добавление новой книги</h2>
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
         <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <input type="hidden" name="type" value="AUDIO">

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
                                <textarea class="form-control" style="height:150px" name="detail_text" placeholder="Детальное описание"></textarea>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="genre">Выберите жанр</label>
                                <select class="form-control" id="genre" name="genre_id">
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
                                    <option value="kz">Казахский</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="publisher">Выберите издателя</label>
                                <select class="form-control" id="publisher" name="publisher_id">
                                    @foreach($publishers as $publisher)
                                        <option value="{{$publisher->id}}">{{$publisher->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <input type="text" name="price" class="form-control" value="0" placeholder="Цена">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="author">Выберите автора</label>
                                <select class="form-control" id="author" name="author_id">
                                    @foreach($authors as $author)
                                        <option value="{{$author->id}}">{{$author->name}} {{$author->surname}}</option>
                                    @endforeach
                                </select>
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
                                    <input class="form-check-input" checked type="checkbox" id="is_free" name="is_free" value="0">
                                    <label class="form-check-label" for="is_free">Платная</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="1">
                                    <label class="form-check-label" for="is_free">Бесплатная</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" checked type="radio" id="type" name="type" value="{{\App\Book::BOOK_TYPE}}">
                                    <label class="form-check-label" for="type">Книга</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="type" name="type" value="{{ \App\Book::AUDIO_BOOK_TYPE }}">
                                    <label class="form-check-label" for="type">Аудио-книга</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link  active" id="home-tab" data-toggle="tab" href="#pdf" role="tab" aria-controls="pdf" aria-selected="true">PDF</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#audio" role="tab" aria-controls="audio" aria-selected="false">Аудио-файлы</a>
                                </li>
                            </ul>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 p-4">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="pdf" role="tabpanel" aria-labelledby="home-tab">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="book_link" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                                <label class="custom-file-label" for="inputGroupFile01">Загрузите книгу (PDF)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="audio" role="tabpanel" aria-labelledby="profile-tab">
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
                            <button type="submit" class="btn btn-primary">Добавить книгу</button>
                        </div>
                    </div>

                </form>
    </div>
@endsection