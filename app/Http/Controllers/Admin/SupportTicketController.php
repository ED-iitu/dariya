<?php

namespace App\Http\Controllers\Admin;

use App\supportTicket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class supportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $supportTickets = supportTicket::all();

        return view('adminPanel.supportTicket.index', [
            'supportTickets' => $supportTickets
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('adminPanel.supportTicket.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        supportTicket::create($request->all());

        return redirect()->route('supportTicketsPage')
            ->with('success','Жанр успешно добавлен.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\supportTicket  $supportTicket
     * @return \Illuminate\Http\Response
     */
    public function show(supportTicket $supportTicket)
    {
        return view('adminPanel.supportTicket.show',compact('supportTicket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\supportTicket  $supportTicket
     * @return \Illuminate\Http\Response
     */
    public function edit(supportTicket $supportTicket)
    {
        return view('adminPanel.supportTicket.edit',compact('supportTicket'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\supportTicket  $supportTicket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, supportTicket $supportTicket)
    {
        $supportTicket->update($request->all());

        return redirect()->route('supportTicketsPage')
            ->with('success','Сообщение успешно обновлено');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\supportTicket $supportTicket
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(supportTicket $supportTicket)
    {
        $supportTicket->delete();

        return redirect()->route('supportTicketsPage')
            ->with('success','Сообщение успешно удалено');
    }
}
