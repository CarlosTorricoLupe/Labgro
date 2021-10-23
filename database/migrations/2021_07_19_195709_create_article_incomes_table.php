<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_incomes', function (Blueprint $table) {
            $table->id();
            $table->float('quantity');
            $table->decimal('unit_price',11,2);
            $table->decimal('total_price',11,2);
            $table->foreignId('income_id')->constrained();
            $table->foreignId('article_id')->constrained();
            $table->timestamps();
            $table->boolean('is_consumed')->default(0);
            $table->date('last_output')->nullable(); //ultima fecha en que salio el articulo
            $table->decimal('current_stock',11,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('article_incomes');
    }
}
