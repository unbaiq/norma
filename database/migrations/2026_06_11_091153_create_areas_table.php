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
        Schema::create('areas', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Location Mapping
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

            /*
            |--------------------------------------------------------------------------
            | Area Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('code', 50)->nullable();

            $table->string('locality')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Area Classification
            |--------------------------------------------------------------------------
            */

            $table->enum('area_type', [
                'residential',
                'commercial',
                'industrial',
                'rural',
                'urban',
                'semi_urban',
                'mixed'
            ])->default('urban');

            /*
            |--------------------------------------------------------------------------
            | Business Configuration
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_serviceable')
                ->default(true);

            $table->boolean('is_priority_area')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Geo Information
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            $table->integer('estimated_population')
                ->nullable();

            $table->integer('chemist_count')
                ->default(0);

            $table->integer('customer_count')
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
            | Additional Information
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

            $table->index('name');
            $table->index('area_type');
            $table->index('status');
            $table->index('is_serviceable');

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Areas
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'city_id',
                'name'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('areas');
    }
};