<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CourseAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($course_key = ($request->route('course_key') ?? $request->get('course_key'))) {
            if ($user = User::query()->where('course_key', $course_key)->first()) {
                Auth::login($user);
            }
        }
        return $next($request);
    }
}
