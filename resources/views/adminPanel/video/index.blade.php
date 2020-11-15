@extends('layouts.admin-app')
@section('admin-content')
    <div class="container">
        <div>
            <a class="btn btn-success" href="{{ route('videos.create') }}">Добавить Видео</a>
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
                <th scope="col">Название</th>
                <th scope="col">ID видео на ютубе</th>
                <th></th>
            </tr>
            </thead>
            <tbody>

            @foreach($videos as $video)
                <tr>
                    <th scope="row">{{ $video->id }}</th>
                    <th>
                        {{ $video->name}}
                        @if($video->for_vip)
                            <span class="badge badge-success">VIP</span>
                        @endif
                    </th>
                    <td><a href="{{ route('videos.show',$video->id) }}">{{ $video->youtube_video_id }}</a></td>
                    <td>
                        <form class="delete" action="{{ route('videos.destroy',$video->id) }}" method="POST">
                            <a class="btn btn-primary edit" href="{{ route('videos.edit',$video->id) }}">Изменить</a>
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