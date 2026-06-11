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
        Schema::create('workflow_rules', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Rule Information
            |--------------------------------------------------------------------------
            */

            $table->string('rule_code')->unique();

            $table->string('name');

            $table->text('description')->nullable();

            /*
            |--------------------------------------------------------------------------
            | Module
            |--------------------------------------------------------------------------
            */

            $table->enum('module', [
                'lead',
                'appointment',
                'measurement',
                'order',
                'delivery',
                'commission',
                'wallet',
                'withdrawal',
                'ticket',
                'notification',
                'fraud',
                'customer',
                'chemist',
                'distributor'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Trigger Event
            |--------------------------------------------------------------------------
            */

            $table->string('trigger_event');

            /*
            |--------------------------------------------------------------------------
            | Conditions
            |--------------------------------------------------------------------------
            */

            $table->json('conditions')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Actions
            |--------------------------------------------------------------------------
            */

            $table->json('actions');

            /*
            |--------------------------------------------------------------------------
            | Execution
            |--------------------------------------------------------------------------
            */

            $table->integer('priority')
                ->default(1);

            $table->integer('delay_minutes')
                ->default(0);

            $table->boolean('run_once')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

            /*
            |--------------------------------------------------------------------------
            | Statistics
            |--------------------------------------------------------------------------
            */

            $table->unsignedBigInteger('execution_count')
                ->default(0);

            $table->unsignedBigInteger('success_count')
                ->default(0);

            $table->unsignedBigInteger('failure_count')
                ->default(0);

            $table->timestamp('last_executed_at')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Approval
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

            $table->index('rule_code');
            $table->index('module');
            $table->index('trigger_event');
            $table->index('is_active');
            $table->index('priority');
            $table->index('last_executed_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workflow_rules');
    }
};