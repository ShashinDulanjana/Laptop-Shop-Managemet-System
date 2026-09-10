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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('laptop_id')->constrained()->onDelete('cascade'); // ලැප්ටොප් එකේ ID එක (Foreign Key)
            $table->string('name'); // පාරිභෝගිකයාගේ නම
            $table->string('phone'); // දුරකථන අංකය
            $table->string('email')->nullable(); // ඊමේල් (අනිවාර්ය නැත)
            $table->text('address'); // ලිපිනය
            $table->integer('quantity'); // ප්‍රමාණය
            $table->string('payment_method'); // ගෙවීම් ක්‍රමය (COD හෝ CARD)
            
            // කාඩ්පත් විස්තර (Online Card Payment තේරුවොත් විතරක් සේව් වේ)
            $table->string('card_name')->nullable();
            $table->string('card_number')->nullable(); 
            $table->string('card_expiry')->nullable();
            $table->string('card_cvc')->nullable();
            
            $table->string('status')->default('Pending'); // ඕඩර් එකේ තත්ත්වය (Default: Pending)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};