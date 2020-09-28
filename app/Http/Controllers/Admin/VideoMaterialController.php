<?php

namespace App\Http\Controllers\Admin;

use App\Video;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VideoMaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::all();

        return view('adminPanel.videoMaterial.index', [
            'videos' => $videos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPanel.videoMaterial.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Video::create($request->all());

        return redirect()->route('videoMaterialsPage')
            ->with('success','Видео успешно добавлено.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function show(Video $video)
    {
        return view('adminPanel.videoMaterial.show',compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        return view('adminPanel.videoMaterial.edit',compact('video'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Video $video)
    {
        $video->update($request->all());

        return redirect()->route('videoMaterialsPage')
            ->with('success','Видео успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Video $video
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route('videoMaterialsPage')
            ->with('success','Видео успешно удалено');
    }
}
