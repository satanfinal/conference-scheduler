<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (!Schema::hasColumn('events', 'meeting_link')) {
                $table->string('meeting_link')->nullable();
            }

            if (!Schema::hasColumn('events', 'speaker_id')) {
                $table->unsignedBigInteger('speaker_id')->nullable();
            }

            if (!Schema::hasColumn('events', 'category_id')) {
                $table->unsignedBigInteger('category_id')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            if (Schema::hasColumn('events', 'meeting_link')) {
                $table->dropColumn('meeting_link');
            }

            if (Schema::hasColumn('events', 'speaker_id')) {
                $table->dropColumn('speaker_id');
            }

            if (Schema::hasColumn('events', 'category_id')) {
                $table->dropColumn('category_id');
            }
        });
    }
};