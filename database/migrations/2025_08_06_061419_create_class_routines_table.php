<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('class_routines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained('classes')->onDelete('cascade');
            $table->string('shift', 20);
            $table->string('type', 20);
            $table->string('routine_title', 150)->nullable();
            $table->string('file_path', 255);
            $table->enum('file_type', ['pdf', 'image'])->default('pdf');
            $table->date('published_date')->default(DB::raw('curdate()'));
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('class_routines');
    }
};
