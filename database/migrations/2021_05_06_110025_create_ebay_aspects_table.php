<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbayAspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebay_aspects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ebay_item_id');
            $table->string('name');
            $table->text('value');
            $table->dateTime('processed_at')->nullable();
            $table->timestamps();

            $table->foreign('ebay_item_id')
                ->references('id')
                ->on('ebay_items')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebay_aspects');
    }
}
