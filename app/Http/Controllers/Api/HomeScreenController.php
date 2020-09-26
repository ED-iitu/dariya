<?php


namespace App\Http\Controllers\Api;


class HomeScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->sendResponse(['data' => 'data1'], 'Products retrieved successfully.');
    }
}