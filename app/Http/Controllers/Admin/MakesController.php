<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Make;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MakesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $makes = Make::withDepth()->defaultOrder()->get();

        return Inertia::render('Admin/Makes/Index', [
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
     * @return
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $alternatives = explode(',', $input['alternatives']);
        unset($input['alternatives']);
        $make = Make::query()->create($input);
        foreach($alternatives as $alternative) {
            $make->alternatives()->create([
                'name' => $alternative
            ]);
        }

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
        return Inertia::render('Admin/Makes/Show', [
            'make' => $make
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Make $make)
    {
        //
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
