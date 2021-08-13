<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EbayAspectMake;
use App\Models\Make;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AspectMakesController extends Controller
{
    public function index()
    {
        $aspectMakes = EbayAspectMake::query()
            ->with('make')
            ->orderBy('make_id', 'ASC')
            ->orderBy('aspect_make', 'ASC')
            ->orderBy('aspect_model', 'ASC')
            ->paginate(12);
        $makes = Make::query()->withDepth()->defaultOrder()->get();

        return Inertia::render('Admin/AspectMakes/Index', [
            'aspectMakes' => $aspectMakes,
            'makes' => $makes
        ]);
    }

    public function update(EbayAspectMake $aspectMake, Request $request)
    {
        $aspectMake->fill($request->only(['make_id']));
        $aspectMake->save();

        return redirect()->back();
    }
}
