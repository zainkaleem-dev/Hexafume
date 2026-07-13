<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('title', 'Hexafume — Think Big | IT Services & Digital Solutions')</title>
<meta name="description" content="@yield('meta_description', 'Hexafume - Pioneering digital excellence through Agentic AI, high-performance SaaS platforms, and custom software development.')">
<meta name="keywords" content="@yield('meta_keywords', 'Agentic AI, SaaS Development, Software Company, AI Automation, Web Development Islamabad, Custom Software Solutions, Hexafume')">
<meta name="robots" content="index, follow">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Favicon -->
<link rel="icon" type="image/png" href="{{ asset('images/hexafume/hexafume-white.png') }}">
<link rel="apple-touch-icon" href="{{ asset('images/hexafume/hexafume-white.png') }}">

<!-- Social Media (Open Graph & Twitter) -->
<meta property="og:site_name" content="Hexafume">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title', 'Hexafume — Think Big | IT Services & Digital Solutions')">
<meta property="og:description" content="@yield('meta_description', 'Pioneering digital excellence through Agentic AI, SaaS, and custom software development.')">
<meta property="og:image" content="{{ asset('images/hexafume/hexafume-original.png') }}">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="@yield('title', 'Hexafume — Think Big | IT Services & Digital Solutions')">
<meta name="twitter:description" content="@yield('meta_description', 'Pioneering digital excellence through Agentic AI, SaaS, and custom software development.')">
<meta name="twitter:image" content="{{ asset('images/hexafume/hexafume-original.png') }}">

<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Structured Data (JSON-LD) -->
@yield('structured_data')

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<link rel="stylesheet" href="{{ asset('css/main.css') }}?v={{ filemtime(public_path('css/main.css')) }}">

@stack('page_styles')
