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
                <th scope="col">Пользователь</th>
                <th scope="col">Кто добавил</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($invites_to_vip as $invite_to_vip)
                <tr>
                    <th scope="row">{{ $invite_to_vip->id }}</th>
                    <td>
                        @if($invite_to_vip->user)
                        {{ $invite_to_vip->user->name }}<br>
                            [{{ $invite_to_vip->user->email }}]
                        @endif
                    </td>
                    <td>
                        @if($invite_to_vip->invited_user)
                            {{ $invite_to_vip->invited_user->name }}<br>
                            [{{ $invite_to_vip->invited_user->email }}]
                        @endif
                    </td>
                    <td>
                        <form class="delete" action="{{ route('invite_to_vip.destroy',$invite_to_vip->id) }}" method="POST">
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