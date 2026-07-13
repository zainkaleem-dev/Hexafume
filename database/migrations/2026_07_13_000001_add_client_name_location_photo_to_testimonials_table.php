<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->string('client_name')->nullable()->after('initials');
            $table->string('location')->nullable()->after('client_name');
            $table->string('photo')->nullable()->after('location');
        });
    }

    public function down(): void
    {
        Schema::table('testimonials', function (Blueprint $table) {
            $table->dropColumn(['client_name', 'location', 'photo']);
        });
    }
};
