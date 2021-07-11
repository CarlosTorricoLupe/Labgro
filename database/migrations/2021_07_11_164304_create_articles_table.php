<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            
            $table->string('cod_article')->unique();
            $table->string('name_article')->unique();
            $table->float('stock');
            $table->foreignId('category_id')->constrained();
            $table->foreignId('unit_id')->constrained();
            $table->foreignId('price_id')->constrained();
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
        Schema::dropIfExists('articles');
       
    }
}
