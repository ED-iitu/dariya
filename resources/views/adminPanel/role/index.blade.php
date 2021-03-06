@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('role.create') }}">Добавить роль</a>
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

            @foreach($roles as $role)
                <tr>
                    <th scope="row">{{ $role->id }}</th>
                    <td><a href="{{ route('role.show',$role->id) }}">{{ $role->name }}</a></td>
                    <td>
                        <form class="delete" action="{{ route('role.destroy',$role->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('role.edit',$role->id) }}">Изменить</a>
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