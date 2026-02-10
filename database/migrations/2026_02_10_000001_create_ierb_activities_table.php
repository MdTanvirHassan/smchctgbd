<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ierb_activities', function (Blueprint $table) {
            $table->id();
            $table->string('topic', 500);
            $table->string('principal_investigator', 255);
            $table->date('activity_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ierb_activities');
    }
};
