<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Web Design & Development',
                'description' => 'WordPress, E-Commerce, Full-Stack, MERN/MEAN, PWA, and responsive websites crafted with precision for performance, SEO, and conversion.',
                'icon' => '<path d="M4 4h16v12H4z"/><path d="M14 20H10"/><path d="M12 16v4"/><path d="M11 9l-3 3 3 3"/><path d="M16 9l3 3-3 3"/>',
                'features' => ['WordPress', 'E-Commerce', 'Full-Stack', 'PWA', 'MERN', 'React'],
            ],
            [
                'name' => 'Mobile App Development',
                'description' => 'Native and cross-platform mobile applications for iOS and Android that deliver seamless, high-performance user experiences on every device.',
                'icon' => '<rect x="5" y="2" width="14" height="20" rx="2"/><circle cx="12" cy="17" r="1"/><path d="M9 6h6"/>',
                'features' => ['iOS', 'Android', 'React Native', 'Flutter', 'Firebase'],
            ],
            [
                'name' => 'AI Integration & Automation',
                'description' => 'Business process automation, AI chatbots, intelligent data processing, agentic systems, LLM integration, and predictive analytics powered by the latest ML models.',
                'icon' => '<circle cx="12" cy="12" r="9"/><path d="M12 6v4"/><path d="M8.5 8.5l2.5 2.5"/><path d="M6 12h4"/><circle cx="12" cy="12" r="2"/>',
                'features' => ['Agentic AI', 'LLM', 'Chatbots', 'BPA', 'Analytics', 'RAG'],
            ],
            [
                'name' => 'Software Development',
                'description' => 'SaaS platforms, ERP systems, enterprise software, API development, and legacy system modernization built for reliability and scale.',
                'icon' => '<path d="M18 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3H6a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3 3 3 0 0 0-3 3 3 3 0 0 0 3 3h12a3 3 0 0 0 3-3 3 3 0 0 0-3-3z"/>',
                'features' => ['SaaS', 'ERP', 'APIs', 'Enterprise', 'Legacy Migration'],
            ],
            [
                'name' => 'Blockchain & Web3',
                'description' => 'Crypto exchanges, smart contracts, DeFi platforms, NFT marketplaces, and DAO governance systems architected for security and decentralisation.',
                'icon' => '<path d="M12 2l9 4.9V17L12 22l-9-5.1V7L12 2z"/><path d="M12 2v10"/><path d="M21 7l-9 5"/><path d="M3 7l9 5"/>',
                'features' => ['DeFi', 'NFT', 'Smart Contracts', 'DAO', 'Solidity'],
            ],
            [
                'name' => 'Graphic & UI/UX Design',
                'description' => 'Brand identity, pitch decks, marketing collateral, UI/UX engineering, prototyping, and visual design systems that convert and inspire.',
                'icon' => '<circle cx="12" cy="12" r="3"/><path d="M12 1v4"/><path d="M12 19v4"/><path d="M4.22 4.22l2.83 2.83"/><path d="M16.95 16.95l2.83 2.83"/><path d="M1 12h4"/><path d="M19 12h4"/>',
                'features' => ['Branding', 'UI/UX', 'Figma', 'Design Systems', 'Prototyping'],
            ],
            [
                'name' => 'Digital & Social Marketing',
                'description' => 'Video production, social media management, ad campaigns, SEO optimisation, content strategy, and performance analytics that drive real revenue.',
                'icon' => '<circle cx="12" cy="12" r="10"/><path d="M2 12h20"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>',
                'features' => ['SEO', 'Social Media', 'Ads', 'Content', 'Analytics'],
            ],
            [
                'name' => 'DevOps Solutions',
                'description' => 'Cloud infrastructure, CI/CD automation, container orchestration, monitoring, and AI-driven DevOps practices that keep your systems blazing fast and always on.',
                'icon' => '<path d="M2 8h20"/><rect x="2" y="4" width="20" height="16" rx="2"/><circle cx="8" cy="12" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="16" cy="12" r="1"/>',
                'features' => ['AWS', 'Docker', 'Kubernetes', 'CI/CD', 'Terraform'],
            ],
        ];

        foreach ($services as $index => $item) {
            Service::updateOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($item['name'])],
                array_merge($item, ['order_index' => $index])
            );
        }
    }
}
