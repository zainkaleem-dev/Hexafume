<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Technology;

class TechnologySeeder extends Seeder
{
    public function run(): void
    {
        $techCategories = [
            'Frontend' => ['React', 'Next.js', 'Vue.js', 'TypeScript', 'Three.js', 'Tailwind', 'Framer Motion', 'WebGL'],
            'Backend' => ['Node.js', 'Python', 'Go', 'FastAPI', 'GraphQL', 'REST API', 'Microservices', 'WebSockets'],
            'Mobile' => ['React Native', 'Flutter', 'Swift', 'Kotlin', 'Firebase', 'Expo'],
            'AI & ML' => ['PyTorch', 'TensorFlow', 'LangChain', 'OpenAI API', 'Hugging Face', 'RAG', 'MLflow'],
            'Database & Cloud' => ['PostgreSQL', 'MongoDB', 'Redis', 'AWS', 'GCP', 'Azure', 'Supabase'],
            'DevOps & Infra' => ['Kubernetes', 'Docker', 'Terraform', 'GitHub Actions', 'Prometheus', 'Nginx', 'CI/CD'],
        ];

        $orderIndex = 0;
        foreach ($techCategories as $category => $techs) {
            foreach ($techs as $tech) {
                Technology::updateOrCreate(
                    ['name' => $tech, 'category' => $category],
                    ['order_index' => $orderIndex++]
                );
            }
        }
    }
}
