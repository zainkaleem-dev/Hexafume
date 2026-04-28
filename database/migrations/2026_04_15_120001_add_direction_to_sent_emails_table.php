<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sent_emails', function (Blueprint $table) {
            $table->string('direction', 20)->default('sent')->after('sender_name');
        });

        // Backfill: contact-form submissions are received (they include sender_email).
        DB::table('sent_emails')
            ->whereNotNull('sender_email')
            ->update(['direction' => 'received']);
    }

    public function down(): void
    {
        Schema::table('sent_emails', function (Blueprint $table) {
            $table->dropColumn('direction');
        });
    }
};

