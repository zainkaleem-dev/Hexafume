@extends('layouts.admin')
@php
  $isEditMode = isset($editingProject) && $editingProject;
  $editingProjectPayload = null;

  if ($isEditMode) {
    $editingProjectPayload = [
      'id' => $editingProject->id,
      'name' => $editingProject->name,
      'url_slug' => $editingProject->url_slug,
      'type' => $editingProject->type,
      'client_name' => $editingProject->client_name,
      'site_url' => $editingProject->site_url,
      'start_date' => optional($editingProject->start_date)->format('Y-m-d'),
      'finish_date' => optional($editingProject->finish_date)->format('Y-m-d'),
      'total_time' => $editingProject->total_time,
      'team' => $editingProject->team,
      'status' => $editingProject->status,
      'delivered_on_time' => (bool) $editingProject->delivered_on_time,
      'overview_heading' => $editingProject->overview_heading,
      'overview_p1' => $editingProject->overview_p1,
      'overview_p2' => $editingProject->overview_p2,
      'overview_p3' => $editingProject->overview_p3,
      'stat1_num' => $editingProject->stat1_num,
      'stat1_lbl' => $editingProject->stat1_lbl,
      'stat2_num' => $editingProject->stat2_num,
      'stat2_lbl' => $editingProject->stat2_lbl,
      'stat3_num' => $editingProject->stat3_num,
      'stat3_lbl' => $editingProject->stat3_lbl,
      'stack_description' => $editingProject->stack_description,
      'timeline_heading' => $editingProject->timeline_heading,
      'timeline_subtext' => $editingProject->timeline_subtext,
      'meta_title' => $editingProject->meta_title,
      'meta_description' => $editingProject->meta_description,
      'meta_keywords' => $editingProject->meta_keywords,
      'canonical_url' => $editingProject->canonical_url,
      'og_image_url' => $editingProject->og_image_url,
      'twitter_card' => $editingProject->twitter_card,
      'seo_index' => (bool) $editingProject->seo_index,
      'show_portfolio' => (bool) $editingProject->show_portfolio,
      'is_featured' => (bool) $editingProject->is_featured,
      'visibility' => $editingProject->visibility,
      'publish_at' => optional($editingProject->publish_at)->format('Y-m-d'),
      'hero_image_url' => $editingProject->hero_image_url,
      'logo_image_url' => $editingProject->logo_image_url,
      'tech_tags' => $editingProject->techTags->pluck('name')->values(),
      'service_tags' => $editingProject->serviceTags->pluck('name')->values(),
      'challenges' => $editingProject->challenges->map(function ($challenge) {
        return [
          'title' => $challenge->title,
          'solution' => $challenge->solution,
        ];
      })->values(),
      'timeline_entries' => $editingProject->timelineEntries->map(function ($entry) {
        return [
          'date_label' => $entry->date_label,
          'title' => $entry->title,
          'description' => $entry->description,
          'tag_text' => $entry->tag_text,
          'tag_color' => $entry->tag_color,
          'is_milestone' => (bool) $entry->is_milestone,
        ];
      })->values(),
      'related_projects' => $editingProject->relatedProjects->map(function ($related) {
        return [
          'name' => $related->name,
          'category' => $related->category,
          'description' => $related->description,
          'image_path' => $related->image_path,
          'link_url' => $related->link_url,
        ];
      })->values(),
    ];
  }
@endphp

@section('title', $isEditMode ? 'Edit Project' : 'Add Project')
@section('page_title', $isEditMode ? 'Edit Project' : 'Add New Project')

@section('breadcrumb')
  <a href="{{ route('admin.dashboard') }}">Admin</a> ›
  <a href="{{ route('admin.projects.index') }}">Projects</a> ›
  <span>{{ $isEditMode ? 'Edit Project' : 'Add New Project' }}</span>
@endsection

@section('topbar_actions')
  <button class="save-draft-btn" onclick="saveDraft()">Save Draft</button>
  <button class="publish-btn" onclick="publishProject()">
    <svg viewBox="0 0 24 24"><path d="M22 2L11 13"/><path d="M22 2L15 22l-4-9-9-4 20-7z"/></svg>
    {{ $isEditMode ? 'Update Project' : 'Publish Project' }}
  </button>
@endsection

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/admin-add-project.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endpush

@section('content')
<form id="projectForm" novalidate>
  @csrf
  <div class="form-layout">

    <!-- LEFT COLUMN -->
    <div class="form-left">

      <!-- ===== SECTION 1: BASIC INFO ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon"><svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
            <div>
              <div class="section-title">Basic Information</div>
              <div class="section-subtitle">Project name, type, client &amp; core details</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">
          <div class="form-row">
            <div class="form-group">
              <label>Project Name <span class="required">*</span></label>
              <input type="text" id="projectName" name="name" placeholder="e.g. Castlly" required/>
            </div>
            <div class="form-group">
              <label>Project Type / Category <span class="required">*</span></label>
              <select id="projectType" name="type">
                <option value="">Select type…</option>
                <option>SaaS Platform</option>
                <option>Streaming Platform</option>
                <option>E-Commerce</option>
                <option>FinTech</option>
                <option>HealthTech</option>
                <option>EdTech</option>
                <option>Marketplace</option>
                <option>Mobile App</option>
                <option>Point of Sale</option>
                <option>Automotive</option>
                <option>AgriTech</option>
                <option>Other</option>
              </select>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Client / Company Name <span class="required">*</span></label>
              <input type="text" id="clientName" name="client_name" placeholder="e.g. Castlly Inc."/>
            </div>
            <div class="form-group">
              <label>Live Site URL</label>
              <input type="url" id="siteUrl" name="site_url" placeholder="https://castlly.com"/>
            </div>
          </div>
          <div class="form-row triple">
            <div class="form-group">
              <label>Start Date <span class="required">*</span></label>
              <input type="date" id="startDate" name="start_date"/>
            </div>
            <div class="form-group">
              <label>Finish Date <span class="required">*</span></label>
              <input type="date" id="finishDate" name="finish_date"/>
            </div>
            <div class="form-group">
              <label>Total Time Allotted</label>
              <input type="text" id="totalTime" name="total_time" placeholder="e.g. ~12 Weeks"/>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>Team</label>
              <input type="text" id="team" name="team" placeholder="e.g. Full-stack team"/>
            </div>
            <div class="form-group">
              <label>Project Status <span class="required">*</span></label>
              <select id="projectStatus" name="status">
                <option value="live">Live ✓</option>
                <option value="progress">In Progress</option>
                <option value="review">Under Review</option>
                <option value="paused">Paused</option>
                <option value="draft">Draft</option>
              </select>
            </div>
          </div>

          <!-- Delivered toggle -->
          <div class="toggle-row">
            <div class="toggle-label-wrap">
              <div class="toggle-label">Delivered on Schedule</div>
              <div class="toggle-sublabel">Was this project delivered on time?</div>
            </div>
            <label class="toggle"><input type="checkbox" id="deliveredOnTime" name="delivered_on_time" checked/><span class="toggle-track"></span></label>
          </div>
        </div>
      </div>

      <!-- ===== SECTION 2: PROJECT IMAGE ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg></div>
            <div>
              <div class="section-title">Project Image</div>
              <div class="section-subtitle">Hero image shown at the top of the project page</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">
          <div class="image-upload-area" id="heroImageArea" onclick="document.getElementById('heroImageInput').click()">
            <div class="upload-icon"><svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg></div>
            <div class="upload-text">Click to upload hero image</div>
            <div class="upload-sub">PNG, JPG, WebP — max 5MB. Recommended: 1300×400px</div>
            <input type="file" id="heroImageInput" name="hero_image" class="upload-input" accept="image/*" onchange="previewImage(this,'heroImageArea','heroPreview')"/>
            <div class="preview-overlay"><span>Click to change</span></div>
          </div>
          <div class="field-hint">This image is used as the full-width banner strip on the project detail page.</div>

          <br/>
          <label>Project Logo / Icon Image</label>
          <div class="image-upload-area" id="logoImageArea" style="padding: 1.2rem;" onclick="document.getElementById('logoImageInput').click()">
            <div style="display:flex; align-items:center; gap:.8rem;">
              <div class="upload-icon" style="margin:0; flex-shrink:0;"><svg viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/></svg></div>
              <div>
                <div class="upload-text" style="text-align:left; margin:0;">Upload logo / icon</div>
                <div class="upload-sub">Used in project cards and sidebar. Square preferred.</div>
              </div>
            </div>
            <input type="file" id="logoImageInput" name="logo_image" class="upload-input" accept="image/*" onchange="previewLogoImage(this)"/>
          </div>
        </div>
      </div>

      <!-- ===== SECTION 3: OVERVIEW ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon"><svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></div>
            <div>
              <div class="section-title">Overview Section</div>
              <div class="section-subtitle">Main description and stats row</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Overview Heading <span class="required">*</span></label>
            <input type="text" id="overviewHeading" name="overview_heading" placeholder="e.g. A New Standard for Creator Commerce"/>
          </div>
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Overview Paragraph 1 <span class="required">*</span></label>
            <textarea id="overviewP1" name="overview_p1" placeholder="First paragraph — set the scene and explain what the project is..." rows="3"></textarea>
          </div>
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Overview Paragraph 2</label>
            <textarea id="overviewP2" name="overview_p2" placeholder="Second paragraph — go deeper into features or scope..." rows="3"></textarea>
          </div>
          <div class="form-group" style="margin-bottom:1.5rem;">
            <label>Overview Paragraph 3</label>
            <textarea id="overviewP3" name="overview_p3" placeholder="Third paragraph — architecture, scale, or outcome..." rows="3"></textarea>
          </div>

          <label class="field-label">Stats Row (3 Metrics)</label>
          <div class="field-hint" style="margin-bottom:.8rem;">These appear as the three highlighted numbers below the overview text.</div>
          <div class="form-row triple">
            <div class="form-group">
              <label>Stat 1 — Number</label>
              <input type="text" id="stat1num" name="stat1_num" placeholder="e.g. 12+"/>
              <input type="text" id="stat1lbl" name="stat1_lbl" placeholder="Label: e.g. Core Features" style="margin-top:.4rem;"/>
            </div>
            <div class="form-group">
              <label>Stat 2 — Number</label>
              <input type="text" id="stat2num" name="stat2_num" placeholder="e.g. 3mo"/>
              <input type="text" id="stat2lbl" name="stat2_lbl" placeholder="Label: e.g. Delivery Time" style="margin-top:.4rem;"/>
            </div>
            <div class="form-group">
              <label>Stat 3 — Number</label>
              <input type="text" id="stat3num" name="stat3_num" placeholder="e.g. 99%"/>
              <input type="text" id="stat3lbl" name="stat3_lbl" placeholder="Label: e.g. Uptime SLA" style="margin-top:.4rem;"/>
            </div>
          </div>
        </div>
      </div>

      <!-- ===== SECTION 4: PROJECT INFO (SIDEBAR) ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg></div>
            <div>
              <div class="section-title">Project Info (Sidebar)</div>
              <div class="section-subtitle">Details shown in the right sidebar of the project page</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Services Delivered Tags</label>
            <div class="field-hint" style="margin-bottom:.5rem;">Tags shown in the "Services Delivered" card in the sidebar.</div>
            <div class="tag-input-wrap">
              <div class="tag-input-row">
                <input type="text" id="serviceTagInput" placeholder="e.g. UI/UX Design" onkeydown="if(event.key==='Enter'){event.preventDefault();addTag('serviceTagInput','serviceTagsDisplay','serviceTags');}"/>
                <button type="button" class="tag-add-btn" onclick="addTag('serviceTagInput','serviceTagsDisplay','serviceTags')">+ Add</button>
              </div>
              <div class="tags-display" id="serviceTagsDisplay"></div>
            </div>
            <input type="hidden" id="serviceTags" name="service_tags"/>
          </div>
        </div>
      </div>

      <!-- ===== SECTION 5: CHALLENGES & SOLUTIONS ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
            <div>
              <div class="section-title">Challenges &amp; Solutions</div>
              <div class="section-subtitle">Problems faced and how they were solved</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">
          <div class="repeater" id="challengesRepeater"></div>
          <button type="button" class="add-item-btn" onclick="addChallenge()">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Challenge &amp; Solution
          </button>
        </div>
      </div>

      <!-- ===== SECTION 6: TECH STACK ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon"><svg viewBox="0 0 24 24"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg></div>
            <div>
              <div class="section-title">Tech Stack &amp; Tools</div>
              <div class="section-subtitle">Technologies used in this project</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Stack Description</label>
            <textarea id="stackDesc" name="stack_description" placeholder="Brief description of the technology stack..." rows="2"></textarea>
          </div>
          <div class="form-group">
            <label>Tech Pills</label>
            <div class="field-hint" style="margin-bottom:.5rem;">Each entry becomes a pill badge in the tech grid.</div>
            <div class="tag-input-wrap">
              <div class="tag-input-row">
                <input type="text" id="techTagInput" placeholder="e.g. React" onkeydown="if(event.key==='Enter'){event.preventDefault();addTag('techTagInput','techTagsDisplay','techTags');}"/>
                <button type="button" class="tag-add-btn" onclick="addTag('techTagInput','techTagsDisplay','techTags')">+ Add</button>
              </div>
              <div class="tags-display" id="techTagsDisplay"></div>
            </div>
            <input type="hidden" id="techTags" name="tech_tags"/>
          </div>
        </div>
      </div>

      <!-- ===== SECTION 7: PROJECT TIMELINE ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon"><svg viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg></div>
            <div>
              <div class="section-title">Project Timeline</div>
              <div class="section-subtitle">Week-by-week milestones from kickoff to launch</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">
          <div class="form-row" style="margin-bottom:1rem;">
            <div class="form-group">
              <label>Timeline Heading</label>
              <input type="text" id="timelineHeading" name="timeline_heading" placeholder="e.g. From Kickoff to Launch"/>
            </div>
            <div class="form-group">
              <label>Timeline Subtext</label>
              <input type="text" id="timelineSubtext" name="timeline_subtext" placeholder="e.g. A focused 12-week sprint..."/>
            </div>
          </div>
          <div class="repeater" id="timelineRepeater"></div>
          <button type="button" class="add-item-btn" onclick="addTimelineEntry()">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Timeline Entry
          </button>
        </div>
      </div>

      <!-- ===== SECTION 8: MORE PROJECTS ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon"><svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg></div>
            <div>
              <div class="section-title">Related / More Projects</div>
              <div class="section-subtitle">Projects shown in the "More Projects" section at the bottom</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">
          <div class="repeater" id="moreProjectsRepeater"></div>
          <button type="button" class="add-item-btn" onclick="addMoreProject()">
            <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Related Project
          </button>
        </div>
      </div>

      <!-- ===== SECTION 9: SEO & META ===== -->
      <div class="form-section">
        <div class="section-header" onclick="toggleSection(this)">
          <div class="section-header-left">
            <div class="section-icon"><svg viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
            <div>
              <div class="section-title">SEO &amp; Meta</div>
              <div class="section-subtitle">Search engine and social sharing metadata</div>
            </div>
          </div>
          <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
        </div>
        <div class="section-body">
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Meta Title</label>
            <input type="text" id="metaTitle" name="meta_title" placeholder="e.g. Castlly — Project Detail | Hexafume" oninput="updateCharCount(this,'metaTitleCount',60)"/>
            <div class="char-counter" id="metaTitleCount">0 / 60</div>
          </div>
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Meta Description</label>
            <textarea id="metaDesc" name="meta_description" rows="3" placeholder="Brief description for search results (160 chars max)…" oninput="updateCharCount(this,'metaDescCount',160)"></textarea>
            <div class="char-counter" id="metaDescCount">0 / 160</div>
          </div>
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Keywords</label>
            <input type="text" id="metaKeywords" name="meta_keywords" placeholder="e.g. Castlly, Hexafume Project, Streaming Platform…"/>
          </div>
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Canonical URL</label>
            <input type="url" id="canonicalUrl" name="canonical_url" placeholder="https://hexafume.com/project/castlly"/>
          </div>
          <div class="form-row">
            <div class="form-group">
              <label>OG Image URL</label>
              <input type="url" id="ogImage" name="og_image_url" placeholder="https://…/og-image.png"/>
            </div>
            <div class="form-group">
              <label>Twitter Card</label>
              <select id="twitterCard" name="twitter_card">
                <option value="summary_large_image">Summary Large Image</option>
                <option value="summary">Summary</option>
              </select>
            </div>
          </div>

          <!-- Visibility toggles -->
          <div class="toggle-row">
            <div class="toggle-label-wrap">
              <div class="toggle-label">Index this page</div>
              <div class="toggle-sublabel">Allow search engines to crawl and index</div>
            </div>
            <label class="toggle"><input type="checkbox" id="seoIndex" name="seo_index" checked/><span class="toggle-track"></span></label>
          </div>

        </div>
      </div>

    </div><!-- /form-left -->

    <!-- RIGHT SIDEBAR PANEL -->
    <div class="form-sidebar">

      <!-- PUBLISH STATUS -->
      <div class="sidebar-panel">
        <div class="panel-header">Publish Settings</div>
        <div class="panel-body">
          <div class="form-group" style="margin-bottom:.9rem;">
            <label>Visibility</label>
            <select id="visibility" name="visibility">
              <option value="public">Public</option>
              <option value="private">Private (Draft)</option>
              <option value="password">Password Protected</option>
            </select>
          </div>
          <div class="form-group" style="margin-bottom:.9rem;">
            <label>Publish Date</label>
            <input type="date" id="publishDate" name="publish_at"/>
          </div>
          <div class="form-group">
            <label>Project URL Slug</label>
            <input type="text" id="urlSlug" name="url_slug" placeholder="castlly"/>
            <div class="field-hint">hexafume.com/project/<strong id="slugPreview">castlly</strong></div>
          </div>

          <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid var(--border);">
            <div class="toggle-row" style="margin-bottom: 1rem;">
              <div class="toggle-label-wrap">
                <div class="toggle-label" style="font-size: 0.85rem;">Show on Portfolio</div>
                <div class="toggle-sublabel" style="font-size: 0.75rem;">Display in portfolio</div>
              </div>
              <label class="toggle"><input type="checkbox" id="showPortfolio" name="show_portfolio" checked/><span class="toggle-track"></span></label>
            </div>
            <div class="toggle-row">
              <div class="toggle-label-wrap">
                <div class="toggle-label" style="font-size: 0.85rem;">Featured Project</div>
                <div class="toggle-sublabel" style="font-size: 0.75rem;">Show on the Homepage</div>
              </div>
              <label class="toggle"><input type="checkbox" id="isFeatured" name="is_featured"/><span class="toggle-track"></span></label>
            </div>
          </div>
        </div>
      </div>

      <!-- FORM PROGRESS -->
      <div class="sidebar-panel">
        <div class="panel-header">Completion</div>
        <div class="panel-body">
          <div style="margin-bottom:1rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;">
              <span style="font-size:.75rem;color:var(--w60);">Form progress</span>
              <span id="progressPct" style="font-size:.75rem;color:var(--blue-b);font-weight:700;">0%</span>
            </div>
            <div style="height:4px;background:var(--surface2);border-radius:100px;overflow:hidden;">
              <div id="progressBar" style="height:100%;background:linear-gradient(90deg,var(--blue),var(--blue-b));border-radius:100px;width:0%;transition:width .4s ease;"></div>
            </div>
          </div>
          <div class="steps-list" id="stepsList">
            <div class="step-item"><div class="step-dot active" id="step1dot">1</div><div class="step-content"><div class="step-name active-text" id="step1name">Basic Information</div></div></div>
            <div class="step-item"><div class="step-dot" id="step2dot">2</div><div class="step-content"><div class="step-name" id="step2name">Project Image</div></div></div>
            <div class="step-item"><div class="step-dot" id="step3dot">3</div><div class="step-content"><div class="step-name" id="step3name">Overview &amp; Stats</div></div></div>
            <div class="step-item"><div class="step-dot" id="step4dot">4</div><div class="step-content"><div class="step-name" id="step4name">Challenges</div></div></div>
            <div class="step-item"><div class="step-dot" id="step5dot">5</div><div class="step-content"><div class="step-name" id="step5name">Tech Stack</div></div></div>
            <div class="step-item"><div class="step-dot" id="step6dot">6</div><div class="step-content"><div class="step-name" id="step6name">Timeline</div></div></div>
            <div class="step-item"><div class="step-dot" id="step7dot">7</div><div class="step-content"><div class="step-name" id="step7name">SEO &amp; Meta</div></div></div>
          </div>
        </div>
      </div>

      <!-- TIPS -->
      <div class="sidebar-panel">
        <div class="panel-header">Tips</div>
        <div class="panel-body" style="font-size:.78rem;color:var(--w60);line-height:1.7;">
          <p style="margin-bottom:.6rem;">💡 Use <strong style="color:var(--w80);">bold project names</strong> and short, punchy headings for better impact.</p>
          <p style="margin-bottom:.6rem;">📷 Hero images look best at <strong style="color:var(--w80);">1300×400px</strong> with a dark or branded background.</p>
          <p style="margin-bottom:.6rem;">📊 Stats work best with real numbers — avoid vague estimates.</p>
          <p>🚀 Save as draft first, preview on frontend, then publish.</p>
        </div>
      </div>

    </div><!-- /form-sidebar -->

  </div><!-- /form-layout -->
</form>

<!-- SUCCESS TOAST -->
<div class="toast" id="toast">
  <div class="toast-icon"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
  <div class="toast-text">
    <strong id="toastTitle">Project Published!</strong>
    <span id="toastSub">The project has been saved to the database.</span>
  </div>
</div>
@endsection

@push('page_scripts')
<script>
const isEditMode = @json($isEditMode);
const editingProject = @json($editingProjectPayload);

// ===== SECTION TOGGLE =====
function toggleSection(header) {
  const body = header.nextElementSibling;
  const toggle = header.querySelector('.section-toggle');
  if (body.classList.contains('collapsed')) {
    body.classList.remove('collapsed');
    toggle.classList.add('open');
  } else {
    body.classList.add('collapsed');
    toggle.classList.remove('open');
  }
}

// ===== TAG SYSTEM =====
const tagStores = {};
function addTag(inputId, displayId, storeId) {
  const input = document.getElementById(inputId);
  const val = input.value.trim();
  if (!val) return;
  if (!tagStores[storeId]) tagStores[storeId] = [];
  if (tagStores[storeId].includes(val)) { input.value = ''; return; }
  tagStores[storeId].push(val);
  renderTags(displayId, storeId);
  input.value = '';
  updateProgress();
}
function removeTag(storeId, val, displayId) {
  tagStores[storeId] = (tagStores[storeId] || []).filter(t => t !== val);
  renderTags(displayId, storeId);
  updateProgress();
}
function renderTags(displayId, storeId) {
  const d = document.getElementById(displayId);
  if (!d) return;
  d.innerHTML = (tagStores[storeId] || []).map(t => `
    <span class="tag-chip">${t}
      <button type="button" onclick="removeTag('${storeId}','${t}','${displayId}')">×</button>
    </span>
  `).join('');
}

// ===== CHALLENGES REPEATER =====
let challengeCount = 0;
function addChallenge(data) {
  challengeCount++;
  const r = document.getElementById('challengesRepeater');
  const item = document.createElement('div');
  item.className = 'repeater-item';
  item.id = `challenge-${challengeCount}`;
  item.innerHTML = `
    <div class="repeater-item-header">
      <span class="repeater-item-num">Challenge #${challengeCount}</span>
      <button type="button" class="repeater-remove-btn" onclick="removeItem('challenge-${challengeCount}')"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    </div>
    <div class="form-group" style="margin-bottom:.7rem;">
      <label>Challenge Title</label>
      <input type="text" placeholder="e.g. High-bandwidth video ingestion at scale" value="${data?.title||''}"/>
    </div>
    <div class="form-group">
      <label>Solution Description</label>
      <textarea rows="3" placeholder="How was this challenge solved? What approach was taken?">${data?.solution||''}</textarea>
    </div>
  `;
  r.appendChild(item);
  updateProgress();
}

// ===== TIMELINE REPEATER =====
let timelineCount = 0;
function addTimelineEntry(data) {
  const selectedTagColor = data?.tag_color || (data?.tag_text === 'Launched' ? 'green' : (data?.tag_text ? 'amber' : 'blue'));
  timelineCount++;
  const r = document.getElementById('timelineRepeater');
  const item = document.createElement('div');
  item.className = 'repeater-item';
  item.id = `tl-${timelineCount}`;
  item.innerHTML = `
    <div class="repeater-item-header">
      <span class="repeater-item-num">Entry #${timelineCount}</span>
      <button type="button" class="repeater-remove-btn" onclick="removeItem('tl-${timelineCount}')"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Week / Date Label</label>
        <input type="text" placeholder="e.g. Week 1 — Jan 2025" value="${data?.date||''}"/>
      </div>
      <div class="form-group">
        <label>Entry Title</label>
        <input type="text" placeholder="e.g. Project Kickoff &amp; Discovery" value="${data?.title||''}"/>
      </div>
    </div>
    <div class="form-group" style="margin-bottom:.7rem;">
      <label>Description</label>
      <textarea rows="3" placeholder="What happened in this phase?">${data?.desc||''}</textarea>
    </div>
    <div class="form-group">
      <label>Tag / Badge</label>
      <div class="tl-tag-row">
        <button type="button" class="tl-tag-opt ${!data?.tag_text ? 'selected-blue' : ''}" onclick="selectTlTag(this,'none')">None</button>
        <button type="button" class="tl-tag-opt ${(data?.tag_text === 'Milestone' || selectedTagColor === 'blue') ? 'selected-blue' : ''}" onclick="selectTlTag(this,'milestone')">Milestone</button>
        <button type="button" class="tl-tag-opt ${(data?.tag_text === 'Design Phase' || (data?.tag_text && selectedTagColor === 'amber')) ? 'selected-amber' : ''}" onclick="selectTlTag(this,'design')">Design Phase</button>
        <button type="button" class="tl-tag-opt ${data?.tag_text === 'QA Phase' ? 'selected-amber' : ''}" onclick="selectTlTag(this,'qa')">QA Phase</button>
        <button type="button" class="tl-tag-opt ${(data?.tag_text === 'Launched' || selectedTagColor === 'green') ? 'selected-green' : ''}" onclick="selectTlTag(this,'launched')">Launched</button>
      </div>
    </div>
    <div style="margin-top:.5rem;">
      <label class="toggle-label" style="font-size:.75rem;display:flex;align-items:center;gap:.5rem;">
        <label class="toggle"><input type="checkbox" ${data?.is_milestone ? 'checked' : ''}/><span class="toggle-track"></span></label>
        Mark as Milestone (enlarged dot on timeline)
      </label>
    </div>
  `;
  r.appendChild(item);
  updateProgress();
}

function selectTlTag(btn, val) {
  const row = btn.closest('.tl-tag-row');
  row.querySelectorAll('.tl-tag-opt').forEach(b => {
    b.classList.remove('selected-blue','selected-green','selected-amber');
  });
  if (val === 'milestone') btn.classList.add('selected-blue');
  else if (val === 'launched') btn.classList.add('selected-green');
  else if (val === 'design' || val === 'qa') btn.classList.add('selected-amber');
}

// ===== MORE PROJECTS REPEATER =====
let moreProjectCount = 0;
function addMoreProject(data) {
  moreProjectCount++;
  const r = document.getElementById('moreProjectsRepeater');
  const item = document.createElement('div');
  item.className = 'repeater-item';
  item.id = `mp-${moreProjectCount}`;
  item.innerHTML = `
    <div class="repeater-item-header">
      <span class="repeater-item-num">Project #${moreProjectCount}</span>
      <button type="button" class="repeater-remove-btn" onclick="removeItem('mp-${moreProjectCount}')"><svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></button>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Project Name</label>
        <input type="text" placeholder="e.g. TradeBox" value="${data?.name||''}"/>
      </div>
      <div class="form-group">
        <label>Category</label>
        <input type="text" placeholder="e.g. Financial trading platform" value="${data?.cat||''}"/>
      </div>
    </div>
    <div class="form-group" style="margin-bottom:.7rem;">
      <label>Short Description</label>
      <textarea rows="2" placeholder="One or two sentences about the project.">${data?.desc||''}</textarea>
    </div>
    <div class="form-row">
      <div class="form-group">
        <label>Image URL / Path</label>
        <input type="text" placeholder="images/tradebox-logo.png" value="${data?.img||''}"/>
      </div>
      <div class="form-group">
        <label>Link</label>
        <input type="url" placeholder="https://tradebox.hexafume.com" value="${data?.link||''}"/>
      </div>
    </div>
  `;
  r.appendChild(item);
}

// ===== GENERIC REMOVE =====
function removeItem(id) {
  const el = document.getElementById(id);
  if (el) el.remove();
  updateProgress();
}

// ===== IMAGE PREVIEW =====
function previewImage(input, areaId, previewId) {
  const file = input.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function(e) {
    const area = document.getElementById(areaId);
    area.classList.add('has-image');
    const existing = area.querySelector('img.preview-img');
    if (existing) existing.remove();
    const img = document.createElement('img');
    img.className = 'preview-img';
    img.src = e.target.result;
    area.insertBefore(img, area.firstChild);
    updateProgress();
  };
  reader.readAsDataURL(file);
}

function previewLogoImage(input) {
  const file = input.files[0];
  if (!file) return;
  const reader = new FileReader();
  reader.onload = function(e) {
    const area = document.getElementById('logoImageArea');
    area.style.background = `url(${e.target.result}) center/contain no-repeat var(--surface2)`;
    area.style.minHeight = '80px';
  };
  reader.readAsDataURL(file);
}

// ===== SLUG =====
document.addEventListener('DOMContentLoaded', function() {
  const nameInput = document.getElementById('projectName');
  const slugInput = document.getElementById('urlSlug');
  const slugPreview = document.getElementById('slugPreview');
  nameInput.addEventListener('input', function() {
    const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
    slugInput.value = slug;
    slugPreview.textContent = slug || 'project-name';
    updateProgress();
  });
  slugInput.addEventListener('input', function() {
    slugPreview.textContent = this.value || 'project-name';
  });

  if (isEditMode && editingProject) {
    const fieldMap = {
      projectName: editingProject.name,
      urlSlug: editingProject.url_slug,
      projectType: editingProject.type,
      clientName: editingProject.client_name,
      siteUrl: editingProject.site_url,
      startDate: editingProject.start_date,
      finishDate: editingProject.finish_date,
      totalTime: editingProject.total_time,
      team: editingProject.team,
      projectStatus: editingProject.status,
      overviewHeading: editingProject.overview_heading,
      overviewP1: editingProject.overview_p1,
      overviewP2: editingProject.overview_p2,
      overviewP3: editingProject.overview_p3,
      stat1num: editingProject.stat1_num,
      stat1lbl: editingProject.stat1_lbl,
      stat2num: editingProject.stat2_num,
      stat2lbl: editingProject.stat2_lbl,
      stat3num: editingProject.stat3_num,
      stat3lbl: editingProject.stat3_lbl,
      stackDesc: editingProject.stack_description,
      timelineHeading: editingProject.timeline_heading,
      timelineSubtext: editingProject.timeline_subtext,
      metaTitle: editingProject.meta_title,
      metaDesc: editingProject.meta_description,
      metaKeywords: editingProject.meta_keywords,
      canonicalUrl: editingProject.canonical_url,
      ogImage: editingProject.og_image_url,
      twitterCard: editingProject.twitter_card,
      visibility: editingProject.visibility,
      publishDate: editingProject.publish_at,
    };

    Object.entries(fieldMap).forEach(([id, value]) => {
      const el = document.getElementById(id);
      if (el && value !== null && value !== undefined) {
        el.value = value;
      }
    });

    document.getElementById('deliveredOnTime').checked = !!editingProject.delivered_on_time;
    document.getElementById('seoIndex').checked = !!editingProject.seo_index;
    document.getElementById('showPortfolio').checked = !!editingProject.show_portfolio;
    document.getElementById('isFeatured').checked = !!editingProject.is_featured;
    slugPreview.textContent = editingProject.url_slug || 'project-name';

    // Show existing images
    if (editingProject.hero_image_url) {
      const area = document.getElementById('heroImageArea');
      area.classList.add('has-image');
      const img = document.createElement('img');
      img.className = 'preview-img';
      img.src = editingProject.hero_image_url;
      area.insertBefore(img, area.firstChild);
    }
    if (editingProject.logo_image_url) {
      const area = document.getElementById('logoImageArea');
      area.style.background = `url(${editingProject.logo_image_url}) center/contain no-repeat var(--surface2)`;
      area.style.minHeight = '80px';
    }

    tagStores.techTags = Array.isArray(editingProject.tech_tags) ? editingProject.tech_tags : [];
    tagStores.serviceTags = Array.isArray(editingProject.service_tags) ? editingProject.service_tags : [];
    renderTags('techTagsDisplay', 'techTags');
    renderTags('serviceTagsDisplay', 'serviceTags');

    (editingProject.challenges || []).forEach((c) => addChallenge(c));
    if ((editingProject.challenges || []).length === 0) addChallenge();

    (editingProject.timeline_entries || []).forEach((t) => addTimelineEntry({
      date: t.date_label,
      title: t.title,
      desc: t.description,
      tag_text: t.tag_text,
      tag_color: t.tag_color,
      is_milestone: t.is_milestone
    }));
    if ((editingProject.timeline_entries || []).length === 0) addTimelineEntry();

    (editingProject.related_projects || []).forEach((r) => addMoreProject({
      name: r.name,
      cat: r.category,
      desc: r.description,
      img: r.image_path,
      link: r.link_url
    }));
    if ((editingProject.related_projects || []).length === 0) addMoreProject();
  } else {
    // Pre-populate with defaults
    addChallenge();
    addTimelineEntry();
    addMoreProject();
  }

  updateProgress();
});

// ===== CHAR COUNTER =====
function updateCharCount(el, counterId, max) {
  const len = el.value.length;
  const counter = document.getElementById(counterId);
  counter.textContent = `${len} / ${max}`;
  counter.className = 'char-counter' + (len > max ? ' over' : len > max * .85 ? ' warn' : '');
}

// ===== PROGRESS =====
function updateProgress() {
  const checks = [
    !!document.getElementById('projectName').value,
    !!document.getElementById('projectType').value,
    !!document.getElementById('clientName').value,
    !!document.getElementById('heroImageInput').files.length || document.getElementById('heroImageArea').classList.contains('has-image'),
    !!document.getElementById('overviewHeading').value,
    !!document.getElementById('overviewP1').value,
    document.querySelectorAll('#challengesRepeater .repeater-item').length > 0,
    (tagStores['techTags'] || []).length > 0,
    document.querySelectorAll('#timelineRepeater .repeater-item').length > 0,
    !!document.getElementById('metaTitle').value,
  ];
  const done = checks.filter(Boolean).length;
  const pct = Math.round((done / checks.length) * 100);
  document.getElementById('progressBar').style.width = pct + '%';
  document.getElementById('progressPct').textContent = pct + '%';

  const dots = [
    document.getElementById('projectName').value,
    document.getElementById('heroImageArea').classList.contains('has-image'),
    document.getElementById('overviewHeading').value,
    document.querySelectorAll('#challengesRepeater .repeater-item').length > 0,
    (tagStores['techTags'] || []).length > 0,
    document.querySelectorAll('#timelineRepeater .repeater-item').length > 0,
    document.getElementById('metaTitle').value,
  ];
  dots.forEach((val, i) => {
    const dot = document.getElementById(`step${i+1}dot`);
    const name = document.getElementById(`step${i+1}name`);
    if (!dot) return;
    if (val) {
      dot.classList.add('done'); dot.classList.remove('active');
      dot.textContent = '✓';
      name.classList.add('done-text'); name.classList.remove('active-text');
    }
  });
}

// ===== PUBLISH / DRAFT =====
function showToast(title, sub) {
  const t = document.getElementById('toast');
  document.getElementById('toastTitle').textContent = title;
  document.getElementById('toastSub').textContent = sub;
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 3500);
}

async function publishProject() {
  const name = document.getElementById('projectName').value.trim();
  if (!name) {
    alert('Please enter a project name before publishing.');
    document.getElementById('projectName').focus();
    return;
  }

  const btn = document.querySelector('.publish-btn');
  const origContent = btn.innerHTML;
  btn.disabled = true;
  btn.innerHTML = 'Publishing...';

  try {
    const formData = new FormData();

    // Basic Info
    formData.append('name', document.getElementById('projectName').value);
    formData.append('url_slug', document.getElementById('urlSlug').value);
    formData.append('type', document.getElementById('projectType').value);
    formData.append('client_name', document.getElementById('clientName').value);
    formData.append('site_url', document.getElementById('siteUrl').value);
    formData.append('start_date', document.getElementById('startDate').value);
    formData.append('finish_date', document.getElementById('finishDate').value);
    formData.append('total_time', document.getElementById('totalTime').value);
    formData.append('team', document.getElementById('team').value);
    formData.append('status', document.getElementById('projectStatus').value);
    formData.append('delivered_on_time', document.getElementById('deliveredOnTime').checked ? 1 : 0);

    // Images
    const heroImg = document.getElementById('heroImageInput').files[0];
    if (heroImg) formData.append('hero_image', heroImg);
    const logoImg = document.getElementById('logoImageInput').files[0];
    if (logoImg) formData.append('logo_image', logoImg);

    // Overview
    formData.append('overview_heading', document.getElementById('overviewHeading').value);
    formData.append('overview_p1', document.getElementById('overviewP1').value);
    formData.append('overview_p2', document.getElementById('overviewP2').value);
    formData.append('overview_p3', document.getElementById('overviewP3').value);

    // Stats
    formData.append('stat1_num', document.getElementById('stat1num').value);
    formData.append('stat1_lbl', document.getElementById('stat1lbl').value);
    formData.append('stat2_num', document.getElementById('stat2num').value);
    formData.append('stat2_lbl', document.getElementById('stat2lbl').value);
    formData.append('stat3_num', document.getElementById('stat3num').value);
    formData.append('stat3_lbl', document.getElementById('stat3lbl').value);

    // Tech Stack
    formData.append('stack_description', document.getElementById('stackDesc').value);
    formData.append('tech_tags', JSON.stringify(tagStores['techTags'] || []));
    formData.append('service_tags', JSON.stringify(tagStores['serviceTags'] || []));

    // Timeline
    formData.append('timeline_heading', document.getElementById('timelineHeading').value);
    formData.append('timeline_subtext', document.getElementById('timelineSubtext').value);

    // SEO
    formData.append('meta_title', document.getElementById('metaTitle').value);
    formData.append('meta_description', document.getElementById('metaDesc').value);
    formData.append('meta_keywords', document.getElementById('metaKeywords').value);
    formData.append('canonical_url', document.getElementById('canonicalUrl').value);
    formData.append('og_image_url', document.getElementById('ogImage').value);
    formData.append('twitter_card', document.getElementById('twitterCard').value);
    formData.append('seo_index', document.getElementById('seoIndex').checked ? 1 : 0);
    formData.append('show_portfolio', document.getElementById('showPortfolio').checked ? 1 : 0);
    formData.append('is_featured', document.getElementById('isFeatured').checked ? 1 : 0);

    // Publish Details
    formData.append('visibility', document.getElementById('visibility').value);
    formData.append('publish_at', document.getElementById('publishDate').value);

    // Repeaters
    const challenges = [];
    document.querySelectorAll('#challengesRepeater .repeater-item').forEach(item => {
      challenges.push({
        title: item.querySelector('input').value,
        solution: item.querySelector('textarea').value
      });
    });
    formData.append('challenges', JSON.stringify(challenges));

    const timeline = [];
    document.querySelectorAll('#timelineRepeater .repeater-item').forEach(item => {
      timeline.push({
        date_label: item.querySelectorAll('input')[0].value,
        title: item.querySelectorAll('input')[1].value,
        description: item.querySelector('textarea').value,
        tag_text: item.querySelector('.tl-tag-opt.selected-blue, .tl-tag-opt.selected-green, .tl-tag-opt.selected-amber')?.textContent || null,
        tag_color: item.querySelector('.tl-tag-opt.selected-blue') ? 'blue' : (item.querySelector('.tl-tag-opt.selected-green') ? 'green' : (item.querySelector('.tl-tag-opt.selected-amber') ? 'amber' : null)),
        is_milestone: item.querySelector('.toggle input').checked ? 1 : 0
      });
    });
    formData.append('timeline', JSON.stringify(timeline));

    const related = [];
    document.querySelectorAll('#moreProjectsRepeater .repeater-item').forEach(item => {
      const inputs = item.querySelectorAll('input');
      related.push({
        name: inputs[0].value,
        category: inputs[1].value,
        description: item.querySelector('textarea').value,
        image_path: inputs[2].value,
        link_url: inputs[3].value
      });
    });
    formData.append('related_projects', JSON.stringify(related));

    let endpoint = '{{ route("admin.projects.store") }}';
    if (isEditMode && editingProject?.id) {
      endpoint = `/admin/projects/${editingProject.id}`;
      formData.append('_method', 'PUT');
    }

    const response = await fetch(endpoint, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
        'Accept': 'application/json'
      }
    });

    const result = await response.json();

    if (response.ok && result.success) {
      Swal.fire({
        icon: 'success',
        title: isEditMode ? 'Project Updated!' : 'Project Published!',
        text: result.message,
        confirmButtonColor: 'var(--blue)',
      });

      if (result.notification && typeof window.showAdminNotificationToast === 'function') {
        window.showAdminNotificationToast(result.notification.title, result.notification.message);
      }
    } else {
      let errorMsg = result.message || 'Something went wrong.';
      if (result.errors) {
        errorMsg = Object.values(result.errors).flat().join('\n');
      }
      Swal.fire({
        icon: 'error',
        title: 'Publishing Failed',
        text: errorMsg,
        confirmButtonColor: 'var(--blue)',
      });
    }
  } catch (err) {
    console.error(err);
    Swal.fire({
      icon: 'error',
      title: 'Oops!',
      text: 'An unexpected error occurred. Please check the console.',
      confirmButtonColor: 'var(--blue)',
    });
  } finally {
    btn.disabled = false;
    btn.innerHTML = origContent;
  }
}

function saveDraft() {
  document.getElementById('projectStatus').value = 'draft';
  document.getElementById('visibility').value = 'private';
  publishProject();
}

// Listen to any input change to update progress
document.addEventListener('input', updateProgress);
</script>
@endpush
