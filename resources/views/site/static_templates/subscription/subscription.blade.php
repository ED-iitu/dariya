<!-- Start subscription -->
<div class="subscription container mb-md-5 mb-3">
    <div class="content-box">
        @foreach($tariffs as $tariff)
            <div class="item {{ $tariff->slug }} p-md-3 p-1">
                <div class="info-img">
                    <img src="{{ url( $tariff->image_url ) }}">
                </div>
                @if($tariff->tariffPriceLists)
                    <form action="/">
                        @foreach($tariff->tariffPriceLists as $key=>$price_list)
                            <div>
                                @php
                                $key++;
                                @endphp
                                <input id="premium_item_{{$key}}" type="radio" name="premium_item">
                                <label for="premium_item_1">
                                    <span>{{ $price_list->duration }} месяц</span>
                                    <span>{{ \Akaunting\Money\Money::KZT($price_list->price)->format() }}/мес</span>
                                </label>
                            </div>
                        @endforeach
                        <button class="mt-3 mt-sm-0">Перейти к оплате</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
<!-- End subscription -->
