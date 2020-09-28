@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Обновление жанра < {{ $genre->name }} ></h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('genresPage') }}"> Вернуться назад</a>
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

        <form action="{{ route('genres.update',$genre->id) }}" method="POST">
            @csrf
            @method('PUT')


                <div class="row mt-5">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="form-group">
                            <input type="text" name="name" class="form-control" placeholder="Название" value="{{ $genre->name }}">
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                        <button type="submit" class="btn btn-primary">Обновить Жанр</button>
                    </div>
                </div>


        </form>
    </div>
@endsection