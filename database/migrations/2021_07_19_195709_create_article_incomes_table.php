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
<<<<<<< HEAD
            $table->boolean('is_consumed')->default(1);
=======
            $table->boolean('is_consumed')->default(0);
>>>>>>> a3119c7bbce0f93f29e78726db8302b1d990ef01
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
