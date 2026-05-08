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
            $table->foreignId('mikrotik_device_id')->nullable();
            $table->id();
            $table->string('code');
            $table->string('username');
            $table->string('password');
            $table->foreignId('package_id');
            $table->foreignId('user_id');
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
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
