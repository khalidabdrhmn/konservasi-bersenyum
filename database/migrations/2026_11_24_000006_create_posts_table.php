<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();

            // Relasi dengan administrator (penulis)
            $table->foreignId('user_id')->constrained('users');

            // Informasi artikel / berita
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('excerpt')->nullable();
            $table->longText('content');
            $table->string('image')->nullable();

            // Status publikasi
            $table->string('status')->default('draft'); // draft, published, archived
            $table->timestamp('published_at')->nullable();

            // Pengaturan urutan
            $table->unsignedInteger('sort_order')->default(0);

            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'published_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};