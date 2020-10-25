@extends('layouts.app')
@section('title', $title)
@section('content')
    @include('site.blocks.breadcrumb', ['breadcrumb' => $breadcrumb])
    <!-- End Bradcaump area -->
    <div class="page-blog-details bg--white">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-12 mt--30 mb-3">
                    <div class="blog-details content">
                        <article class="blog-post-details">
                            <div class="post-thumbnail">
                                <img src="{{$article->image_link}}" alt="blog images">
                            </div>
                            <div class="post_wrapper">
                                <div class="post_header">
                                    <h2>{{$article->name}}</h2>
                                    <ul class="post_author">
                                        <li>Автор : <a href="{{url('/articles?author='.$article->author)}}">{{$article->author}}</a></li>
                                        <li class="post-separator">/</li>
                                        <li>{{\Jenssegers\Date\Date::parse($article->created_at)->format('j F, Y')}}</li>
                                        <li class="post-separator">/</li>
                                        <li> <i class="fa fa-eye" aria-hidden="true"></i> {{$article->show_counter}}</li>
                                    </ul>
                                    @include('site.blocks.share_links')
                                    @php $rating = $article->rate; @endphp
                                    <div style="display: inline-block">
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
                                </div>
                                <div class="post_content">
                                    {!! $article->detail_text !!}
                                </div>
                                @if(empty($comments))
                                    <ul class="blog_meta">
                                        <li><a href="#">Нет отзывов</a></li>
                                    </ul>
                                @else
                                    <div class="comments_area mt-3">
                                        <h3 class="comment__title">{{$comments->count()}} отзывов</h3>
                                        <ul class="comment__list">
                                            @foreach($comments as $comment)
                                            <li>
                                                <div class="wn__comment">
                                                    <div class="thumb">
                                                        <img src="../images/blog/comment/1.jpeg" alt="comment images">
                                                    </div>
                                                    <div class="content">
                                                        <div class="comnt__author d-block d-sm-flex">
                                                            <span>{{$comment->nickname}}</span>
                                                            <span>{{\Jenssegers\Date\Date::parse($comment->created_at)->format('j F, Y H:i:s')}}</span>

                                                        </div>
                                                        <p>{{$comment->message}}</p>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                            </div>
                        </article>
                        @if( Auth::user())
                        <div class="comment_respond">
                            <h3 class="reply_title">Оставить отзыв</h3>
                            <form class="comment__form" action="{{route('comment')}}" method="GET">
                                <div>
                                    <div class="rate-rating">
                                        <label>
                                            <input type="radio" name="stars" value="1" />
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 1 ) active @endif">★</span>
                                        </label>
                                        <label>
                                            <input type="radio" name="stars" value="2" />
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 2 ) active @endif">★</span>
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 2 ) active @endif">★</span>
                                        </label>
                                        <label>
                                            <input type="radio" name="stars" value="3" />
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 3 ) active @endif">★</span>
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 3 ) active @endif">★</span>
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 3 ) active @endif">★</span>
                                        </label>
                                        <label>
                                            <input type="radio" name="stars" value="4" />
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 4 ) active @endif">★</span>
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 4 ) active @endif">★</span>
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 4 ) active @endif">★</span>
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 4 ) active @endif">★</span>
                                        </label>
                                        <label>
                                            <input type="radio" name="stars" value="5" />
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 5 ) active @endif">★</span>
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 5 ) active @endif">★</span>
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 5 ) active @endif">★</span>
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 5 ) active @endif">★</span>
                                            <span class="rate-icon @if(Auth::user()->getRatingForArticle($article->id) && Auth::user()->getRatingForArticle($article->id) >= 5 ) active @endif">★</span>
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="object_id" value="{{$article->id}}">
                                <input type="hidden" name="object_type" value="article">
                                <input type="hidden" name="author_id" value="{{Auth::user()->id}}">
                                <div class="input__box">
                                    <label>Отзыв</label>
                                    <textarea name="message"></textarea>
                                </div>
                                <div class="submite__btn">
                                    <button class="btn btn-primary" type="submit">Отправить отзыв</button>
                                </div>
                            </form>
                        </div>
                        @else
                        <div>
                            Чтобы оставить комментарий вам необходими <a href="{{route('signin')}}">Авторизоваться</a>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-12 mt--30 mb-3">
                    <div class="wn__sidebar">
                        <!-- End Single Widget -->
                        <!-- Start Single Widget -->
                        <aside class="widget recent_widget">
                            <h3 class="widget-title">Похожие статьи</h3>
                            <div class="recent-posts">
                                <ul>
                                    @foreach($similar_articles as $similar)
                                    <li>
                                        <div class="post-wrapper d-flex">
                                            <div class="thumb">
                                                <a href="{{route('article', $similar->id)}}"><img src="{{$similar->image_link}}" alt="blog images"></a>
                                            </div>
                                            <div class="content">
                                                <h4><a href="{{route('article', $similar->id)}}">{{$similar->name}}</a></h4>
                                                <p>	{{$similar->created_at}}</p>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </aside>
                        <!-- End Single Widget -->
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection