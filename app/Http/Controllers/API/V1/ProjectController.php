<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\API\V1\ProjectQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreProjectRequest;
use App\Http\Requests\API\V1\UpdateProjectRequest;
use App\Http\Resources\V1\ProjectCollection;
use App\Http\Resources\V1\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): ProjectCollection
    {
        $filter = new ProjectQuery();
        $queryItems = $filter->transform($request);
        return new ProjectCollection(Project::where($queryItems)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request): ProjectResource
    {
        return new ProjectResource(Project::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project): ProjectResource
    {
        return new ProjectResource($project);
    }

    /**
     * Update Unit
     */
    public function update(UpdateProjectRequest $request, Project $project): ProjectResource
    {
        $project->update($request->all());
        return new ProjectResource($project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully.']);
    }
}
