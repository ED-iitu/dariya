@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <h2>Транзакции</h2>
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
                <th scope="col">Email</th>
                <th scope="col">Тип транзакции</th>
                <th scope="col">ID Книги</th>
                <th scope="col">Сумма</th>
                <th scope="col">ID Стороннего сервиса</th>
                <th scope="col">Статус</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($transactions as $transaction)
                <tr>
                    <th scope="row">{{ $transaction->transaction_id }}</th>
                    <td>{{ $transaction->users->email }}</td>
                    <td>{{$transaction->transaction_type}}</td>
                    <td>{{$transaction->object_id}}</td>
                    <td>{{$transaction->amount}}</td>
                    <td>{{$transaction->processor_transaction_id}}</td>
                    <td>
                        @if ($transaction->status === 1)
                            Оплачен
                        @else
                            Не оплачен
                        @endif
                    </td>
                    <td>
                        <form class="delete" action="{{ route('transactions.destroy',$transaction->transaction_id) }}" method="POST">@csrf
                            <a class="btn btn-success" href="{{ route('transactions.show',$transaction->transaction_id) }}">Посмотреть</a>
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