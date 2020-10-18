@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Добавление нового Баннера</h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('bannersPage') }}"> Вернуться назад</a>
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

        <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Название">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" name="background_color" class="form-control" placeholder="Цвет фона">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="type">Тип баннера</label>
                        <select name="type" class="form-control">
                            @foreach(\App\Banner::getBannerTypes() as $type=>$type_name)
                                <option value="{{$type}}">{{$type_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <input type="text" name="redirect" class="form-control" placeholder="Ссылка куда перенаправлять">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="file_url" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" >
                            <label class="custom-file-label" for="inputGroupFile01">Загрузите картинку</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Добавить Баннер</button>
                </div>
            </div>

        </form>
    </div>
@endsection