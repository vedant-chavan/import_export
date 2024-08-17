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
        Schema::create('import_data', function (Blueprint $table) {
            $table->id();
            $table->string('unique_number', 12)->unique();
            $table->date('date_of_installation');
            $table->string('seal_name');
            $table->string('installed_at');
            $table->string('type');
            $table->string('use');
            $table->string('client');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('import_data');
    }
};
