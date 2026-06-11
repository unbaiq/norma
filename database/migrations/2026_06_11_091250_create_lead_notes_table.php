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
        Schema::create('lead_notes', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Lead Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('lead_id')
                ->constrained('leads')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | User Information
            |--------------------------------------------------------------------------
            */

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | Note Type
            |--------------------------------------------------------------------------

            */

            $table->enum('note_type', [
                'general',
                'call',
                'follow_up',
                'appointment',
                'measurement',
                'order',
                'delivery',
                'commission',
                'rejection',
                'internal'
            ])->default('general');

            /*
            |--------------------------------------------------------------------------
            | Note Content
            |--------------------------------------------------------------------------
            */

            $table->longText('note');

            $table->text('summary')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Follow-up
            |--------------------------------------------------------------------------

            */

            $table->timestamp('next_followup_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------

            */

            $table->boolean('is_internal')
                ->default(false);

            $table->boolean('is_customer_visible')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------

            */

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'urgent'
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Related Records
            |--------------------------------------------------------------------------

            */

            $table->string('reference_type')
                ->nullable();

            $table->unsignedBigInteger('reference_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------

            */

            $table->enum('status', [
                'active',
                'archived',
                'deleted'
            ])->default('active');

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

            $table->index('lead_id');
            $table->index('user_id');
            $table->index('note_type');
            $table->index('priority');
            $table->index('status');
            $table->index('next_followup_at');

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
        Schema::dropIfExists('lead_notes');
    }
};