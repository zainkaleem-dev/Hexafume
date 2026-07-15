@extends('layouts.app')

@section('title', $project->meta_title ?: $project->name . ' — Project Detail | Hexafume')
@section('meta_description', $project->meta_description ?: 'Explore the case study and full development timeline for ' . $project->name . ' by Hexafume.')
@if($project->meta_keywords)
@section('meta_keywords', $project->meta_keywords)
@endif

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('css/project-detail.css') }}">
@endpush

@section('content')
<!-- PROJECT HERO -->
<section class="project-hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-orb"></div>
  <div class="project-hero-inner">
    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb-sep">›</span>
      <a href="{{ route('work') }}">Work</a>
      <span class="breadcrumb-sep">›</span>
      <span>{{ $project->name }}</span>
    </nav>

    <!-- Eyebrow -->
    <div class="hero-eyebrow">
      <span class="dot"></span>
      {{ $project->type }}
    </div>

    <!-- Title -->
    <h1>{{ $project->name }}<br><span class="grad">Case Study</span></h1>

    <!-- Meta pills -->
    <div class="hero-meta-row">
      <div class="hero-meta-pill">
        <svg viewBox="0 0 24 24"><path d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        <span>
            {{ $project->start_date ? $project->start_date->format('M Y') : '' }}
            @if($project->finish_date) — {{ $project->finish_date->format('M Y') }} @endif
        </span>
      </div>
      @if($project->total_time)
      <div class="hero-meta-pill">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        <span><strong>{{ $project->total_time }}</strong> timeline</span>
      </div>
      @endif
      @if($project->team)
      <div class="hero-meta-pill">
        <svg viewBox="0 0 24 24"><path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
        <span><strong>{{ $project->team }}</strong></span>
      </div>
      @endif
      @if($project->delivered_on_time)
      <div class="hero-meta-pill">
        <svg viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span><strong>Delivered</strong> on schedule</span>
      </div>
      @endif
    </div>

    <!-- Hero image strip -->
    <div class="hero-strip">
      @if($project->hero_image_url)
        <img src="{{ $project->hero_image_url }}" alt="{{ $project->name }} Hero" class="hero-strip-img" width="1200" height="700" style="max-width:100%;max-height:700px;object-fit:cover;display:block;"
          onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"/>
      @endif
      <div class="hero-strip-fallback" @if($project->hero_image_url) style="display:none;" @endif>
        @if($project->logo_image_url)
            <img src="{{ $project->logo_image_url }}" alt="{{ $project->name }} Logo" class="hero-strip-logo" width="180" height="180" style="width:180px;height:180px;max-width:180px;max-height:180px;object-fit:contain;display:block;"
              onerror="this.style.display='none'"/>
        @else
            <h2 style="color:rgba(255,255,255,0.2); font-size:3rem;">{{ $project->name }}</h2>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- PAGE BODY -->
<div class="page-body">

  <!-- MAIN COLUMN -->
  <main class="main-col">

    <!-- Overview -->
    <div class="overview-block reveal">
      <div class="sec-label">Overview</div>
      <h2>{{ $project->overview_heading }}</h2>
      <p>{{ $project->overview_p1 }}</p>
      @if($project->overview_p2) <p>{{ $project->overview_p2 }}</p> @endif
      @if($project->overview_p3) <p>{{ $project->overview_p3 }}</p> @endif

      <!-- Stats -->
      @if($project->stat1_num || $project->stat2_num || $project->stat3_num)
      <div class="stats-row">
        @if($project->stat1_num)
        <div class="stat-cell">
          <div class="stat-num">{{ $project->stat1_num }}</div>
          <div class="stat-lbl">{{ $project->stat1_lbl }}</div>
        </div>
        @endif
        @if($project->stat2_num)
        <div class="stat-cell">
          <div class="stat-num">{{ $project->stat2_num }}</div>
          <div class="stat-lbl">{{ $project->stat2_lbl }}</div>
        </div>
        @endif
        @if($project->stat3_num)
        <div class="stat-cell">
          <div class="stat-num">{{ $project->stat3_num }}</div>
          <div class="stat-lbl">{{ $project->stat3_lbl }}</div>
        </div>
        @endif
      </div>
      @endif
    </div>

    @if($project->challenges && $project->challenges->count() > 0)
    <!-- Challenges & Solutions -->
    <div class="challenge-block reveal">
      <div class="sec-label">Challenges & Solutions</div>
      <h2>Problems We Solved</h2>
      <ul class="challenge-list">
        @foreach($project->challenges as $challenge)
        <li class="challenge-item">
          <div class="challenge-icon">
            <svg viewBox="0 0 24 24"><path d="M15 10l4.553-2.069A1 1 0 0121 8.87v6.26a1 1 0 01-1.447.9L15 14M3 8h12a2 2 0 012 2v4a2 2 0 01-2 2H3a2 2 0 01-2-2v-4a2 2 0 012-2z"/></svg>
          </div>
          <div class="challenge-text">
            <h4>{{ $challenge->title }}</h4>
            <p>{{ $challenge->solution }}</p>
          </div>
        </li>
        @endforeach
      </ul>
    </div>
    @endif

    @if($project->timelineEntries && $project->timelineEntries->count() > 0)
    <!-- Timeline -->
    <div class="timeline-block reveal">
      <div class="sec-label">Project Roadmap</div>
      <h2>{{ $project->timeline_heading ?: 'The Journey from Idea to Launch' }}</h2>
      @if($project->timeline_subtext)
        <p style="color:var(--w60); margin-bottom:2rem; font-size:0.95rem;">{{ $project->timeline_subtext }}</p>
      @endif
      <div class="timeline">
        @foreach($project->timelineEntries as $entry)
        <div class="tl-entry {{ $entry->is_milestone ? 'milestone' : '' }}">
          <div class="tl-dot"></div>
          <div class="tl-date">{{ $entry->date_label }}</div>
          <div class="tl-card">
            <h4>{{ $entry->title }}</h4>
            <p>{{ $entry->description }}</p>
            @if($entry->tag_text)
              <span class="tl-tag {{ $entry->tag_color }}">{{ $entry->tag_text }}</span>
            @endif
          </div>
        </div>
        @endforeach
      </div>
    </div>
    @endif

    @if($project->techTags && $project->techTags->count() > 0)
    <!-- Tech Stack -->
    <div class="tech-block reveal">
      <div class="sec-label">Technology Stack</div>
      <h2>The Engineering Behind {{ $project->name }}</h2>
      @if($project->stack_description)
      <p style="color:var(--w60); margin-bottom:2rem;">{{ $project->stack_description }}</p>
      @endif
      <div class="tech-grid">
        @foreach($project->techTags as $tag)
          <div class="tech-pill">{{ $tag->name }}</div>
        @endforeach
      </div>
    </div>
    @endif

  </main>

  <!-- SIDEBAR -->
  <aside class="sidebar reveal">
    <div class="sidebar-sticky">
      <!-- Project Summary -->
      <div class="sidebar-card">
        <h3>Project Stats</h3>
        <ul class="info-list">
          <li class="info-item"><span class="info-key">Client</span><span class="info-val">{{ $project->client_name }}</span></li>
          <li class="info-divider"></li>
          <li class="info-item"><span class="info-key">Category</span><span class="info-val">{{ $project->type }}</span></li>
          
          @if($project->team)
          <li class="info-divider"></li>
          <li class="info-item"><span class="info-key">Team</span><span class="info-val">{{ $project->team }}</span></li>
          @endif
          
          @if($project->total_time)
          <li class="info-divider"></li>
          <li class="info-item"><span class="info-key">Duration</span><span class="info-val">{{ $project->total_time }}</span></li>
          @endif
          
          <li class="info-divider"></li>
          <li class="info-item">
            <span class="info-key">Status</span>
            <span class="info-val" style="color: {{ $project->status === 'live' ? '#00c864' : 'var(--blue)' }};">
                {{ ucfirst($project->status) }}
            </span>
          </li>
        </ul>
      </div>

      @if($project->serviceTags && $project->serviceTags->count() > 0)
      <!-- Services -->
      <div class="sidebar-card">
        <h3>Services Delivered</h3>
        <div class="tag-wrap">
          @foreach($project->serviceTags as $service)
            <span class="tag">{{ $service->name }}</span>
          @endforeach
        </div>
      </div>
      @endif

      @if($project->site_url)
      <!-- Live Link -->
      <a href="{{ $project->site_url }}" target="_blank" rel="noopener" class="live-btn">
        Visit Website
        <svg viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6M15 3h6v6M10 14L21 3"/></svg>
      </a>
      @endif

      <!-- Back Link -->
      <a href="{{ route('work') }}" class="back-btn">
        <svg viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
        Back to Portfolio
      </a>
    </div>
  </aside>

</div>

@if($project->relatedProjects && $project->relatedProjects->count() > 0)
<!-- MORE PROJECTS -->
<section class="more-projects">
  <div class="more-inner">
    <div class="more-head reveal">
      <h2>Related Work</h2>
    </div>
    <div class="more-grid">
      @foreach($project->relatedProjects as $related)
      <div class="port-card reveal">
        <div class="port-thumb2">
          @if($related->image_url)
            <img src="{{ $related->image_url }}" alt="{{ $related->name }}" class="port-thumb2-img" width="900" height="600" style="width:100%;height:180px;max-width:100%;max-height:180px;object-fit:cover;display:block;"/>
          @else
            <div style="width:100%; height:180px; background:var(--surface2); display:flex; align-items:center; justify-content:center; font-weight:700; color:var(--w40);">{{ $related->name }}</div>
          @endif
          <span class="port-cat-badge">{{ $related->category }}</span>
        </div>
        <div class="port-body2">
          <h3>{{ $related->name }}</h3>
          <p>{{ $related->description }}</p>
          @if($related->link_url)
            <a href="{{ $related->link_url }}" target="_blank" class="port-link2">View Project →</a>
          @endif
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@endsection

@push('page_scripts')
<script>
// TIMELINE REVEAL
const tlEntries = document.querySelectorAll('.tl-entry');
const tlObserver = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('visible');
    }
  });
}, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

tlEntries.forEach(entry => tlObserver.observe(entry));

// NAV SCROLL
window.addEventListener('scroll', () => {
  document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 40);
}, { passive: true });
</script>
@endpush
