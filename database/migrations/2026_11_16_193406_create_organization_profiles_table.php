
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_profiles', function (Blueprint $table) {
            $table->id();

            // Identitas organisasi
            $table->string('name')->default('Konservasi Bersenyum');
            $table->string('tagline')->nullable();
            $table->string('logo_path')->nullable();

            // Halaman beranda
            $table->string('hero_title')->nullable();
            $table->text('hero_description')->nullable();
            $table->string('hero_image')->nullable();

            // Halaman tentang kami
            $table->string('about_title')->nullable();
            $table->longText('about_description')->nullable();
            $table->string('about_image')->nullable();

            // Informasi kontak
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->text('address')->nullable();

            // Media sosial
            $table->string('instagram')->nullable();
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();

            // Informasi footer
            $table->string('footer_text')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_profiles');
    }
};
