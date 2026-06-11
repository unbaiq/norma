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
        Schema::create('system_settings', function (Blueprint $table) {

            $table->id();

            /*
            |--------------------------------------------------------------------------
            | Setting Information
            |--------------------------------------------------------------------------
            */

            $table->string('group');

            $table->string('key')->unique();

            $table->string('label');

            $table->text('description')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Value Information
            |--------------------------------------------------------------------------
            */

            $table->longText('value')
                ->nullable();

            $table->enum('value_type', [
                'string',
                'integer',
                'decimal',
                'boolean',
                'json',
                'array',
                'text'
            ])->default('string');

            /*
            |--------------------------------------------------------------------------
            | Default Value
            |--------------------------------------------------------------------------
            */

            $table->longText('default_value')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Validation
            |--------------------------------------------------------------------------
            */

            $table->string('validation_rule')
                ->nullable();

            /*
            |--------------------------------------------------------------------------
            | Visibility
            |--------------------------------------------------------------------------
            */

            $table->boolean('is_public')
                ->default(false);

            $table->boolean('is_editable')
                ->default(true);

            $table->boolean('is_encrypted')
                ->default(false);

            /*
            |--------------------------------------------------------------------------
            | Environment
            |--------------------------------------------------------------------------
            */

            $table->enum('environment', [
                'all',
                'local',
                'staging',
                'production'
            ])->default('all');

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

            $table->index('group');
            $table->index('key');
            $table->index('value_type');
            $table->index('is_active');
            $table->index('environment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('system_settings');
    }
};