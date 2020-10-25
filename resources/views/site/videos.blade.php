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
                        @foreach($videos as $video)
                            <div class="col-md-4 col-6">
                                @include('site.blocks.video')
                            </div>
                        @endforeach
                        </div>
                        <!-- End Single Post -->
                    </div>
                    {{$videos->links()}}
                </div>
                <div class="col-lg-3 col-12 md-mt-30 sm-mt-30 pt--30">
                    <div class="wn__sidebar">
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <aside class="widget recent_widget">
                            <h3 class="widget-title">Недавние</h3>
                            <div class="recent-posts">
                                <ul>
                                    @foreach($recentVideos as $recent)
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