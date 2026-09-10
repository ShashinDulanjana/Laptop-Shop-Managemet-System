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
    Schema::create('laptops', function (Blueprint $table) {
        $table->id();
        $table->string('brand');        // ලැප්ටොප් වර්ගය (Ex: HP, Dell)
        $table->string('model');        // මොඩල් එක (Ex: Pavilion, Vostro)
        $table->decimal('price', 10, 2); // මිල
        $table->text('description')->nullable(); // විස්තර
        $table->integer('stock')->default(0);    // තොග ප්‍රමාණය
        $table->string('image')->nullable();     // පින්තූරය සඳහා path එක
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laptops');
    }
};
