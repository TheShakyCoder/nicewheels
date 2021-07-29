<?php

namespace App\Services;

use App\Models\Bookmark;
use App\Models\Redemption;
use App\Models\User;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Boolean;

class UserService
{
    private $user;

    public function __construct(Request $request)
    {
        $this->user = $request->user();
    }

    public function bookmarks(Boolean $count = null)
    {
        if(!\Auth::check()) {
            return $count ? 0 : collect([]);
        }
        $bookmarks = Bookmark::query()->where('user_id', $this->user->id);
        return $count ? $bookmarks->count() : $bookmarks->get();
    }

    public function redemptions(Boolean $count = null)
    {
        $redemption = Redemption::query()->where('user_id', $this->user->id);
        return $count ? $redemption->count() : $redemption->get();
    }
}
