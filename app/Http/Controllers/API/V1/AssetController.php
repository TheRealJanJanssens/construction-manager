<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\API\V1\AssetQuery;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\AssetCollection;
use App\Http\Resources\V1\AssetResource;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     * Note: This isn't a very usefull call fo a user. Maybe for an admin?
     */
    public function index(Request $request): AssetCollection
    {
        $filter = new AssetQuery();
        $queryItems = $filter->transform($request);
        return new AssetCollection(Asset::where($queryItems)->get());
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset): AssetResource
    {
        return new AssetResource($asset);
    }
}
