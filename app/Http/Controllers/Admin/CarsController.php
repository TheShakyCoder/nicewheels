<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EbayItem;
use App\Models\Make;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CarsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        //  MOVE TO SERVICE
        $cars = EbayItem::query()
            ->with(['make', 'ebayCategory'])
            ->whereNotNull('aspected_at')
            ->whereNull('checked_at')
            ->where('ended_at', '>', now()->subMonths(6))
            ->orderBy(\DB::raw('checked_at IS NULL'), 'ASC')
            ->orderBy('ended_at', 'DESC')
            ->paginate(12);

        return Inertia::render('Admin/Cars/Index', [
            'cars' => $cars
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EbayItem  $ebayItem
     * @return \Inertia\Response
     */
    public function edit(EbayItem $car)
    {
        $car->load(['filters.category', 'images' => function($q) {
            $q->orderBy('sort', 'ASC');
        }, 'ebayCategory', 'primaryCategory', 'aspects']);
        $makes = Make::withDepth()->defaultOrder()->get();

        return Inertia::render('Admin/Cars/Edit', [
            'car' => $car,
            'makes' => $makes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EbayItem  $ebayItem
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, EbayItem $car)
    {
        $car->fill($request->all());
        $car->checked_at = now();
        $car->checked_by = \Auth::id();
        $car->save();

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EbayItem  $ebayItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(EbayItem $ebayItem)
    {
        //
    }
}
