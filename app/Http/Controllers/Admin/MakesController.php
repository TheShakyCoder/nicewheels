<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Make;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Cache;

class MakesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Make $make = null)
    {
        // $makes = Make::query()
        //     ->when($make, function($q) use($make) {
        //         $q->where('parent_id', $make->id);
        //     }, function($q) {
        //         $q->where('parent_id', null);
        //     })
        //     ->defaultOrder()->get();

        $hours = 24;
        $makes = Cache::remember('makes-'.($make ? $make->id : 0), 3600 * $hours, function() use($hours, $make) {
            return Make::query()
                ->when($make, function($q) use($make) {
                    $q->where('parent_id', $make->id);
                }, function($q) {
                    $q->where('parent_id', null);
                })
                ->defaultOrder()
                ->get();
        });

        return Inertia::render('Admin/Makes/Index', [
            'makes' => $makes,
            'make' => $make
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
     * @return
     */
    public function store(Request $request)
    {
        $input = $request->all();
        Make::query()->create($input);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Make  $make
     * @return \Inertia\Response
     */
    public function show(Make $make)
    {
        $makes = Cache::remember('makes-all', 3600 * $hours, function() {
            return Make::query()->withDepth()->defaultOrder()->get();
        });

        return Inertia::render('Admin/Makes/Show', [
            'make' => $make,
            'children' => Make::query()->where('parent_id', $make->id)->defaultOrder()->withCount('ebayItems')->get(),
            'ancestors' => Make::whereAncestorOf($make)->get(),
            'makes' => $makes,
            'cars' => $make->ebayItems()->limit(100)->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Make  $make
     * @return \Illuminate\Http\Response
     */
    public function edit(Make $make)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Make  $make
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Make $make)
    {
        $make->fill($request->all());
        $make->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Make  $make
     * @return \Illuminate\Http\Response
     */
    public function destroy(Make $make)
    {
        //
    }

    public function up(Make $make)
    {
        $make->up();
        return redirect()->back();
    }

    public function down(Make $make)
    {
        $make->down();
        return redirect()->back();
    }
}
