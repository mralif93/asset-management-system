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
        Schema::create('audit_trails', function (Blueprint $table) {
            $table->id();
            
            // User Information
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('user_name')->nullable();
            $table->string('user_email')->nullable();
            $table->string('user_role')->nullable();
            
            // Action Details
            $table->string('action'); // CREATE, UPDATE, DELETE, LOGIN, LOGOUT, VIEW, etc.
            $table->string('model_type')->nullable(); // Model class name
            $table->unsignedBigInteger('model_id')->nullable(); // Model ID
            $table->string('model_name')->nullable(); // Readable model name
            
            // Request Information
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->string('method', 10)->nullable(); // GET, POST, PUT, DELETE
            $table->text('url')->nullable();
            $table->text('route_name')->nullable();
            
            // Change Details
            $table->json('old_values')->nullable(); // Previous values (for updates)
            $table->json('new_values')->nullable(); // New values (for creates/updates)
            $table->text('description')->nullable(); // Human readable description
            
            // Additional Context
            $table->string('event_type')->nullable(); // web, api, console
            $table->string('status', 20)->default('success'); // success, failed, warning
            $table->text('error_message')->nullable();
            $table->json('additional_data')->nullable(); // Any extra context
            
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['user_id', 'created_at']);
            $table->index(['model_type', 'model_id']);
            $table->index(['action', 'created_at']);
            $table->index(['ip_address', 'created_at']);
            $table->index('created_at');
            
            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_trails');
    }
};
