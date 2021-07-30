<?php

namespace App\Services;

use App\Models\Make;
use Illuminate\Database\Eloquent\Collection;

class StaticService
{
    public function getFolder(Collection $fullMake)
    {
        return $fullMake->reduce(function ($carry, $item) {
            return $carry .'/'. $item->slug;
        });
    }

    public function getFullMake(Collection $fullMake)
    {
        return $fullMake->reduce(function ($carry, $item) {
            return $carry .' '. $item->name;
        });
    }

    public function getCompiledHtml($template, $fullMake, $cars, $lastPage, $makeAndDescendants)
    {
        return view($template, [
            'fullMake' => $fullMake,
            'cars' => $cars,
            'lastPage' => $lastPage,
            'makesAndDescendants' => $makeAndDescendants
        ])->render();
    }
}
