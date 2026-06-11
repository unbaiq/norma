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
        Schema::create('cities', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Country & State Mapping
            |--------------------------------------------------------------------------
            */

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            $table->foreignId('state_id')
                ->constrained('states')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | City Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('code', 20)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Administrative Information
            |--------------------------------------------------------------------------
            */

            $table->string('district')->nullable();

            $table->string('zone')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Location
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)->nullable();

            $table->decimal('longitude', 11, 8)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Business Configuration
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_serviceable')
                ->default(true);

            $table->boolean('is_metro_city')
                ->default(false);

            $table->boolean('is_default')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            $table->integer('population')->nullable();

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

            $table->json('meta')->nullable();

            $table->timestamps();

            $table->softDeletes();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('country_id');
            $table->index('state_id');
            $table->index('name');
            $table->index('district');
            $table->index('status');
            $table->index('is_serviceable');

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicate Cities
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'state_id',
                'name'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};