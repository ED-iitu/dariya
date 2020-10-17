<?php

namespace App\Http\Controllers\Admin;

use App\Genre;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kodeine\Acl\Models\Eloquent\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();

        return view('adminPanel.role.index', [
            'roles' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPanel.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Role::create($request->all());

        return redirect()->route('rolePage')
            ->with('success','Жанр успешно добавлен.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Genre  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Genre $role)
    {
        return view('adminPanel.role.show',compact('role'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Genre  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Genre $role)
    {
        return view('adminPanel.role.edit',compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Genre  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $role)
    {
        $role->update($request->all());

        return redirect()->route('rolePage')
            ->with('success','Жанр успешно обновлен');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Genre $role
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Genre $role)
    {
        $role->delete();

        return redirect()->route('rolePage')
            ->with('success','Жанр успешно удален');
    }
}
