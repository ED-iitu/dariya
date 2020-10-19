
<!-- Start Slider area -->
@if($banners)
<section id="banner-main">
    <div class="container">
        <div class="owl-carousel owl-theme">
            @foreach($banners as $banner)
                <div class="item">
                    <a href="{{$banner->redirect}}" title="{{$banner->title}}" class="d-block" style="@if($banner->background_color)background-color: {{$banner->background_color}};@endif background-image: url({{url($banner->file_url)}});">
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
<!-- End Slider area -->
