<?php


namespace App\Http\Controllers\Admin;


use App\Page;
use Illuminate\Http\Request;

class PageController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pages = Page::all();

        return view('adminPanel.page.index', [
            'pages' => $pages
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPanel.page.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Page::create($request->all());

        return redirect()->route('pagesPage')
            ->with('success','Страница успешно добавлена.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        return view('adminPanel.page.show',compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('adminPanel.page.edit',compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $page->update($request->all());

        return redirect()->route('pagesPage')
            ->with('success','Страница успешно обновлена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Page $page
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('pagesPage')
            ->with('success','Страница успешно удалена');
    }
}