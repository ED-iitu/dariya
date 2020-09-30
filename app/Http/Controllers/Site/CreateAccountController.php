<?php

namespace App\Http\Controllers\Site;

use App\Article;
use App\Book;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateAccountController extends Controller
{
    public function index()
    {
        return view('site.createAccount');
    }
}
