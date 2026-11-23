<?php

namespace Database\Seeders;

use App\Models\Gallery;
use App\Models\GalleryItem;
use App\Models\ManagementPeriod;
use App\Models\Member;
use App\Models\Post;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TargetDataSeeder extends Seeder
{
    public function run(): void
    {
        $usedSlugs = [];
        foreach (ManagementPeriod::withTrashed()->orderBy('id')->get() as $period) {
            $base = Str::slug($period->name) ?: 'periode-'.$period->id;
            $slug = $period->slug ?: $base;
            $counter = 2;
            while (isset($usedSlugs[$slug]) || ManagementPeriod::withTrashed()
                ->where('id', '!=', $period->id)
                ->where('slug', $slug)
                ->exists()) {
                $slug = $base.'-'.$counter++;
            }
            $usedSlugs[$slug] = true;
            $period->slug = $slug;
            $period->status = $period->is_active ? 'active' : ($period->status ?: 'draft');
            $period->save();
        }

        foreach (Member::whereNull('full_name')->get() as $member) {
            $member->full_name = $member->name;
            $member->is_public = false;
            $member->save();
        }

        foreach (Program::whereNull('publication_status')->get() as $program) {
            $program->publication_status = $program->status ?: 'draft';
            $program->implementation_status = 'planned';
            $program->save();
        }

        foreach (Gallery::whereNull('publication_status')->get() as $gallery) {
            $gallery->publication_status = $gallery->status ?: 'draft';
            $gallery->save();

            if ($gallery->image && !$gallery->items()->exists()) {
                GalleryItem::create([
                    'gallery_id' => $gallery->id,
                    'media_type' => 'image',
                    'file_path' => $gallery->image,
                    'caption' => $gallery->title,
                    'sort_order' => 0,
                ]);
            }
        }

        foreach (Post::whereNull('publication_status')->get() as $post) {
            $post->publication_status = $post->status ?: 'draft';
            $post->post_type = 'article';
            $post->save();
        }
    }
}
