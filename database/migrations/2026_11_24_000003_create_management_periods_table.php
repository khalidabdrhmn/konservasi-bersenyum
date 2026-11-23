<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('management_periods', function (Blueprint $table) {
            $table->id();

            // Informasi periode kepengurusan
            $table->string('name'); // Contoh: "Periode 2024-2026"
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(false);
            $table->text('description')->nullable();

            // Relasi dengan administrator yang membuat periode
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('management_periods');
    }
};