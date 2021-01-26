<?php


namespace App\Http\Controllers\Site;


use App\Course;
use App\Http\Controllers\Api\Controller;
use App\Lesson;
use App\UserLessonLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index(Request $request){
        $courses = Course::query()->where('is_free',false)->get();
        if(Auth::check() && Auth::user()->have_active_tariff() && Auth::user()->tariff->slug == 'premium'){
            $my_courses = Course::query()->get();
        }else{
            $my_courses = Course::query()->where('is_free',true)->get();
        }
        return view('courses.index', [
            'courses' => $courses,
            'my_courses' => $my_courses
        ]);
    }

    public function lesson($id){
        if($lesson = Lesson::query()->find($id)){
            $is_access = false;
            if(Auth::user()){
                if(Auth::user()->have_active_tariff() && $tariff = Auth::user()->tariff->slug == 'premium'){
                    $is_access = true;
                }
            }
            return view('courses.lesson', [
                'lesson' => $lesson,
                'is_access' => $is_access
            ]);
        }
        return response('Not Found',404);
    }
    public function finish_lesson($id){
        if($lesson = Lesson::query()->find($id)){
            if(!UserLessonLog::query()->where([
                'user_id' => (Auth::check()) ? Auth::id() : 0,
                'lesson_id' => $lesson->id,
                'course_id' => $lesson->course_id,
            ])->exists()){
                $link = new UserLessonLog();
                $link->user_id = (Auth::check()) ? Auth::id() : 0;
                $link->lesson_id = $lesson->id;
                $link->course_id = $lesson->course_id;
                $link->save();
            }
            return $this->sendResponse([],'Успешно завершен!');
        }
        return $this->sendError('Курс не найден!','',404);
    }
}