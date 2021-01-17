<div data-role="header" data-position="fixed" data-fullscreen="true">
    <a href="#" id="close-detail" class="close-btn">Назад</a>
    <h1>{{ $lesson->name }}</h1>
</div>
@if($is_access)
    <div data-role="main" id="page-lesson" class="ui-content" data-theme="a" data-full="false">
        <div class="lesson-content">
            {{ $lesson->lesson }}
        </div>
        <div class="lesson-video">
            @foreach($lesson->videos as $video)
                @if($video->is_extenal)
                    <iframe src="{{ $video->video_link }}" width="100%" height="320" frameborder="0"
                            webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                @else
                    <video width="100%" height="320" controls>
                        <source src="{{ url($video->video_link) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @endif
            @endforeach
        </div>
    </div>
    <div data-role="footer" data-position="fixed" class="ui-bar">
        <a href="javascript:;" class="btn btn-primary finish-lesson" data-lesson-id="{{ $lesson->id }}">Завершить</a>
    </div>
@else
    <div data-role="main" id="page-lesson" class="ui-content" data-theme="a" data-full="false">
        <div class="lesson-content">
            Чтобы получить доступ к уроку купите подписку <a href="javascript:;" class="btn btn-link show-tariff">Премиум</a>
        </div>
    </div>
@endif