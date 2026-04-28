<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamMember;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        $members = [
            [
                'name' => 'Sarah Connor',
                'first_name' => 'Sarah',
                'last_name' => 'Connor',
                'email' => 'sarah@hexafume.com',
                'url_slug' => 'sarah-connor',
                'initials' => 'SC',
                'title' => 'Chief Executive Officer',
                'dept' => 'leadership',
                'dept_label' => 'Leadership',
                'exp' => '15+ Years',
                'bio' => 'Visionary leader with a passion for transformative digital solutions.',
                'skills' => ['Strategy', 'Leadership', 'Innovation'],
                'show_on_team' => true,
            ],
            [
                'name' => 'John Smith',
                'first_name' => 'John',
                'last_name' => 'Smith',
                'email' => 'john@hexafume.com',
                'url_slug' => 'john-smith',
                'initials' => 'JS',
                'title' => 'Lead Engineer',
                'dept' => 'engineering',
                'dept_label' => 'Engineering',
                'exp' => '10+ Years',
                'bio' => 'Expert in AI architectures and scalable backend systems.',
                'skills' => ['Python', 'Go', 'System Design'],
                'show_on_team' => true,
            ],
            [
                'name' => 'Alice Doe',
                'first_name' => 'Alice',
                'last_name' => 'Doe',
                'email' => 'alice@hexafume.com',
                'url_slug' => 'alice-doe',
                'initials' => 'AD',
                'title' => 'Product Designer',
                'dept' => 'design',
                'dept_label' => 'Design & UX',
                'exp' => '8+ Years',
                'bio' => 'Crafting intuitive user experiences that bridge form and function.',
                'skills' => ['Figma', 'UI/UX', 'Prototyping'],
                'show_on_team' => true,
            ]
        ];

        foreach ($members as $member) {
            TeamMember::updateOrCreate(
                ['url_slug' => $member['url_slug']],
                $member
            );
        }
    }
}
