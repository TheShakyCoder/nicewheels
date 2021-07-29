<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbayItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebay_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ebay_item_id');
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->integer('mileage')->nullable();
            $table->integer('year')->nullable();
            $table->unsignedInteger('ebay_category_id');
            $table->unsignedInteger('primary_category_id');
            $table->string('ebay_url')->nullable();
            $table->string('gallery_url')->nullable();
            $table->unsignedInteger('bids')->nullable();
            $table->unsignedInteger('final_amount')->nullable();
            $table->boolean('used_price')->default(false);
            $table->integer('make_id')->nullable();
            $table->unsignedBigInteger('checked_by')->nullable();
            $table->datetime('checked_at')->nullable();
            $table->datetime('aspected_at')->nullable();
            $table->datetime('processed_at')->nullable();
            $table->datetime('ended_at');
            $table->timestamps();
            $table->softDeletes();

            $table->unique('id');
            $table->unique('ebay_item_id');
            $table->index('make_id');
            $table->index('used_price');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebay_items');
    }
}
