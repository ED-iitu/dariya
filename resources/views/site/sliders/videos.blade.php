<div id="videos_slider">
    <a class="link-to-all" href="#">Все видео</a>
    <div class="owl-carousel">
        @foreach($videos as $video)
            @include('site.blocks.video')
        @endforeach
    </div>
</div>
