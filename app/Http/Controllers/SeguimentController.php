<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSeguimentRequest;
use App\Http\Requests\UpdateSeguimentRequest;
use App\Models\Segment;

class SeguimentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeguimentRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Segment $seguiment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Segment $seguiment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeguimentRequest $request, Segment $seguiment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Segment $seguiment)
    {
        //
    }
}
