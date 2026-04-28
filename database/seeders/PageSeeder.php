<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // --- 1. HOME PAGE ---
        $home = \App\Models\Page::updateOrCreate(['slug' => 'home'], [
            'name' => 'Home', 'type' => 'Landing Page', 'status' => 'live', 'author' => 'Admin',
            'meta_title' => 'Hexafume — Think Big | IT Services & Digital Solutions',
            'meta_description' => 'We design and deploy agentic AI, high-performance SaaS platforms, and automation systems that turn ideas into scalable, revenue-generating products.',
        ]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $home->id, 'section_key' => 'hero'], ['sort_order' => 1, 'content' => [
            'badge' => 'Pioneering Digital Excellence',
            'title' => 'We Build Digital Futures That Matter.',
            'subtitle' => 'We design and deploy agentic AI, high-performance SaaS platforms, and automation systems that turn ideas into scalable, revenue-generating products.',
            'stats' => [
                ['num' => '1200', 'label' => 'Projects Delivered'],
                ['num' => '50', 'label' => 'Expert Engineers'],
                ['num' => '15', 'label' => 'Countries Served'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $home->id, 'section_key' => 'marquee'], ['sort_order' => 2, 'content' => [
            'items' => ['Agentic AI Systems', 'eCommerce Growth Engines', 'Custom SaaS Development', 'Workflow Automation', 'Mobile App Development', 'DevOps & Cloud Infrastructure']
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $home->id, 'section_key' => 'about'], ['sort_order' => 3, 'content' => [
            'badge' => 'Who We Are',
            'title' => 'Transforming Ideas Into Digital Reality',
            'desc_p1' => "At Hexafume, we're more than just a service provider we're a team of passionate professionals dedicated to empowering businesses with cutting-edge digital solutions.",
            'desc_p2' => "Our mission is to be your trusted partner, guiding you through every step of your digital journey.",
            'pillars' => [
                ['title' => 'Innovation', 'desc' => 'Cutting Edge Tech', 'icon' => '🚀'],
                ['title' => 'Performance', 'desc' => 'Optimized Solutions', 'icon' => '⚡'],
                ['title' => 'Security', 'desc' => 'Enterprise Grade', 'icon' => '🔒'],
                ['title' => 'Global Reach', 'desc' => '15+ Countries', 'icon' => '🌍'],
            ],
            'btn_text' => 'About Us'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $home->id, 'section_key' => 'services_header'], ['sort_order' => 4, 'content' => [
            'badge' => 'What We Do',
            'title' => 'Our Services <span class="grad">Era</span>',
            'subtitle' => 'Comprehensive digital solutions that propel your business into the future'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $home->id, 'section_key' => 'process_header'], ['sort_order' => 5, 'content' => [
            'badge' => 'How We Work',
            'title' => 'Our Standard <br><span class="grad">Work Process</span>',
            'subtitle' => 'A proven methodology that ensures exceptional results every time'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $home->id, 'section_key' => 'portfolio_header'], ['sort_order' => 6, 'content' => [
            'badge' => 'Case Studies',
            'title' => 'Featured <span class="grad">Projects</span>',
            'subtitle' => 'Explore our portfolio of transformative digital experiences'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $home->id, 'section_key' => 'testimonials_header'], ['sort_order' => 7, 'content' => [
            'badge' => 'Client Love',
            'title' => 'What Our Clients <span class="grad">Say</span>'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $home->id, 'section_key' => 'contact_header'], ['sort_order' => 8, 'content' => [
            'badge' => 'Get In Touch',
            'title' => "Let's Start a <span class=\"grad\">Conversation</span>",
            'subtitle' => "We're in the business of providing strategic digital solutions. Reach out and let's discuss how we can help you grow.",
            'address_label' => 'Our Office',
            'address' => 'DHA 1, Islamabad, Pakistan',
            'email_label' => 'Email Us',
            'email' => 'support@hexafume.com',
            'phone_label' => 'Call Us 24/7',
            'phone' => '+92 315 088 4024'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $home->id, 'section_key' => 'cta'], ['sort_order' => 9, 'content' => [
            'title' => 'Ready to Think Big?',
            'subtitle' => "Let's transform your vision into a digital masterpiece. Get in touch and let's build something extraordinary together.",
            'btn1_text' => 'Start Your Project',
            'btn2_text' => 'Call Us Now',
        ]]);


        // --- 2. ABOUT PAGE ---
        $about = \App\Models\Page::updateOrCreate(['slug' => 'about'], [
            'name' => 'About', 'type' => 'Information Page', 'status' => 'live', 'author' => 'Admin',
            'meta_title' => 'About Us — Hexafume | Who We Are',
            'meta_description' => 'Learn about Hexafume — our story, mission, values, and the team driving digital transformation since 2022.',
        ]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $about->id, 'section_key' => 'hero'], ['sort_order' => 1, 'content' => [
            'badge' => 'Who We Are',
            'title' => 'We Build <span class="grad">Digital Futures</span> That Matter',
            'subtitle' => 'Hexafume is a next-generation digital agency pioneered by excellence and innovation.',
            'stats' => [
                ['num' => '1200', 'label' => 'Projects Delivered'],
                ['num' => '50', 'label' => 'Expert Engineers'],
                ['num' => '15', 'label' => 'Countries Served'],
                ['num' => '3', 'label' => 'Years Building'],
            ],
            'btn1_text' => 'Explore Services',
            'btn2_text' => 'Start a Project',
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $about->id, 'section_key' => 'story'], ['sort_order' => 2, 'content' => [
            'badge' => 'Our Story',
            'title' => 'From a Bold <span class="grad">Vision</span> to Global Impact',
            'p1' => "Hexafume was born out of frustration. We saw businesses with brilliant ideas trapped by outdated technology, slow agencies, and digital strategies that just didn't work.",
            'p2' => "Founded in 2022, we set out to build a company that thinks like a startup, executes like an enterprise, and cares like a partner.",
            'journey_badge' => 'Our Journey',
            'btn_text' => 'Meet the Team',
            'timeline' => [
                ['year' => '2022', 'title' => 'Founded in Islamabad', 'desc' => 'Launched with a mission to make world-class technology accessible.'],
                ['year' => '2023', 'title' => 'First 50 Projects Shipped', 'desc' => 'Expanded to 20 engineers and earning trust.'],
                ['year' => '2024', 'title' => 'AI Division Launched', 'desc' => 'Dedicated Agentic AI research team formed.'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $about->id, 'section_key' => 'mission_vision'], ['sort_order' => 3, 'content' => [
            'badge' => 'Our Foundation',
            'title' => 'Mission, Vision & Values',
            'subtitle' => 'The principles that guide every decision, every build, and every client relationship.',
            'mission_title' => 'Our Mission',
            'mission_text' => 'To democratise access to world-class digital technology — empowering every business to lead in the digital age.',
            'vision_title' => 'Our Vision',
            'vision_text' => 'To become the most trusted technology partner for growth-stage companies worldwide.',
            'values' => [
                ['emoji' => '🔥', 'title' => 'Relentless Quality', 'text' => "We don't ship average work."],
                ['emoji' => '🤝', 'title' => 'True Partnership', 'text' => "Your success is our success."],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $about->id, 'section_key' => 'team_teaser'], ['sort_order' => 4, 'content' => [
            'badge' => 'The People',
            'title' => 'Brilliant Minds, <span class="grad">One Team</span>',
            'subtitle' => 'We are engineers, designers, strategists, and researchers united by a shared obsession: building things that actually work — beautifully, reliably, and at scale.',
            'highlights' => [
                'active team members',
                'core disciplines represented',
                'Built from live team data',
                'Updated as members are added',
            ],
            'btn_text' => 'Meet the Full Team'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $about->id, 'section_key' => 'pillars'], ['sort_order' => 5, 'content' => [
            'badge' => 'Why Hexafume',
            'title' => 'What Makes Us <span class="grad">Different</span>',
            'desc' => 'The six pillars that define how we work and why clients keep coming back.',
            'items' => [
                ['title' => 'AI-First Thinking', 'desc' => 'Every solution we design is evaluated through an AI lens.', 'icon' => 'brain'],
                ['title' => 'Enterprise-Grade Security', 'desc' => 'From SOC 2 alignment to penetration testing.', 'icon' => 'shield'],
                ['title' => 'Agile Delivery', 'desc' => 'Two-week sprints, weekly demos, daily standups.', 'icon' => 'refresh'],
                ['title' => 'Dedicated Expert Teams', 'desc' => 'No junior developers hidden in projects.', 'icon' => 'users'],
                ['title' => 'Scalability by Design', 'desc' => 'We architect for tomorrow, not just today.', 'icon' => 'trending-up'],
                ['title' => 'Lifetime Support', 'desc' => 'Our relationship doesn\'t end at launch.', 'icon' => 'message-square'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $about->id, 'section_key' => 'cta'], ['sort_order' => 6, 'content' => [
            'badge' => "Let's Build",
            'title' => 'Ready to <span class="grad">Think Big</span>?',
            'subtitle' => "Let's transform your vision into a digital masterpiece. Get in touch and let's build something extraordinary together.",
            'btn1_text' => 'Start Your Project',
            'btn2_text' => 'Call Us Now',
        ]]);


        // --- 3. SERVICES PAGE ---
        $services = \App\Models\Page::updateOrCreate(['slug' => 'services'], [
            'name' => 'Services', 'type' => 'Service Catalog', 'status' => 'live', 'author' => 'Admin',
            'meta_title' => 'Services — Hexafume | Digital Solutions That Scale',
        ]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $services->id, 'section_key' => 'hero'], ['sort_order' => 1, 'content' => [
            'badge' => 'What We Do',
            'title' => 'Our Services <span class="grad">Era</span>',
            'subtitle' => 'Comprehensive digital solutions engineered to propel your business into the future.',
            'tags' => ['Agentic AI', 'SaaS Development', 'Web & Mobile Apps', 'UI/UX Design', 'Blockchain', 'DevOps', 'Digital Marketing']
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $services->id, 'section_key' => 'practices_header'], ['sort_order' => 2, 'content' => [
            'badge' => 'Full Capability Stack',
            'title' => 'Everything You Need to <span class="grad">Scale</span>',
            'desc' => 'Eight practice areas. One unified team. Engineered for speed, quality, and long-term impact.',
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $services->id, 'section_key' => 'features_strip'], ['sort_order' => 3, 'content' => [
            'badge' => 'Why Us',
            'title' => 'Every Project Comes With <span class="grad">This</span>',
            'items' => [
                ['icon' => '⚡', 'title' => 'Speed Without Compromise', 'desc' => 'Agile sprints, daily standups, and bi-weekly demos. Fast delivery without cutting corners.'],
                ['icon' => '🔒', 'title' => 'Enterprise Security', 'desc' => 'Every system is hardened with penetration testing, encryption, and SOC 2 alignment.'],
                ['icon' => '📈', 'title' => 'Built to Scale', 'desc' => "Architecture designed for your 10x future — not just today's requirements."],
                ['icon' => '🤝', 'title' => 'Lifetime Support', 'desc' => 'Ongoing maintenance, monitoring, and strategic guidance long after launch day.'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $services->id, 'section_key' => 'tech_header'], ['sort_order' => 4, 'content' => [
            'badge' => 'Our Stack',
            'title' => 'Technologies We <span class="grad">Master</span>',
            'subtitle' => 'We stay on the cutting edge — picking the right tool for the right job, always.'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $services->id, 'section_key' => 'cta'], ['sort_order' => 5, 'content' => [
            'badge' => 'Get Started',
            'title' => 'Have a Project in <span class="grad">Mind?</span>',
            'subtitle' => 'Let\'s talk about your goals, challenges, and how we can build something extraordinary together.',
            'btn1_text' => 'Start Your Project',
            'btn2_text' => 'See Our Process'
        ]]);

        // --- 4. PROCESS PAGE ---
        $process = \App\Models\Page::updateOrCreate(['slug' => 'process'], [
            'name' => 'Process', 'type' => 'Information Page', 'status' => 'live', 'author' => 'Admin',
        ]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $process->id, 'section_key' => 'hero'], ['sort_order' => 1, 'content' => [
            'badge' => 'How We Work',
            'title' => 'Our Standard <span class="grad">Work Process</span>',
            'subtitle' => 'A proven methodology refined across 1200+ projects — combining strategy, agile execution, and relentless quality control.',
            'stats' => [
                ['num' => '5', 'label' => 'Clear Steps'],
                ['num' => '98%', 'label' => 'On-Time Delivery'],
                ['num' => '1200+', 'label' => 'Projects Done'],
                ['num' => '100%', 'label' => 'Transparency'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $process->id, 'section_key' => 'methodology_header'], ['sort_order' => 2, 'content' => [
            'badge' => 'The Methodology',
            'title' => 'Five Steps to <span class="grad">Exceptional</span>',
            'desc' => 'Every engagement — regardless of size or complexity — follows this battle-tested framework.',
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $process->id, 'section_key' => 'phases'], ['sort_order' => 3, 'content' => [
            'badge' => 'Inside Each Phase',
            'title' => 'What Happens <span class="grad">Behind the Scenes</span>',
            'desc' => 'The rigorous sub-processes that make every step work.',
            'items' => [
                ['title' => 'Discovery & Scoping', 'desc' => 'Stakeholder interviews, market research, and technical feasibility studies.', 'badge' => 'Weeks 1-2'],
                ['title' => 'Design & Prototyping', 'desc' => 'User flows, wireframes, and high-fidelity interactive prototypes.', 'badge' => 'Weeks 2-4'],
                ['title' => 'Agile Development', 'desc' => 'Two-week sprints with daily standups and weekly build reviews.', 'badge' => 'Ongoing'],
                ['title' => 'QA & Stress Testing', 'desc' => 'Automated testing and manual bug hunting in staging environments.', 'badge' => 'Pre-Launch'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $process->id, 'section_key' => 'tools'], ['sort_order' => 4, 'content' => [
            'badge' => 'Our Toolkit',
            'title' => 'Tools That Power <span class="grad">Every Project</span>',
            'desc' => 'Industry-leading tools, tailored workflows, and practices refined across hundreds of builds.',
            'items' => [
                ['emoji' => '📋', 'title' => 'Jira / Linear', 'desc' => 'Sprint planning and backlog management.'],
                ['emoji' => '🎨', 'title' => 'Figma', 'desc' => 'Collaborative design systems.'],
                ['emoji' => '🔀', 'title' => 'GitHub', 'desc' => 'Version control and CI/CD.'],
                ['emoji' => '☁️', 'title' => 'AWS / GCP', 'desc' => 'Scalable cloud hosting.'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $process->id, 'section_key' => 'faq_header'], ['sort_order' => 5, 'content' => [
            'badge' => 'Common Questions',
            'title' => 'Frequently <span class="grad">Asked</span>'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $process->id, 'section_key' => 'cta'], ['sort_order' => 6, 'content' => [
            'badge' => 'Ready to Start',
            'title' => 'Let\'s Build Something <span class="grad">Remarkable</span>',
            'subtitle' => 'Ready to experience a process that actually works? Let\'s kick off your project today.',
            'btn1_text' => 'Start Your Project',
            'btn2_text' => 'Browse Services'
        ]]);

        // --- 5. WORK PAGE ---
        $work = \App\Models\Page::updateOrCreate(['slug' => 'work'], [
            'name' => 'Work', 'type' => 'Portfolio Page', 'status' => 'live', 'author' => 'Admin',
        ]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $work->id, 'section_key' => 'hero'], ['sort_order' => 1, 'content' => [
            'badge' => 'Our Work',
            'title' => 'Real Products.<br><span class="grad">Real Impact.</span>',
            'subtitle' => 'From streaming platforms to financial trading tools — every project we ship is a testament to engineering discipline, creative thinking, and obsessive attention to detail.',
            'stats' => [
                ['num' => '6+', 'label' => 'Flagship Products'],
                ['num' => '12+', 'label' => 'Industries Served'],
                ['num' => '1200+', 'label' => 'Digital Experiences'],
                ['num' => '3', 'label' => 'Years Building'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $work->id, 'section_key' => 'impact'], ['sort_order' => 2, 'content' => [
            'badge' => 'By The Numbers',
            'title' => 'The <span class="grad">Impact</span> We\'ve Made',
            'subtitle' => 'Measurable outcomes across every project we\'ve delivered.',
            'items' => [
                ['icon' => '🚀', 'num' => '6+', 'label' => 'Live Products Shipped'],
                ['icon' => '🌍', 'num' => '15+', 'label' => 'Countries Reached'],
                ['icon' => '⚡', 'num' => '99.9%', 'label' => 'Average Uptime SLA'],
                ['icon' => '⭐', 'num' => '100%', 'label' => 'Client Satisfaction Rate'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $work->id, 'section_key' => 'testimonials_header'], ['sort_order' => 3, 'content' => [
            'badge' => 'Client Love',
            'title' => 'What Our Clients <span class="grad">Say</span>'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $work->id, 'section_key' => 'tech_header'], ['sort_order' => 4, 'content' => [
            'badge' => 'Tech Behind The Work',
            'title' => 'Built With the <span class="grad">Best Stack</span>',
            'subtitle' => 'We pick the right tool for each job — always staying on the leading edge.'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $work->id, 'section_key' => 'cta'], ['sort_order' => 5, 'content' => [
            'badge' => 'Let\'s Build Together',
            'title' => 'Your Project Could Be <span class="grad">Next.</span>',
            'subtitle' => 'Whether it\'s a bold product idea or a complex platform — we have the team, the process, and the hunger to make it extraordinary.',
            'btn1_text' => 'Start Your Project',
            'btn2_text' => 'See Our Process'
        ]]);

        // --- 6. TEAM PAGE ---
        $team = \App\Models\Page::updateOrCreate(['slug' => 'team'], [
            'name' => 'Team', 'type' => 'Member List', 'status' => 'live', 'author' => 'Admin',
        ]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $team->id, 'section_key' => 'hero'], ['sort_order' => 1, 'content' => [
            'badge' => 'The Specialists',
            'title' => 'The Minds Behind<br>the <span class="grad">Magic</span>',
            'subtitle' => 'We are a team of engineers, designers, strategists, and dreamers united by one mission — turning bold ideas into scalable digital realities.'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $team->id, 'section_key' => 'culture'], ['sort_order' => 2, 'content' => [
            'badge' => 'Our Culture',
            'title' => 'Built on <span class="grad">Principles</span>',
            'desc' => 'The values that guide how we work, build, and grow — together.',
            'items' => [
                ['title' => 'Move With Speed', 'desc' => 'We ship fast, iterate faster. Velocity is a discipline — not recklessness.'],
                ['title' => 'Craft With Integrity', 'desc' => 'Every line of code, every pixel matters. We take pride in the details others skip.'],
                ['title' => 'Grow Together', 'desc' => 'No siloes. Every team member\'s growth is a shared victory we celebrate loudly.'],
                ['title' => 'Think in Systems', 'desc' => 'We solve root causes, not symptoms. Great architecture is our obsession.'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $team->id, 'section_key' => 'cta'], ['sort_order' => 3, 'content' => [
            'badge' => 'Hiring',
            'title' => 'Want to Join the <span class="grad">Team?</span>',
            'subtitle' => 'We\'re always looking for brilliant people who want to build things that matter. If that sounds like you, let\'s talk.',
            'btn1_text' => 'Apply Now',
            'btn2_text' => 'Send Us a Message'
        ]]);

        // --- 7. CONTACT PAGE ---
        $contact = \App\Models\Page::updateOrCreate(['slug' => 'contact'], [
            'name' => 'Contact', 'type' => 'Form Page', 'status' => 'live', 'author' => 'Admin',
        ]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $contact->id, 'section_key' => 'hero'], ['sort_order' => 1, 'content' => [
            'badge' => 'Get In Touch',
            'title' => 'Let\'s Start a <span class="grad">Conversation</span>',
            'subtitle' => 'We\'re in the business of providing strategic digital solutions.'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $contact->id, 'section_key' => 'info_col'], ['sort_order' => 2, 'content' => [
            'title' => 'We\'d Love to <span class="grad">Hear From You</span>',
            'desc' => 'Whether you have a project in mind, a question about our services, or just want to say hello — drop us a line.'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $contact->id, 'section_key' => 'contact_items'], ['sort_order' => 3, 'content' => [
            'items' => [
                ['title' => 'Our Office', 'value' => 'DHA 1, Islamabad, Pakistan', 'link' => '#'],
                ['title' => 'Email Us', 'value' => 'hello@hexafume.com', 'link' => 'mailto:hello@hexafume.com'],
                ['title' => 'Call Us 24/7', 'value' => '+92 315 088 4024', 'link' => 'tel:+923150884024'],
                ['title' => 'Business Hours', 'value' => 'Mon–Fri, 9:00 AM – 6:00 PM PKT', 'link' => '#'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $contact->id, 'section_key' => 'socials'], ['sort_order' => 4, 'content' => [
            'items' => [
                ['platform' => 'Facebook', 'link' => 'https://facebook.com/hexafume'],
                ['platform' => 'Twitter', 'link' => 'https://twitter.com/hexafume'],
                ['platform' => 'LinkedIn', 'link' => 'https://linkedin.com/company/hexafume'],
                ['platform' => 'Instagram', 'link' => '#'],
            ]
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $contact->id, 'section_key' => 'response_badge'], ['sort_order' => 5, 'content' => [
            'title' => 'Typical response time: under 4 hours.',
            'subtitle' => 'Our team is active Monday–Friday. Urgent? Call us directly — we\'re available 24/7.'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $contact->id, 'section_key' => 'map_header'], ['sort_order' => 6, 'content' => [
            'badge' => 'Find Us',
            'title' => 'We\'re Based in <span class="grad">Islamabad</span>',
            'subtitle' => 'DHA Phase 1, Islamabad — serving clients across Pakistan and the globe.'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $contact->id, 'section_key' => 'offices_header'], ['sort_order' => 7, 'content' => [
            'badge' => 'Our Presence',
            'title' => 'Where We <span class="grad">Operate</span>'
        ]]);

        \App\Models\PageSection::updateOrCreate(['page_id' => $contact->id, 'section_key' => 'offices'], ['sort_order' => 8, 'content' => [
            'items' => [
                ['flag' => '🇵🇰', 'city' => 'Islamabad, Pakistan', 'details' => "DHA Phase 1, Islamabad\n+92 315 088 4024", 'status' => 'Headquarters — Open Now'],
                ['flag' => '🇦🇪', 'city' => 'Dubai, UAE', 'details' => "Business Bay, Dubai\nGCC Operations Hub", 'status' => 'Regional Office — Active'],
                ['flag' => '🌐', 'city' => 'Remote — Global', 'details' => "Team distributed across\nEurope, North America & GCC", 'status' => 'Always Online'],
            ]
        ]]);
    }
}
