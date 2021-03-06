<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Favorite;
use App\Video;
use App\VideoToCategory;
use App\VipCode;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $videos = Video::query()->orderBy('created_at','desc')->get();

        return view('adminPanel.video.index', [
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
        $categories  = (Category::query()->where('slug','video')->first()) ? Category::query()->where('slug','video')->first()->childs : [];
        return view('adminPanel.video.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'preview_text' => ['required'],
            'detail_text'  => ['required'],
            'image_link'  => ['required'],
            'author'    => ['required'],
            'lang'         => ['required']
        ]);

        $image_link = $request->file('image_link');
        $local_video_link = $request->file('local_video_link');
        if (null !== $image_link) {

            $extensionImage = $image_link->getClientOriginalExtension();
            Storage::disk('public')->put($image_link->getFilename().'.'.$extensionImage,  File::get($image_link));
        }

        if (null !== $local_video_link) {
            $extensionImage = $local_video_link->getClientOriginalExtension();
            Storage::disk('public')->put($local_video_link->getFilename().'.'.$extensionImage,  File::get($local_video_link));
        }

        $data = [
            'name'         => $request->name,
            'preview_text' => $request->preview_text,
            'detail_text'  => $request->detail_text,
            'author'    => $request->author,
            'lang'         => $request->lang,
            'youtube_video_id'         => $request->youtube_video_id,
            'in_home_screen' => ($request->in_home_screen) ? $request->in_home_screen : false,
            'in_list' => ($request->in_list) ? $request->in_list : false,
        ];

        if($request->for_vip && $request->for_vip == 'on'){
            $data['for_vip'] = 1;
        }else{
            $data['for_vip'] = 0;
        }

        if (null !== $image_link) {
            $data = array_merge($data, [
                'image_link'   => '/uploads/' . $image_link->getFilename() . '.' . $extensionImage,
            ]);
        }

        if (null !== $local_video_link) {
            $data = array_merge($data, [
                'local_video_link'   => '/uploads/' . $local_video_link->getFilename() . '.' . $extensionImage,
            ]);
        }
        $video = Video::create($data);

        if($request->categories){
            foreach ($request->categories as $category_id){
                $link = new VideoToCategory([
                    'video_id' => $video->id,
                    'category_id' => $category_id
                ]);
                $link->save();
            }
        }

        return redirect()->route('videosPage')
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
        return view('adminPanel.video.show',compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Video  $video
     * @return \Illuminate\Http\Response
     */
    public function edit(Video $video)
    {
        $categories  = (Category::query()->where('slug','video')->first()) ? Category::query()->where('slug','video')->first()->childs : [];
        return view('adminPanel.video.edit',compact('video', 'categories'));
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
        $image_link = $request->file('image_link');
        $local_video_link = $request->file('local_video_link');

        if (null !== $image_link) {
            $extensionImage = $image_link->getClientOriginalExtension();
            Storage::disk('public')->put($image_link->getFilename().'.'.$extensionImage,  File::get($image_link));
        }

        if (null !== $local_video_link) {
            $extensionImage = $local_video_link->getClientOriginalExtension();
            Storage::disk('public')->put($local_video_link->getFilename().'.'.$extensionImage,  File::get($local_video_link));
        }

        $data = [
            'name'         => $request->name,
            'preview_text' => $request->preview_text,
            'detail_text'  => $request->detail_text,
            'author'    => $request->author,
            'lang'         => $request->lang,
            'youtube_video_id'         => $request->youtube_video_id,
            'in_home_screen' => ($request->in_home_screen) ? $request->in_home_screen : false,
            'in_list' => ($request->in_list) ? $request->in_list : false,
        ];

        if($request->for_vip && $request->for_vip == 'on'){
            $data['for_vip'] = 1;
        }else{
            $data['for_vip'] = 0;
        }


        if (null !== $image_link) {
            $data = array_merge($data, [
                'image_link'   => '/uploads/' . $image_link->getFilename() . '.' . $extensionImage,
            ]);
        }

        if (null !== $local_video_link) {
            $data = array_merge($data, [
                'local_video_link'   => '/uploads/' . $local_video_link->getFilename() . '.' . $extensionImage,
            ]);
        }
        $video->update($data);

        VideoToCategory::query()->where('video_id',$video->id)->delete();

        if($request->categories){
            foreach ($request->categories as $category_id){
                $link = new VideoToCategory([
                    'video_id' => $video->id,
                    'category_id' => $category_id
                ]);
                $link->save();
            }
        }

        return redirect()->route('videosPage')
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
        Favorite::query()->where(['object_type' => Favorite::FAVORITE_VIDEO, 'object_id' => $video->id])->delete();
        return redirect()->route('videosPage')
            ->with('success','Видео успешно удалено');
    }

    public function search_vip(Request $request)
    {
        $name = $request->name;
        $videos = Video::query()->where('for_vip',1)->where('name' ,'like', "%$name%")->get();
        return view('adminPanel.video.vip_videos', ['videos' => $videos]);
    }
    public function generate_vip_code(Request $request)
    {
        $request->validate([
            'object_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);
        $code = strtoupper(Str::random(6));
        if(!VipCode::query()->where('code' , $code)->exists()){
            $vip_code = new VipCode();
            $vip_code->object_id = $request->object_id;
            $vip_code->object_type = VipCode::VIDEO_TYPE;
            $vip_code->user_id = $request->user_id;
            $vip_code->try_count = 3;
            $vip_code->status = true;
            $vip_code->code = $code;
            $vip_code->save();
            return view('adminPanel.video.vip_code', ['vip_code' => $vip_code]);
        }
    }
}
