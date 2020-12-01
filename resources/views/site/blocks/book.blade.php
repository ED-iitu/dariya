<div class="book-item">
    <a href="{{ url('book/'.$book->id) }}" class="image mb-2"
       style="
       @if($book->background_color)
               background-color:{{ $book->background_color }};
       @endif
               background-image: url( {{ url($book->image_link) }} );
               ">
        <span class="sale mt-3"><i class="fa fa-book"></i></span>
    </a>
    <h6 class="title mb-2"><a href="{{ url('book/'.$book->id) }}">{{ $book->name }}</a></h6>
    <div class="info mb-2">
        <span>{{\Jenssegers\Date\Date::parse($book->created_at)->format('j F, Y')}}</span>
        <ul class="mb-0">
            <li class="mr-2">
                <i class="bi bi-chat-bubble"></i>
                {{ $book->comments->count() }}
            </li>
            <li>
                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-eye" fill="currentColor"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                          d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z"></path>
                    <path fill-rule="evenodd"
                          d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                </svg>
                {{ $book->show_counter }}
            </li>
        </ul>
    </div>
    <div class="description">
        <p><a href="{{ url('book/'.$book->id) }}">{{$book->preview_text}}</a></p>
    </div>
    @if($book->isAccess())
        <div class="final">
            <a style="background: #f3ac61; border-color: #f3ac61" href="{{ route('readBook',$book->id) }}" class="order"><i class="fa fa-book"></i> Читать</a>
        </div>
    @else
        <div class="final">
            <a href="{{ url('book/'.$book->id) }}" class="order">Купить</a>
            <div class="price">
                @if($book->old_price)
                    <small>{{ \Akaunting\Money\Money::KZT($book->old_price)->format() }}</small>@endif
                <span>{{ \Akaunting\Money\Money::KZT($book->price)->format() }}</span>
            </div>
        </div>
    @endif
    @if(\Illuminate\Support\Facades\Auth::user())
        @if($book->isFavorite())
            <a href="{{ route('removeInFavorite', ['type' => 'article', 'id' => $book->id]) }}"
               class="a-remove-in-favorites"><i class="fa fa-heart"></i></a>
        @else
            <a href="{{ route('addToFavorite', ['type' => 'article', 'id' => $book->id]) }}"
               class="a-add-to-favorites"><i class="fa fa-heart-o"></i></a>
        @endif
    @endif
</div>
