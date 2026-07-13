@extends('layouts.admin')

@section('title', 'Testimonials')
@section('page_title', 'Testimonials')
@section('breadcrumb', 'Testimonials')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/admin-testimonials.css') }}">
@endpush

@section('content')
<div class="toolbar">
  <div class="search-box">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" id="searchInput" placeholder="Search testimonials..." oninput="renderTestimonials()"/>
  </div>
  <a href="{{ route('admin.testimonials.create') }}" class="primary-btn">
    <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
    Add Testimonial
  </a>
</div>

<div class="testimonials-grid" id="testimonialsGrid"></div>

<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <div class="modal-icon"><svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg></div>
    <h3>Delete Testimonial?</h3>
    <p>This will permanently delete <strong id="deleteTestimonialName"></strong>. This action cannot be undone.</p>
    <div class="modal-btns">
      <button class="modal-btn cancel" onclick="closeDeleteModal()">Cancel</button>
      <button class="modal-btn confirm-del" onclick="confirmDelete()">Delete</button>
    </div>
  </div>
</div>
@endsection

@push('page_scripts')
<script>
const testimonials = @json($testimonials ?? []);
let deleteId = null;

function renderTestimonials() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const grid = document.getElementById('testimonialsGrid');
  const filtered = testimonials.filter(t => {
    return !q || [t.client_name, t.company, t.role, t.location, t.quote].join(' ').toLowerCase().includes(q);
  });

  if (!filtered.length) {
    grid.innerHTML = `<div class="empty-state"><svg viewBox="0 0 24 24"><path d="M7 7h10M7 12h7M7 17h10"/><path d="M5 21l2-4h12a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg><h3>No testimonials found</h3><p>Try a different search term.</p></div>`;
    return;
  }

  grid.innerHTML = filtered.map(t => `
    <div class="testimonial-card">
      <div class="testimonial-thumb">
        ${t.photo_url ? `<img src="${t.photo_url}" alt="${t.client_name}">` : `<div class="testimonial-initials">${t.initials || (t.client_name || '').slice(0,2).toUpperCase()}</div>`}
        <span class="status-pill">${t.is_active ? 'Active' : 'Inactive'}</span>
      </div>
      <div class="testimonial-body">
        <div>
          <div class="testimonial-name">${t.client_name}</div>
          <div class="testimonial-sub">${t.company} • ${t.role}${t.location ? ` • ${t.location}` : ''}</div>
        </div>
        <div class="testimonial-quote">"${t.quote}"</div>
        <div class="testimonial-meta">
          <span class="meta-chip">Order ${t.order_index ?? 0}</span>
          ${t.location ? `<span class="meta-chip">${t.location}</span>` : ''}
        </div>
        <div class="card-actions">
          <a href="/admin/testimonials/${t.id}/edit" class="card-btn edit">Edit</a>
          <button class="card-btn delete" onclick='openDeleteModal(${t.id}, ${JSON.stringify(t.client_name)})'>Delete</button>
        </div>
      </div>
    </div>
  `).join('');
}

function openDeleteModal(id, name) {
  deleteId = id;
  document.getElementById('deleteTestimonialName').textContent = name;
  document.getElementById('deleteModal').classList.add('show');
}

function closeDeleteModal() {
  deleteId = null;
  document.getElementById('deleteModal').classList.remove('show');
}

async function confirmDelete() {
  if (!deleteId) return;
  const btn = document.querySelector('#deleteModal .confirm-del');
  const prev = btn.textContent;
  btn.disabled = true;
  btn.textContent = 'Deleting...';

  try {
    const response = await fetch(`/admin/testimonials/${deleteId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
    });
    const result = await response.json();
    if (!response.ok || !result.success) throw new Error(result.message || 'Failed to delete testimonial.');

    const idx = testimonials.findIndex(t => t.id === deleteId);
    if (idx > -1) testimonials.splice(idx, 1);

    if (result.notification && typeof window.showAdminNotificationToast === 'function') {
      window.showAdminNotificationToast(result.notification.title, result.notification.message);
    }

    closeDeleteModal();
    renderTestimonials();
  } catch (err) {
    alert(err.message || 'An error occurred while deleting the testimonial.');
  } finally {
    btn.disabled = false;
    btn.textContent = prev;
  }
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteModal();
});

renderTestimonials();
</script>
@endpush
