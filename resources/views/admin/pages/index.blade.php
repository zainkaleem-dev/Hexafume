@extends('layouts.admin')

@section('title', 'Pages')
@section('page_title', 'Pages')
@section('breadcrumb', 'Pages')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/admin-projects.css') }}">
<style>
  /* Specific overrides for pages if needed */
  .proj-card-thumb {
    background: linear-gradient(135deg, var(--amber-subtle) 0%, var(--surface2) 100%);
  }
  .proj-card-thumb .thumb-letter {
    color: rgba(255, 170, 0, 0.1);
  }
  .status-pill.live { background: rgba(0,200,100,.15); color: var(--green); border: 1px solid rgba(0,200,100,.25); }
</style>
@endpush

@section('content')
<div class="toolbar">
  <div class="search-box">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" id="searchInput" placeholder="Search pages..." oninput="filterPages()"/>
  </div>
  <div class="filter-tabs">
    <button class="filter-tab active" onclick="setFilter('all', this)">All Pages</button>
    <button class="filter-tab" onclick="setFilter('Landing Page', this)">Landing</button>
    <button class="filter-tab" onclick="setFilter('Information Page', this)">Info</button>
    <button class="filter-tab" onclick="setFilter('Service Catalog', this)">Services</button>
  </div>
</div>

<div class="projects-grid" id="pagesGrid"></div>
@endsection

@push('page_scripts')
<script>
const pages = @json($pages ?? []);

let currentFilter = 'all';

function renderPages() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const grid = document.getElementById('pagesGrid');
  const filtered = pages.filter(p => {
    const matchFilter = currentFilter === 'all' || p.type === currentFilter;
    const matchSearch = !q || p.name.toLowerCase().includes(q) || p.type.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q);
    return matchFilter && matchSearch;
  });

  if (filtered.length === 0) {
    grid.innerHTML = `<div class="empty-state" style="grid-column:1/-1">
      <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
      <h3>No pages found</h3><p>Try adjusting your search or filter.</p>
    </div>`;
    return;
  }

  grid.innerHTML = filtered.map(p => `
    <div class="proj-card">
      <div class="proj-card-thumb">
        <span class="thumb-letter">${p.name.substring(0,2).toUpperCase()}</span>
        <span class="status-pill live">● Live</span>
      </div>
      <div class="proj-card-body">
        <div class="proj-card-type">${p.type}</div>
        <div class="proj-card-name">${p.name}</div>
        <div class="proj-card-desc">${p.desc}</div>
        <div class="proj-card-meta">
          <span class="meta-chip"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>${p.last_updated}</span>
          <span class="meta-chip"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>${p.author}</span>
        </div>
        <div class="proj-card-actions">
          <a href="/admin/pages/${p.slug}/edit" class="card-btn edit">✏ Edit Content</a>
          <a href="${p.url}" target="_blank" class="card-btn view">👁 View Page</a>
        </div>
      </div>
    </div>
  `).join('');
}

function filterPages() { renderPages(); }

function setFilter(val, el) {
  currentFilter = val;
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  renderPages();
}

renderPages();
</script>
@endpush
