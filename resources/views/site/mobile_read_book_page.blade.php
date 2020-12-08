@foreach($book_pages as $k=>$page)
    <div id="page-{{$page->page}}" data-page-number="{{$page->page}}" data-book-id="{{$page->book->id}}" class="page @if(in_array($page->page,$bookmarks)) marked @endif" @if(in_array($page->page,$bookmarks)) style="position: relative" @endif>
        @if(in_array($page->page,$bookmarks)) <img style="position: absolute;right: 2px;top: 2px;" width="14" height="18" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAA4AAAASCAYAAABrXO8xAAAACXBIWXMAAA7DAAAOwwHHb6hkAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAOVJREFUOI3tkz9KA3EQRt/MT8VgFTb+KVYv4AHMFazFVqxSiXgEj2DEyspeLLxE2FVbL2ACIqidGGJmxiYRExQ2rfjq7/ENw4wMb+vb4noO5FSjF+otsTLrziCN6c6NpbT1IlUMK7MA1nXGpi/+xT8uRievRSevVRbjZnnNysaxp/6Dp/dHK7J23NU3pnMyuj3UaXqKI0J2gPmp3AcSV2py4koxIX5jIMi1qLWx1Hf1FiF7wOKPjcATcKERZ9J87U2MX6ysutg+cMDom2RYZCUqp2np+VI2Gfy2DIC4Z8HeGrt4HH4CmWBVnyRr+ycAAAAASUVORK5CYII=" alt="active-book-mark"> @endif
        {!! str_replace(['<body>', '</body>'],'',$page->content) !!}
        <hr>
    </div>
@endforeach