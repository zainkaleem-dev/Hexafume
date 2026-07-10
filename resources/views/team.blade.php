@extends('layouts.app')

@section('title', 'Our Team — Hexafume | The Minds Behind the Magic')
@section('meta_description', 'Meet the brilliant minds at Hexafume — a team of engineers, designers, and strategists building the future of digital experiences.')

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('css/team.css') }}">
@endpush

@section('content')
<div class="cursor" id="cursor"></div>
<div class="cursor-ring" id="cursorRing"></div>
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
  $culture = $page->getSectionContent('culture');
  $cta = $page->getSectionContent('cta');
@endphp

<!-- HERO -->
<section class="team-hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-orb"></div>
  <div class="hero-orb-2"></div>
  <div class="team-hero-inner">
    <nav class="breadcrumb" aria-label="Breadcrumb">
      <a href="{{ route('home') }}">Home</a>
      <span class="breadcrumb-sep">›</span>
      <span>Team</span>
    </nav>
    <div class="hero-eyebrow">
      <span class="dot-live"></span>
      {{ $teamStats['members'] ?? 0 }} Specialists &amp; Growing
    </div>
    <h1>{!! $hero['title'] ?? 'The Minds Behind<br>the <span class="grad">Magic</span>' !!}</h1>
    <p class="hero-sub">{{ $hero['subtitle'] ?? 'We are a team of engineers, designers, strategists, and dreamers united by one mission — turning bold ideas into scalable digital realities.' }}</p>
  </div>
</section>

<!-- TEAM GRID -->
<section class="team-section" id="teamSection">
  <!-- Rendered by JS -->
</section>


<!-- JOIN CTA -->
<section class="join-section">
  <div class="join-card reveal">
    <div class="section-badge" style="margin:0 auto 1.5rem;display:inline-flex;"><span class="dot"></span>{{ $cta['badge'] ?? 'Hiring' }}</div>
    <h2>{!! $cta['title'] ?? 'Want to Join the <span class="grad">Team?</span>' !!}</h2>
    <p>{{ $cta['subtitle'] ?? "We're always looking for brilliant people who want to build things that matter. If that sounds like you, let's talk." }}</p>
    <div class="join-btns">
      <a href="{{ route('contact') }}" class="btn-p">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="16" height="16"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        {{ $cta['btn1_text'] ?? 'Apply Now' }}
      </a>
      <a href="{{ route('contact') }}" class="btn-s">{{ $cta['btn2_text'] ?? 'Send Us a Message' }}</a>
    </div>
  </div>
</section>
@endsection

@push('page_scripts')
<script>
// ===== TEAM DATA =====
const team = @json($teamMembersPayload ?? []);

// RENDER FUNCTION
function renderTeam() {
  const container = document.getElementById('teamSection');
  if(!container) return;
  container.innerHTML = '';

  if (team.length === 0) {
    container.innerHTML = `
      <div class="team-grid">
        <div class="member-card" style="grid-column:1/-1; text-align:center; padding:2rem;">
          <div class="member-body">
            <div class="member-name">No team members available</div>
            <p class="member-bio">Please check back soon.</p>
          </div>
        </div>
      </div>
    `;
    return;
  }

  const grid = document.createElement('div');
  grid.className = 'team-grid';

  team.forEach((m, idx) => {
    const card = document.createElement('a');
    card.href = m.profile;
    card.className = 'member-card reveal';
    card.style.transitionDelay = `${idx * 80}ms`;

    card.innerHTML = `
      <div class="member-photo-wrap">
        ${m.photo
          ? `<img src="${m.photo}" alt="${m.name}" loading="lazy"${m.name === 'Danish Khan' ? ' style="object-fit:cover;object-position:center top;"' : ''}>`
          : `<div class="member-avatar-placeholder"><div class="avatar-initials">${m.initials}</div></div>`
        }
        <div class="member-dept-badge">${m.deptLabel}</div>
        <div class="member-arrow"><svg viewBox="0 0 24 24"><path d="M7 17L17 7M7 7h10v10"/></svg></div>
      </div>
      <div class="member-body">
        <div class="member-name">${m.name}</div>
        <div class="member-title">${m.title}</div>
        <p class="member-bio">${m.bio}</p>
        <div class="member-skills">
          ${m.skills.slice(0,3).map(s => `<span class="skill-tag">${s}</span>`).join('')}
        </div>
        <div class="member-socials">
          <div class="member-social"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg></div>
          <div class="member-exp">${m.exp}</div>
        </div>
      </div>
    `;
    grid.appendChild(card);
  });

  container.appendChild(grid);
  
  // Re-trigger observer
  setTimeout(() => {
    document.querySelectorAll('.reveal:not(.visible)').forEach(el => revealObs.observe(el));
  }, 100);
}

// REVEAL OBSERVER
const revealObs = new IntersectionObserver(entries => {
  entries.forEach(e => {
    if(e.isIntersecting) {
      e.target.classList.add('visible');
      revealObs.unobserve(e.target);
    }
  });
}, {threshold: 0.1, rootMargin: '0px 0px -50px 0px'});

// INIT
renderTeam();
setTimeout(() => {
  document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));
}, 100);

// NAV SCROLL
window.addEventListener('scroll', () => {
  document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 40);
}, {passive:true});
</script>
@endpush
