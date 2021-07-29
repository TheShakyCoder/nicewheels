<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEbayCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ebay_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('make_id')->unsigned()->nullable();
            $table->datetime('polled_at')->nullable();
            $table->integer('qty_received')->nullable();
            $table->boolean('poll')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ebay_categories');
    }
}
