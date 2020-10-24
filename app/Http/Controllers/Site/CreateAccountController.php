<?php

namespace App\Http\Controllers\Site;

use App\Article;
use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateAccountController extends Controller
{
    public function signin()
    {
        $title = 'Авторизация';
        $breadcrumb[] = [
            'title' => $title,
            'route' => route('signin'),
            'active' => true
        ];
        return view('site.signin', compact('title', 'breadcrumb'));
    }

    public function signup()
    {
        $title = 'Регистрация';
        $breadcrumb[] = [
            'title' => $title,
            'route' => route('signin'),
            'active' => true
        ];
        return view('site.signup', compact('title', 'breadcrumb'));
    }
}
