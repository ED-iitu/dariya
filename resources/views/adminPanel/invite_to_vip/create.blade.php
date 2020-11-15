@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Добавление нового приглашения к VIP</h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('categoriesPage') }}"> Вернуться назад</a>
                </div>
            </div>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('invite_to_vip.store') }}" method="POST">
            @csrf

            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="use_id">Пользователь</label>
                        <select name="user_id" class="form-control">
                            @foreach($users as $user)
                                <option value="{{$user->id}}">{{$user->name}} [{{$user->email}}]</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Добавить</button>
                </div>
            </div>

        </form>
    </div>
@endsection