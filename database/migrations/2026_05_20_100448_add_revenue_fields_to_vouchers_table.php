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
        Schema::table('vouchers', function (Blueprint $table) {
            //
            // ORIGINAL PACKAGE/VOUCHER PRICE

       
        // IAMTEK COMMISSION %

        $table->decimal('commission_percentage', 5, 2)
              ->default(30);

        // IAMTEK SHARE AMOUNT

        $table->decimal('commission_amount', 10, 2)
              ->default(0);

        // SHOPKEEPER SHARE

        $table->decimal('shopkeeper_amount', 10, 2)
              ->default(0);

        

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            //
             $table->dropColumn([

            'commission_percentage',
            'commission_amount',
            'shopkeeper_amount',
             ]);
        });
    }
};
