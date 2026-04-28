<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'quote' => 'Hexafume understood our vision perfectly. They delivered a beautifully designed platform that exceeded every expectation.',
                'initials' => 'AP',
                'company' => 'Arete Properties',
                'role' => 'Real Estate',
            ]
        ];

        foreach ($testimonials as $index => $item) {
            Testimonial::updateOrCreate(
                ['company' => $item['company']],
                array_merge($item, ['order_index' => $index])
            );
        }
    }
}
