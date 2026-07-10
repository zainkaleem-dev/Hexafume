<!-- FOOTER -->
<footer>
  <div class="footer-brand footer-col">
    <div class="footer-brand-name" style="height:70px !important;">
      <img class="footer-logo-img" src="{{ asset('images/hexafume/hexafume-white.png') }}" alt="Hexafume" onerror="this.style.display='none';this.nextElementSibling.style.display='inline'"/>
      <span style="display:none;">HEXA<span class="dot">FUME</span></span>
    </div>
    <p>We're in the business of providing strategic digital solutions. Since our inception, we've delivered 300+ projects that enable brands to connect globally.</p>
  </div>
  <div class="footer-col">
    <h4>Services</h4>
    <ul>
      <li><a href="{{ route('services') }}">Web Development</a></li>
      <li><a href="{{ route('services') }}">Mobile Apps</a></li>
      <li><a href="{{ route('services') }}">AI Integration</a></li>
      <li><a href="{{ route('services') }}">Blockchain & Web3</a></li>
      <li><a href="{{ route('services') }}">DevOps Solutions</a></li>
    </ul>
  </div>
  <div class="footer-col">
    <h4>Company</h4>
    <ul>
      <li><a href="{{ route('about') }}">About Us</a></li>
      <li><a href="{{ route('process') }}">Our Process</a></li>
      <li><a href="#">Careers</a></li>
      <li><a href="{{ route('work') }}">Case Studies</a></li>
      <li><a href="{{ route('contact') }}">Contact Us</a></li>
    </ul>
  </div>
  <div class="footer-col">
    <h4>Legal</h4>
    <ul>
      <li><a href="#">Privacy Policy</a></li>
      <li><a href="#">Terms of Service</a></li>
      <li><a href="#">Cookie Policy</a></li>
    </ul>
  </div>
</footer>
<div class="footer-bottom">
  <span>© {{ date('Y') }} Hexafume. All rights reserved.</span>
  <span>Built for teams who think big.</span>
</div>
