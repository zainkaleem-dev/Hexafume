@extends('layouts.admin')

@section('title', 'Team Members')
@section('page_title', 'Team Members')
@section('breadcrumb', 'Team')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/admin-team.css') }}">
@endpush

@section('content')
<div class="toolbar">
  <div class="search-box">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" id="searchInput" placeholder="Search team members..." oninput="filterMembers()"/>
  </div>
  <div class="filter-tabs">
    <button class="filter-tab active" onclick="setFilter('all', this)">All</button>
    <button class="filter-tab" onclick="setFilter('leadership', this)">Leadership</button>
    <button class="filter-tab" onclick="setFilter('engineering', this)">Engineering</button>
    <button class="filter-tab" onclick="setFilter('design', this)">Design</button>
    <button class="filter-tab" onclick="setFilter('product', this)">Product</button>
    <button class="filter-tab" onclick="setFilter('marketing', this)">Marketing</button>
  </div>
  <a href="{{ route('admin.team-members.create') }}" class="add-member-btn">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="8" r="4"/><path d="M4 20a8 8 0 0116 0"/><line x1="19" y1="6" x2="19" y2="12"/><line x1="16" y1="9" x2="22" y2="9"/></svg>
    Add Member
  </a>
</div>

<div class="stats-row">
  <div class="stat-card">
    <div class="stat-icon blue">
      <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-num" id="totalCount">0</div>
      <div class="stat-label">Total Members</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green">
      <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-num" id="activeCount">0</div>
      <div class="stat-label">Active</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon amber">
      <svg viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-num" id="featuredCount">0</div>
      <div class="stat-label">Featured</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon purple">
      <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-num" id="deptCount">0</div>
      <div class="stat-label">Departments</div>
    </div>
  </div>
</div>

<div class="team-grid" id="teamGrid"></div>

<!-- DELETE MODAL -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <div class="modal-icon">
      <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
    </div>
    <h3>Remove Team Member?</h3>
    <p>This will permanently remove <strong id="deleteMemberName"></strong> from the team. This action cannot be undone.</p>
    <div class="modal-btns">
      <button class="modal-btn cancel" onclick="closeDeleteModal()">Cancel</button>
      <button class="modal-btn confirm-del" onclick="confirmDelete()">Remove Member</button>
    </div>
  </div>
</div>
@endsection

@push('page_scripts')
<script>
const members = @json($members ?? []);

let currentFilter = 'all';
let deleteId = null;

function updateStats() {
  document.getElementById('totalCount').textContent = members.length;
  document.getElementById('activeCount').textContent = members.filter(m => m.visibility === 'public').length;
  document.getElementById('featuredCount').textContent = members.filter(m => m.is_featured).length;
  const depts = new Set(members.map(m => m.dept).filter(Boolean));
  document.getElementById('deptCount').textContent = depts.size;
}

function renderMembers() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const grid = document.getElementById('teamGrid');
  const filtered = members.filter(m => {
    const matchFilter = currentFilter === 'all' || m.dept === currentFilter;
    const matchSearch = !q || m.name.toLowerCase().includes(q) || (m.title || '').toLowerCase().includes(q) || (m.dept_label || '').toLowerCase().includes(q) || (m.email || '').toLowerCase().includes(q);
    return matchFilter && matchSearch;
  });

  if (filtered.length === 0) {
    grid.innerHTML = `<div class="empty-state" style="grid-column:1/-1">
      <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
      <h3>No team members found</h3><p>Try adjusting your search or filter, or add a new team member.</p>
    </div>`;
    return;
  }

  grid.innerHTML = filtered.map(m => {
    const statusClass = m.visibility === 'public' ? 'active' : 'draft';
    const statusText = m.visibility === 'public' ? '● Active' : '◐ Draft';
    const socialIcons = [];
    if (m.email) socialIcons.push(`<a href="mailto:${m.email}" class="social-link email" title="Email"><svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg></a>`);
    if (m.linkedin) socialIcons.push(`<a href="${m.linkedin}" target="_blank" class="social-link linkedin" title="LinkedIn"><svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg></a>`);
    if (m.twitter) socialIcons.push(`<a href="${m.twitter}" target="_blank" class="social-link twitter" title="Twitter / X"><svg viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"/></svg></a>`);
    if (m.github) socialIcons.push(`<a href="${m.github}" target="_blank" class="social-link github" title="GitHub"><svg viewBox="0 0 24 24"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 00-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0020 4.77 5.07 5.07 0 0019.91 1S18.73.65 16 2.48a13.38 13.38 0 00-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 005 4.77a5.44 5.44 0 00-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 009 18.13V22"/></svg></a>`);

    const skillChips = (m.skills || []).slice(0, 4).map(s => `<span class="skill-chip">${s}</span>`).join('');
    const extraSkills = (m.skills || []).length > 4 ? `<span class="skill-chip more">+${m.skills.length - 4}</span>` : '';

    return `
    <div class="member-card">
      <div class="member-card-header">
        <div class="member-avatar ${m.photo ? 'has-photo' : ''}">
          <span class="avatar-fallback">${m.initials || m.name.substring(0,2).toUpperCase()}</span>
          ${m.photo ? `<img src="${m.photo}" alt="${m.name}" onload="this.previousElementSibling.style.display='none';" onerror="this.remove();this.parentElement.classList.remove('has-photo');"/>` : ''}
        </div>
        <span class="member-status ${statusClass}">${statusText}</span>
        ${m.is_featured ? '<span class="featured-badge" title="Featured">★</span>' : ''}
      </div>
      <div class="member-card-body">
        <div class="member-dept-badge">${m.dept_label || m.dept || 'N/A'}</div>
        <div class="member-name">${m.name}</div>
        <div class="member-title">${m.title || '—'}</div>
        <div class="member-bio">${m.bio || ''}</div>
        <div class="member-meta">
          ${m.exp ? `<span class="meta-chip"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>${m.exp}</span>` : ''}
          ${m.location ? `<span class="meta-chip"><svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>${m.location}</span>` : ''}
        </div>
        ${skillChips || extraSkills ? `<div class="member-skills">${skillChips}${extraSkills}</div>` : ''}
        <div class="member-socials">${socialIcons.join('')}</div>
        <div class="member-actions">
          <a href="/admin/team-members/${m.id}/edit" class="card-btn edit">✏ Edit</a>
          <button class="card-btn delete" onclick='openDeleteModal(${m.id}, ${JSON.stringify(m.name)})'>🗑 Remove</button>
        </div>
      </div>
    </div>`;
  }).join('');
}

function filterMembers() { renderMembers(); }

function setFilter(val, el) {
  currentFilter = val;
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  renderMembers();
}

function openDeleteModal(id, name) {
  deleteId = id;
  document.getElementById('deleteMemberName').textContent = name;
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
  btn.textContent = 'Removing...';

  try {
    const response = await fetch(`/admin/team/${deleteId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
    });

    const result = await response.json();
    if (!response.ok || !result.success) {
      throw new Error(result.message || 'Failed to remove team member.');
    }

    const idx = members.findIndex(m => m.id === deleteId);
    if (idx > -1) members.splice(idx, 1);

    Swal.fire({
      icon: 'success',
      title: 'Removed!',
      text: result.message,
      confirmButtonColor: 'var(--blue)',
    });

    if (result.notification && typeof window.showAdminNotificationToast === 'function') {
      window.showAdminNotificationToast(result.notification.title, result.notification.message);
    }

    closeDeleteModal();
    renderMembers();
    updateStats();
  } catch (err) {
    console.error(err);
    Swal.fire({
      icon: 'error',
      title: 'Failed',
      text: err.message || 'An error occurred while removing this member.',
      confirmButtonColor: 'var(--blue)',
    });
  } finally {
    btn.disabled = false;
    btn.textContent = prevText;
  }
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteModal();
});

updateStats();
renderMembers();
</script>
@endpush
