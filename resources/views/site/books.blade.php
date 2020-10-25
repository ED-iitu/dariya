@extends('layouts.app')
@section('title', $title)
@section('content')
    @include('site.blocks.breadcrumb', ['breadcrumb' => $breadcrumb])
    <div class="mt-3 mb-2">
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
    </div>
    <!-- End Bradcaump area -->
    <!-- Start Shop Page -->
    <div class="page-shop-sidebar left--sidebar bg--white">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 order-2 order-lg-1 md-mt-40 sm-mt-40">
                    <form name="book_filter" action="{{ Request::is('books') ? '/books' : '/audio_books' }}">
                        <div class="shop__sidebar">
                            <aside class="wedget__categories poroduct--cat">
                                <h3 class="wedget__title">Жанры@if($genres) [{{ $genres->count() }}]@endif <i class="fa fa-arrow-circle-down"></i></h3>
                                <ul @if(app('request')->get('genres')) style="display: block" @else  style="display: none" @endif>
                                    @foreach($genres as $genre)
                                        <li @if(app('request')->get('genres') && in_array($genre->id ,app('request')->get('genres'))) class="active" @endif>
                                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}"  @if(app('request')->get('genres') && in_array($genre->id ,app('request')->get('genres'))) checked="checked" @endif>
                                            <a href="javascript:;">{{$genre->name}}
                                                <span>({{ Request::is('books') ? $genre->books->count() : $genre->audio_books->count() }})</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>
                            <aside class="wedget__categories poroduct--cat">
                                <h3 class="wedget__title">Авторы@if($authors) [{{ $authors->count() }}]@endif <i class="fa fa-arrow-circle-down"></i></h3>
                                <ul @if(app('request')->get('authors')) style="display: block" @else  style="display: none" @endif>
                                    @foreach($authors as $author)
                                        <li @if(app('request')->get('authors') && in_array($author->id ,app('request')->get('authors'))) class="active" @endif>
                                            <input type="checkbox" name="authors[]" value="{{ $author->id }}"  @if(app('request')->get('authors') && in_array($author->id ,app('request')->get('authors'))) checked="checked" @endif>
                                            <a href="javascript:;">{{$author->name}} {{$author->surname}}<span>({{ Request::is('books') ? $author->books->count() : $author->audio_books->count() }})</span></a>
                                        </li>
                                    @endforeach
                                </ul>
                            </aside>
                            <aside class="wedget__categories">
                                <button class="btn @if(!empty(app('request')->get('authors')) || !empty(app('request')->get('genres'))) btn-primary @endif">Применить</button>
                                <a href="javascript:;" class="btn btn-info book-filter-clear"><i class="fa fa-close"></i></a>
                            </aside>
                            {{--                        @foreach($banners as $banner)--}}
                            {{--                        <aside class="wedget__categories sidebar--banner">--}}
                            {{--                            <a href="{{$banner->redirect}}"><img src="{{$banner->file_url}}" alt="banner images"></a>--}}
                            {{--                            <div class="text">--}}
                            {{--                                <h2>{{$banner->title}}</h2>--}}
                            {{--                                <h6>save up to <br> <strong>40%</strong>off</h6>--}}
                            {{--                            </div>--}}
                            {{--                        </aside>--}}
                            {{--                        @endforeach--}}
                        </div>
                    </form>
                </div>
                <div class="col-lg-9 col-12 order-1 order-lg-2">
                    <div class="tab__container">
                        <div class="shop-grid tab-pane fade show active" id="nav-grid" role="tabpanel">
                            <div class="row">
                                <!-- Start Single Product -->
                                @foreach($books as $book)
                                    <div class="col-md-4 mb-3 col-6">
                                        @if($book->type == \App\Book::BOOK_TYPE)
                                            @include('site.blocks.book')
                                        @else
                                            @include('site.blocks.audio_book')
                                        @endif
                                    </div>

                                {{--                                <div class="col-lg-4 col-md-4 col-sm-6 col-12" >--}}
                                {{--                                    <div class="product">--}}
                                {{--                                        <div class="product__thumb" style="height: 400px">--}}
                                {{--                                            <a class="first__img" href="{{route('book', $book->id)}}"><img src="{{$book->image_link}}" alt="product image"></a>--}}
                                {{--                                            <div class="new__box">--}}
                                {{--                                                @if($book->type == "BOOK")--}}
                                {{--                                                <span class="new-label">PDF</span>--}}
                                {{--                                                @else--}}
                                {{--                                                <span class="new-label">Аудио</span>--}}
                                {{--                                                @endif--}}
                                {{--                                            </div>--}}
                                {{--                                            <ul class="prize position__right__bottom d-flex">--}}
                                {{--                                                <li>{{$book->price}} KZT</li>--}}
                                {{--                                            </ul>--}}
                                {{--                                        </div>--}}
                                {{--                                        <div class="product__content">--}}
                                {{--                                            <h4>--}}
                                {{--                                                <a href="{{route('book', $book->id)}}">{{$book->name}}</a>--}}
                                {{--                                                <ul class="cart__action d-flex">--}}
                                {{--                                                    <li class="cart"><a href="#">Купить книгу</a></li>--}}
                                {{--                                                </ul>--}}
                                {{--                                                @if($book->favorited())--}}
                                {{--                                                <form action="{{route('unfavoriteBook', $book)}}" method="POST">--}}
                                {{--                                                    @csrf--}}
                                {{--                                                    <ul class="cart__action d-flex" style="margin-top: -20px;">--}}
                                {{--                                                        <li class="wishlist"><button class="btn-danger" type="submit">Удалить из избранных </button></li>--}}
                                {{--                                                    </ul>--}}
                                {{--                                                </form>--}}
                                {{--                                                @else--}}
                                {{--                                                    <form action="{{route('favoriteBook', $book)}}" method="POST">--}}
                                {{--                                                        @csrf--}}
                                {{--                                                        <ul class="cart__action d-flex" style="margin-top: -20px;">--}}
                                {{--                                                            <li class="wishlist"><button class="btn-success" type="submit">Добавить в избранное </button></li>--}}
                                {{--                                                        </ul>--}}
                                {{--                                                    </form>--}}
                                {{--                                                @endif--}}


                                {{--                                            </h4>--}}
                                {{--                                            <p>Кол-во просмотров: {{$book->show_counter}}</p>--}}
                                {{--                                            @php $rating = $book->rate; @endphp--}}
                                {{--                                            <div>--}}
                                {{--                                                @foreach(range(1,5) as $i)--}}
                                {{--                                                    @if($rating >0)--}}
                                {{--                                                        @if($rating >0.5)--}}
                                {{--                                                            <i class="fa fa-star"></i>--}}
                                {{--                                                        @else--}}
                                {{--                                                            <i class="fa fa-star-half-o"></i>--}}
                                {{--                                                        @endif--}}
                                {{--                                                    @else--}}
                                {{--                                                        <i class="fa  fa-star-o"></i>--}}
                                {{--                                                    @endif--}}
                                {{--                                                    <?php $rating--; ?>--}}
                                {{--                                                @endforeach--}}
                                {{--                                                ( {{$book->rate ?? 0}} )--}}
                                {{--                                            </div>--}}
                                {{--                                        </div>--}}
                                {{--                                    </div>--}}
                                {{--                                </div>--}}
                            @endforeach
                            <!-- End Single Product -->
                            </div>

                            {{$books->links()}}

                        </div>
                        {{--                        <div class="shop-grid tab-pane fade" id="nav-list" role="tabpanel">--}}
                        {{--                            <div class="list__view__wrapper">--}}
                        {{--                                <!-- Start Single Product -->--}}
                        {{--                                @foreach($books as $book)--}}
                        {{--                                <div class="list__view">--}}
                        {{--                                    <div class="thumb">--}}
                        {{--                                        <a class="first__img" href="{{route('book', $book->id)}}"><img src="{{$book->image_link}}" alt="product images"></a>--}}
                        {{--                                    </div>--}}
                        {{--                                    <div class="content">--}}
                        {{--                                        <h2><a href="{{route('book', $book->id)}}">{{$book->name}}</a></h2>--}}
                        {{--                                        <ul class="rating d-flex">--}}
                        {{--                                            <li class="on"><i class="fa fa-star-o"></i></li>--}}
                        {{--                                            <li class="on"><i class="fa fa-star-o"></i></li>--}}
                        {{--                                            <li class="on"><i class="fa fa-star-o"></i></li>--}}
                        {{--                                            <li class="on"><i class="fa fa-star-o"></i></li>--}}
                        {{--                                            <li><i class="fa fa-star-o"></i></li>--}}
                        {{--                                            <li><i class="fa fa-star-o"></i></li>--}}
                        {{--                                        </ul>--}}
                        {{--                                        <ul class="prize__box">--}}
                        {{--                                            <li>{{$book->price}} KZT</li>--}}
                        {{--                                            <li class="old__prize">12000 KZT</li>--}}
                        {{--                                        </ul>--}}
                        {{--                                        <p>{{$book->preview_text}}</p>--}}
                        {{--                                        <ul class="cart__action d-flex">--}}
                        {{--                                            <li class="cart"><a href="#">Купить книгу</a></li>--}}
                        {{--                                            <li class="wishlist"><a href="cart.html"></a></li>--}}
                        {{--                                        </ul>--}}

                        {{--                                    </div>--}}
                        {{--                                </div>--}}

                        {{--                                @endforeach--}}
                        {{--                                <!-- End Single Product -->--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection