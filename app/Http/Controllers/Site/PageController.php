<?php


namespace App\Http\Controllers\Site;


use App\Http\Controllers\Controller;
use App\Page;

class PageController extends Controller
{
    public function getPage($id){
        $page = Page::query()->find($id);
        if($page){
            $title = 'title';
            return view('site.page', compact('title', 'page'));
        }
        return view('errors.404');
    }
}