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
        Schema::table('packages', function (Blueprint $table) {
            //
            if (!Schema::hasColumn('packages', 'mikrotik_profile')) {
            $table->string('mikrotik_profile')->nullable()->after('bandwidth');
        }

        if (!Schema::hasColumn('packages', 'is_active')) {
            $table->boolean('is_active')->default(true)->after('mikrotik_profile');
        }

        if (!Schema::hasColumn('packages', 'user_id')) {
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
        }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {
            //
        });
    }
};
