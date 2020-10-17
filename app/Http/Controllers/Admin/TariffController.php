<?php

namespace App\Http\Controllers\Admin;

use App\Tariff;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class TariffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tariffs = Tariff::all();

        return view('adminPanel.tariff.index', [
            'tariffs' => $tariffs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPanel.tariff.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $image_link = $request->file('image_url');
        $extensionImage = $image_link->getClientOriginalExtension();
        Storage::disk('public')->put($image_link->getFilename().'.'.$extensionImage,  File::get($image_link));

        $data = [
            'title'         => $request->title,
            'description' => $request->description,
            'image_url'   => '/uploads/' . $image_link->getFilename() . '.' . $extensionImage,
        ];

        Tariff::create($data);

        return redirect()->route('tariffsPage')
            ->with('success','Тариф успешно добавлен.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tariff  $tarif
     * @return \Illuminate\Http\Response
     */
    public function show(Tariff $tariff)
    {
        return view('adminPanel.tariff.show',compact('tariff'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tariff  $tarif
     * @return \Illuminate\Http\Response
     */
    public function edit(Tariff $tariff)
    {
        return view('adminPanel.tariff.edit',compact('tariff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tariff  $tarif
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tariff $tariff)
    {
        $image_url = $request->file('image_url');

        if (null !== $image_url) {
            $extensionImage = $image_url->getClientOriginalExtension();
            Storage::disk('public')->put($image_url->getFilename().'.'.$extensionImage,  File::get($image_url));
        }

        $data = [
            'title' => $request->title,
            'descripiton' => $request->description,
            'image_url' => '/uploads/' . $image_url->getFilename() . '.' . $extensionImage
        ];

        $tariff->update($data);

        return redirect()->route('tariffsPage')
            ->with('success','Твриф успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tariff $tarif
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Tariff $tariff)
    {
        $tariff->delete();

        return redirect()->route('tariffsPage')
            ->with('success','Тариф успешно удален');
    }
}
