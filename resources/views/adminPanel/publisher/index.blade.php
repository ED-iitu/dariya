@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('publishers.create') }}">Добавить Издателя</a>
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
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($publishers as $publisher)
                <tr>
                    <th scope="row">{{ $publisher->id }}</th>
                    <td><a href="{{ route('publishers.show',$publisher->id) }}">{{ $publisher->name }}</a></td>
                    <td>
                        <form class="delete" action="{{ route('publishers.destroy',$publisher->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('publishers.edit',$publisher->id) }}">Изменить</a>
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