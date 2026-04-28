<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url_slug')->unique();
            $table->string('type');
            $table->string('client_name');
            $table->string('site_url')->nullable();
            $table->date('start_date');
            $table->date('finish_date');
            $table->string('total_time')->nullable();
            $table->string('team')->nullable();
            $table->enum('status', ['live', 'progress', 'review', 'paused', 'draft'])->default('draft');
            $table->boolean('delivered_on_time')->default(true);
            
            $table->string('hero_image_path')->nullable();
            $table->string('logo_image_path')->nullable();
            
            $table->string('overview_heading');
            $table->text('overview_p1');
            $table->text('overview_p2')->nullable();
            $table->text('overview_p3')->nullable();
            
            $table->string('stat1_num')->nullable();
            $table->string('stat1_lbl')->nullable();
            $table->string('stat2_num')->nullable();
            $table->string('stat2_lbl')->nullable();
            $table->string('stat3_num')->nullable();
            $table->string('stat3_lbl')->nullable();
            
            $table->text('stack_description')->nullable();
            $table->string('timeline_heading')->nullable();
            $table->string('timeline_subtext')->nullable();
            
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->string('og_image_url')->nullable();
            $table->enum('twitter_card', ['summary', 'summary_large_image'])->default('summary_large_image');
            
            $table->boolean('seo_index')->default(true);
            $table->boolean('show_portfolio')->default(true);
            $table->boolean('is_featured')->default(false);
            
            $table->enum('visibility', ['public', 'private', 'password'])->default('public');
            $table->date('publish_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
