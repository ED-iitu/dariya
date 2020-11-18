@extends('layouts.app')
@section('title', $title)
@section('content')

    @include('site.blocks.breadcrumb', ['breadcrumb' => $breadcrumb])
    <!-- End Bradcaump area -->
    <!-- Start main Content -->
    <div class="maincontent bg--white pb--55">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mt-3 mb-2">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <p>{!! $message !!}</p>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-12 col-12">
                    <div class="wn__single__product">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="wn__fotorama__wrapper">
                                    <div class="fotorama wn__fotorama__action" data-nav="thumbs"
                                         style="width: 300px;height: 400px;">
                                        <a href="1.jpg"><img src="{{$bookData->image_link}}" alt=""></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="product__info__main">
                                    <h1>{{$bookData->name}}</h1>
                                    <div class="product-info-stock-sku d-flex">
                                        <p>Доступно:<span> Да </span> <i class="fa fa-eye" aria-hidden="true"></i>
                                            :<span> {{$bookData->show_counter}}</span></p>
                                    </div>
                                    @php $rating = $bookData->rate; @endphp
                                    <div>
                                        @foreach(range(1,5) as $i)
                                            @if($rating >0)
                                                @if($rating >0.5)
                                                    <i class="fa fa-star"></i>
                                                @else
                                                    <i class="fa fa-star-half-o"></i>
                                                @endif
                                            @else
                                                <i class="fa  fa-star-o"></i>
                                            @endif
                                            <?php $rating--; ?>
                                        @endforeach
                                        ( {{$bookData->rate}} )
                                    </div>
                                    <div class="product-reviews-summary d-flex">
                                        <div class="reviews-actions d-flex">
                                            <a href="#">({{$bookData->comments->count()}} Отзывов)</a>
                                            <a data-toggle="tab" href="#nav-review" role="tab">Добавить отзыв</a>
                                        </div>
                                    </div>
                                    <div class="price-box">
                                        <span>{{$bookData->price}} KZT</span>
                                    </div>
                                    <div class="price-box">
                                        <span>Автор: {{$bookData->author->name}} {{$bookData->author->surname}}</span>
                                    </div>
                                    <div class="box-tocart d-flex">
                                        @if($bookData->isAccess())
                                            @if($bookData->type == \App\Book::AUDIO_BOOK_TYPE)
                                                <a href="{{ url('listenBook', $bookData->id) }}"
                                                   class="dariya-btn dariya-btn-yellow"><i class="fa fa-microphone"></i>
                                                    Слушать</a>
                                            @else
                                                <a href="{{ route('readBook', $bookData->id) }}"
                                                   class="dariya-btn dariya-btn-yellow"><i class="fa fa-book"></i>
                                                    Читать</a>
                                            @endif
                                        @else
                                            <form action="{{route('buy', ['product',$bookData->id])}}" method="post">
                                                @csrf
                                                <button type="submit" title="Купить книгу"
                                                        class="dariya-btn dariya-btn-yellow"><i
                                                            class="fa fa-shopping-bag"></i> Купить
                                                </button>
                                            </form>
                                        @endif
                                        @if(\Illuminate\Support\Facades\Auth::user())
                                            <div class="product-addto-links clearfix">
                                                @if($bookData->isBookFavorite())
                                                    <form action="{{route('unfavoriteBook', $bookData)}}" method="POST">
                                                        @csrf

                                                        <div class="addtocart__actions ml-2">
                                                            <button class="dariya-btn dariya-btn-red"
                                                                    type="submit" title="Добавить в избранное"><i
                                                                        class="fa fa-trash"></i> Удалить из избранных
                                                            </button>
                                                        </div>
                                                    </form>
                                                @else
                                                    <form action="{{route('favoriteBook', $bookData)}}" method="POST">
                                                        @csrf
                                                        <div class="addtocart__actions ml-2">
                                                            <button class="dariya-btn dariya-btn-blue"
                                                                    type="submit" title="Добавить в избранное"><i
                                                                        class="fa fa-heart"></i> Добавить в избранное
                                                            </button>
                                                        </div>

                                                    </form>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    <div class="product__overview">
                                        <p>{{$bookData->preview_text}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product__info__detailed">
                        <div class="pro_details_nav nav justify-content-start" role="tablist">
                            <a class="nav-item nav-link active" data-toggle="tab" href="#nav-details"
                               role="tab">Детали</a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#nav-review" role="tab">Отзывы</a>
                        </div>
                        <div class="tab__container">
                            <!-- Start Single Tab Content -->
                            <div class="pro__tab_label tab-pane fade show active" id="nav-details" role="tabpanel">
                                <div class="description__attribute">
                                    {!! $bookData->detail_text !!}
                                </div>
                            </div>
                            <!-- End Single Tab Content -->
                            <!-- Start Single Tab Content -->
                            <div class="pro__tab_label tab-pane fade" id="nav-review" role="tabpanel">
                                <div class="review__attribute">
                                    <h1>Отзывы читателей</h1>
                                    <div class="review__ratings__type d-flex">
                                        <div class="review-ratings">
                                            @if(empty($comments))
                                                <div class="rating-summary d-flex">
                                                    <span>Отзывы отсутствуют</span>
                                                </div>
                                            @else
                                                @foreach($comments as $comment)
                                                    <div class="card mt-3"
                                                         style="flex-direction: row;width: 500px !important;">
                                                        <div class="card-header">
                                                            {{$comment->nickname}}
                                                        </div>
                                                        <div class="card-body">
                                                            <blockquote class="blockquote mb-0">
                                                                <p>{{$comment->message}}</p>
                                                                <footer class="blockquote-footer">{{$comment->created_at}}</footer>
                                                            </blockquote>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @if( Auth::user())
                                    <div class="review-fieldset">
                                        <h2>Оставить отзыв</h2>
                                        <h5>{{$bookData->name}}</h5>
                                        <form action="{{route('comment')}}" method="GET">
                                            <div>
                                                <div class="rate-rating">
                                                    <label>
                                                        <input type="radio" name="stars" value="1"/>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 1 ) active @endif">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="2"/>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 2 ) active @endif">★</span>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 2 ) active @endif">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="3"/>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 3 ) active @endif">★</span>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 3 ) active @endif">★</span>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 3 ) active @endif">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="4"/>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 4 ) active @endif">★</span>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 4 ) active @endif">★</span>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 4 ) active @endif">★</span>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 4 ) active @endif">★</span>
                                                    </label>
                                                    <label>
                                                        <input type="radio" name="stars" value="5"/>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 5 ) active @endif">★</span>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 5 ) active @endif">★</span>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 5 ) active @endif">★</span>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 5 ) active @endif">★</span>
                                                        <span class="rate-icon @if(Auth::user()->getRatingForBook($bookData->id) && Auth::user()->getRatingForBook($bookData->id) >= 5 ) active @endif">★</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <input type="hidden" name="object_id" value="{{$bookData->id}}">
                                            <input type="hidden" name="object_type" value="book">
                                            <input type="hidden" name="author_id" value="{{Auth::user()->id}}">
                                            <div class="review_form_field">
                                                <div class="input__box">
                                                    <span>Отзыв</span>
                                                    <textarea name="message"></textarea>
                                                </div>
                                                <div class="submite__btn">
                                                    <button class="btn btn-primary" type="submit">Отправить отзыв
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @else
                                    <div>
                                        Чтобы оставить отзыв вам необходимо <a
                                                href="{{route('signin')}}">Авторизоваться</a>
                                    </div>
                                @endif
                            </div>
                            <!-- End Single Tab Content -->
                        </div>
                    </div>
                    <div class="wn__related__product pt--80 pb--50">
                        <div class="section__title text-center">
                            <h2 class="title__be--2">Похожие книги</h2>
                        </div>
                        <div class="row mt--60">
                            <div class="container">
                                <div id="books_slider">
                                    <a class="link-to-all"
                                       href="{{ route(($bookData->type == \App\Book::BOOK_TYPE) ? 'books' : 'audio_books', $relatedBooksFilterParams) }}">Все
                                        книги</a>
                                    <div class="owl-carousel">
                                        @foreach($relatedBooks as $book)
                                            @include('site.blocks.book')
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection