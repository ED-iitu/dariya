@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Автор</h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('authorsPage') }}"> Вернуться назад</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Имя:</strong>
                    {{ $author->name }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Фамилия:</strong>
                    {{ $author->surname }}
                </div>
            </div>
        </div>
        <hr>
        <h2>Книги автора</h2>
        <ol>
            @foreach ($author->books as $book)
                <li><a href="{{ route('books.show',$book->id) }}">{{ $book->name }}</a></li>
            @endforeach
        </ol>
    </div>
@endsection