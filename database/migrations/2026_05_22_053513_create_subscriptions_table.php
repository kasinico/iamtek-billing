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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id');

            $table->decimal('amount', 10, 2)
                ->default(5000);

            $table->string('status')
                ->default('active');

            $table->timestamp('starts_at');

            $table->timestamp('ends_at');

            $table->string('duration_type');

            $table->integer('duration_value');

            $table->string('activated_by')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
