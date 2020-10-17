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
                            <textarea class="form-control" style="height:250px" name="detail_text" placeholder="Детальное описание">{{ $book->detail_text }}</textarea>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="genre">Выберите жанр</label>
                            <select multiple class="form-control" id="genre" name="genre">
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
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image_link" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" value="{{ asset($book->image_link) }}">
                                <label class="custom-file-label" for="inputGroupFile01">Загрузите картинку</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="book_link" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" value="{{$book->book_link}}">
                                <label class="custom-file-label" for="inputGroupFile01">Загрузите книгу (PDF)</label>
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
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Обновить книгу</button>
                    </div>
                </div>


        </form>
    </div>
@endsection