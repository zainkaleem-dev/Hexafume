<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\TechTag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Carswap',
                'type' => 'Automotive Marketplace',
                'client_name' => 'Carswap',
                'logo' => 'images/hexafume/carswap-logo.png',
                'overview_heading' => 'A marketplace for buying and selling cars',
                'overview_p1' => 'Carswap is a marketplace experience focused on car discovery, listings, and smooth buyer-seller flow.',
                'overview_p2' => 'This entry is seeded so the portfolio shows the Carswap work prominently in the project grid and detail page.',
                'overview_p3' => 'The showcase content can be expanded later with real case study copy, milestones, and outcomes.',
                'stats' => ['1', 'Featured listing', '10w', 'Delivery timeline', '24/7', 'Availability'],
                'stack_description' => 'Laravel, marketplace flows, and responsive UI presentation.',
                'meta_title' => 'Carswap Case Study',
                'meta_description' => 'Carswap project showcase for the Hexafume portfolio.',
                'meta_keywords' => 'Carswap, marketplace, Laravel',
                'is_featured' => true,
                'tech' => ['Laravel', 'React', 'MySQL', 'Bootstrap'],
            ],
            [
                'name' => 'Castly',
                'type' => 'Streaming Platform',
                'client_name' => 'Castly',
                'logo' => 'images/hexafume/castly-logo.png',
                'overview_heading' => 'A streaming platform built for content discovery',
                'overview_p1' => 'Castly focuses on media browsing, subscription flows, and a clean viewing experience.',
                'overview_p2' => 'Seeded as part of the Hexafume project showcase to reflect a real client-style product.',
                'overview_p3' => 'The entry can be expanded with production metrics, delivery notes, and launch results.',
                'stats' => ['1', 'Featured listing', '12w', 'Delivery timeline', '99.9%', 'Uptime target'],
                'stack_description' => 'Laravel, UI design, and content-driven product pages.',
                'meta_title' => 'Castly Case Study',
                'meta_description' => 'Castly streaming platform showcase for the Hexafume portfolio.',
                'meta_keywords' => 'Castly, streaming, Laravel',
                'is_featured' => false,
                'tech' => ['Laravel', 'JavaScript', 'MySQL'],
            ],
            [
                'name' => 'Eventic',
                'type' => 'Event Platform',
                'client_name' => 'Eventic',
                'logo' => 'images/hexafume/eventic-logo.png',
                'overview_heading' => 'Event management and ticketing made simple',
                'overview_p1' => 'Eventic is an event platform for discovering events, managing listings, and driving registrations.',
                'overview_p2' => 'This keeps the portfolio aligned with the existing Eventic brand asset already in the repo.',
                'overview_p3' => 'Use this slot for any event-specific case study details later on.',
                'stats' => ['1', 'Featured listing', '8w', 'Delivery timeline', '24/7', 'Hosting support'],
                'stack_description' => 'Laravel, booking flows, and admin-driven content management.',
                'meta_title' => 'Eventic Case Study',
                'meta_description' => 'Eventic event platform showcase for the Hexafume portfolio.',
                'meta_keywords' => 'Eventic, events, Laravel',
                'is_featured' => false,
                'tech' => ['Laravel', 'React', 'MySQL'],
            ],
            [
                'name' => 'POS',
                'type' => 'Point of Sale',
                'client_name' => 'POS',
                'logo' => 'images/hexafume/pos-logo.png',
                'overview_heading' => 'Retail checkout and inventory in one flow',
                'overview_p1' => 'A POS platform for sales, stock tracking, and smooth point-of-sale operations.',
                'overview_p2' => 'Seeded from the existing POS logo asset so the portfolio reflects another real project entry.',
                'overview_p3' => 'Add implementation and rollout details here if you want a fuller case study later.',
                'stats' => ['1', 'Featured listing', '9w', 'Delivery timeline', '100%', 'Offline-ready target'],
                'stack_description' => 'Laravel, inventory workflows, and transaction-focused UI.',
                'meta_title' => 'POS Case Study',
                'meta_description' => 'Point of sale project showcase for the Hexafume portfolio.',
                'meta_keywords' => 'POS, retail, Laravel',
                'is_featured' => false,
                'tech' => ['Laravel', 'MySQL', 'JavaScript'],
            ],
            [
                'name' => 'TradeBox',
                'type' => 'Trading Platform',
                'client_name' => 'TradeBox',
                'logo' => 'images/hexafume/tradebox-logo.png',
                'overview_heading' => 'Trading workflows designed for speed',
                'overview_p1' => 'TradeBox is a trading platform showcase centered around quick interactions and dense information displays.',
                'overview_p2' => 'This uses the TradeBox asset that already ships with the repo.',
                'overview_p3' => 'You can later swap this for your actual case study copy if needed.',
                'stats' => ['1', 'Featured listing', '11w', 'Delivery timeline', '24/7', 'Market watch'],
                'stack_description' => 'Laravel, responsive charts, and fast dashboard interactions.',
                'meta_title' => 'TradeBox Case Study',
                'meta_description' => 'TradeBox trading platform showcase for the Hexafume portfolio.',
                'meta_keywords' => 'TradeBox, trading, Laravel',
                'is_featured' => false,
                'tech' => ['Laravel', 'React', 'MySQL'],
            ],
            [
                'name' => 'TravelApp',
                'type' => 'Travel Platform',
                'client_name' => 'TravelApp',
                'logo' => 'images/hexafume/travelapp-logo.png',
                'overview_heading' => 'Trip planning and booking in one place',
                'overview_p1' => 'TravelApp is a travel experience for discovery, itinerary planning, and booking journeys.',
                'overview_p2' => 'It rounds out the portfolio with a travel-focused product entry.',
                'overview_p3' => 'Expand this section later with route, booking, or operations details.',
                'stats' => ['1', 'Featured listing', '7w', 'Delivery timeline', '100%', 'Mobile friendly'],
                'stack_description' => 'Laravel, booking flows, and destination-driven UI.',
                'meta_title' => 'TravelApp Case Study',
                'meta_description' => 'TravelApp project showcase for the Hexafume portfolio.',
                'meta_keywords' => 'TravelApp, travel, Laravel',
                'is_featured' => false,
                'tech' => ['Laravel', 'JavaScript', 'MySQL'],
            ],
        ];

        foreach ($projects as $projectData) {
            $project = Project::updateOrCreate(
                ['url_slug' => Str::slug($projectData['name'])],
                [
                    'name' => $projectData['name'],
                    'url_slug' => Str::slug($projectData['name']),
                    'type' => $projectData['type'],
                    'client_name' => $projectData['client_name'],
                    'site_url' => 'https://example.com',
                    'start_date' => '2026-01-10',
                    'finish_date' => '2026-03-22',
                    'total_time' => '10 Weeks',
                    'team' => 'Full-stack product team',
                    'status' => 'live',
                    'delivered_on_time' => true,
                    'hero_image_path' => $projectData['logo'],
                    'logo_image_path' => $projectData['logo'],
                    'overview_heading' => $projectData['overview_heading'],
                    'overview_p1' => $projectData['overview_p1'],
                    'overview_p2' => $projectData['overview_p2'],
                    'overview_p3' => $projectData['overview_p3'],
                    'stat1_num' => $projectData['stats'][0],
                    'stat1_lbl' => $projectData['stats'][1],
                    'stat2_num' => $projectData['stats'][2],
                    'stat2_lbl' => $projectData['stats'][3],
                    'stat3_num' => $projectData['stats'][4],
                    'stat3_lbl' => $projectData['stats'][5],
                    'stack_description' => $projectData['stack_description'],
                    'timeline_heading' => 'From idea to launch',
                    'timeline_subtext' => 'Seeded project data for the Hexafume portfolio.',
                    'meta_title' => $projectData['meta_title'],
                    'meta_description' => $projectData['meta_description'],
                    'meta_keywords' => $projectData['meta_keywords'],
                    'visibility' => 'public',
                    'publish_at' => now()->toDateString(),
                    'is_featured' => $projectData['is_featured'],
                    'seo_index' => true,
                    'show_portfolio' => true,
                    'twitter_card' => 'summary_large_image',
                ]
            );

            foreach ($projectData['tech'] as $techName) {
                $tag = TechTag::firstOrCreate(['name' => $techName]);
                $project->techTags()->syncWithoutDetaching([$tag->id]);
            }
        }
    }
}
