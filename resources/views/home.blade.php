@extends('layouts.app')

@section('structured_data')
<script type="application/ld+json">
[
  {
    "@@context": "https://schema.org",
    "@@type": "ProfessionalService",
    "name": "Hexafume",
    "image": "{{ asset('images/hexafume/hexafume-original.png') }}",
    "@@id": "https://hexafume.com/",
    "url": "https://hexafume.com/",
    "telephone": "+923449121053",
    "address": {
      "@@type": "PostalAddress",
      "streetAddress": "DHA 1",
      "addressLocality": "Islamabad",
      "addressCountry": "PK"
    },
    "geo": {
      "@@type": "GeoCoordinates",
      "latitude": 33.5228,
      "longitude": 73.1492
    },
    "openingHoursSpecification": {
      "@@type": "OpeningHoursSpecification",
      "dayOfWeek": [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday"
      ],
      "opens": "09:00",
      "closes": "18:00"
    },
    "sameAs": [
      "https://www.instagram.com/hexafume?igsh=MWplZXF2bGkzcG00eA==",
      "https://www.linkedin.com/company/hexafume"
    ]
  },
  {
    "@@context": "https://schema.org",
    "@@type": "HowTo",
    "name": "Hexafume Standard Work Process",
    "description": "Our proven 5-step methodology for delivering high-performance digital solutions.",
    "step": [
      {
        "@@type": "HowToStep",
        "name": "Choose Your Service",
        "text": "Select from our wide range of IT solutions — web, apps, marketing, design, or AI-powered services.",
        "url": "https://hexafume.com/#process"
      },
      {
        "@@type": "HowToStep",
        "name": "Share Your Requirements",
        "text": "Tell us about your goals and business needs so we can craft the right solution for you.",
        "url": "https://hexafume.com/#process"
      },
      {
        "@@type": "HowToStep",
        "name": "Consultation & Strategy",
        "text": "We'll set up a meeting to discuss ideas, propose strategies, and align with your vision.",
        "url": "https://hexafume.com/#process"
      },
      {
        "@@type": "HowToStep",
        "name": "Development & Delivery",
        "text": "Our expert team designs, develops, and delivers your project with quality and innovation.",
        "url": "https://hexafume.com/#process"
      },
      {
        "@@type": "HowToStep",
        "name": "Ongoing Support",
        "text": "We ensure your success with continuous support, updates, and improvements post-launch.",
        "url": "https://hexafume.com/#process"
      }
    ]
  }
]
</script>
@endsection

@section('content')
<!-- PRELOADER -->
<div id="preloader">
  <div class="preloader-3d-wrap">
    <div class="preloader-ring-track">
      <div class="preloader-ring-progress" id="ringProgress"></div>
    </div>
    <div class="preloader-logo-center">
      <img src="{{ asset('images/hexafume/hexafume-white.png') }}" id="preloader-img" alt="Hexafume" width="240" height="80"
        style="width:240px;height:80px;max-width:240px;max-height:80px;object-fit:contain;display:block;filter:brightness(1.1);"
        onerror="this.style.display='none';document.getElementById('preloader-fallback').style.display='block'"/>
      <div class="preloader-logo" id="preloader-fallback" style="display:none;">HEXA<span>FUME</span></div>
    </div>
  </div>
</div>

@php
  $hero = $page->getSectionContent('hero');
  $aboutSection = $page->getSectionContent('about');
  $cta = $page->getSectionContent('cta');
  $marquee = $page->getSectionContent('marquee');
  $servicesHeader = $page->getSectionContent('services_header');
  $processHeader = $page->getSectionContent('process_header');
  $portfolioHeader = $page->getSectionContent('portfolio_header');
  $testimonialsHeader = $page->getSectionContent('testimonials_header');
  $contactHeader = $page->getSectionContent('contact_header');
  
  $heroStats = $hero['stats'] ?? [];
  $marqueeItems = $marquee['items'] ?? ['Agentic AI Systems','eCommerce Growth Engines','Custom SaaS Development','Workflow Automation','Mobile App Development','DevOps & Cloud Infrastructure'];
@endphp

<!-- HERO -->
<section id="hero">
  <canvas id="heroCanvas" class="hero-canvas"></canvas>
  <div class="hero-grid"></div>
  <div class="hero-orb"></div>
  <div class="hero-content">
    <div class="hero-left">
      <div class="hero-badge"><span class="dot"></span>{{ $hero['badge'] ?? 'Pioneering Digital Excellence' }}</div>
      <h1>{!! $hero['title'] ?? 'We Build<br/><span class="grad">Digital Futures</span><br/>That Matter.' !!}</h1>
      <p class="hero-sub">{{ $hero['subtitle'] ?? 'We design and deploy agentic AI, high-performance SaaS platforms, and automation systems that turn ideas into scalable, revenue-generating products.' }}</p>
      <div class="hero-actions">
        <a href="#services" class="btn-p">Explore Services <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
        <a href="#portfolio" class="btn-s">View Our Work</a>
      </div>
      <div class="hero-stats">
        @if(isset($hero['stats']))
          @foreach($hero['stats'] as $index => $stat)
            @if($index > 0)
              <div class="hero-divider"></div>
            @endif
            <div class="{{ $index == 0 ? 'hero-stats-inner' : '' }}">
              <div class="hero-stat-num"><span id="stat{{ $index+1 }}">0</span><span class="plus">+</span></div>
              <div class="hero-stat-lbl">{{ $stat['label'] }}</div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
    <div class="hero-visual">
      <div class="logo-wrap">
        <div class="logo-glow"></div>
        <canvas id="logoSandCanvas" class="logo-sand-canvas"></canvas>
        <img src="{{ asset('images/hexafume/hexafume-white.png') }}" alt="Hexafume - Think Big | IT Services & Digital Solutions" class="hero-logo-img" loading="eager" id="heroLogoSource" width="360" height="120" style="width:100%;height:auto;max-width:360px;max-height:120px;object-fit:contain;display:block;">
      </div>
    </div>
    </div>
  </div>
  <div class="testi-dots" id="testiDots" aria-label="Testimonial navigation"></div>
</section>

<!-- MARQUEE -->
<div class="marquee-section">
  <div class="marquee-track" id="marqueeTrack"></div>
</div>

<!-- ABOUT -->
<section id="about" style="padding:3rem 4rem;max-width:1300px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:6rem;align-items:center;">
  <div class="reveal">
    <span class="about-badge"><span class="dot"></span>{{ $aboutSection['badge'] ?? 'Who We Are' }}</span>
    <h2 style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;font-weight:500;font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;letter-spacing:-.02em;margin-bottom:1rem;">
      {!! $aboutSection['title'] ?? 'Transforming Ideas Into <span class="grad">Digital Reality</span>' !!}
    </h2>
    <p class="about-text">{{ $aboutSection['desc_p1'] ?? "Hexafume is a software development company helping businesses build scalable digital products. Our team of engineers, designers, and technology experts creates custom software, AI solutions, SaaS platforms, and enterprise applications that solve real business challenges." }}</p>
    <p class="about-text">{{ $aboutSection['desc_p2'] ?? "" }}</p>
    <div class="about-pillars">
      @if(isset($aboutSection['pillars']))
        @php
          $icons = [
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>',
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2c3 3.5 3 16.5 0 20M12 2c-3 3.5-3 16.5 0 20"/></svg>'
          ];
        @endphp
        @foreach($aboutSection['pillars'] as $i => $pillar)
          <div class="pillar">
            <div class="pillar-icon">
              {!! $icons[$i] ?? '' !!}
            </div>
            <div>
              <h4>{{ $pillar['title'] }}</h4>
              <p>{{ $pillar['desc'] }}</p>
            </div>
          </div>
        @endforeach
      @endif
    </div>
    <a href="{{ route('about') }}" class="btn-p" style="display:inline-flex;">{{ $aboutSection['btn_text'] ?? 'About Us' }}<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
  </div>
    <div class="about-cards reveal" style="transition-delay:.15s;">
      @if(isset($aboutSection['pillars']))
        @foreach($aboutSection['pillars'] as $pillar)
          <div class="about-card">
            <span class="icon">{{ $pillar['icon'] ?? '🚀' }}</span>
            <h3>{{ $pillar['title'] }}</h3>
            <p>{{ $pillar['desc'] }}</p>
          </div>
        @endforeach
      @else
        <div class="about-card"><span class="icon">🚀</span><h3>Innovation</h3><p>Cutting Edge Tech</p></div>
        <div class="about-card"><span class="icon">⚡</span><h3>Performance</h3><p>Optimized Solutions</p></div>
        <div class="about-card"><span class="icon">🔒</span><h3>Security</h3><p>Enterprise Grade</p></div>
        <div class="about-card"><span class="icon">🌍</span><h3>Global Reach</h3><p>20+ Countries</p></div>
      @endif
    </div>
</section>

<!-- SERVICES -->
<section id="services">
  <div class="services-inner">
    <div class="services-head reveal">
      <span class="section-badge"><span class="dot"></span>{{ $servicesHeader['badge'] ?? 'What We Do' }}</span>
      <h2 class="section-title" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;font-weight:500;font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;letter-spacing:-.02em;margin-bottom:1rem;">{!! $servicesHeader['title'] ?? 'Our Software Development <span class="grad">Services</span>' !!}</h2>
      <p class="section-sub">{{ $servicesHeader['subtitle'] ?? 'We provide end-to-end software development services including AI solutions, SaaS development, web applications, mobile apps, cloud infrastructure, and digital transformation solutions.' }}</p>
    </div>
    <div class="services-grid" id="servicesGrid">
      @foreach($services as $i => $s)
        <div class="service-card reveal" style="transition-delay: {{ ($i % 4) * 80 }}ms;">
          <div class="svc-icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
              {!! $s->icon !!}
            </svg>
          </div>
          <h3>{{ $s->name }}</h3>
          <p>{{ $s->description }}</p>
          <div class="svc-tags">
            @foreach($s->features as $t)
              <span class="svc-tag">{{ $t }}</span>
            @endforeach
          </div>
          <a href="{{ route('services') }}" class="svc-link">Learn More →</a>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- PROCESS -->
<section id="process" aria-labelledby="processHeader" style="padding:4rem 4rem;max-width:1300px;margin:0 auto;">
  <div class="process-head reveal">
    <span class="section-badge"><span class="dot"></span>{{ $processHeader['badge'] ?? 'How We Work' }}</span>
    <h2 id="processHeader" class="section-title" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;font-weight:500;font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;letter-spacing:-.02em;margin-bottom:1rem;">{!! $processHeader['title'] ?? 'Our Standard <br><span class="grad">Work Process</span>' !!}</h2>
    <p class="section-sub" style="margin:0 auto;">{{ $processHeader['subtitle'] ?? 'A proven methodology that ensures exceptional results every time' }}</p>
  </div>
  <ol class="process-list" id="processList">
    <div class="process-line"></div>
    @foreach($process_steps as $i => $s)
      <li class="process-step reveal" style="transition-delay: {{ $i * 100 }}ms;">
        <div class="step-num">{{ $s->step_number }}</div>
        <div class="step-content">
          <h3>{{ $s->title }}</h3>
          <p>{{ $s->description }}</p>
        </div>
        <div class="step-visual">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
            <title>{{ $s->title }} Icon</title>
            {!! $s->icon !!}
          </svg>
        </div>
      </li>
    @endforeach
  </ol>
</section>

<!-- PORTFOLIO -->
<section id="portfolio">
  <div class="portfolio-inner">
    <div class="portfolio-head reveal">
      <span class="section-badge"><span class="dot"></span>{{ $portfolioHeader['badge'] ?? 'Case Studies' }}</span>
      <h2 class="section-title" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;font-weight:500;font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;letter-spacing:-.02em;margin-bottom:1rem;">{!! $portfolioHeader['title'] ?? 'Featured <span class="grad">Projects</span>' !!}</h2>
      <p class="section-sub">{{ $portfolioHeader['subtitle'] ?? 'Explore our portfolio of transformative digital experiences' }}</p>
    </div>
    <div class="portfolio-grid" id="portfolioGrid">
      @forelse($featuredProjects as $i => $p)
        <div class="portfolio-card reveal" style="transition-delay: {{ $i * 100 }}ms;">
          <div class="port-thumb" style="position:relative;overflow:hidden;background:var(--surface2);">
            @if($p->hero_image_url)
              <img src="{{ $p->hero_image_url }}" alt="Project Showcase: {{ $p->name }} - {{ $p->type }}" width="1200" height="800" style="position:absolute;inset:0;width:100%;height:100%;max-width:100%;max-height:100%;object-fit:cover;object-position:top;display:block;opacity:0.4;" loading="lazy">
            @endif
            @if($p->logo_image_url)
              <img src="{{ $p->logo_image_url }}" alt="{{ $p->name }} Logo" width="120" height="120" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:120px;height:120px;max-width:120px;max-height:120px;object-fit:contain;display:block;z-index:2;filter:drop-shadow(0 10px 20px rgba(0,0,0,0.5));">
            @endif
            <span class="port-cat">{{ $p->type }}</span>
          </div>
          <div class="port-body">
            <h3>{{ $p->name }}</h3>
            <p>{{ Str::words($p->overview_p1, 20, '...') }}</p>
            <p class="port-dates">
              <strong>{{ $p->start_date ? $p->start_date->format('M Y') : '' }}</strong> — 
              <strong>{{ $p->finish_date ? $p->finish_date->format('M Y') : 'Present' }}</strong>
            </p>
            <a href="{{ route('project-detail', $p->url_slug) }}" class="port-link">Visit Site →</a>
          </div>
        </div>
      @empty
        <div style="grid-column: 1/-1; text-align:center; padding: 4rem; color:var(--w40);">
          No featured projects yet. Check back soon.
        </div>
      @endforelse
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section id="testimonials" style="padding:3.5rem 4rem;max-width:1300px;margin:0 auto;">
  <div class="testi-head reveal">
    <span class="section-badge"><span class="dot"></span>{{ $testimonialsHeader['badge'] ?? 'Client Love' }}</span>
    <h2 class="section-title" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;font-weight:500;font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;letter-spacing:-.02em;margin-bottom:1rem;">{!! $testimonialsHeader['title'] ?? 'What Our Clients <span class="grad">Say</span>' !!}</h2>
  </div>
  @php($testimonialCount = isset($testimonials) ? count($testimonials) : 0)
  <div class="testi-carousel-shell" id="testiCarouselShell" data-testimonial-count="{{ $testimonialCount }}">
    <button type="button" class="testi-arrow testi-arrow-left" id="testiPrev" aria-label="Previous testimonials">
      <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M15 18l-6-6 6-6" />
      </svg>
    </button>
    <div class="testi-grid" id="testiGrid">
    @foreach($testimonials as $i => $t)
      <div class="testi-card reveal" style="transition-delay: {{ $i * 120 }}ms;">
        <div class="stars">★★★★★</div>
        <div class="testi-quote-wrap">
          <p class="testi-q" data-full-quote="{{ e($t->quote) }}">"{{ $t->quote }}"</p>
          <button type="button" class="testi-toggle" aria-expanded="false" hidden>Read More</button>
        </div>
        <div class="testi-author">
          <div class="testi-avatar">
            @if($t->photo_url)
              <img
                src="{{ $t->photo_url }}"
                alt="{{ $t->client_name ?? $t->company }}"
                loading="lazy"
                width="38"
                height="38"
                style="width:38px;height:38px;max-width:38px;max-height:38px;object-fit:cover;object-position:center 18%;display:block;"
              >
            @else
              {{ $t->initials }}
            @endif
          </div>
          <div>
            <div class="testi-name">{{ $t->client_name ?? $t->company }}</div>
            @if($t->location)
              <div class="testi-location">{{ $t->location }}</div>
            @endif
            <div class="testi-role">{{ $t->company }} • {{ $t->role }}</div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
    <button type="button" class="testi-arrow testi-arrow-right" id="testiNext" aria-label="Next testimonials">
      <svg viewBox="0 0 24 24" aria-hidden="true" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M9 6l6 6-6 6" />
      </svg>
    </button>
  </div>
</section>

<!-- CTA -->
<section id="cta" style="padding:9rem 4rem;">
  <div class="cta-glow"></div>
  <div class="cta-inner reveal">
    <span class="section-badge"><span class="dot"></span>Get In Touch</span>
    <h2>{!! $cta['title'] ?? 'Ready to <span class="grad">Think Big</span>?' !!}</h2>
    <p>{{ $cta['subtitle'] ?? "Let's transform your vision into a digital masterpiece. Get in touch and let's build something extraordinary together." }}</p>
    <div class="cta-btns">
      <a href="#contact" class="btn-p">{{ $cta['btn1_text'] ?? 'Start Your Project' }} <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      <a href="tel:{{ str_replace(' ', '', $contactHeader['phone'] ?? '+923449121053') }}" class="btn-s">📞 {{ $cta['btn2_text'] ?? 'Call Us Now' }}</a>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact">
  <div class="contact-inner">
    <div class="reveal">
      <div class="contact-info">
        <span class="section-badge"><span class="dot"></span>{{ $contactHeader['badge'] ?? 'Get In Touch' }}</span>
        <h2>{!! $contactHeader['title'] ?? 'Let\'s Start a <span class="grad">Conversation</span>' !!}</h2>
        <p>{{ $contactHeader['subtitle'] ?? 'We\'re in the business of providing strategic digital solutions. Reach out and let\'s discuss how we can help you grow.' }}</p>
        <div class="contact-items">
          <div class="c-item">
            <div class="c-icon"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
            <div><h4>{{ $contactHeader['address_label'] ?? 'Our Office' }}</h4><p>{{ $contactHeader['address'] ?? 'DHA 1, Islamabad, Pakistan' }}</p></div>
          </div>
          <div class="c-item">
            <div class="c-icon"><svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></div>
            <div><h4>{{ $contactHeader['email_label'] ?? 'Email Us' }}</h4><a href="mailto:{{ $contactHeader['email'] ?? 'info@hexafume.com' }}">{{ $contactHeader['email'] ?? 'info@hexafume.com' }}</a></div>
          </div>
          <div class="c-item">
            <div class="c-icon"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg></div>
            <div><h4>{{ $contactHeader['phone_label'] ?? 'Call Us 24/7' }}</h4><a href="tel:{{ str_replace(' ', '', $contactHeader['phone'] ?? '+923449121053') }}">{{ $contactHeader['phone'] ?? '+92 344 9121053' }}</a></div>
          </div>
        </div>
        <div class="socials">
          <a href="https://www.instagram.com/hexafume?igsh=MWplZXF2bGkzcG00eA==" class="social-btn" aria-label="Follow Hexafume on Instagram" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
          <a href="https://www.linkedin.com/company/hexafume" class="social-btn" aria-label="Connect with Hexafume on LinkedIn" target="_blank" rel="noopener noreferrer"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
        </div>
      </div>
    </div>
    <div class="reveal" style="transition-delay:.15s;">
      <div class="contact-form">
        <form id="contactForm">
          <div class="form-group"><input type="text" name="name" placeholder="Your Name" required/></div>
          <div class="form-row">
            <div class="form-group"><input type="email" name="email" placeholder="Email Address" required/></div>
            <div class="form-group"><input type="tel" name="phone" placeholder="Phone Number"/></div>
          </div>
          <div class="form-group">
            <select name="service" required>
              <option value="" disabled selected>Select a Service</option>
              <option value="Web Design & Development">Web Design & Development</option>
              <option value="Mobile App Development">Mobile App Development</option>
              <option value="AI Integration & Automation">AI Integration & Automation</option>
              <option value="Software Development">Software Development</option>
              <option value="Blockchain & Web3">Blockchain & Web3</option>
              <option value="Graphic & UI/UX Design">Graphic & UI/UX Design</option>
              <option value="Digital & Social Marketing">Digital & Social Marketing</option>
              <option value="DevOps Solutions">DevOps Solutions</option>
              <option value="Staff Augmentation">Staff Augmentation</option>
            </select>
          </div>
          <div class="form-group"><textarea name="message" placeholder="Tell us about your project..." required></textarea></div>
          <button type="submit" class="form-submit" aria-label="Send Message to Hexafume Team">
            Send Message
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
          </button>
        </form>
      </div>
    </div>
  </div>
</section>
@endsection

@push('page_scripts')
<script>
// ===== THREE.JS SAND LOGO ASSEMBLY =====
(function initLogoSand() {
  const canvas = document.getElementById('logoSandCanvas');
  const img = document.getElementById('heroLogoSource');
  if (!canvas || !img) return;

  const W = 320, H = 320;
  const renderer = new THREE.WebGLRenderer({ canvas, antialias: true, alpha: true });
  renderer.setSize(W, H);
  renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));

  const scene = new THREE.Scene();
  const camera = new THREE.PerspectiveCamera(45, 1, 0.1, 2000);
  camera.position.z = 386.29; // Matches 320px canvas exactly (1 unit = 1 pixel)

  let points;
  let particles = [];
  const PARTICLE_COUNT = 8000;
  let isAssembled = false;
  let startTime = 0;

  function sampleImage() {
    const off = document.createElement('canvas');
    const aspect = img.naturalWidth / img.naturalHeight;
    let sw, sh;
    if (aspect > 1) { sw = 128; sh = 128 / aspect; }
    else { sh = 128; sw = 128 * aspect; }
    
    off.width = 128;
    off.height = 128;
    const offCtx = off.getContext('2d');
    offCtx.drawImage(img, (128 - sw) / 2, (128 - sh) / 2, sw, sh);
    const data = offCtx.getImageData(0, 0, 128, 128).data;
    
    const targets = [];
    const scale = 320 / sw; // Maps sampled width to exactly 320px screen width
    for (let y = 0; y < 128; y++) {
      for (let x = 0; x < 128; x++) {
        const i = (y * 128 + x) * 4;
        if (data[i + 3] > 128) {
          targets.push({
            x: (x - 64) * scale,
            y: (64 - y) * scale
          });
        }
      }
    }
    return targets;
  }

  function initParticles() {
    const targets = sampleImage();
    const geo = new THREE.BufferGeometry();
    const pos = new Float32Array(PARTICLE_COUNT * 3);
    const targetPos = new Float32Array(PARTICLE_COUNT * 3);
    const delays = new Float32Array(PARTICLE_COUNT);

    for (let i = 0; i < PARTICLE_COUNT; i++) {
      // Start in a 3D cloud
      pos[i * 3] = (Math.random() - 0.5) * 600;
      pos[i * 3 + 1] = (Math.random() - 0.5) * 600;
      pos[i * 3 + 2] = -800 - Math.random() * 800;

      // Map to a random target point
      const target = targets[Math.floor(Math.random() * targets.length)];
      targetPos[i * 3] = target.x;
      targetPos[i * 3 + 1] = target.y;
      targetPos[i * 3 + 2] = 0;

      delays[i] = Math.random();
    }

    geo.setAttribute('position', new THREE.BufferAttribute(pos, 3));
    geo.setAttribute('targetPosition', new THREE.BufferAttribute(targetPos, 3));
    geo.setAttribute('delay', new THREE.BufferAttribute(delays, 1));

    const mat = new THREE.ShaderMaterial({
      transparent: true,
      uniforms: {
        time: { value: 0 },
        progress: { value: 0 },
        color: { value: new THREE.Color(0xffffff) }
      },
      vertexShader: `
        attribute vec3 targetPosition;
        attribute float delay;
        uniform float time;
        uniform float progress;
        varying float vOpacity;
        
        void main() {
          float p = clamp((progress - delay * 0.4) / 0.6, 0.0, 1.0);
          // Ease out cubic
          p = 1.0 - pow(1.0 - p, 3.0);
          
          vec3 pos = mix(position, targetPosition, p);
          
          // Add some "sand" jitter
          if (p < 0.95) {
            pos.x += sin(time * 5.0 + delay * 10.0) * (1.0 - p) * 5.0;
            pos.y += cos(time * 5.0 + delay * 10.0) * (1.0 - p) * 5.0;
          }
          
          // Floating animation after assembly
          if (p >= 1.0) {
            pos.y += sin(time * 0.8 + delay * 2.0) * 2.5;
            pos.x += cos(time * 0.5 + delay * 2.0) * 1.5;
          }

          vec4 mvPosition = modelViewMatrix * vec4(pos, 1.0);
          gl_PointSize = (2.5 * (1.0 - p * 0.5)) * (400.0 / -mvPosition.z);
          gl_Position = projectionMatrix * mvPosition;
          vOpacity = p;
        }
      `,
      fragmentShader: `
        varying float vOpacity;
        uniform vec3 color;
        void main() {
          float d = distance(gl_PointCoord, vec2(0.5));
          if (d > 0.5) discard;
          gl_FragColor = vec4(color, vOpacity * 0.9);
        }
      `
    });

    points = new THREE.Points(geo, mat);
    scene.add(points);
    startTime = performance.now();
  }

  function animate() {
    requestAnimationFrame(animate);
    const now = performance.now();
    const elapsed = (now - startTime) / 1000;
    
    if (points) {
      points.material.uniforms.time.value = elapsed;
      if (isAssembled) {
        const p = Math.min((now - assembleStartTime) / 3000, 1);
        points.material.uniforms.progress.value = p;
      }
    }
    
    renderer.render(scene, camera);
  }

  let assembleStartTime = 0;
  window.addEventListener('startLogoAssembly', () => {
    isAssembled = true;
    assembleStartTime = performance.now();
    
    // Trigger crossfade after assembly duration
    setTimeout(() => {
      canvas.style.transition = 'opacity 0.8s ease';
      canvas.style.opacity = '0';
      img.classList.add('logo-assembled');
      setTimeout(() => { canvas.style.display = 'none'; }, 800);
    }, 3000); // Wait exactly for assembly (3s)
  });

  if (img.complete) {
    initParticles();
  } else {
    img.onload = initParticles;
  }
  animate();
})();
</script>
<script>
// ===== THREE.JS HERO PARTICLES =====
(function initThree(){
  const canvas=document.getElementById('heroCanvas');
  const scene=new THREE.Scene();
  scene.fog=new THREE.FogExp2(0x05050a,0.0025);
  const camera=new THREE.PerspectiveCamera(75,innerWidth/innerHeight,.1,1000);
  camera.position.z=30;
  const renderer=new THREE.WebGLRenderer({canvas,antialias:true,alpha:true});
  renderer.setSize(innerWidth,innerHeight);
  renderer.setPixelRatio(Math.min(devicePixelRatio,2));

  const geo=new THREE.BufferGeometry();
  const count=1200;
  const pos=new Float32Array(count*3);
  for(let i=0;i<count*3;i++) pos[i]=(Math.random()-.5)*100;
  geo.setAttribute('position',new THREE.BufferAttribute(pos,3));
  const mat=new THREE.PointsMaterial({size:.12,color:0x0033ff,transparent:true,opacity:.7,blending:THREE.AdditiveBlending});
  scene.add(new THREE.Points(geo,mat));

  const snippets=['</>','{ }','=>','const','async','import','npm run','git push','useState()','deploy()','api/v2','.then()','export','return','//AI','docker','k8s','lambda'];
  const meshes=[];
  snippets.forEach(text=>{
    const c=document.createElement('canvas');
    c.width=256;c.height=128;
    const ctx=c.getContext('2d');
    ctx.font='600 56px Courier New';
    ctx.textAlign='center';ctx.textBaseline='middle';
    ctx.fillStyle='rgba(30,80,255,0.7)';
    ctx.fillText(text,128,64);
    const tex=new THREE.CanvasTexture(c);
    const mesh=new THREE.Mesh(
      new THREE.PlaneGeometry(3.5,1.8),
      new THREE.MeshBasicMaterial({map:tex,transparent:true,opacity:.25+Math.random()*.25,side:THREE.DoubleSide,depthWrite:false,blending:THREE.AdditiveBlending})
    );
    mesh.position.set((Math.random()-.5)*60,(Math.random()-.5)*40,(Math.random()-.5)*25-8);
    mesh.rotation.set((Math.random()-.5)*.4,(Math.random()-.5)*.6,0);
    mesh.userData={fs:.3+Math.random()*.7,fo:Math.random()*Math.PI*2};
    scene.add(mesh);meshes.push(mesh);
  });

  let tX=0,tY=0,mX=0,mY=0;
  document.addEventListener('mousemove',e=>{mX=(e.clientX-innerWidth/2)*.03;mY=(e.clientY-innerHeight/2)*.03;});
  const clock=new THREE.Clock();
  (function animate(){
    const t=clock.getElapsedTime();
    requestAnimationFrame(animate);
    tX+=(mX*.5-tX)*.04;tY+=(-mY*.5-tY)*.04;
    camera.position.x+=( tX-camera.position.x)*.05;
    camera.position.y+=(tY-camera.position.y)*.05;
    camera.lookAt(scene.position);
    scene.children[0].rotation.y=t*.04;
    meshes.forEach(m=>{m.position.y+=Math.sin(t*m.userData.fs+m.userData.fo)*.003;m.rotation.y+=.0008;});
    renderer.render(scene,camera);
  })();
  window.addEventListener('resize',()=>{camera.aspect=innerWidth/innerHeight;camera.updateProjectionMatrix();renderer.setSize(innerWidth,innerHeight);});
})();

// ===== COUNT UP STATS =====
(function countUp(){
  const stats = @json($heroStats);
  const targets = {};
  stats.forEach((s, i) => {
    targets[`stat${i+1}`] = parseInt(s.num);
  });
  
  const dur=3000;const start=performance.now();
  (function step(now){
    const p=Math.min((now-start)/dur,1);
    const e=1-Math.pow(1-p,3);
    Object.entries(targets).forEach(([id,t])=>{
      const el=document.getElementById(id);
      if(el) el.textContent=Math.round(t*e);
    });
    if(p<1) requestAnimationFrame(step);
  })(start);
})();

// ===== MARQUEE =====
(function initMarquee(){
  const items = @json($marqueeItems);
  const track=document.getElementById('marqueeTrack');
  const all=[...items,...items,...items];
  all.forEach(item=>{
    const d=document.createElement('div');
    d.className='marquee-item';
    d.innerHTML=`<span>${item}</span><span class="dot"></span>`;
    track.appendChild(d);
  });
})();

// ===== SERVICES (Now handled by Server Side Blade Template) =====

// ===== PROCESS (Now handled by Server Side Blade Template) =====

// ===== TESTIMONIALS (Now handled by Server Side Blade Template) =====

(function initTestimonialToggles() {
  const cards = document.querySelectorAll('.testi-card');

  function measureTruncation(card) {
    const quote = card.querySelector('.testi-q');
    if (!quote) return false;

    const wasExpanded = card.classList.contains('expanded');
    card.classList.remove('expanded');
    const isTruncated = quote.scrollHeight > quote.clientHeight + 1;
    if (wasExpanded) card.classList.add('expanded');
    return isTruncated;
  }

  function refreshCard(card) {
    const toggle = card.querySelector('.testi-toggle');
    if (!toggle) return;

    const isExpanded = card.classList.contains('expanded');
    const isTruncated = card.dataset.truncated === '1';

    toggle.hidden = !isTruncated;
    toggle.textContent = isExpanded ? 'Read Less' : 'Read More';
    toggle.setAttribute('aria-expanded', String(isExpanded));
  }

  cards.forEach(card => {
    const toggle = card.querySelector('.testi-toggle');
    if (!toggle) return;
    toggle.addEventListener('click', () => {
      card.classList.toggle('expanded');
      refreshCard(card);
    });
  });

  const run = () => {
    cards.forEach(card => {
      card.dataset.truncated = measureTruncation(card) ? '1' : '0';
      if (!card.classList.contains('expanded')) {
        refreshCard(card);
      } else {
        refreshCard(card);
      }
    });
  };
  window.addEventListener('load', run, { once: true });
  window.addEventListener('resize', () => requestAnimationFrame(run));
})();

(function initTestimonialCarousel() {
  const shell = document.getElementById('testiCarouselShell');
  const grid = document.getElementById('testiGrid');
  const dotsWrap = document.getElementById('testiDots');
  if (!shell || !grid || !dotsWrap) return;

  const count = Number(shell.dataset.testimonialCount || grid.children.length || 0);
  if (count <= 3) {
    shell.classList.add('is-static');
    return;
  }

  shell.classList.add('is-carousel');

  const cards = () => Array.from(grid.querySelectorAll('.testi-card'));
  const getVisibleCount = () => {
    if (window.innerWidth <= 700) return 1;
    if (window.innerWidth <= 1024) return 2;
    return 3;
  };

  let activeIndex = 0;
  let dots = [];
  let raf = 0;

  const buildDots = () => {
    const totalPages = Math.max(1, Math.ceil(cards().length / getVisibleCount()));
    const maxIndex = totalPages - 1;
    activeIndex = Math.min(activeIndex, maxIndex);
    dotsWrap.innerHTML = '';
    dots = [];
    for (let i = 0; i < totalPages; i++) {
      const dot = document.createElement('button');
      dot.type = 'button';
      dot.className = 'testi-dot' + (i === activeIndex ? ' is-active' : '');
      dot.setAttribute('aria-label', `Go to testimonial group ${i + 1}`);
      dot.addEventListener('click', () => goToPage(i));
      dotsWrap.appendChild(dot);
      dots.push(dot);
    }
  };

  const setActiveDot = (index) => {
    activeIndex = index;
    dots.forEach((dot, i) => dot.classList.toggle('is-active', i === index));
  };

  const goToPage = (index) => {
    const visible = getVisibleCount();
    const firstCard = cards()[index * visible];
    if (!firstCard) return;
    setActiveDot(index);
    grid.scrollTo({ left: firstCard.offsetLeft - grid.offsetLeft, behavior: 'smooth' });
  };

  const updateFromScroll = () => {
    const visible = getVisibleCount();
    const list = cards();
    let page = 0;
    list.forEach((card, index) => {
      const start = card.offsetLeft - grid.offsetLeft;
      if (grid.scrollLeft >= start - 20) {
        page = Math.floor(index / visible);
      }
    });
    setActiveDot(page);
  };

  const rebuild = () => {
    buildDots();
    goToPage(activeIndex);
  };

  grid.addEventListener('scroll', () => {
    if (raf) cancelAnimationFrame(raf);
    raf = requestAnimationFrame(updateFromScroll);
  }, { passive: true });

  window.addEventListener('resize', () => requestAnimationFrame(rebuild));
  buildDots();
  goToPage(0);
})();

// ===== FORM SUBMIT =====
const contactForm = document.getElementById('contactForm');
if (contactForm) {
  contactForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const form = e.target;
    const btn = form.querySelector('.form-submit');
    const originalHtml = btn.innerHTML;
    
    btn.disabled = true;
    btn.innerHTML = '<span class="loading-spinner"></span> Sending...';
    btn.style.opacity = '0.7';

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    try {
      const response = await fetch('{{ route("contact.send") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data)
      });

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        let errorMsg = errorData.message || `Server returned ${response.status}`;
        if (errorData.errors) errorMsg += '\nDetails: ' + Object.values(errorData.errors).flat().join(', ');
        throw new Error(errorMsg);
      }

      const result = await response.json();
      if (result.success) {
        btn.textContent = '✓ ' + result.message.split('!')[0] + '!';
        btn.style.background = '#00aa44';
        form.reset();
      } else {
        throw new Error(result.message || 'Submission failed');
      }
    } catch (error) {
      alert('Submission Failed: ' + error.message);
      btn.textContent = '✖ Error. Please try again.';
      btn.style.background = '#dd3333';
    } finally {
      setTimeout(() => {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
        btn.style.background = '';
        btn.style.opacity = '';
      }, 4000);
    }
  });
}
</script>
@endpush
