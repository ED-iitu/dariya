@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('page.create') }}">Добавить страницу</a>
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
                <th scope="col">Ссылка</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($pages as $page)
                <tr>
                    <th scope="row">{{ $page->id }}</th>
                    <td><a href="{{ route('page.show',$page->id) }}">{{ $page->title }}</a></td>
                    <td><a target="_blank" href="{{ route('page',$page->id) }}">{{ route('page',$page->id) }}</a></td>
                    <td>
                        <form class="delete" action="{{ route('page.destroy',$page->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('page.edit',$page->id) }}">Изменить</a>
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