<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOutputDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('output_details', function (Blueprint $table) {
            $table->id();
            $table->integer('quantity');
            $table->decimal('budget_output',11,2);
            $table->decimal('total',11,2);
            $table->foreignId('article_id')->constrained();
            $table->foreignId('output_id')->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('output_details');
    }
}
