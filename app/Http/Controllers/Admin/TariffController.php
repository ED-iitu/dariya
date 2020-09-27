<?php

namespace App\Http\Controllers\Admin;

use App\Tariff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adminPanel.tariff.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tariff  $tarif
     * @return \Illuminate\Http\Response
     */
    public function show(Tariff $tarif)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tariff  $tarif
     * @return \Illuminate\Http\Response
     */
    public function edit(Tariff $tarif)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tariff  $tarif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tariff $tarif)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tariff  $tarif
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tariff $tarif)
    {
        //
    }
}
