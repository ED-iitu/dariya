@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('invite_to_vip.create') }}">Добавить</a>
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

            @foreach($invites_to_vip as $invite_to_vip)
                <tr>
                    <th scope="row">{{ $invite_to_vip->id }}</th>
                    <td><a href="{{ route('categories.show',$invite_to_vip->id) }}">{{ $invite_to_vip->name }}</a></td>
                    <td>
                        <form class="delete" action="{{ route('categories.destroy',$invite_to_vip->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('categories.edit',$invite_to_vip->id) }}">Изменить</a>
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