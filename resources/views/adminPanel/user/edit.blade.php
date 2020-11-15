@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Обновление < {{ $user->name }} ></h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('usersPage') }}"> Вернуться назад</a>
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

        <form action="{{ route('users.update',$user->id) }}" method="POST">
            @csrf
            @method('PUT')


                <div class="row mt-5">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Имя" value="{{ $user->name }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="E-mail" value="{{ $user->email }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Пароль">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <label for="role">Роль</label>
                            <select name="role" class="form-control">
                                <option value="0">Пользователь</option>
                                @foreach($roles as $role)
                                    @if($user->hasRole($role->slug))
                                        <option selected="selected" value="{{$role->id}}">{{$role->name}}</option>
                                    @else
                                        <option value="{{$role->id}}">{{$role->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Обновить</button>
                    </div>
                </div>


        </form>
    </div>
@endsection