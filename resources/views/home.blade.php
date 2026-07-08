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
      "https://facebook.com/hexafume",
      "https://twitter.com/hexafume",
      "https://linkedin.com/company/hexafume"
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
      <img src="{{ asset('images/hexafume/hexafume-white.png') }}" id="preloader-img" alt="Hexafume"
        style="height:80px;width:auto;filter:brightness(1.1);"
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
        <img src="{{ asset('images/hexafume/hexafume-white.png') }}" alt="Hexafume - Think Big | IT Services & Digital Solutions" class="hero-logo-img" loading="eager" id="heroLogoSource">
      </div>
    </div>
  </div>
</section>

<!-- MARQUEE -->
<div class="marquee-section">
  <div class="marquee-track" id="marqueeTrack"></div>
</div>

<!-- ABOUT -->
<section id="about" style="padding:3rem 1.5rem;max-width:1300px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:6rem;align-items:center;">
  <div class="reveal">
    <span class="about-badge"><span class="dot"></span>{{ $aboutSection['badge'] ?? 'Who We Are' }}</span>
    <h2 style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;font-weight:500;font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;letter-spacing:-.02em;margin-bottom:1rem;">
      {!! $aboutSection['title'] ?? 'Transforming Ideas Into <span class="grad">Digital Reality</span>' !!}
    </h2>
    <p class="about-text">{{ $aboutSection['desc_p1'] ?? "At Hexafume, we're more than just a service provider we're a team of passionate professionals dedicated to empowering businesses with cutting-edge digital solutions." }}</p>
    <p class="about-text">{{ $aboutSection['desc_p2'] ?? "Our mission is to be your trusted partner, guiding you through every step of your digital journey." }}</p>
    <div class="about-pillars">
      @if(isset($aboutSection['pillars']))
        @php
          $icons = [
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>',
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
            '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
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
      <h2 class="section-title" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;font-weight:500;font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;letter-spacing:-.02em;margin-bottom:1rem;">{!! $servicesHeader['title'] ?? 'Our Services <span class="grad">Era</span>' !!}</h2>
      <p class="section-sub">{{ $servicesHeader['subtitle'] ?? 'Comprehensive digital solutions that propel your business into the future' }}</p>
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
<section id="process" aria-labelledby="processHeader" style="padding:4rem 1.5rem;max-width:1300px;margin:0 auto;">
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
              <img src="{{ $p->hero_image_url }}" alt="Project Showcase: {{ $p->name }} - {{ $p->type }}" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:top;opacity:0.4;" loading="lazy">
            @endif
            @if($p->logo_image_url)
              <img src="{{ $p->logo_image_url }}" alt="{{ $p->name }} Logo" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:120px;height:auto;z-index:2;filter:drop-shadow(0 10px 20px rgba(0,0,0,0.5));">
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
<section id="testimonials" style="padding:3.5rem 1.5rem;max-width:1300px;margin:0 auto;">
  <div class="testi-head reveal">
    <span class="section-badge"><span class="dot"></span>{{ $testimonialsHeader['badge'] ?? 'Client Love' }}</span>
    <h2 class="section-title" style="font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Helvetica,Arial,sans-serif;font-weight:500;font-size:clamp(2rem,3.5vw,3rem);line-height:1.1;letter-spacing:-.02em;margin-bottom:1rem;">{!! $testimonialsHeader['title'] ?? 'What Our Clients <span class="grad">Say</span>' !!}</h2>
  </div>
  <div class="testi-grid" id="testiGrid">
    @foreach($testimonials as $i => $t)
      <div class="testi-card reveal" style="transition-delay: {{ $i * 120 }}ms;">
        <div class="stars">★★★★★</div>
        <p class="testi-q">"{{ $t->quote }}"</p>
        <div class="testi-author">
          <div class="testi-avatar">{{ $t->initials }}</div>
          <div>
            <div class="testi-name">{{ $t->company }}</div>
            <div class="testi-role">{{ $t->role }}</div>
          </div>
        </div>
      </div>
    @endforeach
  </div>
</section>

<!-- CTA -->
<section id="cta">
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
          <a href="#" class="social-btn" aria-label="Follow Hexafume on Facebook"><svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
          <a href="#" class="social-btn" aria-label="Follow Hexafume on Twitter"><svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>
          <a href="#" class="social-btn" aria-label="Connect with Hexafume on LinkedIn"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>
          <a href="#" class="social-btn" aria-label="Follow Hexafume on Instagram"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg></a>
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
