@extends('layouts.app')

@section('content')
    @foreach($book as $bookData)
    <div class="ht__bradcaump__area bg-image--4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">{{$bookData->name}}</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('home')}}">Главная</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">{{$bookData->name}}</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- Start main Content -->
    <div class="maincontent bg--white pt--80 pb--55">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-12">
                    <div class="wn__single__product">
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="wn__fotorama__wrapper">
                                    <div class="fotorama wn__fotorama__action" data-nav="thumbs">
                                        <a href="1.jpg"><img src="{{$bookData->image_link}}" alt=""></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="product__info__main">
                                    <h1>{{$bookData->name}}</h1>
                                    <div class="product-info-stock-sku d-flex">
                                        <p>Доступно:<span> Да</span></p>
                                    </div>
                                    <div class="product-reviews-summary d-flex">
                                        <ul class="rating-summary d-flex">
                                            <li><i class="zmdi zmdi-star-outline"></i></li>
                                            <li><i class="zmdi zmdi-star-outline"></i></li>
                                            <li><i class="zmdi zmdi-star-outline"></i></li>
                                            <li class="off"><i class="zmdi zmdi-star-outline"></i></li>
                                            <li class="off"><i class="zmdi zmdi-star-outline"></i></li>
                                        </ul>
                                        <div class="reviews-actions d-flex">
                                            <a href="#">(0 Отзывов)</a>
                                            <a data-toggle="tab" href="#nav-review" role="tab">Добавить отзыв</a>
                                        </div>
                                    </div>
                                    <div class="price-box">
                                        <span>{{$bookData->price}} KZT</span>
                                    </div>
                                    <div class="price-box">
                                        <span>Автор: {{$bookData->authors->name}} {{$bookData->authors->surname}}</span>
                                    </div>
                                    <div class="box-tocart d-flex">
                                        <form action="">
                                            <span>Qty</span>
                                            <input id="qty" class="input-text qty" name="qty" min="1" value="1" title="Qty" type="number">
                                            <div class="addtocart__actions">
                                                <button class="tocart" type="submit" title="Add to Cart">Добавить в корзину</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="product-addto-links clearfix">
                                        <a class="wishlist" href="#"></a>
                                        <a class="compare" href="#"></a>
                                        <a class="email" href="#"></a>
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
                            <a class="nav-item nav-link active" data-toggle="tab" href="#nav-details" role="tab">Детали</a>
                            <a class="nav-item nav-link" data-toggle="tab" href="#nav-review" role="tab">Отзывы</a>
                        </div>
                        <div class="tab__container">
                            <!-- Start Single Tab Content -->
                            <div class="pro__tab_label tab-pane fade show active" id="nav-details" role="tabpanel">
                                <div class="description__attribute">
                                    <p>{{$bookData->detail_text}}</p>
                                </div>
                            </div>
                            <!-- End Single Tab Content -->
                            <!-- Start Single Tab Content -->
                            <div class="pro__tab_label tab-pane fade" id="nav-review" role="tabpanel">
                                <div class="review__attribute">
                                    <h1>Отзывы читателей</h1>
                                    <div class="review__ratings__type d-flex">
                                        <div class="review-ratings">
                                            <div class="rating-summary d-flex">
                                                <span>Отзывы отсутствуют</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="review-fieldset">
                                    <h2>Оставить отзыв</h2>
                                    <h5>{{$bookData->name}}</h5>
                                    <div class="review_form_field">
                                        <div class="input__box">
                                            <span>Имя</span>
                                            <input id="nickname_field" type="text" name="name">
                                        </div>
                                        <div class="input__box">
                                            <span>Отзыв</span>
                                            <textarea name="review"></textarea>
                                        </div>
                                        <div class="review-form-actions">
                                            <button>Оставить отзыв</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End Single Tab Content -->
                        </div>
                    </div>
                    <div class="wn__related__product pt--80 pb--50">
                        <div class="section__title text-center">
                            <h2 class="title__be--2">Похожие книги</h2>
                        </div>
                        <div class="row mt--60">
                            <div class="productcategory__slide--2 arrows_style owl-carousel owl-theme">
                                <!-- Start Single Product -->
                                @foreach($relatedBooks as $related)
                                <div class="col-lg-4 col-md-4 col-sm-6 col-12">
                                    <div class="product">
                                        <div class="product__thumb">
                                            <a class="first__img" href="{{route('book', $related->id)}}"><img src="{{$related->image_link}}" alt="product image"></a>
                                            <div class="new__box">
                                                <span class="new-label">Новый</span>
                                            </div>
                                            <ul class="prize position__right__bottom d-flex">
                                                <li>{{$related->price}} KZT</li>
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
                                            <h4><a href="{{route('book', $related->id)}}">{{$related->name}}</a></h4>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endsection