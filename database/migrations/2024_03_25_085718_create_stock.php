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
        if (!Schema::hasTable('stock')) {
            Schema::create('stock', function (Blueprint $table) {
                $table->id(); // Primary key
                $table->string('product_name');
                $table->integer('stock');
                $table->unsignedBigInteger('category_id');
                $table->decimal('unit_price', 10, 2);
                $table->text('description')->nullable();
                $table->timestamps();

                $table->foreign('category_id')
                    ->references('id')
                    ->on('categories')
                    ->onDelete('cascade');
            });
            Schema::table('stock', function (Blueprint $table) {
                $table->index('product_name');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
