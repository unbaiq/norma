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
        Schema::create('executive_locations', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Executive
            |--------------------------------------------------------------------------
            */

            $table->foreignId('field_executive_id')
                ->constrained('field_executives')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | User Mapping
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Assignment Reference
            |--------------------------------------------------------------------------
            */

            $table->foreignId('executive_assignment_id')
                ->nullable()
                ->constrained('executive_assignments')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Location Type
            |--------------------------------------------------------------------------
            */

            $table->enum('location_type', [
                'live_tracking',
                'check_in',
                'check_out',
                'appointment_visit',
                'measurement_visit',
                'delivery_visit',
                'service_visit',
                'territory_visit'
            ])->default('live_tracking');

            /*
            |--------------------------------------------------------------------------
            | GPS Coordinates
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8);

            $table->decimal('longitude', 11, 8);

            $table->decimal('accuracy', 8, 2)
                ->nullable()
                ->comment('GPS accuracy in meters');

            $table->decimal('altitude', 10, 2)
                ->nullable();

            $table->decimal('speed', 8, 2)
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Address Information
            |--------------------------------------------------------------------------
            */

            $table->text('address')
                ->nullable();

            $table->string('country')
                ->nullable();

            $table->string('state')
                ->nullable();

            $table->string('city')
                ->nullable();

            $table->string('area')
                ->nullable();

            $table->string('pincode')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Territory
            |--------------------------------------------------------------------------
            */

            $table->foreignId('territory_id')
                ->nullable()
                ->constrained('territories')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Device Information
            |--------------------------------------------------------------------------
            */

            $table->string('device_id')
                ->nullable();

            $table->string('device_model')
                ->nullable();

            $table->string('os_version')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Battery Information
            |--------------------------------------------------------------------------
            */

            $table->integer('battery_percentage')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Visit Verification
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_customer_location')
                ->default(false);

            $table->boolean('is_verified')
                ->default(false);

            $table->decimal('distance_from_target', 10, 2)
                ->nullable()
                ->comment('Distance in meters');

            /*
            |--------------------------------------------------------------------------
            | Reference
            |--------------------------------------------------------------------------
            */

            $table->string('reference_type')
                ->nullable();

            $table->unsignedBigInteger('reference_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Tracking Time
            |--------------------------------------------------------------------------
            */

            $table->timestamp('tracked_at');

            /*
            |--------------------------------------------------------------------------
            | Metadata
            |--------------------------------------------------------------------------
            */

            $table->json('meta')
                ->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | Indexes
            |--------------------------------------------------------------------------
            */

            $table->index('field_executive_id');
            $table->index('executive_assignment_id');
            $table->index('territory_id');
            $table->index('location_type');
            $table->index('tracked_at');

            $table->index([
                'reference_type',
                'reference_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('executive_locations');
    }
};