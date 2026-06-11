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
        Schema::create('pincodes', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Location Hierarchy
            |--------------------------------------------------------------------------
            */

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->foreignId('state_id')
                ->constrained('states')
                ->cascadeOnDelete();

            $table->foreignId('city_id')
                ->constrained('cities')
                ->cascadeOnDelete();

            $table->foreignId('area_id')
                ->nullable()
                ->constrained('areas')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Pincode Information
            |--------------------------------------------------------------------------
            */

            $table->string('pincode', 20)->unique();

            $table->string('post_office')->nullable();

            $table->string('district')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Service Configuration
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_serviceable')
                ->default(true);

            $table->boolean('is_active')
                ->default(true);

            $table->boolean('is_priority')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Coverage
            |--------------------------------------------------------------------------
            */

            $table->integer('chemist_count')
                ->default(0);

            $table->integer('customer_count')
                ->default(0);

            $table->integer('field_executive_count')
                ->default(0);

            $table->integer('distributor_count')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | SLA Configuration
            |--------------------------------------------------------------------------
            */

            $table->integer('appointment_sla_hours')
                ->default(24);

            $table->integer('delivery_sla_days')
                ->default(3);

            /*
            |--------------------------------------------------------------------------
            | Territory Mapping
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('territory_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Geo Location
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

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
            | Sorting
            |--------------------------------------------------------------------------
            */

            $table->integer('sort_order')
                ->default(0);

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

            $table->index('country_id');
            $table->index('state_id');
            $table->index('city_id');
            $table->index('area_id');

            $table->index('pincode');
            $table->index('territory_id');
            $table->index('status');
            $table->index('is_serviceable');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pincodes');
    }
};