@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('articles.create') }}">Добавить Статью</a>
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
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($articles as $article)
                <tr>
                    <th scope="row">{{ $article->id }}</th>
                    <td><a href="{{ route('articles.show',$article->id) }}">{{ $article->name }}</a></td>
                    @if ($article->authors)
                    <td>{{ $article->authors->name }}</td>
                    @else
                    <td>Автор не задан</td>
                    @endif
                    <td>
                        <form class="delete" action="{{ route('articles.destroy',$article->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('articles.edit',$article->id) }}">Изменить</a>
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