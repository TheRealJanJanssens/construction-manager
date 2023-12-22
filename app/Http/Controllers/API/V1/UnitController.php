<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\API\V1\ProjectQuery;
use App\Filters\API\V1\UnitQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreUnitRequest;
use App\Http\Requests\API\V1\UpdateUnitRequest;
use App\Http\Resources\V1\ProjectCollection;
use App\Http\Resources\V1\UnitCollection;
use App\Http\Resources\V1\UnitResource;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): UnitCollection
    {
        $filter = new UnitQuery();
        $queryItems = $filter->transform($request);
        return new UnitCollection(Unit::where($queryItems)->with(['meta'])->get());
    }

    /**
     * Insert Unit
     */
    public function store(StoreUnitRequest $request): UnitResource
    {
        return new UnitResource(Unit::create($request->all()));
    }

    /**
     * Get user
     */
    public function show(Unit $unit): UnitResource
    {
        return new UnitResource($unit->loadMissing(['meta']));
    }

    /**
     * Update Unit
     */
    public function update(UpdateUnitRequest $request, Unit $unit): UnitResource
    {
        $unit->update($request->all());
        return new UnitResource($unit);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return response()->json(['message' => 'Unit deleted successfully.']);
    }

    /**
     * Get all unit related projects
     */
    public function projects(Request $request, Unit $unit): ProjectCollection
    {
        $filter = new ProjectQuery();
        $queryItems = $filter->transform($request);
        return new ProjectCollection($unit->projects()->where($queryItems)->get());
    }
}
