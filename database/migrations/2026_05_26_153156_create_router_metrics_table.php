<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('router_metrics', function (Blueprint $table) {

            $table->id();

            $table->foreignId('mikrotik_device_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->boolean('is_online')
                ->default(false);

            $table->string('wan_ip')
                ->nullable();

            $table->string('uptime')
                ->nullable();

            $table->integer('cpu_usage')
                ->default(0);

            $table->integer('ram_usage')
                ->default(0);

            $table->integer('active_users')
                ->default(0);

            $table->bigInteger('rx_bytes')
                ->default(0);

            $table->bigInteger('tx_bytes')
                ->default(0);

            $table->timestamp('last_seen_at')
                ->nullable();

            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('router_metrics');
    }
};