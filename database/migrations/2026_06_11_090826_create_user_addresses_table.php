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
        Schema::create('user_addresses', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Address Type
            |--------------------------------------------------------------------------
            */

            $table->enum('address_type', [
                'home',
                'office',
                'shop',
                'warehouse',
                'billing',
                'shipping',
                'delivery',
                'other'
            ])->default('home');

            /*
            |--------------------------------------------------------------------------
            | Contact Person
            |--------------------------------------------------------------------------
            */

            $table->string('contact_person_name')->nullable();

            $table->string('contact_person_mobile', 20)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Address Information
            |--------------------------------------------------------------------------
            */

            $table->string('house_no')->nullable();

            $table->string('building_name')->nullable();

            $table->string('landmark')->nullable();

            $table->string('street')->nullable();

            $table->string('area')->nullable();

            $table->text('address_line_1');

            $table->text('address_line_2')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Location Mapping
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('country_id')->nullable();

            $table->unsignedBigInteger('state_id')->nullable();

            $table->unsignedBigInteger('city_id')->nullable();

            $table->unsignedBigInteger('territory_id')->nullable();

            $table->string('pincode', 20)->nullable();

            /*
            |--------------------------------------------------------------------------
            | GPS Coordinates
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)->nullable();

            $table->decimal('longitude', 11, 8)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Address Usage
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_default')->default(false);

            $table->boolean('is_billing')->default(false);

            $table->boolean('is_shipping')->default(false);

            $table->boolean('is_active')->default(true);

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_verified')->default(false);

            $table->timestamp('verified_at')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Additional Information
            |--------------------------------------------------------------------------
            */

            $table->text('delivery_instructions')->nullable();

            $table->json('meta')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive'
            ])->default('active');

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('user_id');
            $table->index('address_type');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('city_id');
            $table->index('territory_id');
            $table->index('pincode');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};