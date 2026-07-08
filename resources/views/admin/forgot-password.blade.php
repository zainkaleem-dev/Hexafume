<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>Hexafume Admin â€” Forgot Password</title>
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
      <div class="logo-sub">Admin Reset</div>
    </div>
    @if (session('status'))
      <div class="error-msg show" id="errorMsg">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
        <span id="errorText">{{ session('status') }}</span>
      </div>
    @endif
    <form method="POST" action="{{ route('admin.password.email') }}" novalidate>
      @csrf
      <div class="form-group">
        <label for="email">Email Address</label>
        <div class="input-wrap">
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="admin@hexafume.com" autocomplete="email" required/>
          <span class="input-icon">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </span>
        </div>
      </div>
      <button type="submit" class="btn-login">
        <span class="btn-text">Send Reset Link</span>
        <div class="btn-spinner"></div>
      </button>
      <div class="form-row" style="justify-content:center; margin-top: 1rem;">
        <a href="{{ route('admin.login') }}" class="forgot-link">Back to login</a>
      </div>
    </form>
    <div class="login-footer">
      Â© {{ date('Y') }} Hexafume. Authorized access only.
    </div>
  </div>
</div>
</body>
</html>
