<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StorePhaseRequest;
use App\Http\Requests\API\V1\UpdatePhaseRequest;
use App\Models\Phase;

class PhaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePhaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Phase $phase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhaseRequest $request, Phase $phase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Phase $phase)
    {
        //
    }
}
