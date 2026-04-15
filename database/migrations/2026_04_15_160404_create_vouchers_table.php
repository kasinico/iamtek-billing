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
        // Schema::create('vouchers', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();  
            $table->string('code')->unique();  //voucher login code
            $table->foreignId('package_id')->constrained()->onDelete('cascade');  //internet plan
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // shopkeeper
            $table->string('status')->default('unused');  //unused / used
            $table->timestamp('used_at')->nullable();  //when customer logs in
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
