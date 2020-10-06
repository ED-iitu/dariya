@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('info.create') }}">Добавить Информация</a>
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
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($infos as $info)
                <tr>
                    <th scope="row">{{ $info->id }}</th>
                    <td><a href="{{ route('info.show',$info->id) }}">{{ $info->title }}</a></td>
                    <td>
                        <form class="delete" action="{{ route('info.destroy',$info->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('info.edit',$info->id) }}">Изменить</a>
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