<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10/5/20
 * Time: 01:32
 */

namespace App\Http\Controllers\Site;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index($id)
    {
        $userData = Auth::user();
        return view('site.profile', [
            'userData' => $userData
        ]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('site.profileEdit', [
            'user' => $user
        ]);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $user->name = $request->username;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->date_of_birth = $request->date_of_birth;

        if (!Hash::check($request->oldPassword,$user->password)) {
            return redirect()->back()->with('error', 'Старый пароль введен не верно');
        }

        $user->password = Hash::make($request->newPassword);

        $user->save();

        return redirect()->back()->with('success','Профиль обновлен');
    }
}