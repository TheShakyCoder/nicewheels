<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Substitution;

class SubstitutionsController extends Controller
{
    public function searchCount(string $search)
    {
        $count = Substitution::query()->where('search', 'LIKE', $search)->count();

        return response()->json([
            'search' => $search,
            'count' => $count
        ], 200);
    }
}
