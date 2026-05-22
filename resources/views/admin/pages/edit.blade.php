@extends('layouts.admin')

@section('title', 'Edit Page — ' . $page->name)
@section('page_title', 'Edit Page: ' . $page->name)

@section('breadcrumb')
  <a href="{{ route('admin.dashboard') }}">Admin</a> ›
  <a href="{{ route('admin.pages.index') }}">Pages</a> ›
  <span>Edit Content</span>
@endsection

@section('topbar_actions')
  <button class="save-draft-btn">Preview Page</button>
  <button class="publish-btn" onclick="updatePage()">
    <svg viewBox="0 0 24 24"><path d="M22 2L11 13"/><path d="M22 2L15 22l-4-9-9-4 20-7z"/></svg>
    Update Page Content
  </button>
@endsection

@push('page_styles')
<link rel="stylesheet" href="{{ asset('css/admin-add-project.css') }}">
<style>
  .section-body.collapsed { display: none; }
  .repeater-item { margin-bottom: 1rem; }
  .tl-tag-row { display: flex; gap: 0.5rem; margin-top: 0.5rem; }
  .tl-tag-opt { padding: 0.2rem 0.6rem; border-radius: 100px; font-size: 0.7rem; cursor: pointer; border: 1px solid var(--border); }
  .tl-tag-opt.active { background: var(--blue); color: #fff; border-color: var(--blue); }
</style>
@endpush

@section('content')
<form id="pageEditForm" onsubmit="event.preventDefault(); updatePage();">
  @csrf
  @method('PUT')
  <div class="form-layout">

    <!-- LEFT COLUMN: CONTENT SECTIONS -->
    <div class="form-left">
      
      @foreach($page->sections as $section)
        <div class="form-section" id="section-{{ $section->section_key }}" data-section-key="{{ $section->section_key }}">
          <div class="section-header" onclick="toggleSection(this)">
            <div class="section-header-left">
              <div class="section-icon">
                <svg viewBox="0 0 24 24">
                  @if($section->section_key == 'hero')
                    <path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/>
                  @elseif($section->section_key == 'about' || $section->section_key == 'story')
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                  @else
                    <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/>
                  @endif
                </svg>
              </div>
              <div>
                <div class="section-title">{{ ucfirst(str_replace('_', ' ', $section->section_key)) }} Section</div>
                <div class="section-subtitle">Manage the text, media, and layout for this area</div>
              </div>
            </div>
            <div class="section-toggle open"><svg viewBox="0 0 24 24"><polyline points="18 15 12 9 6 15"/></svg></div>
          </div>

          <div class="section-body">
            @php $content = $section->content; @endphp

            @if($section->section_key == 'hero')
              <div class="form-row">
                <div class="form-group"><label>Badge</label><input type="text" name="sections[hero][badge]" value="{{ $content['badge'] ?? '' }}"/></div>
                <div class="form-group"><label>Title</label><input type="text" name="sections[hero][title]" value="{{ $content['title'] ?? '' }}"/></div>
              </div>
              <div class="form-group" style="margin-top:1rem;"><label>Subtitle</label><textarea name="sections[hero][subtitle]" rows="2">{{ $content['subtitle'] ?? '' }}</textarea></div>
              
              @if(isset($content['tags']))
                <div style="margin-top:1.5rem;">
                  <label class="field-label">Service Tags (Services Page Only)</label>
                  <div class="repeater" id="heroTagsRepeater">
                    @foreach($content['tags'] as $idx => $tag)
                      <div class="repeater-item">
                        <div class="repeater-item-header">
                          <span class="repeater-item-num">Tag #{{ $idx+1 }}</span>
                          <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                        </div>
                        <div class="form-group"><input type="text" name="sections[hero][tags][{{ $idx }}]" value="{{ $tag }}"/></div>
                      </div>
                    @endforeach
                  </div>
                  <button type="button" class="add-item-btn" onclick="addHeroTag()">+ Add Tag</button>
                </div>
              @endif

              @if(isset($content['stats']))
                <div style="margin-top:1.5rem;">
                  <label class="field-label">Hero Stats</label>
                  <div class="repeater" id="heroStatsRepeater">
                    @foreach($content['stats'] as $idx => $stat)
                      <div class="repeater-item">
                        <div class="repeater-item-header">
                          <span class="repeater-item-num">Stat #{{ $idx+1 }}</span>
                          <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                        </div>
                        <div class="form-row">
                          <div class="form-group"><label>Number</label><input type="text" name="sections[hero][stats][{{ $idx }}][num]" value="{{ $stat['num'] ?? $stat['value'] ?? '' }}"/></div>
                          <div class="form-group"><label>Label</label><input type="text" name="sections[hero][stats][{{ $idx }}][label]" value="{{ $stat['label'] ?? '' }}"/></div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                  <button type="button" class="add-item-btn" onclick="addHeroStat()">+ Add Stat</button>
                </div>
              @endif

            @elseif($section->section_key == 'about')
              <div class="form-row">
                <div class="form-group"><label>Badge</label><input type="text" name="sections[about][badge]" value="{{ $content['badge'] ?? '' }}"/></div>
                <div class="form-group"><label>Title</label><input type="text" name="sections[about][title]" value="{{ $content['title'] ?? '' }}"/></div>
              </div>
              <div class="form-group" style="margin-top:1rem;"><label>Paragraph 1</label><textarea name="sections[about][desc_p1]" rows="3">{{ $content['desc_p1'] ?? '' }}</textarea></div>
              <div class="form-group" style="margin-top:1rem;"><label>Paragraph 2</label><textarea name="sections[about][desc_p2]" rows="3">{{ $content['desc_p2'] ?? '' }}</textarea></div>
              
              @if(isset($content['pillars']))
                <div style="margin-top:1.5rem;">
                  <label class="field-label">About Pillars (Home Page Only)</label>
                  <div class="repeater" id="pillarsRepeater-about">
                    @foreach($content['pillars'] as $idx => $item)
                      <div class="repeater-item">
                        <div class="repeater-item-header">
                          <span class="repeater-item-num">Pillar #{{ $idx+1 }}</span>
                          <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                        </div>
                        <div class="form-row">
                          <div class="form-group" style="flex:0 0 80px;"><label>Icon</label><input type="text" name="sections[about][pillars][{{ $idx }}][icon]" value="{{ $item['icon'] ?? '' }}"/></div>
                          <div class="form-group"><label>Title</label><input type="text" name="sections[about][pillars][{{ $idx }}][title]" value="{{ $item['title'] }}"/></div>
                        </div>
                        <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[about][pillars][{{ $idx }}][desc]" rows="2">{{ $item['desc'] }}</textarea></div>
                      </div>
                    @endforeach
                  </div>
                  <button type="button" class="add-item-btn" onclick="addPillar('about', 'sections[about][pillars]')">+ Add Pillar</button>
                </div>
              @endif

            @elseif($section->section_key == 'story')
              <div class="form-row">
                <div class="form-group"><label>Badge</label><input type="text" name="sections[story][badge]" value="{{ $content['badge'] ?? '' }}"/></div>
                <div class="form-group"><label>Title</label><input type="text" name="sections[story][title]" value="{{ $content['title'] ?? '' }}"/></div>
              </div>
              <div class="form-group" style="margin-top:1rem;"><label>Intro Text</label><textarea name="sections[story][p1]" rows="3">{{ $content['p1'] ?? '' }}</textarea></div>
              
              <div style="margin-top:1.5rem;">
                <label class="field-label">Timeline Milestones</label>
                <div class="repeater" id="storyTimelineRepeater">
                  @foreach($content['timeline'] ?? [] as $idx => $item)
                    <div class="repeater-item">
                      <div class="repeater-item-header">
                        <span class="repeater-item-num">Milestone #{{ $idx+1 }}</span>
                        <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                      </div>
                      <div class="form-row">
                        <div class="form-group"><label>Year</label><input type="text" name="sections[story][timeline][{{ $idx }}][year]" value="{{ $item['year'] }}"/></div>
                        <div class="form-group"><label>Title</label><input type="text" name="sections[story][timeline][{{ $idx }}][title]" value="{{ $item['title'] }}"/></div>
                      </div>
                      <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[story][timeline][{{ $idx }}][desc]" rows="2">{{ $item['desc'] }}</textarea></div>
                    </div>
                  @endforeach
                </div>
                <button type="button" class="add-item-btn" onclick="addTimelineItem()">+ Add Milestone</button>
              </div>

            @elseif($section->section_key == 'mission_vision')
              <div class="form-row">
                <div class="form-group"><label>Mission Title</label><input type="text" name="sections[mission_vision][mission_title]" value="{{ $content['mission_title'] ?? '' }}"/></div>
                <div class="form-group"><label>Vision Title</label><input type="text" name="sections[mission_vision][vision_title]" value="{{ $content['vision_title'] ?? '' }}"/></div>
              </div>
              <div class="form-row">
                <div class="form-group"><label>Mission Text</label><textarea name="sections[mission_vision][mission_text]" rows="3">{{ $content['mission_text'] ?? '' }}</textarea></div>
                <div class="form-group"><label>Vision Text</label><textarea name="sections[mission_vision][vision_text]" rows="3">{{ $content['vision_text'] ?? '' }}</textarea></div>
              </div>

              <div style="margin-top:1.5rem;">
                <label class="field-label">Core Values</label>
                <div class="repeater" id="valuesRepeater">
                  @foreach($content['values'] ?? [] as $idx => $val)
                    <div class="repeater-item">
                      <div class="repeater-item-header">
                        <span class="repeater-item-num">Value #{{ $idx+1 }}</span>
                        <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                      </div>
                      <div class="form-row">
                        <div class="form-group" style="flex:0 0 60px;"><label>Emoji</label><input type="text" name="sections[mission_vision][values][{{ $idx }}][emoji]" value="{{ $val['emoji'] }}"/></div>
                        <div class="form-group"><label>Title</label><input type="text" name="sections[mission_vision][values][{{ $idx }}][title]" value="{{ $val['title'] }}"/></div>
                      </div>
                      <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[mission_vision][values][{{ $idx }}][text]" rows="2">{{ $val['text'] }}</textarea></div>
                    </div>
                  @endforeach
                </div>
                <button type="button" class="add-item-btn" onclick="addValueItem()">+ Add Value</button>
              </div>

            @elseif($section->section_key == 'pillars' || ($section->section_key == 'about' && isset($content['pillars'])))
              @php $baseKey = ($section->section_key == 'about') ? "sections[about][pillars]" : "sections[pillars][items]"; @endphp
              <div class="repeater" id="pillarsRepeater-{{ $section->section_key }}">
                @foreach($content['items'] ?? $content['pillars'] ?? [] as $idx => $item)
                  <div class="repeater-item">
                    <div class="repeater-item-header">
                      <span class="repeater-item-num">Pillar #{{ $idx+1 }}</span>
                      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                    </div>
                    <div class="form-row">
                      <div class="form-group" style="flex:0 0 80px;"><label>Icon/Emoji</label><input type="text" name="{{ $baseKey }}[{{ $idx }}][icon]" value="{{ $item['icon'] ?? $item['emoji'] ?? '' }}"/></div>
                      <div class="form-group"><label>Title</label><input type="text" name="{{ $baseKey }}[{{ $idx }}][title]" value="{{ $item['title'] }}"/></div>
                    </div>
                    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="{{ $baseKey }}[{{ $idx }}][desc]" rows="2">{{ $item['desc'] }}</textarea></div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="add-item-btn" onclick="addPillar('{{ $section->section_key }}', '{{ $baseKey }}')">+ Add Pillar</button>

            @elseif($section->section_key == 'features_strip')
              <div class="repeater" id="featuresRepeater">
                @foreach($content['items'] ?? [] as $idx => $item)
                  <div class="repeater-item">
                    <div class="repeater-item-header">
                      <span class="repeater-item-num">Feature #{{ $idx+1 }}</span>
                      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                    </div>
                    <div class="form-row">
                      <div class="form-group" style="flex:0 0 80px;"><label>Icon</label><input type="text" name="sections[features_strip][items][{{ $idx }}][icon]" value="{{ $item['icon'] }}"/></div>
                      <div class="form-group"><label>Title</label><input type="text" name="sections[features_strip][items][{{ $idx }}][title]" value="{{ $item['title'] }}"/></div>
                    </div>
                    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[features_strip][items][{{ $idx }}][desc]" rows="2">{{ $item['desc'] }}</textarea></div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="add-item-btn" onclick="addFeature()">+ Add Feature</button>

            @elseif($section->section_key == 'phases')
              <div class="repeater" id="phasesRepeater">
                @foreach($content['items'] ?? [] as $idx => $item)
                  <div class="repeater-item">
                    <div class="repeater-item-header">
                      <span class="repeater-item-num">Phase #{{ $idx+1 }}</span>
                      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                    </div>
                    <div class="form-row">
                      <div class="form-group"><label>Title</label><input type="text" name="sections[phases][items][{{ $idx }}][title]" value="{{ $item['title'] }}"/></div>
                      <div class="form-group" style="flex:0 0 120px;"><label>Badge</label><input type="text" name="sections[phases][items][{{ $idx }}][badge]" value="{{ $item['badge'] }}"/></div>
                    </div>
                    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[phases][items][{{ $idx }}][desc]" rows="2">{{ $item['desc'] }}</textarea></div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="add-item-btn" onclick="addPhase()">+ Add Phase</button>

            @elseif($section->section_key == 'tools')
              <div class="repeater" id="toolsRepeater">
                @foreach($content['items'] ?? [] as $idx => $item)
                  <div class="repeater-item">
                    <div class="repeater-item-header">
                      <span class="repeater-item-num">Tool #{{ $idx+1 }}</span>
                      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                    </div>
                    <div class="form-row">
                      <div class="form-group" style="flex:0 0 80px;"><label>Emoji</label><input type="text" name="sections[tools][items][{{ $idx }}][emoji]" value="{{ $item['emoji'] }}"/></div>
                      <div class="form-group"><label>Title</label><input type="text" name="sections[tools][items][{{ $idx }}][title]" value="{{ $item['title'] }}"/></div>
                    </div>
                    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[tools][items][{{ $idx }}][desc]" rows="2">{{ $item['desc'] }}</textarea></div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="add-item-btn" onclick="addTool()">+ Add Tool</button>

            @elseif($section->section_key == 'impact')
              <div class="repeater" id="impactRepeater">
                @foreach($content['items'] ?? [] as $idx => $item)
                  <div class="repeater-item">
                    <div class="repeater-item-header">
                      <span class="repeater-item-num">Impact Stat #{{ $idx+1 }}</span>
                      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                    </div>
                    <div class="form-row">
                      <div class="form-group" style="flex:0 0 80px;"><label>Icon/Emoji</label><input type="text" name="sections[impact][items][{{ $idx }}][icon]" value="{{ $item['icon'] }}"/></div>
                      <div class="form-group"><label>Number/Value</label><input type="text" name="sections[impact][items][{{ $idx }}][num]" value="{{ $item['num'] }}"/></div>
                    </div>
                    <div class="form-group" style="margin-top:.5rem;"><label>Label</label><input type="text" name="sections[impact][items][{{ $idx }}][label]" value="{{ $item['label'] }}"/></div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="add-item-btn" onclick="addImpactItem()">+ Add Impact Stat</button>

            @elseif($section->section_key == 'culture')
              <div class="repeater" id="cultureRepeater">
                @foreach($content['items'] ?? [] as $idx => $item)
                  <div class="repeater-item">
                    <div class="repeater-item-header">
                      <span class="repeater-item-num">Principle #{{ $idx+1 }}</span>
                      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                    </div>
                    <div class="form-group"><label>Title</label><input type="text" name="sections[culture][items][{{ $idx }}][title]" value="{{ $item['title'] }}"/></div>
                    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[culture][items][{{ $idx }}][desc]" rows="2">{{ $item['desc'] }}</textarea></div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="add-item-btn" onclick="addCultureItem()">+ Add Principle</button>

            @elseif($section->section_key == 'faq')
              <div class="repeater" id="faqRepeater">
                @foreach($content['items'] ?? [] as $idx => $item)
                  <div class="repeater-item">
                    <div class="repeater-item-header">
                      <span class="repeater-item-num">Question #{{ $idx+1 }}</span>
                      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                    </div>
                    <div class="form-group"><label>Question</label><input type="text" name="sections[faq][items][{{ $idx }}][q]" value="{{ $item['q'] }}"/></div>
                    <div class="form-group" style="margin-top:.5rem;"><label>Answer</label><textarea name="sections[faq][items][{{ $idx }}][a]" rows="2">{{ $item['a'] }}</textarea></div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="add-item-btn" onclick="addFaqItem()">+ Add FAQ</button>

            @elseif($section->section_key == 'cta')
              <div class="form-row">
                <div class="form-group"><label>Title</label><input type="text" name="sections[cta][title]" value="{{ $content['title'] ?? '' }}"/></div>
                <div class="form-group"><label>Subtitle</label><input type="text" name="sections[cta][subtitle]" value="{{ $content['subtitle'] ?? '' }}"/></div>
              </div>
              <div class="form-row">
                <div class="form-group"><label>Button 1 Text</label><input type="text" name="sections[cta][btn1_text]" value="{{ $content['btn1_text'] ?? 'Start Project' }}"/></div>
                <div class="form-group"><label>Button 2 Text</label><input type="text" name="sections[cta][btn2_text]" value="{{ $content['btn2_text'] ?? 'Contact Us' }}"/></div>
              </div>

            @elseif($section->section_key == 'marquee')
              <div style="margin-top:0.5rem;">
                <label class="field-label">Marquee Items</label>
                <div class="repeater" id="marqueeItemsRepeater">
                  @foreach($content['items'] ?? [] as $idx => $item)
                    <div class="repeater-item">
                      <div class="repeater-item-header">
                        <span class="repeater-item-num">Item #{{ $idx+1 }}</span>
                        <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                      </div>
                      <div class="form-group"><input type="text" name="sections[marquee][items][{{ $idx }}]" value="{{ $item }}"/></div>
                    </div>
                  @endforeach
                </div>
                <button type="button" class="add-item-btn" onclick="addMarqueeItem()">+ Add Marquee Item</button>
              </div>

            @elseif(str_ends_with($section->section_key, '_header'))
              <div class="form-row">
                <div class="form-group"><label>Section Badge</label><input type="text" name="sections[{{ $section->section_key }}][badge]" value="{{ $content['badge'] ?? '' }}"/></div>
                <div class="form-group"><label>Section Title</label><input type="text" name="sections[{{ $section->section_key }}][title]" value="{{ $content['title'] ?? '' }}"/></div>
              </div>
              @if(isset($content['subtitle']) || $section->section_key != 'testimonials_header')
                <div class="form-group" style="margin-top:1rem;"><label>Section Subtitle</label><textarea name="sections[{{ $section->section_key }}][subtitle]" rows="2">{{ $content['subtitle'] ?? '' }}</textarea></div>
              @endif

            @elseif($section->section_key == 'contact_header')
              <div class="form-row">
                <div class="form-group"><label>Section Badge</label><input type="text" name="sections[contact_header][badge]" value="{{ $content['badge'] ?? '' }}"/></div>
                <div class="form-group"><label>Section Title</label><input type="text" name="sections[contact_header][title]" value="{{ $content['title'] ?? '' }}"/></div>
              </div>
              <div class="form-group" style="margin-top:1rem;"><label>Section Subtitle</label><textarea name="sections[contact_header][subtitle]" rows="2">{{ $content['subtitle'] ?? '' }}</textarea></div>
              
              <div style="margin-top:1.5rem; display:grid; grid-template-columns: 1fr 1fr; gap:1rem;">
                <div class="form-group"><label>Address Label</label><input type="text" name="sections[contact_header][address_label]" value="{{ $content['address_label'] ?? '' }}"/></div>
                <div class="form-group"><label>Address Value</label><input type="text" name="sections[contact_header][address]" value="{{ $content['address'] ?? '' }}"/></div>
                <div class="form-group"><label>Email Label</label><input type="text" name="sections[contact_header][email_label]" value="{{ $content['email_label'] ?? '' }}"/></div>
                <div class="form-group"><label>Email Value</label><input type="text" name="sections[contact_header][email]" value="{{ $content['email'] ?? '' }}"/></div>
                <div class="form-group"><label>Phone Label</label><input type="text" name="sections[contact_header][phone_label]" value="{{ $content['phone_label'] ?? '' }}"/></div>
                <div class="form-group"><label>Phone Value</label><input type="text" name="sections[contact_header][phone]" value="{{ $content['phone'] ?? '' }}"/></div>
              </div>

            @elseif($section->section_key == 'contact_items')
              <div class="repeater" id="contactItemsRepeater">
                @foreach($content['items'] ?? [] as $idx => $item)
                  <div class="repeater-item">
                    <div class="repeater-item-header">
                      <span class="repeater-item-num">Contact Method #{{ $idx+1 }}</span>
                      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                    </div>
                    <div class="form-row">
                      <div class="form-group"><label>Title (e.g. Email Us)</label><input type="text" name="sections[contact_items][items][{{ $idx }}][title]" value="{{ $item['title'] }}"/></div>
                      <div class="form-group"><label>Value (e.g. hello@hex.com)</label><input type="text" name="sections[contact_items][items][{{ $idx }}][value]" value="{{ $item['value'] }}"/></div>
                    </div>
                    <div class="form-group" style="margin-top:.5rem;"><label>Link (e.g. mailto:hello@hex.com or #)</label><input type="text" name="sections[contact_items][items][{{ $idx }}][link]" value="{{ $item['link'] ?? '#' }}"/></div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="add-item-btn" onclick="addContactItem()">+ Add Contact Method</button>

            @elseif($section->section_key == 'socials')
              <div class="repeater" id="socialsRepeater">
                @foreach($content['items'] ?? [] as $idx => $item)
                  <div class="repeater-item">
                    <div class="repeater-item-header">
                      <span class="repeater-item-num">Social Link #{{ $idx+1 }}</span>
                      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                    </div>
                    <div class="form-row">
                      <div class="form-group"><label>Platform</label><input type="text" name="sections[socials][items][{{ $idx }}][platform]" value="{{ $item['platform'] }}"/></div>
                      <div class="form-group"><label>URL</label><input type="text" name="sections[socials][items][{{ $idx }}][link]" value="{{ $item['link'] }}"/></div>
                    </div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="add-item-btn" onclick="addSocialLink()">+ Add Social Link</button>

            @elseif($section->section_key == 'offices')
               <div class="repeater" id="officesRepeater">
                @foreach($content['items'] ?? [] as $idx => $item)
                  <div class="repeater-item">
                    <div class="repeater-item-header">
                      <span class="repeater-item-num">Location #{{ $idx+1 }}</span>
                      <button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button>
                    </div>
                    <div class="form-row">
                      <div class="form-group" style="flex:0 0 80px;"><label>Flag</label><input type="text" name="sections[offices][items][{{ $idx }}][flag]" value="{{ $item['flag'] ?? '' }}"/></div>
                      <div class="form-group"><label>City</label><input type="text" name="sections[offices][items][{{ $idx }}][city]" value="{{ $item['city'] ?? $item['name'] ?? '' }}"/></div>
                    </div>
                    <div class="form-group" style="margin-top:.5rem;"><label>Details (Address/Phone)</label><textarea name="sections[offices][items][{{ $idx }}][details]" rows="2">{{ $item['details'] ?? $item['address'] ?? '' }}</textarea></div>
                    <div class="form-group" style="margin-top:.5rem;"><label>Status (e.g. Open Now)</label><input type="text" name="sections[offices][items][{{ $idx }}][status]" value="{{ $item['status'] ?? '' }}"/></div>
                  </div>
                @endforeach
              </div>
              <button type="button" class="add-item-btn" onclick="addOffice()">+ Add Office</button>

            @else
              <div class="form-group">
                <label>Generic JSON Content</label>
                <div style="font-size:.7rem;color:var(--w60);margin-bottom:.5rem;">This section uses a generic editor. Best used for simple text pairs.</div>
                @foreach($content ?? [] as $key => $val)
                  @if(is_string($val))
                    <div class="form-group" style="margin-bottom:.8rem;">
                      <label style="text-transform:capitalize;">{{ str_replace('_', ' ', $key) }}</label>
                      <input type="text" name="sections[{{ $section->section_key }}][{{ $key }}]" value="{{ $val }}"/>
                    </div>
                  @endif
                @endforeach
              </div>
            @endif
          </div>
        </div>
      @endforeach

    </div><!-- /form-left -->

    <!-- RIGHT SIDEBAR -->
    <div class="form-sidebar">
      
      <!-- PAGE INFO -->
      <div class="sidebar-panel">
        <div class="panel-header">General Info</div>
        <div class="panel-body">
          <div class="form-group">
            <label>Admin Display Name</label>
            <input type="text" name="name" value="{{ $page->name }}"/>
          </div>
          <div class="form-row single" style="margin-top:1rem;">
            <div class="form-group">
              <label>Slug / URL</label>
              <input type="text" disabled value="{{ $page->slug }}" style="opacity:.6;cursor:not-allowed;"/>
              <div class="field-hint">hexafume.com/<strong>{{ $page->slug == 'home' ? '' : $page->slug }}</strong></div>
            </div>
          </div>
        </div>
      </div>

      <!-- SEO PANEL -->
      <div class="sidebar-panel">
        <div class="panel-header">SEO &amp; Meta Settings</div>
        <div class="panel-body">
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Meta Title</label>
            <input type="text" name="meta_title" value="{{ $page->meta_title }}" placeholder="Page header title..."/>
          </div>
          <div class="form-group" style="margin-bottom:1rem;">
            <label>Meta Description</label>
            <textarea name="meta_description" rows="3">{{ $page->meta_description }}</textarea>
          </div>
          <div class="form-group">
            <label>Keywords</label>
            <input type="text" name="meta_keywords" value="{{ $page->meta_keywords }}" placeholder="Comma separated..."/>
          </div>
        </div>
      </div>

      <!-- FORM PROGRESS -->
      <div class="sidebar-panel">
        <div class="panel-header">Completion</div>
        <div class="panel-body">
          <div style="margin-bottom:1rem;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:.5rem;">
              <span style="font-size:.75rem;color:var(--w60);">Page completeness</span>
              <span id="progressPct" style="font-size:.75rem;color:var(--blue-b);font-weight:700;">100%</span>
            </div>
            <div style="height:4px;background:var(--surface2);border-radius:100px;overflow:hidden;">
              <div id="progressBar" style="height:100%;background:linear-gradient(90deg,var(--blue),var(--blue-b));border-radius:100px;width:100%;"></div>
            </div>
          </div>
          <div class="steps-list">
            @foreach($page->sections as $index => $section)
              <div class="step-item" id="step-{{ $section->section_key }}">
                <div class="step-dot">{{ $index + 1 }}</div>
                <div class="step-content">
                  <div class="step-name">{{ ucfirst(str_replace('_', ' ', $section->section_key)) }}</div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <!-- TIPS -->
      <div class="sidebar-panel">
        <div class="panel-header">Tips</div>
        <div class="panel-body" style="font-size:.78rem;color:var(--w60);line-height:1.7;">
          <p style="margin-bottom:.6rem;">💡 Use <strong style="color:var(--w80);">engaging headings</strong> to grab attention immediately.</p>
          <p style="margin-bottom:.6rem;">✨ Keep your meta descriptions between <strong style="color:var(--w80);">150-160 characters</strong> for SEO.</p>
          <p>🚀 Changes are reflected on the live site instantly after updating.</p>
        </div>
      </div>

  </div>
</form>

<!-- SUCCESS TOAST -->
<div class="toast" id="toast">
  <div class="toast-icon"><svg viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></div>
  <div class="toast-text">
    <strong>Success!</strong>
    <span>Page content has been updated.</span>
  </div>
</div>
@endsection

@push('page_scripts')
<script>
function toggleSection(header) {
  const body = header.nextElementSibling;
  const toggle = header.querySelector('.section-toggle');
  body.classList.toggle('collapsed');
  toggle.classList.toggle('open');
}

async function updatePage() {
  const btn = document.querySelector('.publish-btn');
  const form = document.getElementById('pageEditForm');
  const formData = new FormData(form);
  
  // Explicitly ensure _method is present for spoofing
  if (!formData.has('_method')) formData.append('_method', 'PUT');
  
  btn.disabled = true;
  window.adminActionNotify('Updating', '{{ $page->name }}');

  try {
    const response = await fetch("{{ route('admin.pages.update', $page->slug) }}", {
      method: "POST", 
      body: formData,
      headers: {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest'
      }
    });

    const result = await response.json();
    if (result.success) {
      Swal.close();
      window.adminToast('success', 'Updated!', result.message);
      setTimeout(() => {
        if(result.redirect) window.location.href = result.redirect;
      }, 1500);
    } else {
      Swal.fire('Error', result.message || "Something went wrong", 'error');
    }
  } catch (err) {
    console.error(err);
    Swal.fire('Error', "An error occurred during the update.", 'error');
  } finally {
    btn.disabled = false;
  }
}

let tlCount = {{ count($page->sections()->where('section_key', 'story')->first()->content['timeline'] ?? []) }};
function addTimelineItem() {
  const grid = document.getElementById('storyTimelineRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Milestone</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group"><label>Year</label><input type="text" name="sections[story][timeline][${tlCount}][year]"/></div>
      <div class="form-group"><label>Title</label><input type="text" name="sections[story][timeline][${tlCount}][title]"/></div>
    </div>
    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[story][timeline][${tlCount}][desc]" rows="2"></textarea></div>
  `;
  grid.appendChild(div);
  tlCount++;
  updateCompletionProgress();
}

let faqCount = {{ count($page->sections()->where('section_key', 'faq')->first()->content['items'] ?? []) }};
function addFaqItem() {
  const grid = document.getElementById('faqRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New FAQ</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-group"><label>Question</label><input type="text" name="sections[faq][items][${faqCount}][q]"/></div>
    <div class="form-group" style="margin-top:.5rem;"><label>Answer</label><textarea name="sections[faq][items][${faqCount}][a]" rows="2"></textarea></div>
  `;
  grid.appendChild(div);
  faqCount++;
  updateCompletionProgress();
}

let statCount = {{ count($page->sections()->where('section_key', 'hero')->first()->content['stats'] ?? []) }};
function addHeroStat() {
  const grid = document.getElementById('heroStatsRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Stat</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group"><label>Number</label><input type="text" name="sections[hero][stats][${statCount}][num]"/></div>
      <div class="form-group"><label>Label</label><input type="text" name="sections[hero][stats][${statCount}][label]"/></div>
    </div>
  `;
  grid.appendChild(div);
  statCount++;
  updateCompletionProgress();
}

let officeCount = {{ count($page->sections()->where('section_key', 'offices')->first()->content['items'] ?? []) }};
function addOffice() {
  const grid = document.getElementById('officesRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Office</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group" style="flex:0 0 80px;"><label>Flag</label><input type="text" name="sections[offices][items][${officeCount}][flag]"/></div>
      <div class="form-group"><label>City</label><input type="text" name="sections[offices][items][${officeCount}][city]"/></div>
    </div>
    <div class="form-group" style="margin-top:.5rem;"><label>Details (Address/Phone)</label><textarea name="sections[offices][items][${officeCount}][details]" rows="2"></textarea></div>
    <div class="form-group" style="margin-top:.5rem;"><label>Status (e.g. Open Now)</label><input type="text" name="sections[offices][items][${officeCount}][status]"/></div>
  `;
  grid.appendChild(div);
  officeCount++;
  updateCompletionProgress();
}

let valCount = {{ count($page->sections()->where('section_key', 'mission_vision')->first()->content['values'] ?? []) }};
function addValueItem() {
  const grid = document.getElementById('valuesRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Value</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group" style="flex:0 0 60px;"><label>Emoji</label><input type="text" name="sections[mission_vision][values][${valCount}][emoji]"/></div>
      <div class="form-group"><label>Title</label><input type="text" name="sections[mission_vision][values][${valCount}][title]"/></div>
    </div>
    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[mission_vision][values][${valCount}][text]" rows="2"></textarea></div>
  `;
  grid.appendChild(div);
  valCount++;
  updateCompletionProgress();
}

let pillarCounts = {};
function addPillar(sectionKey, baseKey) {
  if (!pillarCounts[sectionKey]) {
    pillarCounts[sectionKey] = document.querySelectorAll(`#pillarsRepeater-${sectionKey} .repeater-item`).length;
  }
  const grid = document.getElementById(`pillarsRepeater-${sectionKey}`);
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Pillar</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group" style="flex:0 0 80px;"><label>Icon</label><input type="text" name="${baseKey}[${pillarCounts[sectionKey]}][icon]"/></div>
      <div class="form-group"><label>Title</label><input type="text" name="${baseKey}[${pillarCounts[sectionKey]}][title]"/></div>
    </div>
    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="${baseKey}[${pillarCounts[sectionKey]}][desc]" rows="2"></textarea></div>
  `;
  grid.appendChild(div);
  pillarCounts[sectionKey]++;
  updateCompletionProgress();
}

let featCount = {{ count($page->sections()->where('section_key', 'features_strip')->first()->content['items'] ?? []) }};
function addFeature() {
  const grid = document.getElementById('featuresRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Feature</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group" style="flex:0 0 80px;"><label>Icon</label><input type="text" name="sections[features_strip][items][${featCount}][icon]"/></div>
      <div class="form-group"><label>Title</label><input type="text" name="sections[features_strip][items][${featCount}][title]"/></div>
    </div>
    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[features_strip][items][${featCount}][desc]" rows="2"></textarea></div>
  `;
  grid.appendChild(div);
  featCount++;
  updateCompletionProgress();
}

let phaseCount = {{ count($page->sections()->where('section_key', 'phases')->first()->content['items'] ?? []) }};
function addPhase() {
  const grid = document.getElementById('phasesRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Phase</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group"><label>Title</label><input type="text" name="sections[phases][items][${phaseCount}][title]"/></div>
      <div class="form-group" style="flex:0 0 120px;"><label>Badge</label><input type="text" name="sections[phases][items][${phaseCount}][badge]"/></div>
    </div>
    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[phases][items][${phaseCount}][desc]" rows="2"></textarea></div>
  `;
  grid.appendChild(div);
  phaseCount++;
  updateCompletionProgress();
}

let toolCount = {{ count($page->sections()->where('section_key', 'tools')->first()->content['items'] ?? []) }};
function addTool() {
  const grid = document.getElementById('toolsRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Tool</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group" style="flex:0 0 80px;"><label>Emoji</label><input type="text" name="sections[tools][items][${toolCount}][emoji]"/></div>
      <div class="form-group"><label>Title</label><input type="text" name="sections[tools][items][${toolCount}][title]"/></div>
    </div>
    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[tools][items][${toolCount}][desc]" rows="2"></textarea></div>
  `;
  grid.appendChild(div);
  toolCount++;
  updateCompletionProgress();
}
let marqueeCount = {{ count($page->sections()->where('section_key', 'marquee')->first()->content['items'] ?? []) }};
function addMarqueeItem() {
  const grid = document.getElementById('marqueeItemsRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Item</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-group"><input type="text" name="sections[marquee][items][${marqueeCount}]"/></div>
  `;
  grid.appendChild(div);
  marqueeCount++;
  updateCompletionProgress();
}

let tagCount = {{ count($page->sections()->where('section_key', 'hero')->first()->content['tags'] ?? []) }};
function addHeroTag() {
  const grid = document.getElementById('heroTagsRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Tag</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-group"><input type="text" name="sections[hero][tags][${tagCount}]"/></div>
  `;
  grid.appendChild(div);
  tagCount++;
  updateCompletionProgress();
}

let impactCount = {{ count($page->sections()->where('section_key', 'impact')->first()->content['items'] ?? []) }};
function addImpactItem() {
  const grid = document.getElementById('impactRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Stat</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group" style="flex:0 0 80px;"><label>Icon</label><input type="text" name="sections[impact][items][${impactCount}][icon]"/></div>
      <div class="form-group"><label>Value</label><input type="text" name="sections[impact][items][${impactCount}][num]"/></div>
    </div>
    <div class="form-group" style="margin-top:.5rem;"><label>Label</label><input type="text" name="sections[impact][items][${impactCount}][label]"/></div>
  `;
  grid.appendChild(div);
  impactCount++;
  updateCompletionProgress();
}

let cultureCount = {{ count($page->sections()->where('section_key', 'culture')->first()->content['items'] ?? []) }};
function addCultureItem() {
  const grid = document.getElementById('cultureRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Principle</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-group"><label>Title</label><input type="text" name="sections[culture][items][${cultureCount}][title]"/></div>
    <div class="form-group" style="margin-top:.5rem;"><label>Description</label><textarea name="sections[culture][items][${cultureCount}][desc]" rows="2"></textarea></div>
  `;
  grid.appendChild(div);
  cultureCount++;
  updateCompletionProgress();
}

let contactCount = {{ count($page->sections()->where('section_key', 'contact_items')->first()->content['items'] ?? []) }};
function addContactItem() {
  const grid = document.getElementById('contactItemsRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Method</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group"><label>Title</label><input type="text" name="sections[contact_items][items][${contactCount}][title]"/></div>
      <div class="form-group"><label>Value</label><input type="text" name="sections[contact_items][items][${contactCount}][value]"/></div>
    </div>
    <div class="form-group" style="margin-top:.5rem;"><label>Link</label><input type="text" name="sections[contact_items][items][${contactCount}][link]" value="#"/></div>
  `;
  grid.appendChild(div);
  contactCount++;
  updateCompletionProgress();
}

let socialCount = {{ count($page->sections()->where('section_key', 'socials')->first()->content['items'] ?? []) }};
function addSocialLink() {
  const grid = document.getElementById('socialsRepeater');
  const div = document.createElement('div');
  div.className = 'repeater-item';
  div.innerHTML = `
    <div class="repeater-item-header"><span class="repeater-item-num">New Link</span><button type="button" class="repeater-remove-btn" onclick="this.closest('.repeater-item').remove()">×</button></div>
    <div class="form-row">
      <div class="form-group"><label>Platform</label><input type="text" name="sections[socials][items][${socialCount}][platform]"/></div>
      <div class="form-group"><label>URL</label><input type="text" name="sections[socials][items][${socialCount}][link]"/></div>
    </div>
  `;
  grid.appendChild(div);
  socialCount++;
  updateCompletionProgress();
}

// Completion Tracking Logic
function updateCompletionProgress() {
  const sections = document.querySelectorAll('.form-section');
  let completedCount = 0;

  sections.forEach(section => {
    const key = section.getAttribute('data-section-key');
    const stepItem = document.getElementById(`step-${key}`);
    if (!stepItem) return;

    const inputs = section.querySelectorAll('input[type="text"], textarea');
    let isDone = true;
    
    // Logic: Section is done if all text inputs and textareas have values
    // We only check visible ones to avoid hidden field issues
    inputs.forEach(input => {
      if (!input.value.trim()) isDone = false;
    });

    const dot = stepItem.querySelector('.step-dot');
    const name = stepItem.querySelector('.step-name');

    if (isDone) {
      dot.classList.add('done');
      dot.classList.remove('active');
      dot.innerHTML = '✓';
      name.classList.add('done-text');
      completedCount++;
    } else {
      dot.classList.remove('done');
      dot.innerHTML = Array.from(stepItem.parentElement.children).indexOf(stepItem) + 1;
      name.classList.remove('done-text');
    }
  });

  // Update overall progress bar
  const pct = Math.round((completedCount / sections.length) * 100);
  const progressBar = document.getElementById('progressBar');
  const progressPct = document.getElementById('progressPct');
  
  if (progressBar) progressBar.style.width = pct + '%';
  if (progressPct) progressPct.innerText = pct + '%';
}

// Initialize on load and listen for changes
document.addEventListener('DOMContentLoaded', () => {
  updateCompletionProgress();
  
  const form = document.getElementById('pageEditForm');
  if (form) {
    form.addEventListener('input', (e) => {
      if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
        updateCompletionProgress();
      }
    });
  }
});
</script>
@endpush
