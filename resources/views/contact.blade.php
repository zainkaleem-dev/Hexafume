@extends('layouts.app')

@section('title', "Contact — Hexafume | Let's Start a Conversation")
@section('meta_description', "Get in touch with Hexafume. Tell us about your project and we'll get back to you within 24 hours. DHA 1, Islamabad — hello@hexafume.com — +92 315 088 4024")

@push('page_styles')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">
@endpush

@section('content')
<!-- PRELOADER -->
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
  $infoCol = $page->getSectionContent('info_col');
  $contactItems = $page->getSectionContent('contact_items');
  $socials = $page->getSectionContent('socials');
  $response = $page->getSectionContent('response_badge');
  $mapHeader = $page->getSectionContent('map_header');
  $officesHeader = $page->getSectionContent('offices_header');
  $offices = $page->getSectionContent('offices');
@endphp

<!-- HERO -->
<section class="page-hero">
  <div class="hero-grid-bg"></div>
  <div class="hero-orb"></div>
  <div class="page-hero-inner">
    <nav class="breadcrumb" aria-label="Breadcrumb"><a href="{{ route('home') }}">Home</a><span class="breadcrumb-sep">›</span><span>Contact</span></nav>
    <div class="section-badge" style="animation:fadeUp .7s .15s ease both;"><span class="dot"></span>{{ $hero['badge'] ?? 'Get In Touch' }}</div>
    <h1>{!! $hero['title'] ?? 'Let\'s Start a <span class="grad">Conversation</span>' !!}</h1>
    <p class="hero-sub">{{ $hero['subtitle'] ?? 'We\'re in the business of providing strategic digital solutions.' }}</p>
  </div>
</section>

<!-- CONTACT MAIN -->
<div class="contact-main">
  <!-- INFO -->
  <div class="contact-info-col reveal">
    <h2>{!! $infoCol['title'] ?? 'We\'d Love to <span class="grad">Hear From You</span>' !!}</h2>
    <p>{{ $infoCol['desc'] ?? 'Whether you have a project in mind, a question about our services, or just want to say hello — drop us a line.' }}</p>

    <div class="contact-items">
      @if(isset($contactItems['items']))
        @foreach($contactItems['items'] as $item)
          <div class="c-item">
            <div class="c-icon">
              @if(str_contains(strtolower($item['title']), 'office')) <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
              @elseif(str_contains(strtolower($item['title']), 'email')) <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
              @elseif(str_contains(strtolower($item['title']), 'phone') || str_contains(strtolower($item['title']), 'call')) <svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
              @else <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg> @endif
            </div>
            <div>
              <h4>{{ $item['title'] }}</h4>
              @if(isset($item['link']) && $item['link'] !== '#')
                <a href="{{ $item['link'] }}">{{ $item['value'] }}</a>
              @else
                <p>{{ $item['value'] }}</p>
              @endif
            </div>
          </div>
        @endforeach
      @endif
    </div>

    <div class="socials-row">
      @if(isset($socials['items']))
        @foreach($socials['items'] as $s)
          <a href="{{ $s['link'] }}" class="social-btn" aria-label="{{ $s['platform'] }}" target="_blank">
            @if(strtolower($s['platform']) === 'facebook') <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
            @elseif(strtolower($s['platform']) === 'twitter' || strtolower($s['platform']) === 'x') <svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg>
            @elseif(strtolower($s['platform']) === 'linkedin') <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
            @elseif(strtolower($s['platform']) === 'instagram') <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
            @else <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg> @endif
          </a>
        @endforeach
      @endif
    </div>

    <div class="response-badge">
      <div class="response-dot"></div>
      <p><strong>{{ $response['title'] ?? 'Typical response time: under 4 hours.' }}</strong> {{ $response['subtitle'] ?? 'Our team is active Monday–Friday.' }}</p>
    </div>
  </div>

  <!-- FORM -->
  <div class="contact-form-col reveal" style="transition-delay:.15s;">
    <div class="form-card">
      <h3>Send Us a Message</h3>
      <p>Fill in the details below and we'll get back to you with a tailored response.</p>
      <div id="formSuccess" class="form-success">
        <span class="form-success-icon">✅</span>
        <h3>Message Sent!</h3>
        <p>Thank you for reaching out. Our team will be in touch within 24 hours.</p>
      </div>
      <form id="contactForm">
        @csrf
        <div class="form-group"><label for="name">Full Name</label><input type="text" id="name" name="name" placeholder="John Smith" required/></div>
        <div class="form-row">
          <div class="form-group"><label for="email">Email Address</label><input type="email" id="email" name="email" placeholder="john@company.com" required/></div>
          <div class="form-group"><label for="phone">Phone Number</label><input type="tel" id="phone" name="phone" placeholder="+1 234 567 8900"/></div>
        </div>
        <div class="form-group"><label for="company">Company / Organisation</label><input type="text" id="company" name="company" placeholder="Your Company Name"/></div>
        <div class="form-group">
          <label for="service">Service You're Interested In</label>
          <select id="service" name="service" required>
            <option value="" disabled selected>Select a Service</option>
            <option>Web Design & Development</option>
            <option>Mobile App Development</option>
            <option>AI Integration & Automation</option>
            <option>Software Development / SaaS</option>
            <option>Blockchain & Web3</option>
            <option>Graphic & UI/UX Design</option>
            <option>Digital & Social Marketing</option>
            <option>DevOps Solutions</option>
            <option>Staff Augmentation</option>
            <option>Other / Not Sure Yet</option>
          </select>
        </div>
        <div class="form-group">
          <label for="budget">Estimated Budget</label>
          <select id="budget" name="budget">
            <option value="" disabled selected>Select a budget range</option>
            <option>Under $5,000</option>
            <option>$5,000 – $15,000</option>
            <option>$15,000 – $50,000</option>
            <option>$50,000 – $100,000</option>
            <option>$100,000+</option>
            <option>Not sure yet</option>
          </select>
        </div>
        <div class="form-group"><label for="message">Tell Us About Your Project</label><textarea id="message" name="message" placeholder="Describe your idea, goals, timeline, and any specific requirements..." required></textarea></div>
        <button type="submit" class="form-submit" id="submitBtn" aria-label="Send message">
          Send Message
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
        </button>
        <p class="form-note">By submitting this form you agree to our Privacy Policy. We never share your data.</p>
      </form>
    </div>
  </div>
</div>

<!-- MAP -->
<section class="map-strip">
  <div class="map-inner">
    <div class="map-head reveal">
      <div class="section-badge"><span class="dot"></span>{{ $mapHeader['badge'] ?? 'Find Us' }}</div>
      <h2>{!! $mapHeader['title'] ?? 'We\'re Based in <span class="grad">Islamabad</span>' !!}</h2>
      <p>{{ $mapHeader['subtitle'] ?? 'DHA Phase 1, Islamabad — serving clients across Pakistan and the globe.' }}</p>
    </div>
    <div class="map-frame reveal">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3318.6834!2d73.1492!3d33.5228!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x38dfbfd07891722f%3A0x6789f1f7a7b4e3c!2sDHA%20Phase%201%2C%20Islamabad%2C%20Pakistan!5e0!3m2!1sen!2s!4v1" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Hexafume Office Location"></iframe>
      <div class="map-overlay-badge">
        <div class="mb-icon"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg></div>
        <div><h4>Hexafume HQ</h4><p>DHA Phase 1, Islamabad, PK</p></div>
      </div>
    </div>
  </div>
</section>

<!-- OFFICES -->
<section class="offices-section">
  <div class="offices-head reveal">
    <div class="section-badge"><span class="dot"></span>{{ $officesHeader['badge'] ?? 'Our Presence' }}</div>
    <h2 class="section-title">{!! $officesHeader['title'] ?? 'Where We <span class="grad">Operate</span>' !!}</h2>
  </div>
  <div class="offices-grid">
    @if(isset($offices['items']))
      @foreach($offices['items'] as $i => $off)
        <div class="office-card reveal" style="transition-delay:{{ $i * 0.08 }}s;">
          <span class="office-flag">{{ $off['flag'] ?? '' }}</span>
          <h3>{{ $off['city'] ?? $off['name'] ?? '' }}</h3>
          <p>{!! nl2br(e($off['details'] ?? $off['address'] ?? '')) !!}</p>
          <div class="office-status"><span class="sdot"></span><span style="color:#00e676;font-size:.65rem;font-weight:600;">{{ $off['status'] ?? '' }}</span></div>
        </div>
      @endforeach
    @endif
  </div>
</section>
@endsection

@push('page_scripts')
<script>
// FORM SUBMIT
document.getElementById('contactForm').addEventListener('submit', async (e) => {
  e.preventDefault();
  const form = e.target;
  const btn = document.getElementById('submitBtn');
  const origHtml = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<span class="loading-spinner"></span> Sending...';
  const formData = new FormData(form);
  const data = Object.fromEntries(formData.entries());
  
  try {
    const res = await fetch('/contact', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': data._token
      },
      body: JSON.stringify(data)
    });
    
    if (!res.ok) throw new Error('Server error');
    const result = await res.json();
    
    if (result.success) {
      form.style.display = 'none';
      document.getElementById('formSuccess').style.display = 'block';
    } else {
      throw new Error(result.message || 'Failed to send message');
    }
  } catch (err) {
    btn.innerHTML = '✖ Error. Try again.';
    btn.style.background = '#dd3333';
    setTimeout(() => {
      btn.disabled = false;
      btn.innerHTML = origHtml;
      btn.style.background = '';
    }, 4000);
  }
});
</script>
@endpush
