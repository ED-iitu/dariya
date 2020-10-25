@if(isset($share_links) && $share_links)
    <div id="social-links" class="mt-3 mb3 mr-4" style="display: inline-block">
        <ul>
            <li>Поделиться:</li>
            @foreach($share_links as $service => $link)
                <li class="ml-2 share-link"><a href="{{ $link }}" target="_blank"><i
                                class="fa fa-{{ $service }}"></i></a></li>
            @endforeach
        </ul>
    </div>
@endif