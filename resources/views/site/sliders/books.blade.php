<div id="books_slider">
    <a class="link-to-all" href="{{ url('books') }}">Все книги</a>
    <div class="owl-carousel">
        @foreach($books as $book)
            @include('site.blocks.book')
        @endforeach
    </div>
</div>
