<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentationProductionProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presentation_production_product', function (Blueprint $table) {
            $table->id();
            $table->float('quantity');
            $table->decimal('unit_cost_production',11,2);
            $table->decimal('unit_price_sale',11,2);
            $table->float('faulty_quantity')->default(0);
            $table->foreignId('presentation_unit_id')->constrained();
            $table->foreignId('production_product_id')->constrained();
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
        Schema::dropIfExists('presentation_production_product');
    }
}
