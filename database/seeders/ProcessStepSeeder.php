<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProcessStep;

class ProcessStepSeeder extends Seeder
{
    public function run(): void
    {
        $steps = [
            [
                'step_number' => '01',
                'title' => 'Choose Your Service',
                'description' => 'Select from our wide range of IT solutions — web, apps, marketing, design, or AI-powered services. Not sure what you need? Our team will guide you to the right fit.',
                'deliverables' => ['Service Brief', 'Initial Proposal', 'Scope Estimate'],
                'icon' => '<path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>',
                'duration' => 'Day 1',
            ],
            [
                'step_number' => '02',
                'title' => 'Share Your Requirements',
                'description' => 'Tell us about your goals, timeline, and business needs. The more context you give us, the more precisely we can craft the right solution. We listen before we build.',
                'deliverables' => ['Requirements Document', 'Technical Spec', 'Project Roadmap'],
                'icon' => '<path d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>',
                'duration' => 'Day 2–3',
            ],
            [
                'step_number' => '03',
                'title' => 'Consultation & Strategy',
                'description' => 'We\'ll set up a kickoff call to discuss ideas, align on vision, and propose a clear strategy. You\'ll walk away with a concrete plan, timeline, and team assignment.',
                'deliverables' => ['Strategy Deck', 'Sprint Plan', 'Team Roster'],
                'icon' => '<path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
                'duration' => 'Week 1',
            ],
            [
                'step_number' => '04',
                'title' => 'Development & Delivery',
                'description' => 'Our expert team designs, builds, and tests your product in agile two-week sprints. You get weekly demos, daily communication, and complete transparency throughout the build.',
                'deliverables' => ['Working Builds', 'Test Reports', 'Demo Sessions'],
                'icon' => '<path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>',
                'duration' => 'Weeks 2–12',
            ],
            [
                'step_number' => '05',
                'title' => 'Ongoing Support',
                'description' => 'Launch day is just the beginning. We provide 30-day hypercare post-launch, plus optional monthly retainers to keep your product evolving, secure, and performant.',
                'deliverables' => ['Support SLA', 'Monthly Reports', 'Update Cycles'],
                'icon' => '<path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.952 11.952 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                'duration' => 'Ongoing',
            ],
        ];

        foreach ($steps as $index => $item) {
            ProcessStep::updateOrCreate(
                ['title' => $item['title']],
                array_merge($item, ['order_index' => $index])
            );
        }
    }
}
