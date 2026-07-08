<aside class="sidebar">
  <div class="sidebar-logo">
    <img src="{{ asset('images/hexafume/hexafume-white.png') }}" alt="Hexafume" class="sidebar-logo-img sidebar-logo-img--white">
    <img src="{{ asset('images/hexafume/hexafume-original.png') }}" alt="Hexafume" class="sidebar-logo-img sidebar-logo-img--original">
    <span class="logo-badge">Admin</span>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section-label">Main</div>
    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>
    <a href="{{ route('admin.projects.index') }}" class="nav-item {{ request()->routeIs('admin.projects.index') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
      Projects
      <span class="nav-badge">{{ $adminProjectCount ?? 0 }}</span>
    </a>
    <a href="{{ route('admin.projects.create') }}" class="nav-item {{ request()->routeIs('admin.projects.create') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
      Add Project
    </a>

    <div class="nav-section-label">Content</div>
    <a href="{{ route('admin.pages.index') }}" class="nav-item {{ request()->routeIs('admin.pages.index') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
      Pages
    </a>
    <a href="{{ route('admin.team.index') }}" class="nav-item {{ request()->routeIs('admin.team.index') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
      Team
      <span class="nav-badge">{{ $adminTeamCount ?? 0 }}</span>
    </a>
    <a href="{{ route('admin.team-members.create') }}" class="nav-item {{ request()->routeIs('admin.team-members.create') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20a8 8 0 0116 0"/><line x1="19" y1="6" x2="19" y2="12"/><line x1="16" y1="9" x2="22" y2="9"/></svg>
      Add Team Member
    </a>
    <a href="{{ route('admin.messages.index') }}" class="nav-item {{ request()->routeIs('admin.messages.index') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z"/></svg>
      Messages
      <span class="nav-badge">{{ $adminMessageCount ?? 0 }}</span>
    </a>

    <div class="nav-section-label">System</div>
    <a href="#" id="adminThemeToggle" class="nav-item">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2M12 20v2M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41M20 12h2M2 12h2"/></svg>
      <span id="adminThemeLabel">Theme</span>
      <span id="adminThemeBadge" class="nav-badge">Dark</span>
    </a>
    <a href="{{ route('admin.tools.index') }}" class="nav-item {{ request()->routeIs('admin.tools.*') ? 'active' : '' }}">
      <svg viewBox="0 0 24 24"><path d="M14.7 6.3l3 3M5 19l6.5-6.5m1.5-6.5l3 3-3.5 3.5-3-3L12 5.5z"/><path d="M14.5 3.5l6 6-2 2-6-6z"/></svg>
      System Tools
    </a>
  </nav>

  <div class="sidebar-bottom">
    <div class="user-row">
      <div class="user-avatar">A</div>
      <div class="user-info">
        <div class="user-name">Admin User</div>
        <div class="user-role">Super Admin</div>
      </div>
      <button class="logout-btn" onclick="logout()" title="Logout">
        <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4M16 17l5-5-5-5M21 12H9"/></svg>
      </button>
    </div>
  </div>
</aside>
