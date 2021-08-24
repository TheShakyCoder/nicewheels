<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Make;

class SubstitutionsController extends Controller
{
    public function searchCount(Make $make, string $search)
    {
        $count = $make->ebayItems()->where('title', 'LIKE', $search)->count();

        return response()->json([
            'search' => $search,
            'count' => $count
        ], 200);
    }
}
