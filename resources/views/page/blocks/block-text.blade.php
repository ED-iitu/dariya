<div class="row mt-3 mb-3" data-index="{{ $key }}" data-type="block-text">
    <input type="hidden" name="data[{{ $key }}][type]" value="{{ $block['type'] }}">
    <input type="hidden" name="data[{{ $key }}][status]" value="{{ $block['status'] }}">
    <input type="hidden" name="data[{{ $key }}][content][text]" value="{{ $block['content']['text'] }}">
    <div class="col-md-12">
        @if($block['content']['text'] != "text"){{$block['content']['text']}}@else [Не задан текст] @endif
    </div>
</div>