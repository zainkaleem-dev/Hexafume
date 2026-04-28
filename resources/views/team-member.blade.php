@extends('layouts.app')
@php
  $memberPageName = $selectedMemberPayload['name'] ?? 'Team Member';
  $memberPageTitle = $selectedMemberPayload['title'] ?? 'Hexafume Team';
  $memberPageBio = $selectedMemberPayload['bio'] ?? 'Team member profile at Hexafume.';
@endphp

@section('title', $memberPageName . ' — Hexafume')
@section('meta_description', \Illuminate\Support\Str::limit($memberPageBio, 155))

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('css/team-member.css') }}">
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

<!-- HERO - dynamically filled -->
<section class="profile-hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-orb"></div>
  <div class="profile-hero-inner">
    <!-- LEFT -->
    <div class="profile-left">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('team') }}">Team</a>
        <span class="breadcrumb-sep">›</span>
        <span id="breadMember">Member</span>
      </nav>
      <div class="profile-dept-badge" id="deptBadge">
        <span class="dot"></span>
        <span id="deptLabel">Loading...</span>
      </div>
      <h1 class="profile-name" id="memberName">Loading...</h1>
      <p class="profile-title-line" id="memberTitle">Loading...</p>
      <p class="profile-bio" id="memberBio">Loading...</p>
      <div class="profile-meta-row" id="metaRow">
        <!-- filled by JS -->
      </div>
      <div class="profile-socials" id="profileSocials">
        <!-- filled by JS -->
      </div>
    </div>
    <!-- RIGHT - PHOTO -->
    <div class="profile-photo-col">
      <div class="profile-photo-frame" id="photoFrame">
        <!-- filled by JS -->
      </div>
    </div>
  </div>
</section>

<!-- CONTENT -->
<div class="profile-content" id="profileContent">
  <!-- LEFT COLUMN -->
  <div class="content-left">

    <!-- SKILLS -->
    <div class="content-section reveal">
      <div class="content-section-label">
        <h2>Core Skills</h2>
        <div class="section-line"></div>
      </div>
      <div class="skills-grid" id="skillsGrid"></div>
    </div>

    <!-- QUALIFICATIONS -->
    <div class="content-section reveal">
      <div class="content-section-label">
        <h2>Qualifications & Certifications</h2>
        <div class="section-line"></div>
      </div>
      <div class="qual-list" id="qualList"></div>
    </div>

    <!-- ACHIEVEMENTS -->
    <div class="content-section reveal">
      <div class="content-section-label">
        <h2>By the Numbers</h2>
        <div class="section-line"></div>
      </div>
      <div class="achieve-grid" id="achieveGrid"></div>
    </div>

    <!-- EXPERTISE -->
    <div class="content-section reveal">
      <div class="content-section-label">
        <h2>Full Expertise</h2>
        <div class="section-line"></div>
      </div>
      <div class="expertise-tags" id="expertiseTags"></div>
    </div>

  </div>

  <!-- RIGHT SIDEBAR -->
  <aside class="content-sidebar">
    <!-- Quick Info -->
    <div class="sidebar-card reveal">
      <h3>Quick Info</h3>
      <ul class="info-list" id="infoList"></ul>
    </div>
    <!-- Availability -->
    <div class="sidebar-card reveal">
      <h3>Availability</h3>
      <p style="font-size:.8rem;color:var(--w60);margin-bottom:1.2rem;line-height:1.6;">
        <span class="availability-dot"></span>
        Available for consultation & project collaboration.
      </p>
      <a href="{{ route('contact') }}" class="contact-btn">Work With Us</a>
      <a href="{{ route('contact') }}" class="contact-btn-outline">Send a Message</a>
    </div>
    <!-- Connect -->
    <div class="sidebar-card reveal">
      <h3>Connect</h3>
      <div class="sidebar-socials" id="sidebarSocials"></div>
    </div>
  </aside>
</div>

<!-- OTHER TEAM MEMBERS -->
<div class="section-divider" style="padding:0;margin:4rem auto 0;"></div>
<div class="other-members">
  <div class="other-head">
    <h2>More of the Team</h2>
    <a href="{{ route('team') }}">View All →</a>
  </div>
  <div class="other-grid" id="otherGrid"></div>
</div>
@endsection

@push('page_scripts')
<script>
const member = @json($selectedMemberPayload ?? null);
const others = @json($otherMembersPayload ?? []);

const skillIcons = ['⚡','🎯','🛠','🔮','📊','🚀','🧩','🎨','🔬','🌐','💡','🔐'];

function renderProfile(member) {
  // Page meta done via section in Blade
  document.getElementById('breadMember').textContent = member.name;

  // Hero left
  document.getElementById('deptLabel').textContent = member.deptLabel;
  document.getElementById('memberName').innerHTML = member.name.split(' ').map((w,i)=>i===member.name.split(' ').length-1?`<span class="grad">${w}</span>`:w).join(' ');
  document.getElementById('memberTitle').textContent = member.title;
  document.getElementById('memberBio').textContent = member.bio;

  // Meta row
  const metaRow = document.getElementById('metaRow');
  const metas = [
    {icon:`<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/>`,text:member.location},
    {icon:`<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>`,text:`${member.exp} experience`},
    {icon:`<path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 014.5 9.5a19.79 19.79 0 01-3.07-8.63A2 2 0 013.5 0h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 7.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/>`,text:member.email},
  ];
  metaRow.innerHTML = metas.map((m,i)=>`
    ${i>0?'<div class="meta-sep"></div>':''}
    <div class="meta-item">
      <svg viewBox="0 0 24 24">${m.icon}</svg>
      ${m.text}
    </div>
  `).join('');

  // Socials
  const socialsEl = document.getElementById('profileSocials');
  let socialHtml = '';
  if (member.linkedin) socialHtml += `<a href="${member.linkedin}" class="profile-social-btn" target="_blank" aria-label="LinkedIn"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg> LinkedIn</a>`;
  if (member.twitter) socialHtml += `<a href="${member.twitter}" class="profile-social-btn" target="_blank" aria-label="Twitter"><svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg> Twitter</a>`;
  socialHtml += `<a href="mailto:${member.email}" class="profile-social-btn" aria-label="Email"><svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg> Email</a>`;
  socialsEl.innerHTML = socialHtml;

  // Photo
  const photoFrame = document.getElementById('photoFrame');
  if (member.photo) {
    photoFrame.innerHTML = `<img src="${member.photo}" alt="${member.name}"><div class="photo-glow"></div><div class="photo-corner-badge">${member.deptLabel}</div><div class="exp-badge">${member.exp} exp.</div>`;
  } else {
    photoFrame.innerHTML = `<div class="profile-photo-initials"><div class="initials-circle">${member.initials}</div></div><div class="photo-glow"></div><div class="photo-corner-badge">${member.deptLabel}</div><div class="exp-badge">${member.exp} exp.</div>`;
  }

  // Skills grid
  const skillsGrid = document.getElementById('skillsGrid');
  const levels = ['Expert','Expert','Advanced','Advanced','Proficient','Proficient','Intermediate'];
  const pcts = [95,92,88,85,80,76,70];
  skillsGrid.innerHTML = member.skills.map((s,i)=>`
    <div class="skill-card">
      <div class="skill-icon">${skillIcons[i % skillIcons.length]}</div>
      <div style="flex:1;">
        <div class="skill-card-name">${s}</div>
        <div class="skill-level">${levels[i]||'Proficient'}</div>
        <div class="skill-bar"><div class="skill-bar-fill" style="width:${pcts[i]||75}%"></div></div>
      </div>
    </div>
  `).join('');

  // Qualifications
  const qualList = document.getElementById('qualList');
  qualList.innerHTML = member.qualifications.map((q,i)=>{
    const isAcademic = q.includes('BSc')||q.includes('MSc')||q.includes('MFA')||q.includes('MBA')||q.includes('BDes')||q.includes('BBA')||q.includes('PhD');
    const icon = isAcademic
      ? `<path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>`
      : `<path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/>`;
    const badge = isAcademic ? 'Degree' : 'Certified';
    return `
      <div class="qual-item">
        <div class="qual-icon-wrap"><svg viewBox="0 0 24 24">${icon}</svg></div>
        <div style="flex:1;">
          <div class="qual-title">${q.split('—')[0].trim()}</div>
          ${q.includes('—') ? `<div class="qual-meta">${q.split('—')[1].trim()}</div>` : ''}
        </div>
        <span class="qual-badge">${badge}</span>
      </div>
    `;
  }).join('');

  // Achievements
  const achieveGrid = document.getElementById('achieveGrid');
  const achieves = member.achievements || [{num:'5+',lbl:'Years Exp.'},{num:'20+',lbl:'Projects'},{num:'100%',lbl:'Commitment'},{num:'∞',lbl:'Passion'}];
  achieveGrid.innerHTML = achieves.map(a=>`
    <div class="achieve-card">
      <span class="achieve-num">${a.num}</span>
      <span class="achieve-lbl">${a.lbl}</span>
    </div>
  `).join('');

  // Expertise tags
  const tagsEl = document.getElementById('expertiseTags');
  const expertise = (member.expertiseTags && member.expertiseTags.length)
    ? member.expertiseTags
    : member.skills.concat((member.qualifications || []).map(q=>q.split('—')[0].trim()));
  tagsEl.innerHTML = expertise.map(t=>`<span class="exp-tag">${t}</span>`).join('');

  // Sidebar info
  const infoList = document.getElementById('infoList');
  infoList.innerHTML = `
    <li class="info-item"><span class="info-key">Department</span><span class="info-val">${member.deptLabel}</span></li>
    <li class="info-divider"></li>
    <li class="info-item"><span class="info-key">Role</span><span class="info-val">${member.title}</span></li>
    <li class="info-divider"></li>
    <li class="info-item"><span class="info-key">Experience</span><span class="info-val">${member.exp}</span></li>
    <li class="info-divider"></li>
    <li class="info-item"><span class="info-key">Location</span><span class="info-val">${member.location}</span></li>
    <li class="info-divider"></li>
    <li class="info-item"><span class="info-key">Skills</span><span class="info-val">${member.skills.length} Listed</span></li>
  `;

  // Sidebar socials
  const sidebarSocials = document.getElementById('sidebarSocials');
  let ssHtml = '';
  if (member.linkedin) ssHtml += `<a href="${member.linkedin}" class="sidebar-social" target="_blank"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg><span class="s-label">LinkedIn</span><span class="s-handle">Connect →</span></a>`;
  if (member.twitter) ssHtml += `<a href="${member.twitter}" class="sidebar-social" target="_blank"><svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg><span class="s-label">Twitter</span><span class="s-handle">Follow →</span></a>`;
  ssHtml += `<a href="mailto:${member.email}" class="sidebar-social"><svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,12 2,6"/></svg><span class="s-label">Email</span><span class="s-handle">Write →</span></a>`;
  sidebarSocials.innerHTML = ssHtml;

  // Other team members
  const otherGrid = document.getElementById('otherGrid');
  otherGrid.innerHTML = others.map(m=>`
    <a href="${m.profile}" class="other-card reveal">
      <div class="other-photo">
        ${m.photo ? `<img src="${m.photo}" alt="${m.name}">` : `<div class="other-avatar">${m.initials}</div>`}
      </div>
      <div class="other-body">
        <div class="other-name">${m.name}</div>
        <div class="other-role">${m.title}</div>
      </div>
    </a>
  `).join('');
}

// ===== INIT =====
(function init() {
  if (!member) return;
  renderProfile(member);

  // Reveal observer
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if(e.isIntersecting) {
        e.target.classList.add('visible');
        obs.unobserve(e.target);
      }
    });
  }, {threshold: .08});
  document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
})();

// NAV SCROLL
window.addEventListener('scroll', () => {
  document.getElementById('navbar').classList.toggle('scrolled', window.scrollY > 40);
}, {passive:true});
</script>
@endpush
