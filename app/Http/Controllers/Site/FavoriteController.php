<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10/6/20
 * Time: 23:30
 */

namespace App\Http\Controllers\Site;


use App\Book;
use Auth;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function index()
    {
        $books = Auth::user()->favorites;

        if (count($books) == 0) {
            $books = [];
        }

        return view('site.favorite', [
            'books' => $books
        ]);
    }
}