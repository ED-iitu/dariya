@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('authors.create') }}">Добавить Автора</a>
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
                <th scope="col">Имя</th>
                <th scope="col">Фамилия</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($authors as $author)
                <tr>
                    <th scope="row">{{ $author->id }}</th>
                    <td><a href="{{ route('authors.show',$author->id) }}">{{ $author->name }}</a></td>
                    <td>{{ $author->surname }}</td>
                    <td>
                        <form class="delete" action="{{ route('authors.destroy',$author->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('authors.edit',$author->id) }}">Изменить</a>
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger edit delete-confirm" onclick="return confirm('Are you sure?')">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection