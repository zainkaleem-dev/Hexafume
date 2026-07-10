@extends('layouts.admin')
@php
  $isEditMode = isset($editingMember) && $editingMember;
  $editingMemberPayload = null;

  if ($isEditMode) {
    $editingMemberPayload = [
      'id' => $editingMember->id,
      'first_name' => $editingMember->first_name,
      'middle_name' => $editingMember->middle_name,
      'last_name' => $editingMember->last_name,
      'url_slug' => $editingMember->url_slug,
      'initials' => $editingMember->initials,
      'title' => $editingMember->title,
      'dept' => $editingMember->dept,
      'dept_label' => $editingMember->dept_label,
      'exp' => $editingMember->exp,
      'location' => $editingMember->location,
      'bio' => $editingMember->bio,
      'photo_url' => $editingMember->photo_path ? asset('storage/' . $editingMember->photo_path) : null,
      'email' => $editingMember->email,
      'linkedin' => $editingMember->linkedin,
      'twitter' => $editingMember->twitter,
      'github' => $editingMember->github,
      'skills' => $editingMember->skills ?? [],
      'expertise_tags' => $editingMember->expertise_tags ?? [],
      'qualifications' => $editingMember->qualifications->pluck('qualification')->values(),
      'achievements' => $editingMember->achievements->map(function ($achievement) {
        return [
          'num' => $achievement->num,
          'lbl' => $achievement->label,
        ];
      })->values(),
      'meta_title' => $editingMember->meta_title,
      'meta_description' => $editingMember->meta_description,
      'meta_keywords' => $editingMember->meta_keywords,
      'canonical_url' => $editingMember->canonical_url,
      'og_image_url' => $editingMember->og_image_url,
      'seo_index' => (bool) $editingMember->seo_index,
      'show_on_team' => (bool) $editingMember->show_on_team,
      'is_featured' => (bool) $editingMember->is_featured,
      'visibility' => $editingMember->visibility,
      'publish_at' => optional($editingMember->publish_at)->format('Y-m-d'),
    ];
  }
@endphp

@section('title', $isEditMode ? 'Edit Team Member' : 'Add Team Member')
@section('page_title', $isEditMode ? 'Edit Team Member' : 'Add New Team Member')

@section('breadcrumb')
  <a href="{{ route('admin.dashboard') }}">Admin</a> ›
  <a href="{{ route('admin.team.index') }}">Team</a> ›
  <span>{{ $isEditMode ? 'Edit Member' : 'Add New Member' }}</span>
@endsection

@section('topbar_actions')
  <button class="save-draft-btn" onclick="saveDraft()">Save Draft</button>
  <button class="publish-btn" onclick="publishMember()">
    <svg viewBox="0 0 24 24"><path d="M22 2L11 13"/><path d="M22 2L15 22l-4-9-9-4 20-7z"/></svg>
    {{ $isEditMode ? 'Update Member' : 'Publish Member' }}
  </button>
@endsection

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/admin-add-team-member.css') }}">
@endpush

@section('content')
<form id="memberForm" novalidate>
  @csrf
  <div class="form-layout">

    <!-- ═══════════════ LEFT COLUMN ═══════════════ -->
    <div class="form-left">

      <!-- ===== SECTION 1: BASIC INFO ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon">
              <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
              <div class="section-title">Basic Information</div>
              <div class="section-subtitle">Name, title, department &amp; core details</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">

          <div class="form-row triple">
            <div class="form-group">
              <label>First Name <span class="required">*</span></label>
              <input type="text" id="firstName" name="first_name" placeholder="e.g. Zaid" required/>
            </div>
            <div class="form-group">
              <label>Middle Name</label>
              <input type="text" id="middleName" name="middle_name" placeholder="e.g. ul"/>
            </div>
            <div class="form-group">
              <label>Last Name <span class="required">*</span></label>
              <input type="text" id="lastName" name="last_name" placeholder="e.g. Hassan" required/>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>URL Slug / ID <span class="required">*</span></label>
              <input type="text" id="urlSlug" name="url_slug" placeholder="e.g. zaid-ul-hassan"/>
              <div class="field-hint">Auto-generated from name. Used in profile URL.</div>
            </div>
            <div class="form-group">
              <label>Initials <span class="required">*</span></label>
              <input type="text" id="initials" name="initials" placeholder="e.g. ZH" maxlength="3"/>
              <div class="field-hint">Shown when no photo is uploaded.</div>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Job Title / Role <span class="required">*</span></label>
              <input type="text" id="memberTitle" name="title" placeholder="e.g. CEO &amp; Co-Founder"/>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Department <span class="required">*</span></label>
              <select id="dept" name="dept">
                <option value="">Select department…</option>
                <option value="leadership">Leadership</option>
                <option value="engineering">Engineering</option>
                <option value="design">Design</option>
                <option value="product">Product</option>
                <option value="marketing">Marketing</option>
                <option value="operations">Operations</option>
                <option value="sales">Sales</option>
                <option value="finance">Finance</option>
                <option value="hr">Human Resources</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="form-group">
              <label>Department Label</label>
              <input type="text" id="deptLabel" name="dept_label" placeholder="e.g. Leadership"/>
              <div class="field-hint">Display label for the badge on the profile page.</div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Years of Experience <span class="required">*</span></label>
              <input type="text" id="experience" name="exp" placeholder="e.g. 8+ yrs"/>
            </div>
            <div class="form-group">
              <label>Location</label>
              <input type="text" id="location" name="location" placeholder="e.g. Islamabad, PK"/>
            </div>
          </div>

          <div class="form-row single">
            <div class="form-group">
              <label>Bio / Summary <span class="required">*</span></label>
              <textarea id="memberBio" name="bio" rows="4" placeholder="Write a short professional bio about this team member…"></textarea>
              <div class="char-counter" id="bioCounter">0 / 300</div>
            </div>
          </div>

        </div>
      </div>

      <!-- ===== SECTION 2: PROFILE PHOTO ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon">
              <svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
            </div>
            <div>
              <div class="section-title">Profile Photo</div>
              <div class="section-subtitle">Member headshot or portrait image</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">
          <div class="image-upload-area" id="photoUploadArea" onclick="document.getElementById('photoInput').click()">
            <div class="upload-icon">
              <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
            </div>
            <div class="upload-text">Click to upload profile photo</div>
            <div class="upload-sub">PNG, JPG, WebP — max 5MB. Square photo preferred (e.g. 600×600px)</div>
            <input type="file" id="photoInput" name="photo" class="upload-input" accept="image/*" onchange="previewImage(this,'photoUploadArea','photoPreview')"/>
            <div class="preview-overlay"><span>Click to change</span></div>
          </div>
          <div class="field-hint" style="margin-top:.6rem;">If no photo is uploaded, the initials avatar will be used instead.</div>
        </div>
      </div>

      <!-- ===== SECTION 3: SOCIAL & CONTACT ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon">
              <svg viewBox="0 0 24 24"><path d="M10 13a5 5 0 007.54.54l3-3a5 5 0 00-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 00-7.54-.54l-3 3a5 5 0 007.07 7.07l1.71-1.71"/></svg>
            </div>
            <div>
              <div class="section-title">Social &amp; Contact</div>
              <div class="section-subtitle">LinkedIn, Twitter/X &amp; email address</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">

          <div class="form-row">
            <div class="form-group">
              <label>Email Address <span class="required">*</span></label>
              <input type="email" id="email" name="email" placeholder="e.g. info@hexafume.com"/>
            </div>
            <div class="form-group">
              <label>LinkedIn Profile URL</label>
              <input type="url" id="linkedin" name="linkedin" placeholder="https://linkedin.com/in/username"/>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Twitter / X Profile URL</label>
              <input type="url" id="twitter" name="twitter" placeholder="https://twitter.com/username"/>
            </div>
            <div class="form-group">
              <label>GitHub Profile URL</label>
              <input type="url" id="github" name="github" placeholder="https://github.com/username"/>
            </div>
          </div>

        </div>
      </div>

      
      

      

      <!-- ===== SECTION 8: SEO ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon">
              <svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            </div>
            <div>
              <div class="section-title">SEO &amp; Meta</div>
              <div class="section-subtitle">Search engine optimisation for the member profile page</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">

          <div class="form-row single">
            <div class="form-group">
              <label>Meta Title <span class="required">*</span></label>
              <input type="text" id="metaTitle" name="meta_title" placeholder="e.g. Zaid ul Hassan — CEO at Hexafume" oninput="countChars(this,'metaTitleCounter',60)"/>
              <div class="char-counter" id="metaTitleCounter">0 / 60</div>
            </div>
          </div>

          <div class="form-row single">
            <div class="form-group">
              <label>Meta Description</label>
              <textarea id="metaDesc" name="meta_description" rows="3" placeholder="Brief description for search engine results…" oninput="countChars(this,'metaDescCounter',160)"></textarea>
              <div class="char-counter" id="metaDescCounter">0 / 160</div>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group">
              <label>Meta Keywords</label>
              <input type="text" id="metaKeywords" name="meta_keywords" placeholder="e.g. CEO, product strategy, Hexafume"/>
            </div>
            <div class="form-group">
              <label>Canonical URL</label>
              <input type="url" id="canonicalUrl" name="canonical_url" placeholder="https://hexafume.com/team/zaid-ul-hassan"/>
            </div>
          </div>

          <div class="form-row single">
            <div class="form-group">
              <label>OG / Share Image URL</label>
              <input type="url" id="ogImage" name="og_image_url" placeholder="https://…/og-zaid.jpg"/>
              <div class="field-hint">Used when the profile is shared on social media. Recommended: 1200×630px.</div>
            </div>
          </div>

          <div class="toggle-row">
            <div class="toggle-label-wrap">
              <div class="toggle-label">Index this profile page</div>
              <div class="toggle-sublabel">Allow search engines to index this team member's page</div>
            </div>
            <label class="toggle"><input type="checkbox" id="seoIndex" name="seo_index" checked/><span class="toggle-track"></span></label>
          </div>

          <div class="toggle-row">
            <div class="toggle-label">Show on Team Page</div>
            <label class="toggle"><input type="checkbox" id="showOnTeam" name="show_on_team" checked/><span class="toggle-track"></span></label>
          </div>

          <div class="toggle-row">
            <div class="toggle-label">Featured Member</div>
            <label class="toggle"><input type="checkbox" id="isFeatured" name="is_featured"/><span class="toggle-track"></span></label>
          </div>

        </div>
      </div>

    </div><!-- /form-left -->

    <!-- ═══════════════ RIGHT SIDEBAR ═══════════════ -->
    <div class="form-sidebar">

      <!-- PROGRESS -->
      <div class="sidebar-panel">
        <div class="panel-header">Profile Completion</div>
        <div class="panel-body">
          <div class="steps-list">
            <div class="step-item">
              <div class="step-dot active" id="step1dot">1</div>
              <div>
                <div class="step-name active-text" id="step1name">Basic Info</div>
              </div>
            </div>
            <div class="step-item">
              <div class="step-dot" id="step2dot">2</div>
              <div>
                <div class="step-name" id="step2name">Profile Photo</div>
              </div>
            </div>
            <div class="step-item">
              <div class="step-dot" id="step3dot">3</div>
              <div>
                <div class="step-name" id="step3name">Social &amp; Contact</div>
              </div>
            </div>
            <div class="step-item">
              <div class="step-dot" id="step4dot">4</div>
              <div>
                <div class="step-name" id="step4name">Core Skills</div>
              </div>
            </div>
            <div class="step-item">
              <div class="step-dot" id="step5dot">5</div>
              <div>
                <div class="step-name" id="step5name">Qualifications</div>
              </div>
            </div>
            <div class="step-item">
              <div class="step-dot" id="step6dot">6</div>
              <div>
                <div class="step-name" id="step6name">Achievements</div>
              </div>
            </div>
            <div class="step-item">
              <div class="step-dot" id="step7dot">7</div>
              <div>
                <div class="step-name" id="step7name">SEO &amp; Meta</div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- QUICK PREVIEW -->
      <div class="sidebar-panel">
        <div class="panel-header">Profile Preview</div>
        <div class="panel-body">
          <div class="member-preview-card">
            <div class="preview-avatar" id="previewAvatar">
              <span id="previewInitials">?</span>
            </div>
            <div class="preview-name" id="previewName">Name</div>
            <div class="preview-role" id="previewRole">Role</div>
            <div class="preview-dept-badge" id="previewDept">Department</div>
            <div class="preview-location" id="previewLocation">
              <svg viewBox="0 0 24 24"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
              <span id="previewLocationText">—</span>
            </div>
          </div>
        </div>
      </div>

      <!-- PUBLISH SETTINGS -->
      <div class="sidebar-panel">
        <div class="panel-header">Publish Settings</div>
        <div class="panel-body">
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Visibility</label>
            <select id="visibility" name="visibility">
              <option value="public">Public</option>
              <option value="private">Private (Draft)</option>
              <option value="unlisted">Unlisted</option>
            </select>
          </div>
          <div class="form-group">
            <label>Publish Date</label>
            <input type="date" id="publishDate" name="publish_at"/>
            <div class="field-hint">Leave blank to publish immediately.</div>
          </div>
        </div>
      </div>

      <!-- QUICK TIPS -->
      <div class="sidebar-panel">
        <div class="panel-header">Tips</div>
        <div class="panel-body tips-list">
          <div class="tip-item">
            <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            Use the format <strong>Degree — Institution</strong> for qualifications.
          </div>
          <div class="tip-item">
            <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            Skills are displayed in order — put the most important first.
          </div>
          <div class="tip-item">
            <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            Square profile photos look best (min 400×400px).
          </div>
          <div class="tip-item">
            <svg viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            Meta title should include the member's name and role.
          </div>
        </div>
      </div>

    </div><!-- /form-sidebar -->

  </div><!-- /form-layout -->
</form>

<!-- TOAST -->
<div class="toast" id="toast">
  <div class="toast-icon">
    <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
  </div>
  <div class="toast-text">
    <strong id="toastTitle">Member Published!</strong>
    <span id="toastSub">Profile has been saved.</span>
  </div>
</div>
@endsection

@push('page_scripts')
<script>
const isEditMode = @json($isEditMode);
const editingMember = @json($editingMemberPayload);

// ===== TAG STORES =====
const tagStores = {};

function addTag(inputId, displayId, storeKey) {
  const input = document.getElementById(inputId);
  const val = input.value.trim();
  if (!val) return;
  if (!tagStores[storeKey]) tagStores[storeKey] = [];
  if (tagStores[storeKey].includes(val)) { input.value = ''; return; }
  tagStores[storeKey].push(val);
  renderTags(displayId, storeKey);
  input.value = '';
  updateProgress();
  // update hidden input
  const hiddenMap = { skills: 'skillsHidden', expertise: 'expertiseHidden' };
  if (hiddenMap[storeKey]) document.getElementById(hiddenMap[storeKey]).value = JSON.stringify(tagStores[storeKey]);
}

function removeTag(storeKey, idx, displayId) {
  tagStores[storeKey].splice(idx, 1);
  renderTags(displayId, storeKey);
  updateProgress();
  const hiddenMap = { skills: 'skillsHidden', expertise: 'expertiseHidden' };
  if (hiddenMap[storeKey]) document.getElementById(hiddenMap[storeKey]).value = JSON.stringify(tagStores[storeKey]);
}

function renderTags(displayId, storeKey) {
  const wrap = document.getElementById(displayId);
  wrap.innerHTML = (tagStores[storeKey] || []).map((t, i) => `
    <span class="tag-chip">${t}<button type="button" onclick="removeTag('${storeKey}',${i},'${displayId}')">×</button></span>
  `).join('');
}

// ===== QUALIFICATIONS REPEATER =====
let qualCount = 0;
function addQual(val = '') {
  qualCount++;
  const r = document.getElementById('qualRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header">
      <span class="repeater-item-num">Entry #${qualCount}</span>
      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove(); updateProgress();">
        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
      </button>
    </div>
    <input type="text" name="qualifications[]" placeholder="e.g. MBA — LUMS  or  AWS Solutions Architect" value="${val}" oninput="updateProgress()"/>
  `;
  r.appendChild(div);
  updateProgress();
}

// ===== ACHIEVEMENTS REPEATER =====
let achieveCount = 0;
function addAchievement(num = '', lbl = '') {
  achieveCount++;
  const r = document.getElementById('achieveRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header">
      <span class="repeater-item-num">Stat #${achieveCount}</span>
      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove(); updateProgress();">
        <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6m3 0V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
      </button>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Value / Number</label>
        <input type="text" name="achieve_num[]" placeholder="e.g. 50+" value="${num}" oninput="updateProgress()"/>
      </div>
      <div class="form-group">
        <label>Label</label>
        <input type="text" name="achieve_lbl[]" placeholder="e.g. Projects Shipped" value="${lbl}" oninput="updateProgress()"/>
      </div>
    </div>
  `;
  r.appendChild(div);
  updateProgress();
}

// ===== SECTION TOGGLE =====
function toggleSection(header) {
  const body = header.nextElementSibling;
  const toggle = header.querySelector('.section-toggle');
  body.classList.toggle('collapsed');
  toggle.classList.toggle('open');
}

// ===== IMAGE PREVIEW =====
function previewImage(input, areaId) {
  const area = document.getElementById(areaId);
  const file = input.files[0];
  if (!file) return;
  window.selectedTeamPhotoFile = file;
  const objectUrl = URL.createObjectURL(file);
  area.innerHTML = `
    <img src="${objectUrl}" class="preview-img" alt="Preview" onload="URL.revokeObjectURL(this.src)"/>
    <div class="preview-overlay"><span>Click to change</span></div>
    <input type="file" name="${input.name}" class="upload-input" accept="image/*" onchange="previewImage(this,'${areaId}')"/>
  `;
  area.classList.add('has-image');

  const previewAvatar = document.getElementById('previewAvatar');
  const previewInitials = document.getElementById('previewInitials');
  const initials = document.getElementById('initials')?.value || '?';
  if (previewAvatar) {
    previewAvatar.innerHTML = `
      <img src="${objectUrl}" alt="Preview photo" class="preview-avatar-img" onload="URL.revokeObjectURL(this.src)"/>
      <span id="previewInitials">${initials}</span>
    `;
  }
  if (previewInitials) previewInitials.textContent = initials;

  updateProgress();
}

// ===== CHAR COUNTER =====
function countChars(el, counterId, max) {
  const len = el.value.length;
  const counter = document.getElementById(counterId);
  counter.textContent = `${len} / ${max}`;
  counter.className = 'char-counter' + (len > max ? ' over' : len > max * 0.85 ? ' warn' : '');
}

// ===== LIVE PREVIEW =====
function getFullName() {
  const first = document.getElementById('firstName').value.trim();
  const middle = document.getElementById('middleName').value.trim();
  const last = document.getElementById('lastName').value.trim();
  return [first, middle, last].filter(Boolean).join(' ').trim();
}

document.addEventListener('input', function(e) {
  const id = e.target.id;
  if (id === 'firstName' || id === 'middleName' || id === 'lastName') {
    const fullName = getFullName();
    document.getElementById('previewName').textContent = fullName || 'Name';
    // auto-slug
    document.getElementById('urlSlug').value = fullName.toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/^-|-$/g,'');
    // auto-initials
    const parts = fullName.split(' ').filter(Boolean);
    const ini = parts.length >= 2 ? parts[0][0] + parts[parts.length-1][0] : (parts[0]?.[0] || '?');
    document.getElementById('initials').value = ini.toUpperCase();
    document.getElementById('previewInitials').textContent = ini.toUpperCase();
  }
  if (id === 'memberTitle') document.getElementById('previewRole').textContent = e.target.value || 'Role';
  if (id === 'deptLabel') document.getElementById('previewDept').textContent = e.target.value || 'Department';
  if (id === 'location') document.getElementById('previewLocationText').textContent = e.target.value || '—';
  if (id === 'initials') document.getElementById('previewInitials').textContent = e.target.value || '?';
  if (id === 'memberBio') countChars(e.target, 'bioCounter', 300);
  updateProgress();
});

// ===== PROGRESS =====
function updateProgress() {
  const checks = [
    !!document.getElementById('firstName').value && !!document.getElementById('lastName').value,
    document.getElementById('photoUploadArea').classList.contains('has-image'),
    !!document.getElementById('email').value,
    (tagStores['skills'] || []).length > 0,
    document.querySelectorAll('#qualRepeater .repeater-item').length > 0,
    document.querySelectorAll('#achieveRepeater .repeater-item').length > 0,
    !!document.getElementById('metaTitle').value,
  ];
  checks.forEach((val, i) => {
    const dot  = document.getElementById(`step${i+1}dot`);
    const name = document.getElementById(`step${i+1}name`);
    if (!dot) return;
    if (val) {
      dot.classList.add('done'); dot.classList.remove('active');
      dot.textContent = '✓';
      name.classList.add('done-text'); name.classList.remove('active-text');
    } else {
      dot.classList.remove('done');
      dot.textContent = i + 1;
      name.classList.remove('done-text');
    }
  });
}

// ===== TOAST =====
function showToast(title, sub) {
  const t = document.getElementById('toast');
  document.getElementById('toastTitle').textContent = title;
  document.getElementById('toastSub').textContent = sub;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3500);
}

// ===== PUBLISH =====
async function publishMember() {
  const firstName = document.getElementById('firstName').value.trim();
  const lastName = document.getElementById('lastName').value.trim();
  const name = getFullName();
  if (!firstName || !lastName) {
    alert('Please enter first name and last name before publishing.');
    document.getElementById(!firstName ? 'firstName' : 'lastName').focus();
    return;
  }

  const btn = document.querySelector('.publish-btn');
  const orig = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = 'Publishing…';

  try {
    const formData = new FormData();

    // Basic
    formData.append('first_name', document.getElementById('firstName').value);
    formData.append('middle_name', document.getElementById('middleName').value);
    formData.append('last_name',  document.getElementById('lastName').value);
    formData.append('url_slug',   document.getElementById('urlSlug').value);
    formData.append('initials',   document.getElementById('initials').value);
    formData.append('title',      document.getElementById('memberTitle').value);
    formData.append('dept',       document.getElementById('dept').value);
    formData.append('dept_label', document.getElementById('deptLabel').value);
    formData.append('exp',        document.getElementById('experience').value);
    formData.append('location',   document.getElementById('location').value);
    formData.append('bio',        document.getElementById('memberBio').value);

    // Photo
    const photoFile = window.selectedTeamPhotoFile || document.querySelector('#photoUploadArea input[type="file"]')?.files[0];
    if (photoFile) formData.append('photo', photoFile);

    // Social
    formData.append('email',    document.getElementById('email').value);
    formData.append('linkedin', document.getElementById('linkedin').value);
    formData.append('twitter',  document.getElementById('twitter').value);
    formData.append('github',   document.getElementById('github').value);

    // Skills & expertise
    formData.append('skills',        JSON.stringify(tagStores['skills'] || []));
    formData.append('expertise_tags', JSON.stringify(tagStores['expertise'] || []));

    // Qualifications
    const quals = [];
    document.querySelectorAll('#qualRepeater .repeater-item input').forEach(inp => quals.push(inp.value));
    formData.append('qualifications', JSON.stringify(quals));

    // Achievements
    const achieves = [];
    document.querySelectorAll('#achieveRepeater .repeater-item').forEach(item => {
      const inputs = item.querySelectorAll('input[type="text"]');
      achieves.push({ num: inputs[0].value, lbl: inputs[1].value });
    });
    formData.append('achievements', JSON.stringify(achieves));

    // SEO
    formData.append('meta_title',       document.getElementById('metaTitle').value);
    formData.append('meta_description', document.getElementById('metaDesc').value);
    formData.append('meta_keywords',    document.getElementById('metaKeywords').value);
    formData.append('canonical_url',    document.getElementById('canonicalUrl').value);
    formData.append('og_image_url',     document.getElementById('ogImage').value);
    formData.append('seo_index',        document.getElementById('seoIndex').checked ? 1 : 0);
    formData.append('show_on_team',     document.getElementById('showOnTeam').checked ? 1 : 0);
    formData.append('is_featured',      document.getElementById('isFeatured').checked ? 1 : 0);

    // Publish settings
    formData.append('visibility', document.getElementById('visibility').value);
    formData.append('publish_at', document.getElementById('publishDate').value);

    let endpoint = '{{ route("admin.team.store") }}';
    if (isEditMode && editingMember?.id) {
      endpoint = `/admin/team/${editingMember.id}`;
      formData.append('_method', 'PUT');
    }

    const response = await fetch(endpoint, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}'
      }
    });

    const result = await response.json();
    if (result.success) {
      showToast(isEditMode ? 'Member Updated!' : 'Member Published!', isEditMode ? `"${name}" has been updated.` : `"${name}" has been added to the team.`);
      if (result.notification && typeof window.showAdminNotificationToast === 'function') {
        window.showAdminNotificationToast(result.notification.title, result.notification.message);
      }
    } else {
      alert('Error: ' + result.message);
    }
  } catch (err) {
    console.error(err);
    alert('An error occurred while publishing.');
  } finally {
    btn.disabled = false;
    btn.innerHTML = orig;
  }
}

function saveDraft() {
  document.getElementById('visibility').value = 'private';
  publishMember();
}

// Init
if (isEditMode && editingMember) {
  const fieldMap = {
    firstName: editingMember.first_name,
    middleName: editingMember.middle_name,
    lastName: editingMember.last_name,
    urlSlug: editingMember.url_slug,
    initials: editingMember.initials,
    memberTitle: editingMember.title,
    dept: editingMember.dept,
    deptLabel: editingMember.dept_label,
    experience: editingMember.exp,
    location: editingMember.location,
    memberBio: editingMember.bio,
    email: editingMember.email,
    linkedin: editingMember.linkedin,
    twitter: editingMember.twitter,
    github: editingMember.github,
    metaTitle: editingMember.meta_title,
    metaDesc: editingMember.meta_description,
    metaKeywords: editingMember.meta_keywords,
    canonicalUrl: editingMember.canonical_url,
    ogImage: editingMember.og_image_url,
    visibility: editingMember.visibility,
    publishDate: editingMember.publish_at,
  };

  Object.entries(fieldMap).forEach(([id, value]) => {
    const el = document.getElementById(id);
    if (el && value !== null && value !== undefined) {
      el.value = value;
    }
  });

  document.getElementById('seoIndex').checked = !!editingMember.seo_index;
  document.getElementById('showOnTeam').checked = !!editingMember.show_on_team;
  document.getElementById('isFeatured').checked = !!editingMember.is_featured;

  tagStores.skills = Array.isArray(editingMember.skills) ? editingMember.skills : [];
  tagStores.expertise = Array.isArray(editingMember.expertise_tags) ? editingMember.expertise_tags : [];
  renderTags('skillTags', 'skills');
  renderTags('expertiseTags', 'expertise');

  (editingMember.qualifications || []).forEach((qualification) => addQual(qualification));
  if ((editingMember.qualifications || []).length === 0) addQual();

  (editingMember.achievements || []).forEach((achievement) => addAchievement(achievement.num || '', achievement.lbl || ''));
  if ((editingMember.achievements || []).length === 0) addAchievement();

  if (editingMember.photo_url) {
    const area = document.getElementById('photoUploadArea');
    window.selectedTeamPhotoFile = null;
    area.innerHTML = `
      <img src="${editingMember.photo_url}" class="preview-img" alt="Preview"/>
      <div class="preview-overlay"><span>Click to change</span></div>
      <input type="file" id="photoInput" name="photo" class="upload-input" accept="image/*" onchange="previewImage(this,'photoUploadArea')"/>
    `;
    area.classList.add('has-image');
    const previewAvatar = document.getElementById('previewAvatar');
    if (previewAvatar) {
      previewAvatar.innerHTML = `
        <img src="${editingMember.photo_url}" alt="Preview photo" class="preview-avatar-img"/>
        <span id="previewInitials" style="display:none;">${editingMember.initials || '?'}</span>
      `;
    }
  }

  document.getElementById('previewName').textContent = getFullName() || 'Name';
  document.getElementById('previewRole').textContent = document.getElementById('memberTitle').value || 'Role';
  document.getElementById('previewDept').textContent = document.getElementById('deptLabel').value || 'Department';
  document.getElementById('previewLocationText').textContent = document.getElementById('location').value || '—';
  document.getElementById('previewInitials').textContent = document.getElementById('initials').value || '?';
  countChars(document.getElementById('memberBio'), 'bioCounter', 300);
  countChars(document.getElementById('metaTitle'), 'metaTitleCounter', 60);
  countChars(document.getElementById('metaDesc'), 'metaDescCounter', 160);
} else {
  addQual();
  addAchievement();
}

document.addEventListener('input', updateProgress);
updateProgress();
</script>
@endpush
