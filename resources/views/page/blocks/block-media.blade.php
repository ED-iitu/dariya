<div class="row mt-3 mb-3" data-index="{{ $key }}" data-type="block-media">
    <input type="hidden" name="data[{{ $key }}][type]" value="{{ $block['type'] }}">
    <input type="hidden" name="data[{{ $key }}][status]" value="{{ $block['status'] }}">
    <div class="col-md-12">
        @if($block['content']['text'] != "text"){{$block['content']['text']}}@else [Не задан текст] @endif
    </div>
    <div class="col-md-12">
        <ul class="list-unstyled">
            @if($block['content'] && is_array($block['content']))
                @foreach($block['content'] as $k=>$element)
                    <li class="media">
                        <input type="hidden" name="data[{{ $key }}][content][{{$k}}][title]" value="{{ $block['content'][$k]['title'] }}">
                        <input type="hidden" name="data[{{ $key }}][content][{{$k}}][image]" value="{{ $block['content'][$k]['image'] }}">
                        <input type="hidden" name="data[{{ $key }}][content][{{$k}}][text]" value="{{ $block['content'][$k]['text'] }}">
                        <img src="{{$block['content']['image']}}" class="mr-3" alt="{{$block['content']['title']}}">
                        <div class="media-body">
                            <h5 class="mt-0 mb-1">{{$block['content']['title']}}</h5>
                            <div class="text">
                                {{$block['content']['text']}}
                            </div>
                        </div>
                    </li>
                @endforeach
            @endif
        </ul>
    </div>
</div>