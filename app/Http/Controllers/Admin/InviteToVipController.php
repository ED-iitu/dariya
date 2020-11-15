<?php

namespace App\Http\Controllers\Admin;

use App\InviteToVip;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class InviteToVipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invites_to_vip = InviteToVip::query()->get();

        return view('adminPanel.invite_to_vip.index', [
            'invites_to_vip' => $invites_to_vip
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = InviteToVip::query()->whereIn('slug',['video', 'article'])->get();
        return view('adminPanel.invite_to_vip.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        InviteToVip::create($request->all());

        return redirect()->route('InviteToVipPage')
            ->with('success','Категория успешно добавлен.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\InviteToVip  $category
     * @return \Illuminate\Http\Response
     */
    public function show(InviteToVip $category)
    {
        return view('adminPanel.invite_to_vip.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\InviteToVip  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(InviteToVip $category)
    {
        $categories = InviteToVip::query()->whereIn('slug',['video', 'article'])->get();
        return view('adminPanel.invite_to_vip.edit',compact('category','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\InviteToVip  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InviteToVip $category)
    {
        $category->update($request->all());

        return redirect()->route('InviteToVipPage')
            ->with('success','Категория успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InviteToVip $category
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(InviteToVip $category)
    {
        $category->delete();

        return redirect()->route('InviteToVipPage')
            ->with('success','Категория успешно удален');
    }
}
