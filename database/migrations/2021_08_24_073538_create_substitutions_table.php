<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubstitutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substitutions', function (Blueprint $table) {
            $table->id();
            $table->integer('make_id');
            $table->integer('to_make_id');
            $table->string('search');
            $table->unsignedInteger('sort')->default(0);
            $table->timestamps();
            $table->unique(['make_id', 'search']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('substitutions');
    }
}
