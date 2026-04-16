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
            $table->string('username')->nullable()->after('code');
            $table->string('password')->nullable()->after('username');

            $table->integer('duration')->nullable(); // minutes or hours
            $table->integer('bandwidth')->nullable(); // Mbps

            $table->timestamp('expires_at')->nullable();
            $table->timestamp('activated_at')->nullable();

            $table->string('router_id')->nullable();
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
