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
                <th scope="col">Коды доступа</th>
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#codes_{{ $invite_to_vip->user_id }}">
                            Просмотр
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="codes_{{ $invite_to_vip->user_id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Коды для {{ $invite_to_vip->user->email }}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Код</th>
                                                <th>Осталось использовать</th>
                                                <th>Статус</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>
                                                        HLSHDH
                                                    </th>
                                                    <th class="text-center">
                                                        3
                                                    </th>
                                                    <th>
                                                        Активный
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="text" class="form-control" placeholder="Укажите VIP-контент">
                                            </div>
                                            <div class="col-4">
                                                <button type="submit" class="btn btn-primary mb-2 generate-code">Генерировать</button>                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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