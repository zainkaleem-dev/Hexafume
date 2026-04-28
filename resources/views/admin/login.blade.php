<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Hexafume Admin — Login</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/admin-login.css') }}">
</head>
<body>
<div class="bg-layer">
  <div class="bg-grid"></div>
  <div class="bg-orb1"></div>
  <div class="bg-orb2"></div>
  <div class="bg-noise"></div>
</div>
<div class="login-wrap">
  <div class="login-card">
    <div class="logo-area">
      <div class="logo-badge">H</div>
      <div class="logo-title">HEXA<span class="dot">.</span>FUME</div>
      <div class="logo-sub">Admin Panel</div>
    </div>
    <div class="error-msg" id="errorMsg">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
      <span id="errorText">Invalid credentials. Please try again.</span>
    </div>
    <form id="loginForm" novalidate>
      <div class="form-group">
        <label for="email">Email Address</label>
        <div class="input-wrap">
          <input type="email" id="email" placeholder="admin@hexafume.com" autocomplete="email" required/>
          <span class="input-icon">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </span>
        </div>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <div class="input-wrap">
          <input type="password" id="password" placeholder="Enter your password" autocomplete="current-password" required/>
          <span class="input-icon">
            <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
          </span>
          <button type="button" class="toggle-pw" id="togglePw" aria-label="Toggle password visibility">
            <svg id="eyeIcon" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </button>
        </div>
      </div>
      <div class="form-row">
        <label class="checkbox-wrap">
          <input type="checkbox" id="remember"/>
          <span>Keep me signed in</span>
        </label>
        <a href="#" class="forgot-link">Forgot password?</a>
      </div>
      <button type="submit" class="btn-login" id="loginBtn">
        <span class="btn-text">Sign In</span>
        <div class="btn-spinner"></div>
      </button>
    </form>
    <div class="login-footer">
      © {{ date('Y') }} Hexafume. Authorized access only.
    </div>
  </div>
</div>
<script>
document.getElementById('togglePw').addEventListener('click', function() {
  const pw = document.getElementById('password');
  const icon = document.getElementById('eyeIcon');
  if (pw.type === 'password') {
    pw.type = 'text';
    icon.innerHTML = '<path d="M17.94 17.94A10.07 10.07 0 0112 20c-7 0-11-8-11-8a18.45 18.45 0 015.06-5.94M9.9 4.24A9.12 9.12 0 0112 4c7 0 11 8 11 8a18.5 18.5 0 01-2.16 3.19m-6.72-1.07a3 3 0 11-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>';
  } else {
    pw.type = 'password';
    icon.innerHTML = '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>';
  }
});
document.getElementById('loginForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = document.getElementById('loginBtn');
  const err = document.getElementById('errorMsg');
  const email = document.getElementById('email').value.trim();
  const password = document.getElementById('password').value;
  err.classList.remove('show');
  if (!email || !password) {
    document.getElementById('errorText').textContent = 'Please fill in all fields.';
    err.classList.add('show');
    return;
  }
  btn.classList.add('loading');
  setTimeout(() => {
    btn.classList.remove('loading');
    if (email === 'admin@hexafume.com' && password === 'admin123') {
      sessionStorage.setItem('hx_admin', '1');
      window.location.href = "{{ route('admin.dashboard') }}";
    } else {
      document.getElementById('errorText').textContent = 'Invalid email or password.';
      err.classList.add('show');
    }
  }, 1200);
});
</script>
</body>
</html>
