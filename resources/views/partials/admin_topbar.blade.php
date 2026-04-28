<header class="topbar">
  <div>
    <div class="topbar-breadcrumb">
      <span>Admin</span> › <span>@yield('breadcrumb', 'Dashboard')</span>
    </div>
    <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
  </div>
  <div class="topbar-right">
    @section('topbar_actions')
    <button class="topbar-btn" title="Search">
      <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    </button>
    <button class="topbar-btn" id="adminNotifBtn" title="Notifications" type="button">
      <svg viewBox="0 0 24 24"><path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0"/></svg>
      @if(($adminUnreadNotifications ?? 0) > 0)
        <span class="notif-dot" id="adminNotifDot"></span>
      @endif
      <span class="notif-count-badge" id="adminNotifCount" @if(($adminUnreadNotifications ?? 0) === 0) style="display:none;" @endif>{{ $adminUnreadNotifications ?? 0 }}</span>
    </button>
    <div class="notif-dropdown" id="adminNotifDropdown">
      <div class="notif-dropdown-header">
        <strong>Notifications</strong>
      </div>
      <div class="notif-dropdown-list">
        @forelse(($adminNotifications ?? collect()) as $notification)
          <a href="{{ $notification->link ?: '#' }}" class="notif-item">
            <div class="notif-item-title">{{ $notification->title }}</div>
            @if($notification->message)
              <div class="notif-item-message">{{ $notification->message }}</div>
            @endif
            <div class="notif-item-time">{{ optional($notification->created_at)->diffForHumans() }}</div>
          </a>
        @empty
          <div class="notif-empty">No notifications yet.</div>
        @endforelse
      </div>
    </div>
    <a href="{{ route('admin.projects.create') }}" class="add-project-btn">
      <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Project
    </a>
    @show
  </div>
</header>
