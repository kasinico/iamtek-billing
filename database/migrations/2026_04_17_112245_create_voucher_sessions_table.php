<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

public function up(): void
{
    Schema::create('voucher_sessions', function (Blueprint $table) {

        $table->id();

        $table->unsignedBigInteger('voucher_id');
        $table->string('voucher_code');

        $table->string('ip_address')->nullable();
        $table->string('mac_address')->nullable();

        $table->unsignedBigInteger('router_id')->nullable();

        $table->timestamp('login_at')->nullable();
        $table->timestamp('logout_at')->nullable();

        $table->string('status')->default('active'); 
        // active | disconnected | expired

        $table->integer('data_used')->nullable(); // KB/MB later

        $table->timestamps();

    });
}

public function down(): void
{
    Schema::dropIfExists('voucher_sessions');
}

};