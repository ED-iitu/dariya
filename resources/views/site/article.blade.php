@extends('layouts.app')

@section('content')
    @foreach($articles as $article)
    <div class="ht__bradcaump__area bg-image--6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">{{$article->name}}</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('home')}}">Главная</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">{{$article->name}}</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <div class="page-blog-details section-padding--lg bg--white">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="blog-details content">
                        <article class="blog-post-details">
                            <div class="post-thumbnail">
                                <img src="{{$article->image_link}}" alt="blog images">
                            </div>
                            <div class="post_wrapper">
                                <div class="post_header">
                                    <h2>{{$article->name}}</h2>
                                    <ul class="post_author">
                                        <li>Автор : <a href="#">{{$article->authors->name}}</a></li>
                                        <li class="post-separator">/</li>
                                        <li>{{$article->created_at}}</li>
                                    </ul>
                                </div>
                                <div class="post_content">
                                    <p>{{$article->detail_text}}</p>
                                </div>
                                <ul class="blog_meta">
                                    <li><a href="#">Нет комментариев</a></li>
                                </ul>
                            </div>
                        </article>
                        <div class="comment_respond">
                            <h3 class="reply_title">Написать комментарий</h3>
                            <form class="comment__form" action="#">
                                <div class="input__box">
                                    <label>Комментарий</label>
                                    <textarea name="comment"></textarea>
                                </div>
                                <div class="input__wrapper clearfix">
                                    <div class="input__box name one--third">
                                        <label>Имя</label>
                                        <input type="text" placeholder="Имя">
                                    </div>
                                    <div class="input__box email one--third">
                                        <label>Email</label>
                                        <input type="email" placeholder="email">
                                    </div>
                                </div>
                                <div class="submite__btn">
                                    <a href="#">Отправить комментарий</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-12 md-mt-40 sm-mt-40">
                    <div class="wn__sidebar">
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <aside class="widget recent_widget">
                            <h3 class="widget-title">Недавние</h3>
                            <div class="recent-posts">
                                <ul>
                                    @foreach($recentArticles as $recent)
                                    <li>
                                        <div class="post-wrapper d-flex">
                                            <div class="thumb">
                                                <a href="{{route('article', $article->id)}}"><img src="{{$recent->image_link}}" alt="blog images"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="{{route('article', $article->id)}}">{{$recent->name}}</a></h4>
                                                <p>	{{$recent->created_at}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <aside class="widget category_widget">
                            <h3 class="widget-title">Жанры</h3>
                            <ul>
                                @foreach($genres as $genre)
                                <li><a href="#">{{$genre->name}}</a></li>
                                @endforeach
                            </ul>
                        </aside>
                        <!-- End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endforeach

@endsection