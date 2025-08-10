<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('credit_sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('credit_sale_id')->constrained('credit_sales');
            $table->string('product');
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_price',10,2);
            $table->decimal('subtotal',10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('credit_sale_items');
    }
};
