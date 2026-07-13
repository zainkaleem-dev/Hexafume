@extends('layouts.admin')
@php
  $isEditMode = isset($editingTestimonial) && $editingTestimonial;
  $editingTestimonialPayload = null;

  if ($isEditMode) {
    $editingTestimonialPayload = [
      'id' => $editingTestimonial->id,
      'client_name' => $editingTestimonial->client_name,
      'location' => $editingTestimonial->location,
      'company' => $editingTestimonial->company,
      'role' => $editingTestimonial->role,
      'quote' => $editingTestimonial->quote,
      'initials' => $editingTestimonial->initials,
      'photo_url' => $editingTestimonial->photo_url,
      'order_index' => $editingTestimonial->order_index,
      'is_active' => (bool) $editingTestimonial->is_active,
    ];
  }
@endphp

@section('title', $isEditMode ? 'Edit Testimonial' : 'Add Testimonial')
@section('page_title', $isEditMode ? 'Edit Testimonial' : 'Add New Testimonial')

@section('breadcrumb')
  <a href="{{ route('admin.dashboard') }}">Admin</a> ›
  <a href="{{ route('admin.testimonials.index') }}">Testimonials</a> ›
  <span>{{ $isEditMode ? 'Edit Testimonial' : 'Add Testimonial' }}</span>
@endsection

@section('topbar_actions')
  <button class="save-draft-btn" onclick="saveDraft()">Save Draft</button>
  <button class="publish-btn" onclick="publishTestimonial()">
    <svg viewBox="0 0 24 24"><path d="M22 2L11 13"/><path d="M22 2L15 22l-4-9-9-4 20-7z"/></svg>
    {{ $isEditMode ? 'Update Testimonial' : 'Publish Testimonial' }}
  </button>
@endsection

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/admin-add-project.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin-testimonials.css') }}">
@endpush

@section('content')
<form id="testimonialForm" novalidate>
  @csrf
  <div class="form-shell">
    <div>
      <div class="form-panel">
        <div class="panel-head">
          <div class="panel-title">Testimonial Details</div>
          <div class="panel-sub">Client name, company, role, location, quote, and photo</div>
        </div>
        <div class="panel-body">
          <div class="form-row">
            <div class="form-group"><label>Client Name <span style="color:var(--red)">*</span></label><input type="text" id="clientName" name="client_name" placeholder="e.g. Areeb Patel" required></div>
            <div class="form-group"><label>Location</label><input type="text" id="location" name="location" placeholder="e.g. United States"></div>
          </div>
          <div class="form-row">
            <div class="form-group"><label>Company <span style="color:var(--red)">*</span></label><input type="text" id="company" name="company" placeholder="e.g. Arete Properties" required></div>
            <div class="form-group"><label>Role <span style="color:var(--red)">*</span></label><input type="text" id="role" name="role" placeholder="e.g. Real Estate" required></div>
          </div>
          <div class="form-row">
            <div class="form-group"><label>Initials</label><input type="text" id="initials" name="initials" maxlength="4" placeholder="AP"><div class="field-hint">Used as the fallback avatar when no photo is uploaded.</div></div>
            <div class="form-group"><label>Order Index</label><input type="number" id="orderIndex" name="order_index" placeholder="0" min="0" step="1"></div>
          </div>
          <div class="form-row single">
            <div class="form-group"><label>Quote <span style="color:var(--red)">*</span></label><textarea id="quote" name="quote" placeholder="Write the testimonial quote..." required></textarea></div>
          </div>
        </div>
      </div>

      <div class="form-panel">
        <div class="panel-head">
          <div class="panel-title">Photo</div>
          <div class="panel-sub">Upload a client portrait or headshot</div>
        </div>
        <div class="panel-body">
          <div class="image-upload-area" id="photoUploadArea" onclick="document.getElementById('photoInput').click()">
            <img id="photoPreviewImg" class="preview-img" style="display:none;" alt="Preview">
            <div class="upload-icon"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg></div>
            <div class="upload-text">Click to upload testimonial photo</div>
            <div class="upload-sub">PNG, JPG, WebP - max 5MB</div>
            <input type="file" id="photoInput" name="photo" class="upload-input" accept="image/*" onchange="previewPhoto(this)">
            <div class="preview-overlay"><span>Click to change</span></div>
          </div>
        </div>
      </div>
    </div>

    <aside class="form-sidebar">
      <div class="sidebar-panel">
        <div class="panel-header">Publish Settings</div>
        <div class="panel-body">
          <div class="toggle-row">
            <div class="toggle-label-wrap">
              <div class="toggle-label">Active</div>
              <div class="toggle-sublabel">Show this testimonial on the public site</div>
            </div>
            <label class="toggle">
              <input type="checkbox" id="isActive" name="is_active" value="1" checked>
              <span class="toggle-track"></span>
            </label>
          </div>
        </div>
      </div>

      <div class="sidebar-panel">
        <div class="panel-header">Preview</div>
        <div class="panel-body">
          <div class="member-preview-card">
            <div class="preview-avatar" id="previewAvatar"><div id="previewInitials">AP</div></div>
            <div class="preview-name" id="previewName">Client Name</div>
            <div class="preview-role" id="previewRole">Company</div>
            <div class="preview-dept-badge" id="previewLocation">Location</div>
          </div>
        </div>
      </div>
    </aside>
  </div>
</form>
@endsection

@push('page_scripts')
<script>
const editingTestimonial = @json($editingTestimonialPayload ?? null);

function syncPreview() {
  document.getElementById('previewName').textContent = document.getElementById('clientName').value || 'Client Name';
  document.getElementById('previewRole').textContent = [document.getElementById('company').value || 'Company', document.getElementById('role').value || 'Role'].join(' • ');
  document.getElementById('previewLocation').textContent = document.getElementById('location').value || 'Location';
  document.getElementById('previewInitials').textContent = (document.getElementById('initials').value || 'AP').slice(0, 4).toUpperCase();
}

function previewPhoto(input) {
  const area = document.getElementById('photoUploadArea');
  const preview = document.getElementById('photoPreviewImg');
  if (!input.files || !input.files[0]) return;
  const url = URL.createObjectURL(input.files[0]);
  preview.src = url;
  preview.style.display = 'block';
  area.classList.add('has-image');
  preview.onload = () => URL.revokeObjectURL(url);
}

async function publishTestimonial() {
  const form = document.getElementById('testimonialForm');
  const btn = document.querySelector('.publish-btn');
  const original = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = '<span class="loading-spinner"></span> Saving...';

  const formData = new FormData(form);
  const orderIndexInput = document.getElementById('orderIndex');
  const normalizedOrderIndex = Number.parseInt(orderIndexInput.value, 10);
  formData.set('order_index', Number.isFinite(normalizedOrderIndex) ? String(normalizedOrderIndex) : '0');

  try {
    const res = await fetch(editingTestimonial ? `/admin/testimonials/${editingTestimonial.id}` : '/admin/testimonials', {
      method: editingTestimonial ? 'POST' : 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        'Accept': 'application/json',
      },
      body: (() => {
        if (editingTestimonial) formData.append('_method', 'PUT');
        return formData;
      })()
    });

    const result = await res.json();
    if (!res.ok || !result.success) throw new Error(result.message || 'Unable to save testimonial.');

    if (result.notification && typeof window.showAdminNotificationToast === 'function') {
      window.showAdminNotificationToast(result.notification.title, result.notification.message);
    }

    window.location.href = '{{ route("admin.testimonials.index") }}';
  } catch (err) {
    alert(err.message || 'An error occurred while saving.');
  } finally {
    btn.disabled = false;
    btn.innerHTML = original;
  }
}

function saveDraft() {
  alert('Draft saving is not wired for testimonials yet.');
}

['clientName','location','company','role','initials'].forEach(id => {
  document.getElementById(id).addEventListener('input', syncPreview);
});

if (editingTestimonial) {
  document.getElementById('clientName').value = editingTestimonial.client_name || '';
  document.getElementById('location').value = editingTestimonial.location || '';
  document.getElementById('company').value = editingTestimonial.company || '';
  document.getElementById('role').value = editingTestimonial.role || '';
  document.getElementById('quote').value = editingTestimonial.quote || '';
  document.getElementById('initials').value = editingTestimonial.initials || '';
  document.getElementById('orderIndex').value = editingTestimonial.order_index ?? 0;
  document.getElementById('isActive').checked = !!editingTestimonial.is_active;
  if (editingTestimonial.photo_url) {
    const area = document.getElementById('photoUploadArea');
    const preview = document.getElementById('photoPreviewImg');
    area.classList.add('has-image');
    preview.src = editingTestimonial.photo_url;
    preview.style.display = 'block';
  }
  syncPreview();
} else {
  syncPreview();
}
</script>
@endpush
