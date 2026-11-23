<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('management_periods', function (Blueprint $table) {
            if (!Schema::hasColumn('management_periods', 'slug')) {
                $table->string('slug', 120)->nullable()->unique()->after('name');
            }
            if (!Schema::hasColumn('management_periods', 'status')) {
                $table->string('status', 20)->nullable()->index()->after('end_date');
            }
        });

        Schema::table('divisions', function (Blueprint $table) {
            if (!Schema::hasColumn('divisions', 'management_period_id')) {
                $table->foreignId('management_period_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('divisions', 'sort_order')) {
                $table->unsignedSmallInteger('sort_order')->default(0)->after('description');
            }
        });

        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('management_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('division_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('parent_position_id')->nullable();
            $table->string('name', 150);
            $table->string('slug', 180);
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
            $table->unique(['management_period_id', 'slug']);
        });

        Schema::table('positions', function (Blueprint $table) {
            $table->foreign('parent_position_id')->references('id')->on('positions')->nullOnDelete();
        });

        Schema::create('member_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('position_id')->constrained()->cascadeOnDelete();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_primary')->default(false);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->unique(['member_id', 'position_id']);
        });

        Schema::create('program_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('slug', 120)->unique();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('programs', function (Blueprint $table) {
            if (!Schema::hasColumn('programs', 'management_period_id')) {
                $table->foreignId('management_period_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('programs', 'program_category_id')) {
                $table->foreignId('program_category_id')->nullable()->after('management_period_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('programs', 'implementation_status')) {
                $table->string('implementation_status', 20)->default('planned')->after('description');
            }
            if (!Schema::hasColumn('programs', 'publication_status')) {
                $table->string('publication_status', 20)->nullable()->after('implementation_status');
            }
        });

        Schema::table('galleries', function (Blueprint $table) {
            if (!Schema::hasColumn('galleries', 'management_period_id')) {
                $table->foreignId('management_period_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('galleries', 'program_id')) {
                $table->foreignId('program_id')->nullable()->after('management_period_id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('galleries', 'publication_status')) {
                $table->string('publication_status', 20)->nullable()->after('status');
            }
        });

        Schema::create('gallery_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('gallery_id')->constrained()->cascadeOnDelete();
            $table->string('media_type', 20)->default('image');
            $table->string('file_path');
            $table->string('thumbnail_path')->nullable();
            $table->string('caption', 500)->nullable();
            $table->string('alt_text', 255)->nullable();
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('posts', function (Blueprint $table) {
            if (!Schema::hasColumn('posts', 'management_period_id')) {
                $table->foreignId('management_period_id')->nullable()->after('id')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('posts', 'post_type')) {
                $table->string('post_type', 20)->default('article')->after('content');
            }
            if (!Schema::hasColumn('posts', 'publication_status')) {
                $table->string('publication_status', 20)->nullable()->after('post_type');
            }
        });

        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name', 80);
            $table->string('slug', 100)->unique();
            $table->timestamps();
        });

        Schema::create('post_tag', function (Blueprint $table) {
            $table->foreignId('post_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
            $table->primary(['post_id', 'tag_id']);
        });

        Schema::create('contact_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->string('email');
            $table->string('phone', 30)->nullable();
            $table->string('subject', 200);
            $table->text('message');
            $table->string('status', 20)->default('new')->index();
            $table->text('admin_note')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('handled_at')->nullable();
            $table->timestamps();
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('event', 80)->index();
            $table->string('subject_type', 255)->nullable()->index();
            $table->unsignedBigInteger('subject_id')->nullable()->index();
            $table->text('description')->nullable();
            $table->json('properties')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        Schema::table('organization_profiles', function (Blueprint $table) {
            if (!Schema::hasColumn('organization_profiles', 'vision')) {
                $table->text('vision')->nullable()->after('about_description');
            }
            if (!Schema::hasColumn('organization_profiles', 'mission')) {
                $table->longText('mission')->nullable()->after('vision');
            }
            if (!Schema::hasColumn('organization_profiles', 'tiktok')) {
                $table->string('tiktok')->nullable()->after('youtube');
            }
        });

        Schema::table('members', function (Blueprint $table) {
            foreach (['full_name', 'display_name', 'student_id', 'study_program', 'university', 'cohort_year', 'is_public'] as $column) {
                if (!Schema::hasColumn('members', $column)) {
                    // Nullable columns are added below to keep migration compatible.
                }
            }
        });

        if (!Schema::hasColumn('members', 'full_name')) {
            Schema::table('members', function (Blueprint $table) {
                $table->string('full_name', 180)->nullable()->after('division_id');
                $table->string('display_name', 120)->nullable();
                $table->string('student_id', 40)->nullable()->index();
                $table->string('study_program', 150)->nullable();
                $table->string('university', 180)->nullable();
                $table->unsignedSmallInteger('cohort_year')->nullable();
                $table->boolean('is_public')->default(false);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('contact_messages');
        Schema::dropIfExists('post_tag');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('gallery_items');
        Schema::dropIfExists('program_categories');
        Schema::dropIfExists('member_assignments');
        Schema::dropIfExists('positions');
    }
};
