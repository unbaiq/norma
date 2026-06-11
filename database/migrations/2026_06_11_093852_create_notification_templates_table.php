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
        Schema::create('notification_templates', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Template Information
            |--------------------------------------------------------------------------
            */

            $table->string('template_code')->unique();

            $table->string('name');

            $table->text('description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Template Type
            |--------------------------------------------------------------------------
            */

            $table->enum('type', [
                'system',
                'order',
                'delivery',
                'appointment',
                'lead',
                'measurement',
                'commission',
                'wallet',
                'withdrawal',
                'otp',
                'marketing',
                'promotion'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Channel
            |--------------------------------------------------------------------------
            */

            $table->enum('channel', [
                'sms',
                'email',
                'push',
                'whatsapp',
                'in_app'
            ]);

            /*
            |--------------------------------------------------------------------------
            | Email Subject
            |--------------------------------------------------------------------------
            */

            $table->string('subject')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Template Content
            |--------------------------------------------------------------------------
            */

            $table->longText('content');

            /*
            |--------------------------------------------------------------------------
            | Variables
            |--------------------------------------------------------------------------
            */

            $table->json('variables')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Provider Template
            |--------------------------------------------------------------------------
            */

            $table->string('provider_template_id')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Language
            |--------------------------------------------------------------------------
            */

            $table->string('language', 10)
                ->default('en');

            /*
            |--------------------------------------------------------------------------
            | Priority
            |--------------------------------------------------------------------------
            */

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'critical'
            ])->default('medium');

            /*
            |--------------------------------------------------------------------------
            | Scheduling
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_scheduled')
                ->default(false);

            $table->integer('schedule_delay_minutes')
                ->default(0);

            /*
            |--------------------------------------------------------------------------
            | Status
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_active')
                ->default(true);

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
            | Additional Data
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

            $table->index('template_code');
            $table->index('type');
            $table->index('channel');
            $table->index('language');
            $table->index('priority');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_templates');
    }
};