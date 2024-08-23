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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('name', 199);
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('sku', 199)->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->string('slug', 199);
            $table->longText('description');
            $table->string('salesPrice', 199)->nullable();
            $table->string('costPrice', 199)->nullable();
            $table->string('startDate', 199)->nullable();
            $table->string('endDate', 199)->nullable();
            $table->string('qr_code', 199);
            $table->tinyInteger('isDelete')->default(0);
            $table->timestamps(); // This will add created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
