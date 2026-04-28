@extends('layouts.admin')

@section('title', 'Message — ' . ($message['subject'] ?? 'View'))
@section('page_title', 'Message Detail')
@section('breadcrumb')
<a href="{{ route('admin.messages.index') }}" style="color:var(--w40);text-decoration:none;">Messages</a>
<svg viewBox="0 0 24 24" style="width:14px;height:14px;stroke:var(--w20);fill:none;stroke-width:2;vertical-align:middle;margin:0 .3rem;"><polyline points="9 18 15 12 9 6"/></svg>
<span>View</span>
@endsection

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/admin-message-show.css') }}">
@endpush

@section('content')
@php $msg = $message; @endphp
@php
  $isFailed = ($msg['status'] ?? null) === 'failed';
  $isReceived = ($msg['direction'] ?? 'received') === 'received';
  $statusClass = $isFailed ? 'failed' : ($isReceived ? 'received' : 'sent');
  $statusLabel = $isFailed ? '✕ Failed' : ($isReceived ? '↓ Received' : '↑ Sent');
@endphp

<!-- BACK + ACTIONS BAR -->
<div class="detail-toolbar">
  <a href="{{ route('admin.messages.index') }}" class="back-btn">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back to Messages
  </a>
  <div class="detail-toolbar-actions">
    @if(!empty($msg['sender_email']))
    <button class="toolbar-action-btn reply-toggle" onclick="toggleReplyPanel()">
      <svg viewBox="0 0 24 24"><polyline points="9 14 4 9 9 4"/><path d="M20 20v-7a4 4 0 00-4-4H4"/></svg>
      Reply
    </button>
    @endif
    <button class="toolbar-action-btn danger" onclick="openDeleteModal()">
      <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
      Delete
    </button>
  </div>
</div>

<div class="detail-layout">
  <!-- ── LEFT: MESSAGE CONTENT ── -->
  <div class="detail-main">
    <!-- Header -->
    <div class="msg-detail-card">
      <div class="msg-detail-header">
        <div class="detail-avatar">{{ $msg['initials'] }}</div>
        <div class="detail-sender">
          <h2 class="detail-sender-name">{{ $msg['sender_name'] ?? 'Unknown' }}</h2>
          <span class="detail-sender-email">{{ $msg['sender_email'] ?? '—' }}</span>
        </div>
        <span class="detail-status {{ $statusClass }}">{{ $statusLabel }}</span>
      </div>

      <div class="msg-detail-subject-row">
        <h3 class="msg-detail-subject">{{ $msg['subject'] }}</h3>
        <span class="msg-detail-date">{{ $msg['date_full'] }}</span>
      </div>

      @if(!empty($msg['parsed']['message']))
      <div class="msg-detail-body">
        {!! nl2br(e($msg['parsed']['message'])) !!}
      </div>
      @else
      <div class="msg-detail-body">
        {!! nl2br(e($msg['body'])) !!}
      </div>
      @endif
    </div>

    <!-- Reply Section (initially hidden) -->
    @if(!empty($msg['sender_email']))
    <div class="reply-panel" id="replyPanel" style="display:none;">
      <div class="reply-header">
        <svg viewBox="0 0 24 24"><polyline points="9 14 4 9 9 4"/><path d="M20 20v-7a4 4 0 00-4-4H4"/></svg>
        <span>Reply to <strong>{{ $msg['sender_name'] ?? 'Sender' }}</strong></span>
        <span class="reply-to-email">&lt;{{ $msg['sender_email'] }}&gt;</span>
      </div>
      <div class="reply-form">
        <div class="reply-field">
          <label>To</label>
          <input type="text" value="{{ $msg['sender_email'] }}" disabled style="opacity:.6;" />
        </div>
        <div class="reply-field">
          <label>Subject</label>
          <input type="text" id="replySubject" value="Re: {{ $msg['subject'] }}" />
        </div>
        <div class="reply-field">
          <label>Message</label>
          <textarea id="replyBody" rows="8" placeholder="Type your reply..."></textarea>
        </div>
        <div class="reply-actions">
          <button class="reply-cancel" onclick="toggleReplyPanel()">Cancel</button>
          <button class="reply-send" id="replySendBtn" onclick="sendReply()">
            <svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            Send Reply
          </button>
        </div>
      </div>
    </div>
    @endif
  </div>

  <!-- ── RIGHT: SIDEBAR INFO ── -->
  <div class="detail-sidebar">
    <!-- Sender Info Card -->
    <div class="info-card">
      <div class="info-card-title">
        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Sender Info
      </div>
      <div class="info-row">
        <span class="info-label">Name</span>
        <span class="info-value">{{ $msg['sender_name'] ?? '—' }}</span>
      </div>
      @if(!empty($msg['sender_email']))
      <div class="info-row">
        <span class="info-label">Email</span>
        <a href="mailto:{{ $msg['sender_email'] }}" class="info-value info-link">{{ $msg['sender_email'] }}</a>
      </div>
      @endif
      @if(!empty($msg['parsed']['sender_phone']))
      <div class="info-row">
        <span class="info-label">Phone</span>
        <span class="info-value">{{ $msg['parsed']['sender_phone'] }}</span>
      </div>
      @endif
    </div>

    <!-- Message Meta Card -->
    <div class="info-card">
      <div class="info-card-title">
        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        Message Details
      </div>
      <div class="info-row">
        <span class="info-label">Status</span>
        <span class="info-value">
          <span class="info-status-badge {{ $statusClass }}">{{ $statusLabel }}</span>
        </span>
      </div>
      <div class="info-row">
        <span class="info-label">{{ $isReceived ? 'Received' : 'Sent' }}</span>
        <span class="info-value">{{ $msg['created_at'] }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Time Ago</span>
        <span class="info-value">{{ $msg['time_ago'] }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Message ID</span>
        <span class="info-value mono">#{{ $msg['id'] }}</span>
      </div>
      @if(!empty($msg['recipient_email']))
      <div class="info-row">
        <span class="info-label">Delivered To</span>
        <span class="info-value">{{ $msg['recipient_email'] }}</span>
      </div>
      @endif
      @if(!empty($msg['parsed']['service']))
      <div class="info-row">
        <span class="info-label">Service</span>
        <span class="info-value">
          <span class="info-service-tag">{{ $msg['parsed']['service'] }}</span>
        </span>
      </div>
      @endif
    </div>

    <!-- Quick Actions Card -->
    <div class="info-card">
      <div class="info-card-title">
        <svg viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
        Quick Actions
      </div>
      @if(!empty($msg['sender_email']))
      <a href="mailto:{{ $msg['sender_email'] }}?subject=Re: {{ urlencode($msg['subject']) }}" class="quick-action-btn">
        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
        Open in Email Client
      </a>
      <button class="quick-action-btn" onclick="copyEmail()">
        <svg viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
        Copy Sender Email
      </button>
      <button class="quick-action-btn" onclick="toggleReplyPanel()">
        <svg viewBox="0 0 24 24"><polyline points="9 14 4 9 9 4"/><path d="M20 20v-7a4 4 0 00-4-4H4"/></svg>
        Reply to Message
      </button>
      @else
      <span class="info-value" style="font-size:.75rem;color:var(--w40);">No sender email available for this message.</span>
      @endif
    </div>
  </div>
</div>

<!-- DELETE MODAL -->
<div class="modal-overlay" id="deleteModal">
  <div class="modal">
    <div class="modal-icon">
      <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
    </div>
    <h3>Delete Message?</h3>
    <p>This will permanently delete this message from <strong>{{ $msg['sender_name'] ?? 'this sender' }}</strong>. This action cannot be undone.</p>
    <div class="modal-btns">
      <button class="modal-btn cancel" onclick="closeDeleteModal()">Cancel</button>
      <button class="modal-btn confirm-del" onclick="confirmDelete()">Delete Message</button>
    </div>
  </div>
</div>

<!-- TOAST -->
<div class="toast" id="successToast">
  <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
  <span id="toastMsg"></span>
</div>
@endsection

@push('page_scripts')
<script>
const messageId = {{ $msg['id'] }};
const senderEmail = @json($msg['sender_email'] ?? '');

function toggleReplyPanel() {
  const panel = document.getElementById('replyPanel');
  if (!panel) return;
  const isHidden = panel.style.display === 'none';
  panel.style.display = isHidden ? 'block' : 'none';
  if (isHidden) {
    panel.scrollIntoView({ behavior: 'smooth', block: 'start' });
    document.getElementById('replyBody').focus();
  }
}

async function sendReply() {
  const subject = document.getElementById('replySubject').value.trim();
  const body = document.getElementById('replyBody').value.trim();

  if (!subject || !body) {
    showToast('Please fill in both subject and message.', true);
    return;
  }

  const btn = document.getElementById('replySendBtn');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner"></span> Sending...';

  try {
    const res = await fetch(`/admin/messages/${messageId}/reply`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
      body: JSON.stringify({ reply_subject: subject, reply_body: body }),
    });

    const result = await res.json();

    if (!res.ok || !result.success) {
      throw new Error(result.message || 'Failed to send reply.');
    }

    showToast(result.message || 'Reply sent successfully!');
    document.getElementById('replyBody').value = '';

    if (typeof window.showAdminNotificationToast === 'function') {
      window.showAdminNotificationToast('Reply Sent', result.message);
    }
  } catch (err) {
    showToast(err.message || 'Failed to send reply.', true);
  } finally {
    btn.disabled = false;
    btn.innerHTML = '<svg viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Send Reply';
  }
}

function openDeleteModal() {
  document.getElementById('deleteModal').classList.add('show');
}
function closeDeleteModal() {
  document.getElementById('deleteModal').classList.remove('show');
}

async function confirmDelete() {
  const btn = document.querySelector('#deleteModal .confirm-del');
  btn.disabled = true;
  btn.textContent = 'Deleting...';

  try {
    const res = await fetch(`/admin/messages/${messageId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
        'Accept': 'application/json',
      },
    });
    const result = await res.json();
    if (!res.ok || !result.success) throw new Error(result.message);
    window.location.href = '{{ route("admin.messages.index") }}';
  } catch (err) {
    alert(err.message || 'Failed to delete.');
    btn.disabled = false;
    btn.textContent = 'Delete Message';
  }
}

function copyEmail() {
  if (!senderEmail) return;
  navigator.clipboard.writeText(senderEmail).then(() => {
    showToast('Sender email copied!');
  });
}

function showToast(msg, isError) {
  const toast = document.getElementById('successToast');
  const textEl = document.getElementById('toastMsg');
  textEl.textContent = msg;
  toast.classList.toggle('error', !!isError);
  toast.classList.add('show');
  setTimeout(() => toast.classList.remove('show'), 3500);
}

document.getElementById('deleteModal').addEventListener('click', function(e) {
  if (e.target === this) closeDeleteModal();
});
</script>
@endpush
