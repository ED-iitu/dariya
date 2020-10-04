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

class ProfileController extends Controller
{
    public function index($id)
    {
        $userData = User::where('id', '=', $id);

        return view('site.profile', [
            'userData' => $userData
        ]);
    }
}