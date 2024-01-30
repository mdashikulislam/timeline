<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('timelines', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->enum('is_edit',['Active','Inactive'])->default('Inactive');
        });
    }

    public function down(): void
    {
        Schema::table('timelines', function (Blueprint $table) {
            //
        });
    }
};
