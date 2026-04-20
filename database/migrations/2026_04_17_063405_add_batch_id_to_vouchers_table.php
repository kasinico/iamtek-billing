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
             if (!Schema::hasColumn('vouchers', 'batch_id')) {
            $table->unsignedBigInteger('batch_id')->nullable();
        }

                // $table->foreignId('batch_id')->nullable()->constrained('voucher_batches');
                // $table->foreignId('batch_id')->nullable()->constrained()->nullOnDelete();

            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            //
        });
    }
};
