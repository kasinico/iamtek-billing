<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('packages', function (Blueprint $table) {

            // Owner of package: admin/shopkeeper/reseller
            if (!Schema::hasColumn('packages', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('id');
            }

            // Speed limit display/control e.g. 2M/2M, 5M/5M
            if (!Schema::hasColumn('packages', 'bandwidth')) {
                $table->string('bandwidth')->nullable()->after('duration');
            }

            // MikroTik hotspot user profile name e.g. 1hour, 1day
            // Your DB has duration_unit, not type, so we place it after duration_unit.
            if (!Schema::hasColumn('packages', 'mikrotik_profile')) {
                $table->string('mikrotik_profile')->nullable()->after('duration_unit');
            }

        });
    }

    public function down(): void
    {
        Schema::table('packages', function (Blueprint $table) {

            if (Schema::hasColumn('packages', 'mikrotik_profile')) {
                $table->dropColumn('mikrotik_profile');
            }

            // Do NOT drop user_id/bandwidth because they already exist in your DB structure.
        });
    }
};