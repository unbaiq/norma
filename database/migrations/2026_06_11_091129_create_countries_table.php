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
        Schema::create('countries', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Country Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');
            $table->string('official_name')->nullable();

            $table->string('iso2', 2)->unique();
            $table->string('iso3', 3)->unique();

            $table->string('numeric_code', 10)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Phone Information
            |--------------------------------------------------------------------------
            */

            $table->string('phone_code', 10)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Currency
            |--------------------------------------------------------------------------
            */

            $table->string('currency_name')->nullable();
            $table->string('currency_code', 10)->nullable();
            $table->string('currency_symbol', 10)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Timezone
            |--------------------------------------------------------------------------
            */

            $table->string('timezone')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Flags
            |--------------------------------------------------------------------------
            */

            $table->string('flag')->nullable();

            $table->boolean('is_default')->default(false);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Sort Order
            |--------------------------------------------------------------------------
            */

            $table->integer('sort_order')->default(0);

            /*
            |--------------------------------------------------------------------------
            | Additional Data
            |--------------------------------------------------------------------------
            */

            $table->json('meta')->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('name');
            $table->index('iso2');
            $table->index('iso3');
            $table->index('phone_code');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};