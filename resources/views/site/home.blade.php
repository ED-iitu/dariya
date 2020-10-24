@extends('layouts.app')

@section('content')
    @include('site.sliders.banner_main')
    @include('site.tabs.tabs_box')
    @include('site.static_templates.subscription.subscription')
    @include('site.static_templates.download_mobile_apps')
    @include('site.static_templates.about')
@endsection
