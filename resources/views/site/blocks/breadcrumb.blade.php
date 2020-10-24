<div class="container">
    <div class="ht__bradcaump__area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bradcaump__inner">
                        <nav class="bradcaump-content">
                            <a class="breadcrumb_item" href="{{route('home')}}">Главная</a>
                            @foreach($breadcrumb as $value)
                                @if($value['active'] == true)
                                    <span class="brd-separetor">/</span>
                                    <span class="breadcrumb_item active">{{$value['title']}}</span>
                                @else
                                    <span class="brd-separetor">/</span>
                                    <a class="breadcrumb_item" href="{{$value['route']}}">{{$value['title']}}</a>
                                @endif
                            @endforeach
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
