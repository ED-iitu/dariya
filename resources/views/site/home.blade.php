@extends('layouts.app')
@section('title', $title)
@section('content')
    @if ($message = Session::get('success'))
        <div class="container">
            <div class="mt-3 mb-2">
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif
    @if ($message = Session::get('error'))
        <div class="container">
            <div class="mt-3 mb-2">
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            </div>
        </div>
    @endif
    @include('site.sliders.banner_main')
    @include('site.tabs.tabs_box')
    @include('site.static_templates.subscription.subscription')
    @include('site.static_templates.download_mobile_apps')
    @include('site.sliders.advertisings')
    @include('site.static_templates.about')
@endsection
