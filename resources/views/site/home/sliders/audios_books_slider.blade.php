<div id="audios_books_slider">
    <a class="link-to-all" href="{{ url('audioBooks') }}">Все аудиокниги</a>
    <div class="owl-carousel">
        @foreach($audio_books as $book)
            @include('site.blocks.audio_book')
        @endforeach
    </div>
</div>
