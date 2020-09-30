@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <h2>Support Tickets</h2>
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
                <th scope="col">Тема</th>
                <th scope="col">Пользователь</th>
                <th scope="col">Описание</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($supportTickets as $supportTicket)
                <tr>
                    <th scope="row">{{ $supportTicket->id }}</th>
                    <td><a href="{{ route('supportTickets.show',$supportTicket->id) }}">{{ $supportTicket->title }}</a></td>
                    <td>{{$supportTicket->credential}}</td>
                    <td>{{$supportTicket->description}}</td>
                    <td>
                        <form class="delete" action="{{ route('supportTickets.destroy',$supportTicket->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('supportTickets.edit',$supportTicket->id) }}">Изменить</a>
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