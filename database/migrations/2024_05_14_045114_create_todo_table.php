<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('todo', function (Blueprint $table) {
            $table->id();
            $table->string('user');
            $table->string('task');
            $table->string('subtask1')->nullable();
            $table->string('subtask2')->nullable();
            $table->string('subtask3')->nullable(); $table->boolean('is_done')->default(false); $table->boolean('is_subtask1_done')->default(false); $table->boolean('is_subtask2_done')->default(false); $table->boolean('is_subtask3_done')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todo');
    }
};
