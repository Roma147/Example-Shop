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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // ID товара
            $table->string('category'); // Категория товара (например, "Электроника", "Одежда")
            $table->string('name'); // Название товара
            $table->text('description')->nullable(); // Описание товара, может быть пустым
            $table->decimal('price', 8, 2); // Цена (до 8 цифр, 2 после запятой, например 12345.67)
            $table->integer('stock_quantity')->default(0); // Количество на складе
            $table->timestamps(); // Поля created_at и updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
