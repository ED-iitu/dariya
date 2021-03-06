@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('tariffs.create') }}">Добавить Тариф</a>
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
                <th scope="col">Описание</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($tariffs as $tariff)
                <tr>
                    <th scope="row">{{ $tariff->id }}</th>
                    <td><a href="{{ route('tariffs.show',$tariff->id) }}">{{ $tariff->title }}</a></td>
                    <td>{{ $tariff->description }}</td>
                    <td>
                        <form class="delete" action="{{ route('tariffs.destroy',$tariff->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('tariffs.edit',$tariff->id) }}">Изменить</a>
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