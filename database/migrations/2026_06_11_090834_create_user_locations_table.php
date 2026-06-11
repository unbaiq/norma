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
        Schema::create('user_locations', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Location Type
            |--------------------------------------------------------------------------
            */

            $table->enum('location_type', [
                'home',
                'shop',
                'warehouse',
                'office',
                'appointment',
                'delivery',
                'live_tracking',
                'checkin',
                'checkout'
            ])->default('live_tracking');

            /*
            |--------------------------------------------------------------------------
            | Coordinates
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8);

            $table->decimal('longitude', 11, 8);

            $table->decimal('accuracy', 10, 2)
                ->nullable()
                ->comment('GPS Accuracy in meters');

            /*
            |--------------------------------------------------------------------------
            | Address Information
            |--------------------------------------------------------------------------
            */

            $table->text('address')->nullable();

            $table->string('country')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->string('pincode')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Territory Mapping
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('territory_id')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Device Information
            |--------------------------------------------------------------------------
            */

            $table->string('device_uuid')->nullable();

            $table->string('device_type')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Tracking Information
            |--------------------------------------------------------------------------
            */

            $table->timestamp('tracked_at')
                ->nullable();

            $table->boolean('is_current')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Related Module
            |--------------------------------------------------------------------------
            */

            $table->string('reference_type')
                ->nullable()
                ->comment('appointment, delivery, visit, lead etc');

            $table->unsignedBigInteger('reference_id')
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
            | Additional Information
            |--------------------------------------------------------------------------
            */

            $table->json('meta')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('user_id');
            $table->index('location_type');
            $table->index('territory_id');
            $table->index('tracked_at');
            $table->index('is_current');
            $table->index(['reference_type', 'reference_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_locations');
    }
};