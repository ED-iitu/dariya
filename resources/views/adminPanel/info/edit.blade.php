@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Обновление жанра < {{ $info->title }} ></h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('infoPage') }}"> Вернуться назад</a>
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

        <form action="{{ route('info.update',$info->id) }}" method="POST">
            @csrf
            @method('PUT')


                <div class="row mt-5">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Название" value="{{ $info->title }}">
                        </div>
                        <div class="form-group">
                            <textarea name="text" class="form-control" placeholder="Текст">{{ $info->text }}</textarea>
                        </div>
                        <div class="form-group">
                            <select name="type" class="form-control" placeholder="Название">
                                @foreach(App\Info::getTypeLabels() as $value=>$name)
                                    <option @if($value == $info->type) selected="selected" @endif value="{{$value}}">{{$name}}</option>
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