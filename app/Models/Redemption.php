<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Redemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'ebay_item_id',
        'amount',
        'transaction_id'
    ];

    public function getAmountAttribute($value) { return $value / 100; }
    public function setAmountAttribute($value) { $this->attributes['amount'] = $value * 100; }
}
