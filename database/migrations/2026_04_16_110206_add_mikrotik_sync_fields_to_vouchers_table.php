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

        if (!Schema::hasColumn('vouchers', 'is_pushed')) {
            $table->boolean('is_pushed')->default(false);
        }

        if (!Schema::hasColumn('vouchers', 'mikrotik_id')) {
            $table->string('mikrotik_id')->nullable();
        }

        if (!Schema::hasColumn('vouchers', 'sync_error')) {
            $table->text('sync_error')->nullable();
        }

        if (!Schema::hasColumn('vouchers', 'mikrotik_device_id')) {
            $table->foreignId('mikrotik_device_id')->nullable();
        }
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
