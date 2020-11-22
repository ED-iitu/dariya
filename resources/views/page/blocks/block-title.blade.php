<div class="row mt-3 mb-3" data-index="{{ $key }}" data-type="block-title">
    <input type="hidden" name="data[{{ $key }}][type]" value="{{ $block['type'] }}">
    <input type="hidden" name="data[{{ $key }}][status]" value="{{ $block['status'] }}">
    <input type="hidden" name="data[{{ $key }}][content][title]" value="{{ $block['content']['title'] }}">
    <div class="col-md-12 m-4">
        <h1 class="text-md-center">@if($block['content']['title'] != "title"){{ $block['content']['title'] }}@else [Не задан загаловок] @endif</h1>
    </div>
</div>