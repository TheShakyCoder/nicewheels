<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Substitution;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Make;
use Illuminate\Support\Facades\Cache;

class SubstitutionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $substitutions = Substitution::query()->with(['make', 'newMake'])->orderBy('make_id', 'ASC')->orderBy('sort', 'ASC')->paginate(12);

        $hours = 24;
        $makes = Cache::remember('makes-substitutions', 3600 * $hours, function() use($hours) {
            return Make::query()->withDepth()->defaultOrder()->get();
        });

        return Inertia::render('Admin/Substitutions/Index', [
            'substitutions' => $substitutions,
            'makes' => $makes
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Substitution::query()->updateOrCreate([
            'search' => $request->get('search'),
            'make_id' => $request->get('make_id'),
        ], [
            'to_make_id' => $request->get('to_make_id')
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Substitution  $substitution
     * @return \Illuminate\Http\Response
     */
    public function show(Substitution $substitution)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Substitution  $substitution
     * @return \Illuminate\Http\Response
     */
    public function edit(Substitution $substitution)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Substitution  $substitution
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Substitution $substitution)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Substitution  $substitution
     * @return \Illuminate\Http\Response
     */
    public function destroy(Substitution $substitution)
    {
        //
    }

    public function up(Substitution $substitution)
    {
        $substitution->sort = max($substitution->sort - 1, 0);
        $substitution->save();
        return redirect()->back();
    }

    public function down(Substitution $substitution)
    {
        $substitution->sort = $substitution->sort + 1;
        $substitution->save();
        return redirect()->back();
    }
}
