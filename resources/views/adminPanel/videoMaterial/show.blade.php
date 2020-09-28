@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Видео: {{$video->youtube_video_id}}</h2>
                </div>
                <div>
                    <a class="btn btn-primary" href="{{ route('videoMaterialsPage') }}"> Вернуться назад</a>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>ID видео с ютуба:</strong>
                    {{ $video->youtube_video_id }}
                </div>
            </div>
        </div>
    </div>
@endsection