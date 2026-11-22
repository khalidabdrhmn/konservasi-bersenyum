
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('programs', function (Blueprint $table) {
            $table->id();

            // Relasi dengan administrator
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Informasi program
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('category', 100);
            $table->string('excerpt')->nullable();
            $table->longText('description')->nullable();

            // Gambar program
            $table->string('image')->nullable();

            // Status publikasi
            $table->string('status')->default('draft');
            $table->timestamp('published_at')->nullable();

            // Pengaturan urutan
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
