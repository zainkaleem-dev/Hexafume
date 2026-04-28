<?php

namespace Database\Seeders;

use App\Models\Experience;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Experience::create([
            'title' => 'Full Stack Developer',
            'description' => 'Built scalable web applications using Laravel and React',
            'start_date' => '2023-01-15',
            'end_date' => null,
            'type' => 'work'
        ]);

        Experience::create([
            'title' => 'AI/ML Course',
            'description' => 'Completed comprehensive machine learning course focusing on computer vision',
            'start_date' => '2022-09-01',
            'end_date' => '2023-06-30',
            'type' => 'education'
        ]);

        Experience::create([
            'title' => 'Open Source Contributions',
            'description' => 'Contributed to multiple Laravel packages and open source projects',
            'start_date' => '2022-01-01',
            'end_date' => null,
            'type' => 'project'
        ]);
    }
}
