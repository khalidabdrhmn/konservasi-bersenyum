<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();

            // Relasi dengan periode dan divisi
            $table->foreignId('management_period_id')->constrained('management_periods');
            $table->foreignId('division_id')
                ->nullable()
                ->constrained('divisions')
                ->nullOnDelete();

            // Informasi anggota
            $table->string('name');
            $table->string('position'); // Contoh: "Ketua Umum", "Sekretaris", "Anggota"
            $table->string('slug')->unique();
            $table->text('bio')->nullable();
            $table->string('photo')->nullable();
            $table->string('instagram')->nullable();
            $table->string('linkedin')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            // Relasi dengan administrator
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['management_period_id', 'division_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};