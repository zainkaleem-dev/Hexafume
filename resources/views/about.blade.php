@extends('layouts.app')

@section('title', 'About Us — Hexafume | Who We Are')
@section('meta_description', 'Learn about Hexafume — our story, mission, values, and the team driving digital transformation across AI, SaaS, and custom software development since 2022.')

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('css/about.css') }}">
@endpush

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
  $story = $page->getSectionContent('story');
  $mv = $page->getSectionContent('mission_vision');
  $pillars = $page->getSectionContent('pillars');
  $teamTeaser = $page->getSectionContent('team_teaser');
  $cta = $page->getSectionContent('cta');
@endphp

<!-- HERO -->
<section class="page-hero">
  <div class="hero-grid-bg"></div>
  <div class="hero-orb"></div>
  <div class="hero-orb-2"></div>
  <div class="page-hero-inner">
    <div class="hero-left-col">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>About Us</span>
      </nav>
      <div class="section-badge" style="animation:fadeUp .7s .15s ease both;"><span class="dot"></span>{{ $hero['badge'] ?? 'Who We Are' }}</div>
      <h1>{!! $hero['title'] ?? 'We Build <span class="grad">Digital Futures</span> That Matter' !!}</h1>
      <p class="hero-sub">{{ $hero['subtitle'] ?? 'Hexafume is a next-generation digital agency pioneered by excellence and innovation.' }}</p>
      <div class="hero-btns">
        <a href="{{ route('services') }}" class="btn-p">{{ $hero['btn1_text'] ?? 'Explore Services' }} <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
        <a href="{{ route('contact') }}" class="btn-s">{{ $hero['btn2_text'] ?? 'Start a Project' }}</a>
      </div>
    </div>
    <div class="hero-right-col">
      @if(isset($hero['stats']))
        @php
          $icons = ['🚀', '⚡', '🌍', '📅'];
        @endphp
        @foreach($hero['stats'] as $index => $stat)
          <div class="hero-stat-card"><span class="stat-num" id="s{{ $index+1 }}">0</span><span class="stat-lbl">{{ $stat['label'] }}</span><span class="stat-icon">{{ $icons[$index % count($icons)] }}</span></div>
        @endforeach
      @endif
    </div>
  </div>
</section>

<!-- STORY -->
<section class="story-section">
  <div class="story-text reveal">
    <div class="section-badge"><span class="dot"></span>{{ $story['badge'] ?? 'Our Story' }}</div>
    <h2 class="section-title">{!! $story['title'] ?? 'From a Bold <span class="grad">Vision</span> to Global Impact' !!}</h2>
    <p>{{ $story['p1'] ?? "Hexafume was born out of frustration. We saw businesses with brilliant ideas trapped by outdated technology, slow agencies, and digital strategies that just didn't work." }}</p>
    <p>{!! $story['p2'] ?? 'Founded in 2022, we set out to build a company that <strong>thinks like a startup, executes like an enterprise, and cares like a partner</strong>.' !!}</p>
    <div style="margin-top:2rem;">
      <a href="{{ route('team') }}" class="btn-p">{{ $story['btn_text'] ?? 'Meet the Team' }} <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
  </div>
  <div class="reveal" style="transition-delay:.15s;">
    <div class="section-badge"><span class="dot"></span>{{ $story['journey_badge'] ?? 'Our Journey' }}</div>
    <div class="story-timeline">
      @if(isset($story['timeline']))
        @foreach($story['timeline'] as $tl)
          <div class="tl-item">
            <span class="tl-year">{{ $tl['year'] }}</span>
            <div class="tl-content"><h4>{{ $tl['title'] }}</h4><p>{{ $tl['desc'] }}</p></div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
</section>

<!-- MISSION / VISION / VALUES -->
<section class="mv-section">
  <div class="mv-inner">
    <div class="mv-head reveal">
      <div class="section-badge"><span class="dot"></span>{{ $mv['badge'] ?? 'Our Foundation' }}</div>
      <h2 class="section-title">{!! $mv['title'] ?? 'Mission, Vision & <span class="grad">Values</span>' !!}</h2>
      <p style="color:var(--w60);max-width:480px;margin:.6rem auto 0;font-size:.9rem;line-height:1.75;">{{ $mv['subtitle'] ?? 'The principles that guide every decision, every build, and every client relationship.' }}</p>
    </div>
    <div class="mv-grid">
      <div class="mv-card reveal">
        <div class="mv-card-icon"><svg viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
        <h3>{{ $mv['mission_title'] ?? 'Our Mission' }}</h3>
        <p>{{ $mv['mission_text'] ?? 'To democratise access to world-class digital technology.' }}</p>
      </div>
      <div class="mv-card reveal" style="transition-delay:.1s;">
        <div class="mv-card-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg></div>
        <h3>{{ $mv['vision_title'] ?? 'Our Vision' }}</h3>
        <p>{{ $mv['vision_text'] ?? 'To become the most trusted technology partner.' }}</p>
      </div>
    </div>
    <div class="values-row">
      @if(isset($mv['values']))
        @foreach($mv['values'] as $i => $val)
          <div class="value-card reveal" style="transition-delay:{{ strval($i * 0.08) }}s;"><span class="value-emoji">{{ $val['emoji'] }}</span><h4>{{ $val['title'] }}</h4><p>{{ $val['text'] }}</p></div>
        @endforeach
      @endif
    </div>
  </div>
</section>

<!-- PILLARS -->
<section class="pillars-section">
  <div class="pillars-head reveal">
    <div class="section-badge"><span class="dot"></span>{{ $pillars['badge'] ?? 'Why Hexafume' }}</div>
    <h2 class="section-title">{!! $pillars['title'] ?? 'What Makes Us <span class="grad">Different</span>' !!}</h2>
    <p>{{ $pillars['desc'] ?? 'The six pillars that define how we work and why clients keep coming back.' }}</p>
  </div>
  <div class="pillars-grid">
    @if(isset($pillars['items']))
      @foreach($pillars['items'] as $i => $pillar)
        <div class="pillar-card reveal" style="transition-delay:{{ strval($i * 0.08) }}s;">
          <div class="pillar-icon">
            @if($pillar['icon'] == 'brain') <svg viewBox="0 0 24 24"><path d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
            @elseif($pillar['icon'] == 'shield') <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            @elseif($pillar['icon'] == 'refresh') <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
            @elseif($pillar['icon'] == 'users') <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
            @elseif($pillar['icon'] == 'trending-up') <svg viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            @elseif($pillar['icon'] == 'message-square') <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
            @else <span style="font-size:2rem;">{{ $pillar['icon'] }}</span> @endif
          </div>
          <h3>{{ $pillar['title'] }}</h3>
          <p>{{ $pillar['desc'] }}</p>
          <span class="pillar-num">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
        </div>
      @endforeach
    @endif
  </div>
</section>

<!-- TEAM TEASER -->
<section class="team-teaser">
  <div class="team-teaser-inner">
    <div class="team-text reveal">
      <div class="section-badge"><span class="dot"></span>{{ $teamTeaser['badge'] ?? 'The People' }}</div>
      <h2>{!! $teamTeaser['title'] ?? 'Brilliant Minds, <span class="grad">One Team</span>' !!}</h2>
      <p>{{ $teamTeaser['subtitle'] ?? 'We are engineers, designers, strategists, and researchers united by a shared obsession.' }}</p>
      <div class="team-highlights">
        @foreach($aboutTeamHighlights ?? [] as $highlight)
          <div class="team-highlight-item">
            <svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            @if(str_contains($highlight, 'active team members'))
              {{ collect($aboutTeamMembers ?? [])->count() }} {{ $highlight }}
            @elseif(str_contains($highlight, 'disciplines'))
              {{ collect($aboutTeamDepartments ?? [])->count() }} {{ $highlight }}
            @else
              {{ $highlight }}
            @endif
          </div>
        @endforeach
      </div>
      <div class="team-dept-tags" style="margin-bottom:2rem;">
        @forelse(($aboutTeamDepartments ?? collect()) as $deptTag)
          <span class="dept-tag">{{ $deptTag }}</span>
        @empty
          <span class="dept-tag">Team</span>
        @endforelse
      </div>
      <a href="{{ route('team') }}" class="btn-p">{{ $teamTeaser['btn_text'] ?? 'Meet the Full Team' }} <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
    </div>
    <div class="reveal" style="transition-delay:.15s;">
      <div class="avatar-stack">
        @php
          $avatarMembers = collect($aboutTeamMembers ?? []);
          $avatarFirstRow = $avatarMembers->take(5);
          $avatarSecondRow = $avatarMembers->slice(5, 5);
          $remainingCount = max($avatarMembers->count() - 10, 0);
        @endphp
        <div class="avatar-row">
          @foreach($avatarFirstRow as $member)
            <div class="avatar-bubble {{ !empty($member['photo']) ? 'has-photo' : '' }}" title="{{ $member['name'] }}">
              @if(!empty($member['photo']))
                <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}" loading="lazy" width="56" height="56" style="width:100%;height:100%;min-width:100%;min-height:100%;border-radius:50%;object-fit:cover;object-position:center top;display:block;">
              @else
                {{ $member['initials'] }}
              @endif
            </div>
          @endforeach
        </div>
        <div class="avatar-row">
          @foreach($avatarSecondRow as $member)
            <div class="avatar-bubble {{ !empty($member['photo']) ? 'has-photo' : '' }}" title="{{ $member['name'] }}">
              @if(!empty($member['photo']))
                <img src="{{ $member['photo'] }}" alt="{{ $member['name'] }}" loading="lazy" width="56" height="56" style="width:100%;height:100%;min-width:100%;min-height:100%;border-radius:50%;object-fit:cover;object-position:center top;display:block;">
              @else
                {{ $member['initials'] }}
              @endif
            </div>
          @endforeach
          @if($remainingCount > 0)
            <div class="avatar-bubble more" title="And more...">+{{ $remainingCount }}</div>
          @endif
        </div>
      </div>
      <!-- Testimonial snippet -->
      <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:1.8rem;margin-top:1.5rem;">
        @if(!empty($aboutTestimonial))
          <div style="color:#ffc107;font-size:.85rem;letter-spacing:3px;margin-bottom:.8rem;">★★★★★</div>
          <p style="font-size:.85rem;line-height:1.75;color:var(--w60);font-style:italic;margin-bottom:1rem;">"{{ $aboutTestimonial->quote }}"</p>
          <div style="display:flex;align-items:center;gap:.75rem;">
            @if(!empty($aboutTestimonial->photo_url))
              <div style="width:34px;height:34px;border-radius:50%;overflow:hidden;background:linear-gradient(135deg,var(--blue),var(--blue-b));flex-shrink:0;">
                <img src="{{ $aboutTestimonial->photo_url }}" alt="{{ $aboutTestimonial->client_name ?? $aboutTestimonial->company }}" width="34" height="34" style="width:34px;height:34px;max-width:34px;max-height:34px;object-fit:cover;object-position:center top;display:block;">
              </div>
            @else
              <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--blue),var(--blue-b));display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;flex-shrink:0;">{{ $aboutTestimonial->initials ?? strtoupper(substr($aboutTestimonial->client_name ?? $aboutTestimonial->company ?? 'T', 0, 2)) }}</div>
            @endif
            <div><div style="font-size:.82rem;font-weight:700;">{{ $aboutTestimonial->client_name ?? $aboutTestimonial->company ?? 'Client' }}</div><div style="font-size:.7rem;color:var(--w60);">{{ $aboutTestimonial->role ?? $aboutTestimonial->location ?? '' }}</div></div>
          </div>
        @else
          <div style="color:#ffc107;font-size:.85rem;letter-spacing:3px;margin-bottom:.8rem;">★★★★★</div>
          <p style="font-size:.85rem;line-height:1.75;color:var(--w60);font-style:italic;margin-bottom:1rem;">"Hexafume understood our vision perfectly. They delivered a beautifully designed platform that exceeded every expectation."</p>
          <div style="display:flex;align-items:center;gap:.75rem;">
            <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,var(--blue),var(--blue-b));display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:700;">AP</div>
            <div><div style="font-size:.82rem;font-weight:700;">Arete Properties</div><div style="font-size:.7rem;color:var(--w60);">Real Estate</div></div>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="about-cta">
  <div class="cta-glow"></div>
  <div class="about-cta-inner reveal">
    <div class="section-badge" style="margin:0 auto 1.5rem;display:inline-flex;"><span class="dot"></span>{{ $cta['badge'] ?? 'Let\'s Build' }}</div>
    <h2>{!! $cta['title'] ?? 'Ready to <span class="grad">Think Big</span>?' !!}</h2>
    <p>{{ $cta['subtitle'] ?? "Let's transform your vision into a digital masterpiece. Get in touch and let's build something extraordinary together." }}</p>
    <div class="cta-btns">
      <a href="{{ route('contact') }}" class="btn-p">{{ $cta['btn1_text'] ?? 'Start Your Project' }} <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg></a>
      <a href="tel:{{ str_replace(' ', '', $contactHeader['phone'] ?? '+923449121053') }}" class="btn-s">📞 {{ $cta['btn2_text'] ?? 'Call Us Now' }}</a>
    </div>
  </div>
</section>
@endsection

@push('page_scripts')
<script>
// STATS COUNT UP
(function(){
  const targets={s1:300,s2:35,s3:20,s4:3};
  const suffixes={s1:'+',s2:'+',s3:'+',s4:''};
  const dur=2800;const start=performance.now();
  (function step(now){
    const p=Math.min((now-start)/dur,1);
    const e=1-Math.pow(1-p,3);
    Object.entries(targets).forEach(([id,t])=>{
      const el=document.getElementById(id);
      if(el)el.textContent=Math.round(t*e)+(suffixes[id]||'');
    });
    if(p<1)requestAnimationFrame(step);
  })(start);
})();
</script>
@endpush
