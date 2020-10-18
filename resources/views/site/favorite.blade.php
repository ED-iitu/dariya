@extends('layouts.app')

@section('content')

    <div class="ht__bradcaump__area bg-image--4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Избранные</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('home')}}">Главная</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Избранные</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Start Tab Box -->
    <section id="tabs_box">
        <div class="container mb-5">
            <div class="tabs">
                @include('site.home.tabs.components.tabs')
            </div>
            <div class="tabs-content">
                @include('site.home.tabs.components.tabs_content')
            </div>
        </div>
    </section>
    <!-- End Tab Box -->

    <div class="page-shop-sidebar left--sidebar bg--white section-padding--lg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12 order-1 order-lg-2">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="shop__list__wrapper d-flex flex-wrap flex-md-nowrap justify-content-between">
                                <div class="shop__list nav justify-content-center" role="tablist">
                                    <a class="nav-item nav-link active" data-toggle="tab" href="#nav-grid" role="tab"><i class="fa fa-th"></i></a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#nav-list" role="tab"><i class="fa fa-list"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                        <div class="tab__container">
                            <div class="shop-grid tab-pane fade show active" id="nav-grid" role="tabpanel">
                                <div class="row">

                                    @if(empty($books))
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                            У вас нет избранных
                                        </div>
                                    @else
                                    <!-- Start Single Product -->
                                        @foreach($books as $book)
                                            <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                                <div class="product">
                                                    <div class="product__thumb" style="height: 400px">
                                                        <a class="first__img" href="{{route('book', $book->id)}}"><img src="{{$book->image_link}}" alt="product image"></a>
                                                        <div class="new__box">
                                                            <span class="new-label">Hot</span>
                                                        </div>
                                                        <ul class="prize position__right__bottom d-flex">
                                                            <li>{{$book->price}} KZT</li>
                                                            <li class="old_prize">15000 KZT</li>
                                                        </ul>
                                                    </div>
                                                    <div class="product__content">
                                                        <h4><a href="single-product.html">{{$book->name}}</a></h4>
                                                        <ul class="cart__action d-flex">
                                                            <li class="cart"><a href="#">Купить книгу</a></li>
                                                        </ul>

                                                        <form action="{{route('unfavoriteBook', $book)}}" method="POST" class="mt-4">
                                                            @csrf
                                                            <ul class="cart__action d-flex" style="margin-top: -20px;">
                                                                <li class="wishlist"><button class="btn-danger" type="submit">Удалить из избранных </button></li>
                                                            </ul>
                                                        </form>
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


                                @endif

                            </div>
                            <div class="shop-grid tab-pane fade" id="nav-list" role="tabpanel">
                                <div class="list__view__wrapper">
                                @if(empty($books))

                                @else
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
                                                        <li class="cart"><a href="cart.html">Купить книгу</a></li>
                                                        <li class="wishlist"><a href="cart.html"></a></li>
                                                    </ul>

                                                </div>
                                            </div>

                                        @endforeach

                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

@endsection