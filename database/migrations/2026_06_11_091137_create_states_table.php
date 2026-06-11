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
        Schema::create('states', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Country Mapping
            |--------------------------------------------------------------------------
            */

            $table->foreignId('country_id')
                ->constrained('countries')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | State Information
            |--------------------------------------------------------------------------
            */

            $table->string('name');

            $table->string('code', 20)->nullable();

            $table->string('iso_code', 20)->nullable();

            /*
            |--------------------------------------------------------------------------
            | Capital Information
            |--------------------------------------------------------------------------
            */

            $table->string('capital')->nullable();

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

            $table->boolean('is_default')
                ->default(false);

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
            $table->index('name');
            $table->index('code');
            $table->index('status');
            $table->index('is_serviceable');

            /*
            |--------------------------------------------------------------------------
            | Prevent Duplicates
            |--------------------------------------------------------------------------
            */

            $table->unique([
                'country_id',
                'name'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};