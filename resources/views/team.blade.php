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
    <div class="hero-stats-row">
      <div class="hstat">
        <div class="hstat-num">{{ $teamStats['members'] ?? 0 }}<span class="plus">+</span></div>
        <div class="hstat-lbl">Team Members</div>
      </div>
      <div class="hstat-div"></div>
      <div class="hstat">
        <div class="hstat-num">{{ $teamStats['disciplines'] ?? 0 }}<span class="plus">+</span></div>
        <div class="hstat-lbl">Disciplines</div>
      </div>
      <div class="hstat-div"></div>
      <div class="hstat">
        <div class="hstat-num">{{ $teamStats['countries'] ?? 0 }}<span class="plus"></span></div>
        <div class="hstat-lbl">Countries</div>
      </div>
      <div class="hstat-div"></div>
      <div class="hstat">
        <div class="hstat-num">{{ $teamStats['projects'] ?? 0 }}<span class="plus">+</span></div>
        <div class="hstat-lbl">Projects Shipped</div>
      </div>
    </div>
  </div>
</section>

<!-- FILTER BAR -->
<div class="filter-section">
  <div class="filter-group" id="filterGroup">
    <button class="filter-btn active" data-dept="all">All</button>
    @foreach(($teamDepartments ?? collect()) as $department)
      <button class="filter-btn" data-dept="{{ $department['key'] }}">{{ $department['label'] }}</button>
    @endforeach
  </div>
  <span class="filter-count" id="filterCount">Showing {{ $teamStats['members'] ?? 0 }} members</span>
</div>

<!-- TEAM GRID -->
<section class="team-section" id="teamSection">
  <!-- Rendered by JS -->
</section>


<!-- CULTURE SECTION -->
<section class="culture-section">
  <div class="culture-inner">
    <div class="culture-head reveal">
      <div class="section-badge"><span class="dot"></span>{{ $culture['badge'] ?? 'Our Culture' }}</div>
      <h2>{!! $culture['title'] ?? 'Built on <span class="grad">Principles</span>' !!}</h2>
      <p>{{ $culture['desc'] ?? 'The values that guide how we work, build, and grow — together.' }}</p>
    </div>
    <div class="culture-grid">
      @if(isset($culture['items']))
        @foreach($culture['items'] as $index => $item)
          <div class="culture-card reveal" style="transition-delay:{{ $index * 80 }}ms">
            <div class="culture-icon">
              @if(str_contains(strtolower($item['title']), 'speed')) <svg viewBox="0 0 24 24"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
              @elseif(str_contains(strtolower($item['title']), 'integrity') || str_contains(strtolower($item['title']), 'craft')) <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
              @elseif(str_contains(strtolower($item['title']), 'together') || str_contains(strtolower($item['title']), 'grow')) <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/></svg>
              @elseif(str_contains(strtolower($item['title']), 'system')) <svg viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
              @else <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M13 10V3L4 14h7v7l9-11h-7z"/></svg> @endif
            </div>
            <h3>{{ $item['title'] }}</h3>
            <p>{{ $item['desc'] }}</p>
          </div>
        @endforeach
      @endif
    </div>
  </div>
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
function renderTeam(filter = 'all') {
  const container = document.getElementById('teamSection');
  if(!container) return;
  container.innerHTML = '';

  const filtered = filter === 'all' ? team : team.filter(m => m.dept === filter);
  if (filtered.length === 0) {
    container.innerHTML = `
      <div class="dept-block reveal visible">
        <div class="dept-label">
          <h2>Team</h2>
          <span class="dept-count">0</span>
          <div class="dept-line"></div>
        </div>
        <div class="team-grid">
          <div class="member-card" style="grid-column:1/-1; text-align:center; padding:2rem;">
            <div class="member-body">
              <div class="member-name">No team members available</div>
              <p class="member-bio">Please check back soon.</p>
            </div>
          </div>
        </div>
      </div>
    `;
    document.getElementById('filterCount').textContent = `Showing 0 members`;
    return;
  }
  
  // Group by department for visual blocks
  const depts = [...new Set(filtered.map(m => m.dept))];
  
  depts.forEach(dept => {
    const deptMembers = filtered.filter(m => m.dept === dept);
    const deptLabel = deptMembers[0].deptLabel;
    
    const block = document.createElement('div');
    block.className = 'dept-block reveal';
    block.innerHTML = `
      <div class="dept-label">
        <h2>${deptLabel}</h2>
        <span class="dept-count">${deptMembers.length}</span>
        <div class="dept-line"></div>
      </div>
      <div class="team-grid"></div>
    `;
    
    const grid = block.querySelector('.team-grid');
    deptMembers.forEach((m, idx) => {
      const card = document.createElement('a');
      card.href = m.profile;
      card.className = 'member-card reveal';
      card.style.transitionDelay = `${idx * 80}ms`;
      
      card.innerHTML = `
        <div class="member-photo-wrap">
          ${m.photo 
            ? `<img src="${m.photo}" alt="${m.name}" loading="lazy">` 
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
    
    container.appendChild(block);
  });

  document.getElementById('filterCount').textContent = `Showing ${filtered.length} members`;
  
  // Re-trigger observer
  setTimeout(() => {
    document.querySelectorAll('.reveal:not(.visible)').forEach(el => revealObs.observe(el));
  }, 100);
}

// FILTER LOGIC
const filterGroup = document.getElementById('filterGroup');
if (filterGroup) {
  filterGroup.addEventListener('click', e => {
    const btn = e.target.closest('.filter-btn');
    if(!btn) return;
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    renderTeam(btn.dataset.dept);
  });
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
