<div id="articles_slider">
    <a class="link-to-all" href="{{ url('articles') }}">Все статьи</a>
    <div class="owl-carousel">
        @foreach($articles as $article)
            @include('site.blocks.article')
        @endforeach
    </div>
</div>









