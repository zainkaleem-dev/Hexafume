@extends('layouts.app')

@section('title', 'Projects — Hexafume | Our Work & Case Studies')
@section('meta_description', "Explore Hexafume's portfolio of digital projects — from AI-powered SaaS platforms to streaming services, trading tools, and beyond. Real results for real clients.")

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('css/work.css') }}">
@endpush

@section('content')
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
  $impact = $page->getSectionContent('impact');
  $cta = $page->getSectionContent('cta');
@endphp

<!-- HERO -->
<section class="page-hero">
  <div class="hero-grid-bg"></div>
  <div class="hero-orb"></div>
  <div class="hero-orb-2"></div>
  <div class="page-hero-inner">
    <div class="breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb-sep">/</span>
      <span>Projects</span>
    </div>
    <h1>{!! $hero['title'] ?? 'Real Products.<br><span class="grad">Real Impact.</span>' !!}</h1>
    <p class="hero-sub">{{ $hero['subtitle'] ?? 'From streaming platforms to financial trading tools — every project we ship is a testament to engineering discipline.' }}</p>
    <div class="hero-stat-row">
      @if(isset($hero['stats']))
        @foreach($hero['stats'] as $stat)
          <div class="hero-stat"><span class="num">{{ $stat['num'] }}</span><span class="lbl">{{ $stat['label'] }}</span></div>
        @endforeach
      @endif
    </div>
  </div>
</section>

<!-- FILTER BAR -->
<div class="filter-section">
  <div class="filter-bar" id="filterBar">
    <span class="filter-label">Filter by:</span>
    <button class="filter-btn active" data-filter="all">All Projects</button>
    @foreach($categories as $cat)
      <button class="filter-btn" data-filter="{{ $cat }}">{{ $cat }}</button>
    @endforeach
  </div>
</div>

<!-- PROJECTS GRID -->
<section class="projects-section">
  <div class="projects-grid" id="projectsGrid">
    @forelse($projects as $i => $p)
      <div class="proj-card reveal{{ $p->is_featured ? ' featured' : '' }}"
           style="transition-delay:{{ $i * 80 }}ms"
           data-cat="{{ $p->type }}">
        <div class="proj-thumb" style="background:var(--surface2);position:relative;">
          @if($p->hero_image_url)
            <img src="{{ $p->hero_image_url }}" alt="{{ $p->name }}" loading="lazy" width="1200" height="800" style="position:absolute;inset:0;width:100%;height:100%;max-width:100%;max-height:100%;object-fit:cover;display:block;opacity:0.4;">
          @endif
          @if($p->logo_image_url)
            <img src="{{ $p->logo_image_url }}" alt="{{ $p->name }} Logo" width="110" height="110" style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:110px;height:110px;max-width:110px;max-height:110px;object-fit:contain;display:block;z-index:2;filter:drop-shadow(0 10px 20px rgba(0,0,0,0.5));">
          @endif
          <div class="proj-thumb-overlay"></div>
          <span class="proj-cat">{{ $p->type }}</span>
          <span class="proj-status {{ $p->status }}">{{ $p->status === 'live' ? '● Live' : '🔧 In Dev' }}</span>
        </div>
        <div class="proj-body">
          <h3>{{ $p->name }}</h3>
          <p>{{ $p->overview_p1 }}</p>
          <div class="proj-tags">
            @foreach($p->techTags->take(6) as $tag)
              <span class="proj-tag">{{ $tag->name }}</span>
            @endforeach
          </div>
          <div class="proj-footer">
            <span class="proj-dates">
              {{ $p->start_date ? $p->start_date->format('M Y') : '' }}
              @if($p->finish_date) — {{ $p->finish_date->format('M Y') }} @endif
            </span>
            <a href="{{ route('project-detail', $p->url_slug) }}" class="proj-link">
              View Project
              <svg viewBox="0 0 24 24"><path d="M7 17L17 7M7 7h10v10"/></svg>
            </a>
          </div>
        </div>
      </div>
    @empty
      <div class="proj-empty" style="grid-column:1/-1;text-align:center;padding:4rem;color:rgba(255,255,255,0.4);">
        <p>No projects published yet. Check back soon.</p>
      </div>
    @endforelse
  </div>
</section>

<!-- IMPACT -->
<section class="impact-section">
  <div class="impact-inner">
    <div class="impact-head reveal">
      <div class="section-badge"><span class="dot"></span>{{ $impact['badge'] ?? 'By The Numbers' }}</div>
      <h2 class="section-title">{!! $impact['title'] ?? 'The <span class="grad">Impact</span> We\'ve Made' !!}</h2>
      <p>{{ $impact['subtitle'] ?? 'Measurable outcomes across every project we\'ve delivered.' }}</p>
    </div>
    <div class="impact-grid">
      @if(isset($impact['items']))
        @foreach($impact['items'] as $i => $item)
          <div class="impact-card reveal" style="transition-delay:{{ strval($i * 0.08) }}s;">
            <span class="ic-icon">{{ $item['icon'] }}</span>
            <span class="ic-num">{{ $item['num'] }}</span>
            <span class="ic-lbl">{{ $item['label'] }}</span>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="testis-section">
  <div class="testis-head reveal">
    <div class="section-badge"><span class="dot"></span>Client Voices</div>
    <h2 class="section-title">What Clients <span class="grad">Say</span></h2>
    <p>Don't take our word for it — hear from the people who've built with us.</p>
  </div>
  <div class="testis-grid" id="testiGrid">
    @foreach($testimonials as $i => $t)
      <div class="testi-card reveal" style="transition-delay:{{ $i * 120 }}ms;">
        <div class="stars">★★★★★</div>
        <p class="testi-q">"{{ $t->quote }}"</p>
        <div class="testi-author">
          <div class="testi-avatar">{{ $t->initials }}</div>
          <div><div class="testi-name">{{ $t->company }}</div><div class="testi-role">{{ $t->role }}</div></div>
        </div>
      </div>
    @endforeach
  </div>
</section>

@php
  $techHeader = $page->getSectionContent('tech_header');
@endphp
<!-- TECH STACK -->
<section class="tech-section">
  <div class="tech-inner">
    <div class="tech-head reveal">
      <div class="section-badge"><span class="dot"></span>{{ $techHeader['badge'] ?? 'Tech Behind The Work' }}</div>
      <h2 class="section-title">{!! $techHeader['title'] ?? 'Built With the <span class="grad">Best Stack</span>' !!}</h2>
      <p>{{ $techHeader['subtitle'] ?? 'We pick the right tool for each job — always staying on the leading edge.' }}</p>
    </div>
    <div class="tech-categories">
      @php $catDelay = 0; @endphp
      @foreach($technologies as $category => $techs)
        <div class="tech-cat reveal" style="transition-delay: {{ ($catDelay++ % 3) * 0.08 }}s;">
          <span class="tech-cat-label">{{ $category }}</span>
          <div class="tech-pills">
            @foreach($techs as $tech)
              <span class="tech-pill">{{ $tech->name }}</span>
            @endforeach
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="cta-glow"></div>
  <div class="cta-inner reveal">
    <div class="section-badge" style="margin:0 auto 1.5rem;"><span class="dot"></span>{{ $cta['badge'] ?? 'Let\'s Build Together' }}</div>
    <h2>{!! $cta['title'] ?? 'Your Project Could Be <span class="grad">Next.</span>' !!}</h2>
    <p>{{ $cta['subtitle'] ?? 'Whether it\'s a bold product idea or a complex platform — we have the team, the process, and the hunger to make it extraordinary.' }}</p>
    <div class="cta-btns">
      <a href="{{ route('contact') }}" class="btn-p">{{ $cta['btn1_text'] ?? 'Start Your Project' }} <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      <a href="{{ route('process') }}" class="btn-s">{{ $cta['btn2_text'] ?? 'See Our Process' }}</a>
    </div>
  </div>
</section>
@endsection

@push('page_scripts')
<script>
// FILTER — cards are server-rendered, just toggle visibility
const filterBar = document.getElementById('filterBar');
if (filterBar) {
  filterBar.addEventListener('click', e => {
    const btn = e.target.closest('.filter-btn');
    if (!btn) return;
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const filter = btn.dataset.filter;
    document.querySelectorAll('#projectsGrid .proj-card').forEach(card => {
      card.style.display = (filter === 'all' || card.dataset.cat === filter) ? '' : 'none';
    });
  });
}

// SCROLL REVEAL
const revealObs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); revealObs.unobserve(e.target); } });
}, { threshold: .08, rootMargin: '0px 0px -40px 0px' });
setTimeout(() => { document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el)); }, 80);
</script>
@endpush
