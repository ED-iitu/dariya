@extends('layouts.admin-app')
@section('admin-content')
    <style>
        .edit{
            font-size: 10px;
        }
    </style>
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('books.create') }}">Добавить книгу</a>
        </div>
        <div class="mt-3 mb-2">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
        </div>

        <hr>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Название</th>
                <th scope="col">Автор</th>
                <th scope="col">Кол-во просмотров</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($books as $book)
            <tr>
                <th scope="row">{{ $book->id }}</th>
                <td><a href="{{ route('books.show',$book->id) }}">{{ $book->name }}</a></td>
                @if($book->authors)
                <td>{{ $book->authors->name }} {{ $book->authors->surname }}</td>
                @else
                    <td>Автор не задан</td>
                @endif

                <td>{{ $book->show_counter }}</td>
                <td>
                    <form action="{{ route('books.destroy',$book->id) }}" method="POST">
                        <a class="btn btn-primary edit" href="{{ route('books.edit',$book->id) }}">Изменить</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger edit">Удалить</button>
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection