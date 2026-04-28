<?php

namespace Database\Seeders;

use App\Models\Experience;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first() ?? User::factory()->create();

        Project::create([
            'title' => 'AI Trash Detection',
            'slug' => 'ai-trash-detection',
            'description' => 'AI-powered litter detection and classification system using computer vision',
            'image' => null,
            'technologies_used' => ['Python', 'TensorFlow', 'React', 'Laravel'],
            'github_link' => 'https://github.com',
            'live_link' => 'https://example.com',
            'user_id' => $user->id
        ]);

        Project::create([
            'title' => 'Portfolio Website',
            'slug' => 'portfolio-website',
            'description' => 'Personal portfolio showcasing projects and experience',
            'image' => null,
            'technologies_used' => ['Laravel', 'React', 'TailwindCSS'],
            'github_link' => 'https://github.com',
            'live_link' => 'https://example.com',
            'user_id' => $user->id
        ]);
    }
}
