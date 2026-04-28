@extends('layouts.admin')

@section('title', 'Messages')
@section('page_title', 'Messages')
@section('breadcrumb', 'Messages')

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/admin-messages.css') }}">
@endpush

@section('content')
<div class="toolbar">
  <div class="search-box">
    <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input type="text" id="searchInput" placeholder="Search messages..." oninput="filterMessages()"/>
  </div>
  <div class="filter-tabs">
    <button class="filter-tab active" onclick="setFilter('all', this)">All</button>
    <button class="filter-tab" onclick="setFilter('received', this)">Received</button>
    <button class="filter-tab" onclick="setFilter('sent', this)">Sent</button>
    <button class="filter-tab" onclick="setFilter('failed', this)">Failed</button>
  </div>
</div>

<div class="stats-row">
  <div class="stat-card">
    <div class="stat-icon blue">
      <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-num" id="totalCount">0</div>
      <div class="stat-label">Total Messages</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green">
      <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-num" id="sentCount">0</div>
      <div class="stat-label">Received</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon red">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-num" id="failedCount">0</div>
      <div class="stat-label">Failed</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon amber">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
    <div class="stat-info">
      <div class="stat-num" id="recentCount">0</div>
      <div class="stat-label">Last 7 Days</div>
    </div>
  </div>
</div>

<div class="messages-grid" id="messagesGrid"></div>

<!-- VIEW MESSAGE MODAL -->
<div class="modal-overlay" id="viewModal">
  <div class="modal view-modal">
    <button class="modal-close" onclick="closeViewModal()">&times;</button>
    <div class="view-modal-header">
      <div class="view-avatar" id="viewAvatar"></div>
      <div class="view-meta">
        <h3 id="viewName"></h3>
        <span class="view-email" id="viewEmail"></span>
      </div>
      <span class="view-status" id="viewStatus"></span>
    </div>
    <div class="view-subject" id="viewSubject"></div>
    <div class="view-date" id="viewDate"></div>
    <div class="view-body" id="viewBody"></div>
  </div>
</div>

<!-- DELETE MESSAGE MODAL -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <div class="modal-icon">
      <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
    </div>
    <h3>Delete Message?</h3>
    <p>This will permanently delete the message from <strong id="deleteMsgName"></strong>. This action cannot be undone.</p>
    <div class="modal-btns">
      <button class="modal-btn cancel" onclick="closeDeleteModal()">Cancel</button>
      <button class="modal-btn confirm-del" onclick="confirmDelete()">Delete Message</button>
    </div>
  </div>
</div>
@endsection

@push('page_scripts')
<script>
const messages = @json($messages ?? []);

let currentFilter = 'all';
let deleteId = null;

function updateStats() {
  document.getElementById('totalCount').textContent = messages.length;
  document.getElementById('sentCount').textContent = messages.filter(m => (m.direction || 'sent') === 'received').length;
  document.getElementById('failedCount').textContent = messages.filter(m => m.status === 'failed').length;

  const weekAgo = new Date();
  weekAgo.setDate(weekAgo.getDate() - 7);
  document.getElementById('recentCount').textContent = messages.filter(m => {
    return new Date(m.created_at) >= weekAgo;
  }).length;
}

function renderMessages() {
  const q = document.getElementById('searchInput').value.toLowerCase();
  const grid = document.getElementById('messagesGrid');
  const filtered = messages.filter(m => {
    const direction = m.direction || 'sent';
    const matchFilter =
      currentFilter === 'all' ||
      (currentFilter === 'failed' && m.status === 'failed') ||
      (currentFilter === 'received' && direction === 'received') ||
      (currentFilter === 'sent' && direction === 'sent');
    const matchSearch = !q ||
      (m.sender_name || '').toLowerCase().includes(q) ||
      (m.sender_email || '').toLowerCase().includes(q) ||
      m.subject.toLowerCase().includes(q) ||
      (m.body || '').toLowerCase().includes(q);
    return matchFilter && matchSearch;
  });

  if (filtered.length === 0) {
    grid.innerHTML = `<div class="empty-state" style="grid-column:1/-1">
      <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      <h3>No messages found</h3><p>Try adjusting your search or filters.</p>
    </div>`;
    return;
  }

  grid.innerHTML = filtered.map(m => {
    const direction = m.direction || 'sent';
    const isFailed = m.status === 'failed';
    const statusClass = isFailed ? 'failed' : (direction === 'received' ? 'received' : 'sent');
    const statusIcon = isFailed ? '✕' : (direction === 'received' ? '↓' : '↑');
    const statusLabel = isFailed ? 'Failed' : (direction === 'received' ? 'Received' : 'Sent');
    const bodyPreview = (m.body || '').replace(/\n/g, ' ').substring(0, 120) + ((m.body || '').length > 120 ? '…' : '');
    const displayName = m.sender_name || 'Unknown';
    const displayEmail = m.sender_email || '—';

    return `
    <div class="msg-card">
      <div class="msg-card-top">
        <div class="msg-avatar">${m.initials}</div>
        <div class="msg-sender-info">
          <div class="msg-sender-name">${escapeHtml(displayName)}</div>
          <div class="msg-sender-email">${escapeHtml(displayEmail)}</div>
        </div>
        <span class="msg-status ${statusClass}">${statusIcon} ${statusLabel}</span>
      </div>
      <div class="msg-subject">${escapeHtml(m.subject)}</div>
      <div class="msg-preview">${escapeHtml(bodyPreview)}</div>
      <div class="msg-card-footer">
        <span class="msg-time">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          ${m.time_ago}
        </span>
        <div class="msg-actions">
          <a href="/admin/messages/${m.id}" class="msg-action-btn view" title="View">
            <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
          </a>
          <button type="button" class="msg-action-btn delete" onclick="openDeleteModal(${m.id}, ${JSON.stringify(displayName).replace(/"/g, '&quot;')}); return false;" title="Delete">
            <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
          </button>
        </div>
      </div>
    </div>`;
  }).join('');
}

function escapeHtml(str) {
  const div = document.createElement('div');
  div.textContent = str;
  return div.innerHTML;
}

function filterMessages() { renderMessages(); }

function setFilter(val, el) {
  currentFilter = val;
  document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
  el.classList.add('active');
  renderMessages();
}

/* ── View Modal ── */
function openViewModal(id) {
  const m = messages.find(msg => msg.id === id);
  if (!m) return;

  document.getElementById('viewAvatar').textContent = m.initials;
  document.getElementById('viewName').textContent = m.sender_name || 'Unknown';
  document.getElementById('viewEmail').textContent = m.sender_email || '—';
  document.getElementById('viewSubject').textContent = m.subject;
  document.getElementById('viewDate').textContent = m.created_at;
  document.getElementById('viewBody').textContent = m.body;

  const badge = document.getElementById('viewStatus');
  badge.textContent = m.status === 'sent' ? '↓ Received' : '✕ Failed';
  badge.className = 'view-status ' + (m.status === 'sent' ? 'received' : 'failed');

  document.getElementById('viewModal').classList.add('show');
}

function closeViewModal() {
  document.getElementById('viewModal').classList.remove('show');
}

/* ── Delete Modal ── */
function openDeleteModal(id, name) {
  deleteId = id;
  document.getElementById('deleteMsgName').textContent = name;
  document.getElementById('deleteModal').classList.add('show');
}

function closeDeleteModal() {
  deleteId = null;
  document.getElementById('deleteModal').classList.remove('show');
}

async function confirmDelete() {
  if (deleteId === null || deleteId === undefined) return;

  const btn = document.querySelector('#deleteModal .confirm-del');
  const prevText = btn.textContent;
  btn.disabled = true;
  btn.textContent = 'Deleting...';

  try {
    const response = await fetch(`/admin/messages/${deleteId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
      credentials: 'same-origin',
    });

    const raw = await response.text();
    let result = {};
    try { result = raw ? JSON.parse(raw) : {}; } catch (_) {}

    if (!response.ok || !result.success) {
      throw new Error(result.message || 'Failed to delete message.');
    }

    const idx = messages.findIndex(m => String(m.id) === String(deleteId));
    if (idx > -1) {
      messages.splice(idx, 1);
      closeDeleteModal();
      renderMessages();
      updateStats();
    } else {
      // Fallback to server truth if client array is stale.
      window.location.reload();
      return;
    }

    if (typeof window.showAdminNotificationToast === 'function') {
      window.showAdminNotificationToast('Message Deleted', 'The message has been removed from backend and list.');
    }
  } catch (err) {
    alert(err.message || 'An error occurred while deleting this message.');
  } finally {
    btn.disabled = false;
    btn.textContent = prevText;
  }
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteModal();
});
document.getElementById('viewModal').addEventListener('click', function(e) {
  if (e.target === this) closeViewModal();
});

updateStats();
renderMessages();
</script>
@endpush
