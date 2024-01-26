<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('timeline_items', function (Blueprint $table) {
            $table->unsignedBigInteger('label_id')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('timeline_items', function (Blueprint $table) {
            //
        });
    }
};
