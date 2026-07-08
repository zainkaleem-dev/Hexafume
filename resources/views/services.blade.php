@extends('layouts.app')

@section('title', 'Services — Hexafume | Digital Solutions That Scale')
@section('meta_description', "Hexafume's full suite of digital services — Agentic AI, SaaS Development, Web & Mobile Apps, UI/UX Design, Blockchain, DevOps, and Digital Marketing.")

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
@endpush

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
  $practices = $page->getSectionContent('practices_header');
  $features = $page->getSectionContent('features_strip');
  $techHeader = $page->getSectionContent('tech_header');
  $cta = $page->getSectionContent('cta');
@endphp

<!-- HERO -->
<section class="page-hero">
  <div class="hero-grid-bg"></div>
  <div class="hero-orb"></div>
  <div class="page-hero-inner">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>Services</span></nav>
    <div class="section-badge" style="animation:fadeUp .7s .15s ease both;"><span class="dot"></span>{{ $hero['badge'] ?? 'What We Do' }}</div>
    <h1>{!! $hero['title'] ?? 'Our Services <span class="grad">Era</span>' !!}</h1>
    <p class="hero-sub">{{ $hero['subtitle'] ?? 'Comprehensive digital solutions engineered to propel your business into the future.' }}</p>
    <div class="hero-tags">
      @if(isset($hero['tags']))
        @foreach($hero['tags'] as $tag)
          <span class="hero-tag">{{ $tag }}</span>
        @endforeach
      @endif
    </div>
  </div>
</section>

<!-- SERVICES LIST -->
<section class="services-section">
  <div class="services-header reveal">
    <div class="section-badge"><span class="dot"></span>{{ $practices['badge'] ?? 'Full Capability Stack' }}</div>
    <h2 class="section-title">{!! $practices['title'] ?? 'Everything You Need to <span class="grad">Scale</span>' !!}</h2>
    <p>{{ $practices['desc'] ?? 'Eight practice areas. One unified team. Engineered for speed, quality, and long-term impact.' }}</p>
  </div>
  <div class="service-featured" id="serviceList">
    @foreach($services as $i => $s)
      <div class="svc-big-card reveal" style="transition-delay: {{ $i * 60 }}ms;">
        <div class="svc-big-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">{!! $s->icon !!}</svg></div>
        <div class="svc-big-body">
          <h3>{{ $s->name }}</h3>
          <p>{{ $s->description }}</p>
          <div class="svc-tags">
            @foreach($s->features as $t)
              <span class="svc-tag">{{ $t }}</span>
            @endforeach
          </div>
        </div>
        <div class="svc-big-cta">
          <a href="{{ route('contact') }}" class="svc-arrow" aria-label="Get started with {{ $s->name }}">
            <svg viewBox="0 0 24 24"><path d="M7 17L17 7M7 7h10v10"/></svg>
          </a>
        </div>
        <span class="svc-big-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
      </div>
    @endforeach
  </div>
</section>

<!-- TECH STACK -->
<section class="tech-section">
  <div class="tech-head reveal">
    <div class="section-badge"><span class="dot"></span>{{ $techHeader['badge'] ?? 'Our Stack' }}</div>
    <h2 class="section-title">{!! $techHeader['title'] ?? 'Technologies We <span class="grad">Master</span>' !!}</h2>
    <p style="color:var(--w60);max-width:480px;margin:.8rem auto 0;font-size:.9rem;line-height:1.75;">{{ $techHeader['subtitle'] ?? 'We stay on the cutting edge — picking the right tool for the right job, always.' }}</p>
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
</section>

<!-- CTA -->
<section class="services-cta">
  <div class="cta-glow"></div>
  <div class="services-cta-inner reveal">
    <div class="section-badge" style="margin:0 auto 1.5rem;display:inline-flex;"><span class="dot"></span>{{ $cta['badge'] ?? 'Get Started' }}</div>
    <h2>{!! $cta['title'] ?? 'Have a Project in <span class="grad">Mind?</span>' !!}</h2>
    <p>{{ $cta['subtitle'] ?? 'Let\'s talk about your goals, challenges, and how we can build something extraordinary together.' }}</p>
    <div class="cta-btns">
      <a href="{{ route('contact') }}" class="btn-p">{{ $cta['btn1_text'] ?? 'Start Your Project' }} <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      <a href="{{ route('process') }}" class="btn-s">{{ $cta['btn2_text'] ?? 'See Our Process' }}</a>
    </div>
  </div>
</section>
@endsection

@push('page_scripts')
<script>
// SERVICES (Now handled by Server Side Blade Template)

</script>
@endpush
