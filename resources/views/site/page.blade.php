@extends('layouts.app')
@section('title', $title)
@section('content')
    <div class="container">
        @foreach($page->data as $key => $block)
            @include('page/blocks/'.$block['type'], compact('key', 'block'))
        @endforeach
    </div>
@endsection
