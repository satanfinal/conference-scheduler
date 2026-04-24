<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('rsvps')) {
            Schema::create('rsvps', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('event_id');
                $table->timestamps();
            });
        } else {
            Schema::table('rsvps', function (Blueprint $table) {
                if (!Schema::hasColumn('rsvps', 'user_id')) {
                    $table->unsignedBigInteger('user_id')->nullable();
                }

                if (!Schema::hasColumn('rsvps', 'event_id')) {
                    $table->unsignedBigInteger('event_id')->nullable();
                }
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('rsvps');
    }
};