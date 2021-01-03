<?php

namespace App\Observers;

use App\TariffPriceList;

class TariffPriceListObserver
{
    /**
     *
     * @param  \App\TariffPriceList  $tariff_price_list
     * @return void
     */
    public function created(TariffPriceList $tariff_price_list)
    {
        $tariff_price_list->generatePriceCode();
        $tariff_price_list->save();
    }

    /**
     *
     * @param  \App\TariffPriceList  $tariff_price_list
     * @return void
     */
    public function updated(TariffPriceList $tariff_price_list)
    {
        $tariff_price_list->generatePriceCode();
        $tariff_price_list->save();
    }
}
