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
            $table->string('customer_name');
            $table->string('customer_phone');
            
            // ලැප්ටොප් ටේබල් එක සමඟ සම්බන්ධ කිරීමට (Foreign Key)
            $table->foreignId('laptop_id')->constrained('laptops')->onDelete('cascade'); 
            
            $table->integer('quantity');
            $table->decimal('total_price', 12, 2);
            
            // බිල් එක දාපු Sales Assistant ව හඳුනා ගැනීමට (Foreign Key)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade'); 
            
            $table->timestamps();
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