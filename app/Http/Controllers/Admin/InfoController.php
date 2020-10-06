<?php


namespace App\Http\Controllers\Admin;


use App\Info;
use Illuminate\Http\Request;

class InfoController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $infos = Info::all();

        return view('adminPanel.info.index', [
            'infos' => $infos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPanel.info.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Info::create($request->all());

        return redirect()->route('infoPage')
            ->with('success','Информация успешно добавлен.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function show(Info $info)
    {
        return view('adminPanel.info.show',compact('info'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function edit(Info $info)
    {
        return view('adminPanel.info.edit',compact('info'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Info  $info
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Info $info)
    {
        $info->update($request->all());

        return redirect()->route('infoPage')
            ->with('success','Информация успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Info $info
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Info $info)
    {
        $info->delete();

        return redirect()->route('infoPage')
            ->with('success','Информация успешно удален');
    }
}