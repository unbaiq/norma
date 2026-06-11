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
        Schema::create('warehouse_locations', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Warehouse Information
            |--------------------------------------------------------------------------
            */

            $table->string('warehouse_code')->unique();

            $table->string('name');

            $table->string('contact_person')
                ->nullable();

            $table->string('contact_number', 20)
                ->nullable();

            $table->string('email')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Warehouse Type
            |--------------------------------------------------------------------------
            */

            $table->enum('warehouse_type', [
                'central',
                'regional',
                'distributor',
                'fulfillment_center',
                'transit_hub'
            ])->default('regional');

            /*
            |--------------------------------------------------------------------------
            | Distributor Mapping
            |--------------------------------------------------------------------------
            */

            $table->foreignId('distributor_id')
                ->nullable()
                ->constrained('distributor_profiles')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Address
            |--------------------------------------------------------------------------
            */

            $table->text('address');

            $table->foreignId('country_id')
                ->nullable()
                ->constrained('countries')
                ->nullOnDelete();

            $table->foreignId('state_id')
                ->nullable()
                ->constrained('states')
                ->nullOnDelete();

            $table->foreignId('city_id')
                ->nullable()
                ->constrained('cities')
                ->nullOnDelete();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained('areas')
                ->nullOnDelete();

            $table->foreignId('pincode_id')
                ->nullable()
                ->constrained('pincodes')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | GPS Location
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Capacity
            |--------------------------------------------------------------------------
            */

            $table->integer('storage_capacity')
                ->default(0);

            $table->integer('current_utilization')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Operations
            |--------------------------------------------------------------------------
            */

            $table->time('opening_time')
                ->nullable();

            $table->time('closing_time')
                ->nullable();

            $table->boolean('supports_dispatch')
                ->default(true);

            $table->boolean('supports_returns')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->enum('status', [
                'active',
                'inactive',
                'maintenance',
                'closed'
            ])->default('active');

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('warehouse_code');
            $table->index('warehouse_type');
            $table->index('distributor_id');
            $table->index('country_id');
            $table->index('state_id');
            $table->index('city_id');
            $table->index('pincode_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('warehouse_locations');
    }
};