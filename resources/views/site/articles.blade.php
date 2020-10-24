@extends('layouts.app')
@section('title', $title)
@section('content')
    @include('site.blocks.breadcrumb', ['breadcrumb' => $breadcrumb])
    <!-- End Bradcaump area -->
    <!-- Start Blog Area -->
    <div class="page-blog bg--white blog-sidebar right-sidebar">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12">
                    <div class="blog-page">
                        <!-- Start Single Post -->
                        <div class="row mt--30 mb-3">
                        @foreach($articles as $article)
                            <div class="col-md-4">
                                @include('site.blocks.article')
                            </div>
{{--                        <article class="blog__post d-flex flex-wrap">--}}
{{--                            <div class="thumb">--}}
{{--                                <a href="{{route('article', $article->id)}}">--}}
{{--                                    <img src="{{$article->image_link}}" alt="blog images">--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                            <div class="content">--}}
{{--                                <h4><a href="{{route('article', $article->id)}}">{{$article->name}}</a></h4>--}}
{{--                                <ul class="post__meta">--}}
{{--                                    <li>Автор : <a href="{{url('/articles?author='.$article->author)}}">{{$article->author}}</a></li>--}}
{{--                                    <li class="post_separator">/</li>--}}
{{--                                    <li>{{$article->created_at}}</li>--}}
{{--                                    <li class="post_separator">/</li>--}}
{{--                                    <li>Просмотры: {{$article->show_counter}}</li>--}}
{{--                                </ul>--}}
{{--                                @php $rating = $article->rate; @endphp--}}
{{--                                <div>--}}
{{--                                    @foreach(range(1,5) as $i)--}}
{{--                                        @if($rating >0)--}}
{{--                                            @if($rating >0.5)--}}
{{--                                                <i class="fa fa-star"></i>--}}
{{--                                            @else--}}
{{--                                                <i class="fa fa-star-half-o"></i>--}}
{{--                                            @endif--}}
{{--                                        @else--}}
{{--                                            <i class="fa  fa-star-o"></i>--}}
{{--                                        @endif--}}
{{--                                        <?php $rating--; ?>--}}
{{--                                    @endforeach--}}
{{--                                    ( {{$article->rate ?? 0}} )--}}
{{--                                </div>--}}
{{--                                <p>{{$article->preview_text}}</p>--}}
{{--                                <div class="blog__btn">--}}
{{--                                    <a class="shopbtn" href="{{route('article', $article->id)}}">Читать</a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </article>--}}
                        @endforeach
                        </div>
                        <!-- End Single Post -->
                    </div>
                    {{$articles->links()}}
                </div>
                <div class="col-lg-3 col-12 md-mt-30 sm-mt-30 pt--30">
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
                            <h3 class="widget-title">Категории</h3>
                            <ul>
                                @foreach($categories as $category)
                                <li><a href="{{url('/articles?category='.$category->name)}}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection