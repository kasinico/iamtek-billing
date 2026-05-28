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
        Schema::create('customers', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | OWNER
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | CUSTOMER DETAILS
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('phone')
                ->nullable();

            $table->string('email')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | CONNECTION TYPE
            |--------------------------------------------------------------------------
            */

            $table->enum('connection_type', [

                'hotspot',
                'pppoe',
                'static'

            ])->default('hotspot');

            /*
            |--------------------------------------------------------------------------
            | ROUTER
            |--------------------------------------------------------------------------
            */

            $table->foreignId('mikrotik_device_id')
                ->nullable()
                ->constrained();

            /*
            |--------------------------------------------------------------------------
            | PACKAGE
            |--------------------------------------------------------------------------
            */

            $table->foreignId('package_id')
                ->nullable()
                ->constrained();

            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [

                'active',
                'inactive',
                'expired',
                'suspended'

            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | HOTSPOT INFO
            |--------------------------------------------------------------------------
            */

            $table->string('mac_address')
                ->nullable();

            $table->string('username')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | EXPIRY
            |--------------------------------------------------------------------------
            */

            $table->timestamp('expires_at')
                ->nullable();

            $table->timestamps();

        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
