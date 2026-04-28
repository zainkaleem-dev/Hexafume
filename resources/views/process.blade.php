@extends('layouts.app')

@section('title', 'Our Process — Hexafume | How We Work')
@section('meta_description', "Discover Hexafume's proven 5-step methodology for delivering exceptional digital products — from strategy and consultation through development, delivery, and ongoing support.")

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('css/process.css') }}">
@endpush

@section('content')
<!-- PRELOADER -->
<div id="preloader">
  <div class="preloader-3d-wrap">
    <div class="preloader-ring-track"></div>
    <div class="preloader-ring-progress" id="ringProgress"></div>
    <div class="preloader-logo-center">
      <img src="{{ asset('images/hexafume/hexafume-white.png') }}" id="preloader-img" alt="Hexafume" style="height:80px;width:auto;filter:brightness(1.1);" onerror="this.style.display='none';document.getElementById('preloader-fallback').style.display='block'"/>
      <div class="preloader-logo" id="preloader-fallback" style="display:none;">HEXA<span>FUME</span></div>
    </div>
  </div>
</div>

@php
  $hero = $page->getSectionContent('hero');
  $methodology = $page->getSectionContent('methodology_header');
  $phases = $page->getSectionContent('phases');
  $tools = $page->getSectionContent('tools');
  $faqHeader = $page->getSectionContent('faq_header');
  $cta = $page->getSectionContent('cta');
@endphp

<!-- HERO -->
<section class="page-hero">
  <div class="hero-grid-bg"></div>
  <div class="hero-orb"></div>
  <div class="page-hero-inner">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>Process</span></nav>
    <div class="section-badge" style="animation:fadeUp .7s .15s ease both;"><span class="dot"></span>{{ $hero['badge'] ?? 'How We Work' }}</div>
    <h1>{!! $hero['title'] ?? 'Our Standard <span class="grad">Work Process</span>' !!}</h1>
    <p class="hero-sub">{{ $hero['subtitle'] ?? 'A proven methodology refined across 1200+ projects — combining strategy, agile execution, and relentless quality control.' }}</p>
    <div class="hero-quick-stats">
      @if(isset($hero['stats']))
        @foreach($hero['stats'] as $index => $stat)
          @if($index > 0)
            <div class="hqs-div"></div>
          @endif
          <div class="hqs"><div class="hqs-num">{{ $stat['num'] }}</div><div class="hqs-lbl">{{ $stat['label'] }}</div></div>
        @endforeach
      @endif
    </div>
  </div>
</section>

<!-- PROCESS ZIGZAG -->
<section class="process-section">
  <div class="process-head reveal">
    <div class="section-badge"><span class="dot"></span>{{ $methodology['badge'] ?? 'The Methodology' }}</div>
    <h2 class="section-title">{!! $methodology['title'] ?? 'Five Steps to <span class="grad">Exceptional</span>' !!}</h2>
    <p>{{ $methodology['desc'] ?? 'Every engagement — regardless of size or complexity — follows this battle-tested framework.' }}</p>
  </div>
  <ol class="process-list" id="processList" aria-label="Work process steps">
    <div class="process-line"></div>
    @foreach($process_steps as $i => $s)
      <li class="process-step reveal" style="transition-delay: {{ $i * 100 }}ms;">
        <div class="step-num">{{ $s->step_number }}</div>
        <div class="step-content">
          <div class="step-duration">{{ $s->duration }}</div>
          <h3>{{ $s->title }}</h3>
          <p>{{ $s->description }}</p>
          <div class="step-deliverables">
            @foreach($s->deliverables as $d)
              <span class="step-d-tag">{{ $d }}</span>
            @endforeach
          </div>
        </div>
        <div class="step-visual">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true"><title>{{ $s->title }} Icon</title>{!! $s->icon !!}</svg>
        </div>
      </li>
    @endforeach
  </ol>
</section>

<!-- PHASES -->
<section class="phases-section">
  <div class="phases-inner">
    <div class="phases-head reveal">
      <div class="section-badge"><span class="dot"></span>{{ $phases['badge'] ?? 'Inside Each Phase' }}</div>
      <h2 class="section-title">{!! $phases['title'] ?? 'What Happens <span class="grad">Behind the Scenes</span>' !!}</h2>
      <p>{{ $phases['desc'] ?? 'The rigorous sub-processes that make every step work.' }}</p>
    </div>
    <div class="phases-grid">
      @if(isset($phases['items']))
        @foreach($phases['items'] as $i => $phase)
          <div class="phase-card reveal" style="transition-delay:{{ strval($i * 0.08) }}s;">
            <div class="phase-card-icon">
              @if(str_contains(strtolower($phase['title']), 'discovery')) <svg viewBox="0 0 24 24"><path d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/></svg>
              @elseif(str_contains(strtolower($phase['title']), 'design')) <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
              @elseif(str_contains(strtolower($phase['title']), 'dev')) <svg viewBox="0 0 24 24"><path d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
              @elseif(str_contains(strtolower($phase['title']), 'qa') || str_contains(strtolower($phase['title']), 'test')) <svg viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.952 11.952 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
              @elseif(str_contains(strtolower($phase['title']), 'deploy')) <svg viewBox="0 0 24 24"><path d="M2 8h20"/><rect x="2" y="4" width="20" height="16" rx="2"/><circle cx="8" cy="12" r="1"/><circle cx="12" cy="12" r="1"/><circle cx="16" cy="12" r="1"/></svg>
              @else <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg> @endif
            </div>
            <h3>{{ $phase['title'] }}</h3>
            <p>{{ $phase['desc'] }}</p>
            <span class="phase-badge">{{ $phase['badge'] }}</span>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</section>

<!-- TOOLS -->
<section class="tools-section">
  <div class="tools-head reveal">
    <div class="section-badge"><span class="dot"></span>{{ $tools['badge'] ?? 'Our Toolkit' }}</div>
    <h2 class="section-title">{!! $tools['title'] ?? 'Tools That Power <span class="grad">Every Project</span>' !!}</h2>
    <p>{{ $tools['desc'] ?? 'Industry-leading tools, tailored workflows, and practices refined across hundreds of builds.' }}</p>
  </div>
  <div class="tools-grid">
    @if(isset($tools['items']))
      @foreach($tools['items'] as $i => $tool)
        <div class="tool-card reveal" style="transition-delay:{{ strval($i * 0.06) }}s;">
          <span class="tool-emoji">{{ $tool['emoji'] }}</span>
          <h4>{{ $tool['title'] }}</h4>
          <p>{{ $tool['desc'] }}</p>
        </div>
      @endforeach
    @endif
  </div>
</section>

<!-- FAQ -->
<section class="faq-section">
  <div class="faq-inner">
    <div class="faq-head reveal">
      <div class="section-badge"><span class="dot"></span>{{ $faqHeader['badge'] ?? 'Common Questions' }}</div>
      <h2 class="section-title">{!! $faqHeader['title'] ?? 'Frequently <span class="grad">Asked</span>' !!}</h2>
    </div>
    <div class="faq-list" id="faqList">
      @foreach($faqs as $i => $faq)
        <div class="faq-item reveal" style="transition-delay: {{ $i * 50 }}ms;">
          <div class="faq-q" role="button" aria-expanded="false" onclick="this.parentElement.classList.toggle('open'); this.setAttribute('aria-expanded', this.parentElement.classList.contains('open'));">
            <span>{{ $faq->question }}</span>
            <span class="faq-icon"><svg viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg></span>
          </div>
          <div class="faq-a"><div class="faq-a-inner">{{ $faq->answer }}</div></div>
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- CTA -->
<section class="process-cta">
  <div class="cta-glow"></div>
  <div class="process-cta-inner reveal">
    <div class="section-badge" style="margin:0 auto 1.5rem;display:inline-flex;"><span class="dot"></span>{{ $cta['badge'] ?? 'Ready to Start' }}</div>
    <h2>{!! $cta['title'] ?? 'Let\'s Build Something <span class="grad">Remarkable</span>' !!}</h2>
    <p>{{ $cta['subtitle'] ?? 'Ready to experience a process that actually works? Let\'s kick off your project today.' }}</p>
    <div class="cta-btns">
      <a href="{{ route('contact') }}" class="btn-p">{{ $cta['btn1_text'] ?? 'Start Your Project' }} <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      <a href="{{ route('services') }}" class="btn-s">{{ $cta['btn2_text'] ?? 'Browse Services' }}</a>
    </div>
  </div>
</section>
@endsection

@push('page_scripts')
<script>
// PROCESS STEPS (Now handled by Server Side Blade Template)

// FAQ (Now handled by Server Side Blade Template)
</script>
@endpush
