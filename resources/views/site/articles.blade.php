@extends('layouts.app')

@section('content')
    <div class="ht__bradcaump__area bg-image--4">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner text-center">
                        <h2 class="bradcaump-title">Статьи</h2>
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('home')}}">Главная</a>
                            <span class="brd-separetor">/</span>
                            <span class="breadcrumb_item active">Статьи</span>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Bradcaump area -->
    <!-- Start Blog Area -->
    <div class="page-blog bg--white section-padding--lg blog-sidebar right-sidebar">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="blog-page">
                        <div class="page__header">
                            <h2>Список статей</h2>
                        </div>
                        <!-- Start Single Post -->
                        @foreach($articles as $article)
                        <article class="blog__post d-flex flex-wrap">
                            <div class="thumb">
                                <a href="{{route('article', $article->id)}}">
                                    <img src="{{$article->image_link}}" alt="blog images">
                                </a>
                            </div>
                            <div class="content">
                                <h4><a href="{{route('article', $article->id)}}">{{$article->name}}</a></h4>
                                <ul class="post__meta">
                                    <li>Автор : <a href="#">{{$article->authors->name}}</a></li>
                                    <li class="post_separator">/</li>
                                    <li>{{$article->created_at}}</li>
                                    <li class="post_separator">/</li>
                                    <li>Просмотры: {{$article->show_counter}}</li>
                                </ul>
                                @php $rating = $article->rate; @endphp
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
                                    ( {{$article->rate ?? 0}} )
                                </div>
                                <p>{{$article->preview_text}}</p>
                                <div class="blog__btn">
                                    <a class="shopbtn" href="{{route('article', $article->id)}}">Читать</a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                        <!-- End Single Post -->
                    </div>
                    {{$articles->links()}}
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
                                                <a href="{{route('article', $recent->id)}}"><img src="{{$recent->image_link}}" alt="blog images"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="blog-details.html">{{$recent->name}}</a></h4>
                                                <p>	{{$recent->created_at}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>
                        <!-- Start Single Widget -->
                        <aside class="widget category_widget">
                            <h3 class="widget-title">Жанры</h3>
                            <ul>
                                @foreach($genres as $genre)
                                <li><a href="#">{{$genre->name}}</a></li>
                                @endforeach
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection