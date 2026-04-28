@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard')
@section('breadcrumb', 'Dashboard')

@section('content')
<div class="greeting">
  <div class="greeting-eyebrow">{{ date('l, F d, Y') }}</div>
  <h1>Good morning, Admin. <span>Here's what's happening.</span></h1>
</div>

<!-- STATS -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-header">
      <span class="stat-label">Total Projects</span>
      <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg></div>
    </div>
    <div class="stat-value">{{ $totalProjects ?? 0 }}</div>
    <div class="stat-trend"><span class="up">↑ {{ $recentProjectAdds ?? 0 }}</span> added this month</div>
  </div>
  <div class="stat-card">
    <div class="stat-header">
      <span class="stat-label">Live Projects</span>
      <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
    </div>
    <div class="stat-value">{{ $liveProjects ?? 0 }}</div>
    <div class="stat-trend"><span class="up">↑ {{ $recentLive ?? 0 }}</span> went live recently</div>
  </div>
  <div class="stat-card">
    <div class="stat-header">
      <span class="stat-label">In Progress</span>
      <div class="stat-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
    </div>
    <div class="stat-value">{{ $inProgressProjects ?? 0 }}</div>
    <div class="stat-trend">Active sprints running</div>
  </div>
  <div class="stat-card">
    <div class="stat-header">
      <span class="stat-label">Team Members</span>
      <div class="stat-icon"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg></div>
    </div>
    <div class="stat-value">{{ $teamMembers ?? 0 }}</div>
    <div class="stat-trend">Across {{ $teamDepartments ?? 0 }} departments</div>
  </div>
</div>

<!-- CONTENT GRID -->
<div class="content-grid">

  <!-- PROJECTS TABLE -->
  <div>
    <div class="section-hd">
      <h2>Recent Projects</h2>
      <a href="{{ route('admin.projects.index') }}" class="section-link">View All →</a>
    </div>
    <div class="projects-table">
      <div class="table-head">
        <span>Project</span>
        <span>Type</span>
        <span>Timeline</span>
        <span>Status</span>
        <span>Actions</span>
      </div>
      @forelse(($recentProjects ?? collect()) as $project)
      <div class="table-row">
        <div class="proj-name-wrap">
          <div class="proj-thumb">{{ strtoupper(substr($project->name, 0, 2)) }}</div>
          <div>
            <div class="proj-name">{{ $project->name }}</div>
            <div class="proj-type">{{ $project->type }}</div>
          </div>
        </div>
        <div class="tbl-val">{{ $project->type }}</div>
        <div class="tbl-val">{{ optional($project->start_date)->format('M Y') }} - {{ optional($project->finish_date)->format('M Y') }}</div>
        <div><span class="status-badge {{ $project->status }}"><span class="status-dot"></span>{{ ucfirst($project->status) }}</span></div>
        <div class="tbl-actions">
          <a href="{{ route('admin.projects.edit', $project) }}" class="tbl-action-btn" title="Edit">
            <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
          </a>
          <button class="tbl-action-btn" title="Delete">
            <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
          </button>
        </div>
      </div>
      @empty
      <div class="table-row">
        <div class="tbl-val" style="grid-column: 1 / -1;">No projects found.</div>
      </div>
      @endforelse
    </div>
  </div>

  <!-- RIGHT COL -->
  <div class="right-col">

    <!-- QUICK ACTIONS -->
    <div class="quick-card">
      <div class="section-hd"><h2>Quick Actions</h2></div>
      <div class="quick-list">
        <a href="{{ route('admin.projects.create') }}" class="quick-item">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
          Add New Project
          <span class="arr">→</span>
        </a>
        <a href="{{ route('admin.projects.index') }}" class="quick-item">
          <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
          Manage Projects
          <span class="arr">→</span>
        </a>
        <a href="{{ route('admin.team.index') }}" class="quick-item">
          <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
          Manage Team
          <span class="arr">→</span>
        </a>
        <a href="{{ route('admin.team-members.create') }}" class="quick-item">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20a8 8 0 0116 0"/><line x1="19" y1="6" x2="19" y2="12"/><line x1="16" y1="9" x2="22" y2="9"/></svg>
          Add Team Member
          <span class="arr">→</span>
        </a>
        <a href="#" class="quick-item">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93l-1.41 1.41M4.93 4.93l1.41 1.41M12 2v2M12 20v2M4.93 19.07l1.41-1.41M19.07 19.07l-1.41-1.41M20 12h2M2 12h2"/></svg>
          Site Settings
          <span class="arr">→</span>
        </a>
      </div>
    </div>

    <!-- RECENT ACTIVITY -->
    <div class="activity-card">
      <div class="section-hd"><h2>Recent Activity</h2></div>
      <div class="activity-list">
        @forelse(($recentActivity ?? collect()) as $activity)
        <div class="activity-item">
          <div class="act-icon {{ $activity['type'] === 'live' ? 'green' : ($activity['type'] === 'team' ? 'amber' : 'blue') }}">
            @if($activity['type'] === 'live')
              <svg viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            @elseif($activity['type'] === 'team')
              <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            @else
              <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
            @endif
          </div>
          <div class="act-text">
            <strong>{{ $activity['text'] }}</strong>
            <span>{{ $activity['time'] }}</span>
          </div>
        </div>
        @empty
        <div class="activity-item">
          <div class="act-text">
            <strong>No activity yet</strong>
            <span>New updates will show here.</span>
          </div>
        </div>
        @endforelse
      </div>
    </div>
  </div>
</div>

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@push('page_scripts')
<script>
// Dashboard specific interactions
</script>
@endpush
@endsection
