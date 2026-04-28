<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'How long does a typical project take?',
                'answer' => 'It depends on scope. A landing page or MVP can launch in 2–4 weeks. A full SaaS product typically takes 8–16 weeks. We define a clear timeline during consultation and stick to it.',
            ],
            [
                'question' => 'Do you work with startups or just enterprises?',
                'answer' => 'Both. We love working with early-stage startups building their first product, as well as established enterprises modernising legacy systems. Our process scales to fit any stage.',
            ],
            [
                'question' => 'How much do your services cost?',
                'answer' => 'Projects are priced based on complexity and scope. After your initial consultation, we provide a detailed quote. We offer fixed-price and time-and-materials models to suit different needs.',
            ],
            [
                'question' => 'Can I see progress during development?',
                'answer' => 'Absolutely — this is a core part of how we work. You get weekly demo sessions, a real-time project dashboard, and a dedicated Slack channel for daily communication.',
            ],
            [
                'question' => 'What happens if requirements change mid-project?',
                'answer' => 'We use an agile change request process. Minor changes are absorbed within the sprint; larger scope changes are documented, costed, and agreed upon before implementation — no surprises.',
            ],
            [
                'question' => 'Do you provide support after launch?',
                'answer' => 'Yes. Every project includes 30 days of post-launch hypercare. We also offer monthly retainer packages for ongoing development, maintenance, monitoring, and growth support.',
            ],
            [
                'question' => 'Who will I be working with?',
                'answer' => 'You\'ll have a dedicated project manager as your single point of contact, supported by a senior engineer, designer, and QA specialist — all assigned to your project from day one.',
            ],
        ];

        foreach ($faqs as $index => $item) {
            Faq::updateOrCreate(
                ['question' => $item['question']],
                array_merge($item, ['order_index' => $index, 'category' => 'Process'])
            );
        }
    }
}
