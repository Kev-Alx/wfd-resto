<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
            $table->string('notes')->nullable();
            $table->foreignUuid('order_id')->nullable()->references('uuid')->on('orders')->onDelete('cascade');
            $table->foreignUuid('item_id')->nullable()->references('uuid')->on('items')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
