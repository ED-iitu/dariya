<div data-role="page" id="lesson" data-theme="a" data-fullscreen="true">
    <div data-role="header" data-position="fixed" data-fullscreen="true">
        <a href="#" id="close-detail" class="close-btn">Назад</a>
        <h1>{{ $lesson->name }}</h1>
    </div>
    @if($is_access)
        <div data-role="main" id="page-lesson" class="ui-content" data-theme="a" data-full="false">
            <div class="lesson-content">
                {!! $lesson->lesson !!}
            </div>
            <div class="lesson-video">
                @foreach($lesson->videos as $video)
                    @if($video->is_external)
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
            @if($lesson->files)
                <div class="lesson-files" style="padding: 20px">
                    @foreach($lesson->files as $file)
                        @if($file->is_extenal)
                            <p>Файл: <a href="{{ $file->file_url }}" target="_blank">{{ $file->title }}</a></p>
                        @else
                            <p>Файл: <a href="{{ url($file->file_url) }}" target="_blank">{{ $file->title }}</a></p>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
        @if(!$lesson->is_finished())
            <div data-role="footer" data-position="fixed" class="ui-bar">
                <a href="javascript:;" class="btn btn-primary finish-lesson" data-lesson-id="{{ $lesson->id }}">Завершить</a>
            </div>
        @endif
    @else
        <div data-role="main" id="page-lesson" class="ui-content" data-theme="a" data-full="false">
            @if(\Illuminate\Support\Facades\Auth::check())
                <div class="lesson-content">
                    Чтобы получить доступ к уроку купите подписку <a href="javascript:;"
                                                                     class="btn btn-link show-tariff">Премиум</a>
                </div>
            @else
                <div class="lesson-content">
                    <p>Чтобы получить доступ к курсам авторизуйтесь!</p>
                </div>
            @endif
        </div>
    @endif
</div>
