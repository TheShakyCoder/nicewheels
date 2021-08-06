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

    public function getFilterCompiledHtml($template, $fullMake, $cars, $lastPage, $makeAndDescendants, $makes, $folder, $news)
    {
        return view($template, [
            'fullMake' => $fullMake,
            'cars' => $cars,
            'lastPage' => $lastPage,
            'makesAndDescendants' => $makeAndDescendants,
            'makes' => $makes,
            'folder' => $folder,
            'news' => $news
        ])->render();
    }

    public function getCarCompiledHtml($template, $car, $makes)
    {
        return view($template, [
            'car' => $car,
            'makes' => $makes
        ])->render();
    }
}
