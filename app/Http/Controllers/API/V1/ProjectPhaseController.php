<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreProjectPhaseRequest;
use App\Http\Requests\API\V1\UpdateProjectPhaseRequest;
use App\Models\ProjectPhase;

class ProjectPhaseController extends Controller
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
    public function store(StoreProjectPhaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectPhase $projectPhase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectPhaseRequest $request, ProjectPhase $projectPhase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectPhase $projectPhase)
    {
        //
    }
}
