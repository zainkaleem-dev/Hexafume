@extends('layouts.admin')

@section('title', 'Projects')
@section('page_title', 'Projects')
@section('breadcrumb', 'Projects')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/admin-projects.css') }}">
@endpush

@section('content')
<div class="toolbar">
  <div class="search-box">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" id="searchInput" placeholder="Search projects..." oninput="filterProjects()"/>
  </div>
  <div class="filter-tabs">
    <button class="filter-tab active" onclick="setFilter('all', this)">All</button>
    <button class="filter-tab" onclick="setFilter('live', this)">Live</button>
    <button class="filter-tab" onclick="setFilter('progress', this)">In Progress</button>
    <button class="filter-tab" onclick="setFilter('review', this)">Review</button>
  </div>
</div>

<div class="projects-grid" id="projectsGrid"></div>

<!-- DELETE MODAL -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <div class="modal-icon"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></div>
    <h3>Delete Project?</h3>
    <p>This will permanently delete <strong id="deleteProjectName"></strong> and all its data from the database. This action cannot be undone.</p>
    <div class="modal-btns">
      <button class="modal-btn cancel" onclick="closeDeleteModal()">Cancel</button>
      <button class="modal-btn confirm-del" onclick="confirmDelete()">Delete Project</button>
    </div>
  </div>
</div>
@endsection

@push('page_scripts')
<script>
const projects = @json($projects ?? []);

let currentFilter = 'all';
let deleteId = null;

function renderProjects() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const grid = document.getElementById('projectsGrid');
  const filtered = projects.filter(p => {
    const matchFilter = currentFilter === 'all' || p.status === currentFilter;
    const matchSearch = !q || p.name.toLowerCase().includes(q) || p.type.toLowerCase().includes(q) || p.category.toLowerCase().includes(q);
    return matchFilter && matchSearch;
  });

  if (filtered.length === 0) {
    grid.innerHTML = `<div class="empty-state" style="grid-column:1/-1">
      <svg viewBox="0 0 24 24"><path d="M22 19a2 2 0 01-2 2H4a2 2 0 01-2-2V5a2 2 0 012-2h5l2 3h9a2 2 0 012 2z"/></svg>
      <h3>No projects found</h3><p>Try adjusting your search or filter.</p>
    </div>`;
    return;
  }

  grid.innerHTML = filtered.map(p => `
    <div class="proj-card">
      <div class="proj-card-thumb">
        ${p.logo_image_url 
          ? `<img src="${p.logo_image_url}" alt="${p.name}" class="proj-thumb-img">`
          : `<span class="thumb-letter">${p.name.substring(0,2).toUpperCase()}</span>`
        }
        <span class="status-pill ${p.status}">${p.status === 'live' ? '● Live' : p.status === 'progress' ? '◐ In Progress' : p.status === 'review' ? '◑ Review' : p.status}</span>
      </div>
      <div class="proj-card-body">
        <div class="proj-card-type">${p.type}</div>
        <div class="proj-card-name">${p.name}</div>
        <div class="proj-card-desc">${p.desc}</div>
        <div class="proj-card-meta">
          <span class="meta-chip"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>${p.timeline}</span>
          <span class="meta-chip"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>${p.team}</span>
          <span class="meta-chip">${p.category}</span>
        </div>
        <div class="proj-card-actions">
          <a href="/admin/projects/${p.id}/edit" class="card-btn edit">✏ Edit</a>
          <button class="card-btn delete" onclick='openDeleteModal(${p.id}, ${JSON.stringify(p.name)})'>🗑 Delete</button>
        </div>
      </div>
    </div>
  `).join('');
}

function filterProjects() { renderProjects(); }

function setFilter(val, el) {
  currentFilter = val;
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  renderProjects();
}

function openDeleteModal(id, name) {
  deleteId = id;
  document.getElementById('deleteProjectName').textContent = name;
  document.getElementById('deleteModal').classList.add('show');
}
function closeDeleteModal() {
  deleteId = null;
  document.getElementById('deleteModal').classList.remove('show');
}
async function confirmDelete() {
  if (!deleteId) return;

  const btn = document.querySelector('#deleteModal .confirm-del');
  const prevText = btn.textContent;
  btn.disabled = true;
  btn.textContent = 'Deleting...';

  try {
    const response = await fetch(`/admin/projects/${deleteId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
    });

    const result = await response.json();
    if (!response.ok || !result.success) {
      throw new Error(result.message || 'Failed to delete project.');
    }

    const idx = projects.findIndex(p => p.id === deleteId);
    if (idx > -1) projects.splice(idx, 1);

    if (result.notification && typeof window.showAdminNotificationToast === 'function') {
      window.showAdminNotificationToast(result.notification.title, result.notification.message);
    }

    closeDeleteModal();
    renderProjects();
  } catch (err) {
    alert(err.message || 'An error occurred while deleting this project.');
  } finally {
    btn.disabled = false;
    btn.textContent = prevText;
  }
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteModal();
});

renderProjects();
</script>
@endpush
