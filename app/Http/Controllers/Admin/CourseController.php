<?php

namespace App\Http\Controllers\Admin;

use App\Course;
use App\Favorite;
use App\Lesson;
use App\LessonVideo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::query()->orderBy('created_at','desc')->get();

        return view('adminPanel.course.index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPanel.course.create');
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
            'name' => 'required',
            'description' => 'required',
            'author' => 'required',
            'image_link' => 'required',
        ]);


        $data = [
            'name'         => $request->name,
            'description' => $request->description,
            'author'    => $request->author,
            'image_link' => null,
        ];
        $image_link = $request->file('image_link');

        if($image_link){
            $extensionImage = $image_link->getClientOriginalExtension();
            Storage::disk('public')->put($image_link->getFilename().'.'.$extensionImage,  File::get($image_link));
            $data['image_link']   = '/uploads/' . $image_link->getFilename() . '.' . $extensionImage;
        }

        $course = Course::create($data);

        if($request->lessons){
            foreach ($request->lessons as $lesson){
                if(isset($lesson['name']) && !empty($lesson['name']) && isset($lesson['lesson']) && !empty($lesson['lesson'])){
                    $n_lesson  = new Lesson();
                    $n_lesson->name = $lesson['name'];
                    $n_lesson->lesson = $lesson['lesson'];
                    $n_lesson->course_id = $course->id;
                    if($n_lesson->save()){
                        sleep(1);
                        if(isset($lesson['video_link']) && !empty($lesson['video_link']) & is_array($lesson['video_link'])){
                            foreach ($lesson['video_link'] as $v=>$video_link){
                                $v++;
                                $n_lesson_video = new LessonVideo();
                                $n_lesson_video->lesson_id = $n_lesson->id;
                                $n_lesson_video->video_title = $n_lesson->name.' '.$v;
                                if($video_link instanceof UploadedFile){
                                    $extensionImage = $video_link->getClientOriginalExtension();
                                    Storage::disk('public')->put($video_link->getFilename().'.'.$extensionImage,  File::get($video_link));
                                    $n_lesson_video->video_link = '/uploads/' . $video_link->getFilename() . '.' . $extensionImage;
                                }else{
                                    $n_lesson_video->video_link = $video_link;
                                    $n_lesson_video->is_external = true;
                                }
                                $n_lesson_video->save();
                                sleep(1);
                            }
                        }
                    }
                }
            }
        }

        return redirect()->route('coursesPage')
            ->with('success','Курс успешно добавлен.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        return view('adminPanel.course.show',compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('adminPanel.course.edit',[
            'course' => $course,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $image_link = $request->file('image_link');

        if (null !== $image_link) {
            $extensionImage = $image_link->getClientOriginalExtension();
            Storage::disk('public')->put($image_link->getFilename().'.'.$extensionImage,  File::get($image_link));
        }


        $data = [
            'name'         => $request->name,
            'description' => $request->description,
            'author'    => $request->author,
        ];

        if (null !== $image_link) {
            $data = array_merge($data, [
                'image_link'   => '/uploads/' . $image_link->getFilename() . '.' . $extensionImage,
            ]);
        }
        $course->update($data);

        if($request->lessons){
            foreach ($request->lessons as $lesson_id=>$lesson){
                if(isset($lesson['name']) && !empty($lesson['name']) && isset($lesson['lesson']) && !empty($lesson['lesson'])){
                    if(!($n_lesson = Lesson::query()->find($lesson_id))){
                        $n_lesson  = new Lesson();
                    }
                    $n_lesson->name = $lesson['name'];
                    $n_lesson->lesson = $lesson['lesson'];
                    $n_lesson->course_id = $course->id;
                    if($n_lesson->save()){
                        sleep(1);
                        if(isset($lesson['video_link']) && !empty($lesson['video_link']) & is_array($lesson['video_link'])){
                            foreach ($lesson['video_link'] as $v=>$video_link){
                                $v++;
                                $n_lesson_video = new LessonVideo();
                                $n_lesson_video->lesson_id = $n_lesson->id;
                                $n_lesson_video->video_title = $n_lesson->name.' '.$v;
                                if($video_link instanceof UploadedFile){
                                    $extensionImage = $video_link->getClientOriginalExtension();
                                    Storage::disk('public')->put($video_link->getFilename().'.'.$extensionImage,  File::get($video_link));
                                    $n_lesson_video->video_link = '/uploads/' . $video_link->getFilename() . '.' . $extensionImage;
                                }else{
                                    $n_lesson_video->video_link = $video_link;
                                    $n_lesson_video->is_external = true;
                                }
                                $n_lesson_video->save();
                                sleep(1);
                            }
                        }
                    }
                }
            }
        }


        return redirect()->route('coursesPage')
            ->with('success','Курс успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course $course
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('coursesPage')
            ->with('success','Статься успешно удален');
    }

    public function remove_lesson_video(Request $request){
        $request->validate([
            'id' => 'required'
        ]);
        if($video = LessonVideo::query()->find($request->id)){
            try {
                $video->delete();
                return response('OK');
            } catch (\Exception $e) {
                return response('OK',401);
            }

        }
        return response('OK',400);
    }
}
