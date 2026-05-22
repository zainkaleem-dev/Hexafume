<!-- NAV -->
<nav id="navbar">
  <a href="{{ route('home') }}" class="nav-logo">
    <img src="{{ asset('images/hexafume/hexafume-white.png') }}" alt="Hexafume" style="height:70px;width:auto;object-fit:contain;filter:brightness(1.1);" onerror="this.style.display='none';this.nextElementSibling.style.display='flex'"/>
    <div class="nav-logo-icon" style="display:none;">H</div>
  </a>
  <ul class="nav-links">
    <li><a href="{{ route('home') }}">Home</a></li>
    <li><a href="{{ route('about') }}">About</a></li>
    <li><a href="{{ route('services') }}">Services</a></li>
    <li><a href="{{ route('process') }}">Process</a></li>
    <li><a href="{{ route('work') }}">Work</a></li>
    <li><a href="{{ route('team') }}">Team</a></li>
    <li><a href="{{ route('contact') }}">Contact</a></li>
  </ul>
  <a href="{{ route('contact') }}#contact" class="nav-cta">Get A Quote</a>
  <button class="hamburger" id="hamburger" aria-label="Open Navigation Menu">
    <span></span><span></span><span></span>
  </button>
</nav>

<!-- MOBILE MENU -->
<div class="mobile-menu" id="mobileMenu">
  <a href="{{ route('home') }}" onclick="closeMenu()">Home</a>
  <a href="{{ route('about') }}" onclick="closeMenu()">About</a>
  <a href="{{ route('services') }}" onclick="closeMenu()">Services</a>
  <a href="{{ route('process') }}" onclick="closeMenu()">Process</a>
  <a href="{{ route('work') }}" onclick="closeMenu()">Work</a>
  <a href="{{ route('team') }}" onclick="closeMenu()">Team</a>
  <a href="{{ route('contact') }}" onclick="closeMenu()">Contact</a>
</div>
