@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('banners.create') }}">Добавить Баннер</a>
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
                <th scope="col">Фоновый цвет</th>
                <th scope="col">Тип</th>
                <th scope="col">Перенаправление</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($banners as $banner)
                <tr>
                    <th scope="row">{{ $banner->id }}</th>
                    <td><a href="{{ route('banners.show',$banner->id) }}">{{ $banner->title }}</a></td>
                    <td style="background-color: {{ $banner->background_color }}"></td>
                    <td>{{ $banner->type_name() }}</td>
                    <td>{{ $banner->redirect }}</td>
                    <td>
                        <form class="delete" action="{{ route('banners.destroy',$banner->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('banners.edit',$banner->id) }}">Изменить</a>
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