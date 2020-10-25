@extends('layouts.app')
@section('title', $title)
@section('content')
    @include('site.blocks.breadcrumb', ['breadcrumb' => $breadcrumb])

    <!-- Start Tab Box -->
    <section id="tabs_box">
        <div class="container mb-5">
            <div class="tabs">
                @include('site.tabs.components.tabs')
            </div>
            <div class="tabs-content">
                <div id="content_item_1" class="active">
                    <div class="row">
                        @foreach($articles as $article)
                            <div class="col-md-3 mb-3">
                                @include('site.blocks.article')
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="content_item_2">
                    <div class="row">
                        @foreach($books as $book)
                            <div class="col-md-3 mb-3">
                                @include('site.blocks.book')
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="content_item_3">
                    <div class="row">
                        @foreach($audio_books as $book)
                            <div class="col-md-3 mb-3">
                                @include('site.blocks.audio_book')
                            </div>
                        @endforeach
                    </div>
                </div>
                <div id="content_item_4">
                    <div class="row">
                        @foreach($videos as $video)
                            <div class="col-md-3 mb-3">
                                @include('site.blocks.video')
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Tab Box -->

@endsection
