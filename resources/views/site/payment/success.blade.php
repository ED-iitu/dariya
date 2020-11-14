@extends('layouts.app')
@section('title', 'Ваша покупка успешно завершена!')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="jumbotron">
                    <div class="alert alert-success" role="alert">
                        Ваша покупка успешно завершена!
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="display-4">{{ $product_name }}</h3>
                        </div>
                        <div class="col-md-4">
                            <img class="image img-thumbnail" src="{{ $image }}" alt="">
                        </div>
                        <div class="col-md-8">
                            <p class="lead">{{ $description }}</p>
                        </div>
                    </div>

                    <hr class="my-4">
                    <p>{{ $text }}.</p>
                    <p class="lead">
                        <a class="btn btn-success btn-lg" href="#" role="button">
                            <i class="fa fa-android"></i> Google Play
                        </a>
                        <a class="btn btn-light btn-lg" href="#" role="button">
                            <i class="fa fa-apple"></i> App Store
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection