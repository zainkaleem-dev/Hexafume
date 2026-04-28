<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();

            // Basic Information
            $table->string('name');
            $table->string('url_slug')->unique();
            $table->string('initials', 3);
            $table->string('title');
            $table->string('dept');
            $table->string('dept_label')->nullable();
            $table->string('exp')->nullable();
            $table->string('location')->nullable();
            $table->text('bio');

            // Profile Photo
            $table->string('photo_path')->nullable();

            // Social & Contact
            $table->string('email');
            $table->string('linkedin')->nullable();
            $table->string('twitter')->nullable();
            $table->string('github')->nullable();

            // Core Skills (stored as JSON array)
            $table->json('skills')->nullable();

            // Expertise Tags (stored as JSON array)
            $table->json('expertise_tags')->nullable();

            // SEO & Meta
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_image_url')->nullable();

            // Visibility & Publishing
            $table->boolean('seo_index')->default(true);
            $table->boolean('show_on_team')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->enum('visibility', ['public', 'private', 'unlisted'])->default('public');
            $table->date('publish_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
