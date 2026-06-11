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
        Schema::create('delivery_proofs', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Proof Information
            |--------------------------------------------------------------------------
            */

            $table->string('proof_number')->unique();

            /*
            |--------------------------------------------------------------------------
            | Delivery References
            |--------------------------------------------------------------------------
            */

            $table->foreignId('delivery_id')
                ->constrained('deliveries')
                ->cascadeOnDelete();

            $table->foreignId('order_id')
                ->nullable()
                ->constrained('orders')
                ->nullOnDelete();

            $table->foreignId('customer_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Delivery Executive
            |--------------------------------------------------------------------------
            */

            $table->foreignId('field_executive_id')
                ->nullable()
                ->constrained('field_executives')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Proof Type
            |--------------------------------------------------------------------------
            */

            $table->enum('proof_type', [
                'otp',
                'signature',
                'photo',
                'video',
                'qr_scan',
                'manual'
            ])->default('otp');

            /*
            |--------------------------------------------------------------------------
            | Receiver Information
            |--------------------------------------------------------------------------
            */

            $table->string('receiver_name')
                ->nullable();

            $table->string('receiver_mobile')
                ->nullable();

            $table->string('receiver_relation')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | OTP Verification
            |--------------------------------------------------------------------------
            */

            $table->string('otp_code')
                ->nullable();

            $table->boolean('otp_verified')
                ->default(false);

            $table->timestamp('otp_verified_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Signature
            |--------------------------------------------------------------------------
            */

            $table->string('signature_file')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Media Proof
            |--------------------------------------------------------------------------
            */

            $table->string('photo')
                ->nullable();

            $table->string('video')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | GPS Verification
            |--------------------------------------------------------------------------
            */

            $table->decimal('latitude', 10, 8)
                ->nullable();

            $table->decimal('longitude', 11, 8)
                ->nullable();

            $table->string('gps_address')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Verification
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_verified')
                ->default(false);

            $table->timestamp('verified_at')
                ->nullable();

            $table->foreignId('verified_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Delivery Result
            |--------------------------------------------------------------------------
            */

            $table->enum('delivery_result', [
                'successful',
                'failed',
                'partial',
                'returned'
            ])->default('successful');

            $table->text('failure_reason')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Customer Feedback
            |--------------------------------------------------------------------------
            */

            $table->tinyInteger('rating')
                ->nullable();

            $table->text('feedback')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Notes
            |--------------------------------------------------------------------------
            */

            $table->longText('remarks')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Proof Timestamp
            |--------------------------------------------------------------------------
            */

            $table->timestamp('captured_at');

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

            $table->index('proof_number');
            $table->index('delivery_id');
            $table->index('order_id');
            $table->index('customer_id');
            $table->index('field_executive_id');
            $table->index('proof_type');
            $table->index('delivery_result');
            $table->index('captured_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_proofs');
    }
};