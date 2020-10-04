<?php
namespace App\Http\Controllers\Site;


use App\Http\Controllers\Controller;
use App\Tariff;

class TariffController extends Controller
{
    public function index()
    {
        $tariffs = Tariff::all();

        return view('site.tariffs', [
            'tariffs' => $tariffs
        ]);
    }
}