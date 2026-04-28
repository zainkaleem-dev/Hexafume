<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('title', 'Admin Dashboard') — Hexafume Admin</title>
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
<style>
:root {
  --bg: #04040a;
  --surface: #080810;
  --surface2: #0c0c18;
  --surface3: #101020;
  --blue: #4d4dff;
  --blue-b: #6e6eff;
  --blue-glow: rgba(77,77,255,0.22);
  --blue-subtle: rgba(77,77,255,0.06);
  --border: rgba(255,255,255,0.06);
  --border-b: rgba(77,77,255,0.28);
  --white: #ffffff;
  --w80: rgba(255,255,255,0.8);
  --w60: rgba(255,255,255,0.6);
  --w40: rgba(255,255,255,0.4);
  --w20: rgba(255,255,255,0.2);
  --w10: rgba(255,255,255,0.07);
  --w05: rgba(255,255,255,0.04);
  --sidebar-w: 240px;
  --header-h: 64px;
  --green: #00c864;
  --amber: #ffaa00;
  --red: #ff4d6a;
  --font-display: 'Syne', sans-serif;
  --font-body: 'DM Sans', sans-serif;
  --radius: 14px;
}

/* Bright, fresh admin theme */
:root[data-admin-theme="fresh"] {
  /* 3-color core: light canvas, deep ink, vivid accent */
  --bg: #f8fafc;
  --surface: #ffffff;
  --surface2: #f1f5f9;
  --surface3: #e2e8f0;
  --blue: #ff6b00;
  --blue-b: #ff8a3d;
  --blue-glow: rgba(255,107,0,0.22);
  --blue-subtle: rgba(255,107,0,0.12);
  --border: rgba(15,23,42,0.16);
  --border-b: rgba(255,107,0,0.42);
  --white: #0f172a;
  --w80: rgba(15,23,42,0.85);
  --w60: rgba(15,23,42,0.68);
  --w40: rgba(15,23,42,0.52);
  --w20: rgba(15,23,42,0.28);
  --w10: rgba(15,23,42,0.14);
  --w05: rgba(15,23,42,0.07);
  --green: #15803d;
  --amber: #b45309;
  --red: #dc2626;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html, body { height: 100%; }
body {
  background: var(--bg);
  color: var(--white);
  font-family: var(--font-body);
  font-size: 14px;
  line-height: 1.6;
  overflow-x: hidden;
}
a { text-decoration: none; color: inherit; }
button { cursor: pointer; font-family: var(--font-body); }

/* LAYOUT */
.admin-layout { display: flex; min-height: 100vh; }

/* SIDEBAR */
.sidebar {
  width: var(--sidebar-w);
  background: var(--surface);
  border-right: 1px solid var(--border);
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0; left: 0; bottom: 0;
  z-index: 100;
  transition: transform .3s ease;
}
.sidebar-logo { display: flex; align-items: center; gap: .75rem; padding: 1.4rem 1.5rem; border-bottom: 1px solid var(--border); }
.sidebar-logo-img { height: 36px; width: auto; object-fit: contain; }
.sidebar-logo-img--white { display: block; filter: brightness(1.1); }
.sidebar-logo-img--original { display: none; }
:root[data-admin-theme="fresh"] .sidebar-logo-img--white { display: none; }
:root[data-admin-theme="fresh"] .sidebar-logo-img--original { display: block; }
.logo-icon { width: 36px; height: 36px; background: linear-gradient(135deg, var(--blue), var(--blue-b)); border-radius: 10px; display: flex; align-items: center; justify-content: center; font-family: var(--font-display); font-weight: 800; font-size: 1rem; color: #fff; box-shadow: 0 0 18px var(--blue-glow); flex-shrink: 0; }
.logo-name { font-family: var(--font-display); font-weight: 700; font-size: .95rem; letter-spacing: .04em; }
.logo-name .dot { color: var(--blue-b); }
.logo-badge { margin-left: auto; font-size: .6rem; letter-spacing: .1em; text-transform: uppercase; background: var(--blue-subtle); border: 1px solid var(--border-b); color: var(--blue-b); padding: .18rem .55rem; border-radius: 100px; }

.sidebar-nav { flex: 1; padding: 1.2rem 0; overflow-y: auto; }
.nav-section-label { font-size: .65rem; letter-spacing: .14em; text-transform: uppercase; color: var(--w40); padding: .8rem 1.5rem .35rem; font-weight: 600; }
.nav-item { display: flex; align-items: center; gap: .7rem; padding: .65rem 1.5rem; color: var(--w60); font-size: .85rem; font-weight: 500; transition: color .2s, background .2s; position: relative; cursor: pointer; }
.nav-item svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 1.7; flex-shrink: 0; }
.nav-item:hover { color: var(--white); background: var(--w05); }
.nav-item.active { color: var(--white); background: var(--blue-subtle); }
.nav-item.active::before { content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 2px; background: var(--blue-b); border-radius: 0 2px 2px 0; }
.nav-badge { margin-left: auto; font-size: .65rem; background: var(--blue); color: #fff; padding: .1rem .5rem; border-radius: 100px; font-weight: 600; }

.sidebar-bottom { padding: 1rem 1.2rem; border-top: 1px solid var(--border); }
.user-row { display: flex; align-items: center; gap: .7rem; padding: .5rem; border-radius: 10px; transition: background .2s; cursor: pointer; }
.user-row:hover { background: var(--w05); }
.user-avatar { width: 34px; height: 34px; background: linear-gradient(135deg, var(--blue), var(--blue-b)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .8rem; flex-shrink: 0; }
.user-info { flex: 1; min-width: 0; }
.user-name { font-size: .82rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.user-role { font-size: .7rem; color: var(--w40); }
.logout-btn { background: none; border: none; color: var(--w40); padding: .3rem; border-radius: 6px; transition: color .2s, background .2s; display: flex; align-items: center; }
.logout-btn:hover { color: var(--red); background: rgba(255,77,106,.06); }
.logout-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 1.7; }

/* MAIN CONTENT */
.main-content { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; min-height: 100vh; }

/* TOPBAR */
.topbar { height: var(--header-h); background: var(--surface); border-bottom: 1px solid var(--border); display: flex; align-items: center; padding: 0 2rem; gap: 1rem; position: sticky; top: 0; z-index: 50; }
.topbar-title { font-family: var(--font-display); font-weight: 700; font-size: 1rem; letter-spacing: -.01em; }
.topbar-breadcrumb { font-size: .75rem; color: var(--w40); display: flex; align-items: center; gap: .4rem; }
.topbar-breadcrumb span { color: var(--w60); }
.topbar-right { margin-left: auto; display: flex; align-items: center; gap: .8rem; }
.topbar-btn { width: 36px; height: 36px; background: var(--surface2); border: 1px solid var(--border); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: var(--w60); transition: all .2s; position: relative; }
.topbar-btn:hover { background: var(--surface3); border-color: var(--border-b); color: var(--white); }
.topbar-btn svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 1.7; }
.notif-dot { position: absolute; top: 6px; right: 6px; width: 6px; height: 6px; background: var(--red); border-radius: 50%; border: 1.5px solid var(--surface); }
.notif-count-badge { position: absolute; top: -5px; right: -5px; min-width: 16px; height: 16px; border-radius: 999px; background: var(--red); color: #fff; font-size: .58rem; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; padding: 0 4px; }
.notif-dropdown { position: absolute; top: calc(var(--header-h) - 10px); right: 86px; width: 320px; max-height: 360px; overflow: hidden; background: var(--surface); border: 1px solid var(--border); border-radius: 12px; box-shadow: 0 16px 40px rgba(0,0,0,.4); z-index: 80; opacity: 0; pointer-events: none; transform: translateY(-8px); transition: all .2s ease; }
.notif-dropdown.show { opacity: 1; pointer-events: auto; transform: translateY(0); }
.notif-dropdown-header { padding: .75rem .85rem; border-bottom: 1px solid var(--border); font-size: .78rem; color: var(--w80); }
.notif-dropdown-list { max-height: 300px; overflow: auto; }
.notif-item { display: block; padding: .7rem .85rem; border-bottom: 1px solid var(--w05); }
.notif-item:hover { background: var(--w05); }
.notif-item-title { font-size: .75rem; color: var(--white); font-weight: 600; }
.notif-item-message { font-size: .72rem; color: var(--w60); margin-top: .15rem; }
.notif-item-time { font-size: .65rem; color: var(--w40); margin-top: .2rem; }
.notif-empty { padding: .9rem; font-size: .73rem; color: var(--w40); text-align: center; }
.admin-floating-toast { position: fixed; right: 20px; bottom: 20px; z-index: 300; min-width: 260px; max-width: 360px; background: var(--surface); border: 1px solid var(--border-b); border-radius: 10px; padding: .75rem .9rem; box-shadow: 0 12px 30px rgba(0,0,0,.35); opacity: 0; transform: translateY(8px); transition: all .2s ease; }
.admin-floating-toast.show { opacity: 1; transform: translateY(0); }
.admin-floating-toast-title { font-size: .78rem; font-weight: 700; margin-bottom: .15rem; }
.admin-floating-toast-message { font-size: .72rem; color: var(--w60); }
.add-project-btn { display: flex; align-items: center; gap: .5rem; background: var(--blue); color: #fff; border: none; border-radius: 9px; padding: .55rem 1.1rem; font-size: .78rem; font-weight: 600; letter-spacing: .04em; transition: box-shadow .2s, background .2s; }
.add-project-btn:hover { background: var(--blue-b); box-shadow: 0 0 20px var(--blue-glow); }
.add-project-btn svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 2; }

/* PAGE BODY */
.page-body { padding: 2rem; flex: 1; }

@keyframes fadeUp { from { opacity: 0; transform: translateY(18px); } to { opacity: 1; transform: translateY(0); } }

/* SCROLLBAR */
::-webkit-scrollbar { width: 5px; }
::-webkit-scrollbar-track { background: transparent; }
::-webkit-scrollbar-thumb { background: var(--w20); border-radius: 10px; }

</style>
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@stack('page_styles')
</head>
<body>

<div class="admin-layout">
  @include('partials.admin_sidebar')
  <div class="main-content">
    @include('partials.admin_topbar')
    <div class="page-body">
      @yield('content')
    </div>
  </div>
</div>

<script>
function logout() {
  sessionStorage.removeItem('hx_admin');
  window.location.href = "{{ route('admin.login') }}";
}
// Check auth
if (!sessionStorage.getItem('hx_admin') && window.location.pathname !== "{{ route('admin.login') }}") {
  // window.location.href = "{{ route('admin.login') }}";
}

(function () {
  const notifBtn = document.getElementById('adminNotifBtn');
  const notifDropdown = document.getElementById('adminNotifDropdown');
  if (notifBtn && notifDropdown) {
    notifBtn.addEventListener('click', function (e) {
      e.stopPropagation();
      notifDropdown.classList.toggle('show');
    });
    document.addEventListener('click', function (e) {
      if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
        notifDropdown.classList.remove('show');
      }
    });
  }
})();

window.showAdminNotificationToast = function (title, message) {
  const toast = document.createElement('div');
  toast.className = 'admin-floating-toast';
  toast.innerHTML = `
    <div class="admin-floating-toast-title">${title || 'Notification'}</div>
    <div class="admin-floating-toast-message">${message || ''}</div>
  `;
  document.body.appendChild(toast);
  requestAnimationFrame(() => toast.classList.add('show'));
  setTimeout(() => {
    toast.classList.remove('show');
    setTimeout(() => toast.remove(), 250);
  }, 3200);
};

(function initAdminThemeToggle() {
  const THEME_KEY = 'hx_admin_theme';
  const root = document.documentElement;
  const toggle = document.getElementById('adminThemeToggle');
  const badge = document.getElementById('adminThemeBadge');
  const label = document.getElementById('adminThemeLabel');

  function applyTheme(theme) {
    if (theme === 'fresh') {
      root.setAttribute('data-admin-theme', 'fresh');
    } else {
      root.removeAttribute('data-admin-theme');
    }

    if (badge) {
      badge.textContent = theme === 'fresh' ? 'Fresh' : 'Dark';
    }
    if (label) {
      label.textContent = 'Theme';
    }
  }

  const savedTheme = localStorage.getItem(THEME_KEY) || 'dark';
  applyTheme(savedTheme);

  if (toggle) {
    toggle.addEventListener('click', function (e) {
      e.preventDefault();
      const current = root.getAttribute('data-admin-theme') === 'fresh' ? 'fresh' : 'dark';
      const next = current === 'fresh' ? 'dark' : 'fresh';
      localStorage.setItem(THEME_KEY, next);
      applyTheme(next);
    });
  }
})();
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Generic Swal for Add/Publish buttons
document.addEventListener('click', function(e) {
  const btn = e.target.closest('.publish-btn, .add-project-btn, .save-draft-btn, .add-item-btn, .add-member-btn, .form-submit');
  if (btn && !btn.disabled && !btn.hasAttribute('data-no-swal')) {
    const action = btn.innerText.trim() || 'Action';
    const pageContext = document.querySelector('.topbar-title')?.innerText || document.title;
    
    // Show a quick toast to acknowledge the click as requested
    window.adminToast('info', 'Processing ' + action, 'Working on ' + pageContext);
  }
});

window.adminActionNotify = function(action, context) {
    const ctx = context || document.querySelector('.topbar-title')?.innerText || 'Record';
    Swal.fire({
        title: action + '...',
        text: 'Working on ' + ctx + '. Please wait.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
};

window.adminToast = function(icon, title, text) {
  Swal.fire({
    icon: icon,
    title: title,
    text: text,
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
  });
};
</script>

@stack('page_scripts')
</body>
</html>
