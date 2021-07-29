<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbayItemFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebay_items_filters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ebay_item_id');
            $table->unsignedBigInteger('filter_id');
            $table->unique(['ebay_item_id', 'filter_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebay_items_filters');
    }
}
