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
        Schema::create('project_role', function (Blueprint $table) {
            // $table->unsignedBigInteger('project_id');
            // $table->unsignedBigInteger('role_id');

            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();


            // $table->foreign('progect_id')->refrences('id')->on('projects')->onDelete('cascade');
            // $table->foreign('role_id')->refrences('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_role');
    }
};
