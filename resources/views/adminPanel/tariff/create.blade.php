@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Добавление нового Тарифа</h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('tariffsPage') }}"> Вернуться назад</a>
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

        <form action="{{ route('tariffs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row mt-5">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="title">Название</label>
                        <input type="text" name="title" class="form-control" placeholder="Название">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text" name="slug" class="form-control" placeholder="Slug">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="description">Описание</label>
                        <textarea name="description" class="form-control" placeholder="Описание"></textarea>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="image_url" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" >
                            <label class="custom-file-label" for="inputGroupFile01">Загрузите картинку</label>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row border-right">
                        @foreach(\App\TariffPriceList::getDurationLabels() as $d=>$label)
                            @php
                                $id = 'd_'.$d;
                            @endphp
                            <div class="col-xs-4 col-sm-12 col-md-4 border-left border-top border-bottom p-3">
                                <div class="form-group">
                                    <label for="price">Цена</label>
                                    <select class="form-control" id="price" name="price_list[{{$id}}][price]">
                                        <option value="0">0</option>
                                        @foreach(\App\TariffPriceList::$prices as $p)
                                            <option value="{{$p}}">{{ \Akaunting\Money\Money::KZT($p, true)->format()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{ $label }}</label>
                                    <input type="hidden" value="{{ $d }}" name="price_list[{{$id}}][duration]">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                    <button type="submit" class="btn btn-primary">Добавить тариф</button>
                </div>
            </div>

        </form>
    </div>
@endsection