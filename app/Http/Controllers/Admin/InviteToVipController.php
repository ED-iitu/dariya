<?php

namespace App\Http\Controllers\Admin;

use App\InviteToVip;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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
        $users = User::query()->where('id','!=', Auth::id())->get();
        return view('adminPanel.invite_to_vip.create', [
            'users' => $users
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
        $request->validate([
            'user_id' => 'required',
        ]);
        $data = $request->all();
        $data['invited_by'] = Auth::id();
        $data['status'] = 0;
        InviteToVip::create($data);

        return redirect()->route('InviteToVipPage')
            ->with('success','Пользовательуспешно добавлен.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\InviteToVip $inviteToVip
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(InviteToVip $inviteToVip)
    {
        $inviteToVip->delete();

        return redirect()->route('InviteToVipPage')
            ->with('success','Пользователь успешно удален');
    }
}
