@extends('layouts.app')

@section('content')
    <div class="ht__bradcaump__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Книги</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('home')}}">Главная</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Книги</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- Start Shop Page -->
    <div class="page-shop-sidebar left--sidebar bg--white section-padding--lg">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-12 order-2 order-lg-1 md-mt-40 sm-mt-40">
                    <div class="shop__sidebar">
                        <aside class="wedget__categories poroduct--cat">
                            <h3 class="wedget__title">Жанры</h3>
                            <ul>
                                @foreach($genres as $genre)
                                <li><a href="#">{{$genre->name}} <span>(3)</span></a></li>
                                @endforeach
                            </ul>
                        </aside>
                        <aside class="wedget__categories poroduct--cat">
                            <h3 class="wedget__title">Авторы</h3>
                            <ul>
                                @foreach($authors as $author)
                                    <li><a href="#">{{$author->name}} {{$author->surname}}<span>(3)</span></a></li>
                                @endforeach
                            </ul>
                        </aside>
                        <aside class="wedget__categories pro--range">
                            <h3 class="wedget__title">Фильтр по цене</h3>
                            <div class="content-shopby">
                                <div class="price_filter s-filter clear">
                                    <form action="#" method="GET">
                                        <div id="slider-range"></div>
                                        <div class="slider__range--output">
                                            <div class="price__output--wrap">
                                                <div class="price--output">
                                                    <span>Цена :</span><input type="text" id="amount" readonly="">
                                                </div>
                                                <div class="price--filter">
                                                    <a href="#">Найти</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </aside>
                        @foreach($banners as $banner)
                        <aside class="wedget__categories sidebar--banner">
                            <a href="{{$banner->redirect}}"><img src="{{$banner->file_url}}" alt="banner images"></a>
                            <div class="text">
                                <h2>{{$banner->title}}</h2>
                                <h6>save up to <br> <strong>40%</strong>off</h6>
                            </div>
                        </aside>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-9 col-12 order-1 order-lg-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shop__list__wrapper d-flex flex-wrap flex-md-nowrap justify-content-between">
                                <div class="shop__list nav justify-content-center" role="tablist">
                                    <a class="nav-item nav-link active" data-toggle="tab" href="#nav-grid" role="tab"><i class="fa fa-th"></i></a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#nav-list" role="tab"><i class="fa fa-list"></i></a>
                                </div>
                                <p>Показ 1–12 из 40 результатов</p>
                                <div class="orderby__wrapper">
                                    <form action="{{route('filter')}}" method="GET">
                                        <span>Сортировать</span>
                                        <select class="shot__byselect" name="orderBy">
                                            <option value="ASC">По умолчанию</option>
                                            <option value="ASC">По возрастанию цены</option>
                                            <option value="DESC">По убыванию цены</option>
                                        </select>
                                        <input type="submit">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab__container">
                        <div class="shop-grid tab-pane fade show active" id="nav-grid" role="tabpanel">
                            <div class="row">
                                <!-- Start Single Product -->
                                @foreach($books as $book)
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="product">
                                        <div class="product__thumb">
                                            <a class="first__img" href="{{route('book', $book->id)}}"><img src="{{$book->image_link}}" alt="product image"></a>
                                            <div class="new__box">
                                                @if($book->type == "BOOK")
                                                <span class="new-label">PDF</span>
                                                @else
                                                <span class="new-label">Аудио</span>
                                                @endif
                                            </div>
                                            <ul class="prize position__right__bottom d-flex">
                                                <li>{{$book->price}} KZT</li>
                                                <li class="old_prize">15000 KZT</li>
                                            </ul>
                                            <div class="action">
                                                <div class="actions_inner">
                                                    <ul class="add_to_links">
                                                        <li><a class="cart" href="cart.html"></a></li>
                                                        <li><a class="wishlist" href="wishlist.html"></a></li>
                                                        <li><a class="compare" href="compare.html"></a></li>
                                                        <li><a data-toggle="modal" title="Quick View" class="quickview modal-view detail-link" href="#productmodal"></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product__content">
                                            <h4><a href="single-product.html">{{$book->name}}</a></h4>
                                            <ul class="rating d-flex">
                                                <li class="on"><i class="fa fa-star-o"></i></li>
                                                <li class="on"><i class="fa fa-star-o"></i></li>
                                                <li class="on"><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                                <!-- End Single Product -->
                            </div>

                                {{$books->links()}}

                        </div>
                        <div class="shop-grid tab-pane fade" id="nav-list" role="tabpanel">
                            <div class="list__view__wrapper">
                                <!-- Start Single Product -->
                                @foreach($books as $book)
                                <div class="list__view">
                                    <div class="thumb">
                                        <a class="first__img" href="{{route('book', $book->id)}}"><img src="{{$book->image_link}}" alt="product images"></a>
                                    </div>
                                    <div class="content">
                                        <h2><a href="{{route('book', $book->id)}}">{{$book->name}}</a></h2>
                                        <ul class="rating d-flex">
                                            <li class="on"><i class="fa fa-star-o"></i></li>
                                            <li class="on"><i class="fa fa-star-o"></i></li>
                                            <li class="on"><i class="fa fa-star-o"></i></li>
                                            <li class="on"><i class="fa fa-star-o"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                            <li><i class="fa fa-star-o"></i></li>
                                        </ul>
                                        <ul class="prize__box">
                                            <li>{{$book->price}} KZT</li>
                                            <li class="old__prize">12000 KZT</li>
                                        </ul>
                                        <p>{{$book->preview_text}}</p>
                                        <ul class="cart__action d-flex">
                                            <li class="cart"><a href="cart.html">Добавить в корзину</a></li>
                                            <li class="wishlist"><a href="cart.html"></a></li>
                                            <li class="compare"><a href="cart.html"></a></li>
                                        </ul>

                                    </div>
                                </div>

                                @endforeach
                                <!-- End Single Product -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection