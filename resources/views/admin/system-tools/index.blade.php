@extends('layouts.admin')

@section('title', 'System Tools')
@section('page_title', 'System Tools')
@section('breadcrumb', 'Maintenance')

@push('page_styles')
<style>
.tools-wrap { display: grid; gap: 1.5rem; }
.tools-hero {
  position: relative;
  overflow: hidden;
  background: linear-gradient(135deg, rgba(77,77,255,.16), rgba(255,255,255,.03));
  border: 1px solid var(--border);
  border-radius: 18px;
  padding: 1.5rem;
}
.tools-hero::after {
  content: '';
  position: absolute;
  inset: auto -40px -60px auto;
  width: 180px;
  height: 180px;
  background: radial-gradient(circle, rgba(77,77,255,.28), transparent 65%);
  filter: blur(6px);
  pointer-events: none;
}
.tools-hero h1 { font-family: var(--font-display); font-size: 1.8rem; line-height: 1.1; margin-bottom: .4rem; }
.tools-hero p { color: var(--w60); max-width: 72ch; }
.tools-warning {
  margin-top: 1rem;
  border: 1px solid rgba(255,170,0,.35);
  background: rgba(255,170,0,.09);
  color: var(--w80);
  padding: .85rem 1rem;
  border-radius: 12px;
}
.summary-grid {
  display: grid;
  grid-template-columns: repeat(5, minmax(0, 1fr));
  gap: 1rem;
}
.summary-card, .panel-card {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 1rem;
}
.summary-label { color: var(--w40); font-size: .72rem; text-transform: uppercase; letter-spacing: .12em; }
.summary-value { margin-top: .35rem; font-family: var(--font-display); font-size: 1.7rem; font-weight: 700; }
.summary-meta { margin-top: .25rem; color: var(--w40); font-size: .78rem; }
.actions-grid {
  display: grid;
  grid-template-columns: repeat(2, minmax(0, 1fr));
  gap: 1rem;
}
.list-grid {
  display: grid;
  gap: 1rem;
}
.list-panel {
  background: var(--surface);
  border: 1px solid var(--border);
  border-radius: 16px;
  padding: 1rem;
}
.list-panel-head {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  margin-bottom: .9rem;
}
.list-panel-head h2 { font-family: var(--font-display); font-size: 1.05rem; }
.list-panel-head p { color: var(--w40); font-size: .78rem; }
.accordion-shell {
  border: 1px solid var(--border);
  border-radius: 16px;
  overflow: hidden;
  background: var(--surface);
}
.accordion-toggle {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 1rem;
  padding: 1rem 1.05rem;
  background: transparent;
  border: 0;
  color: var(--white);
  text-align: left;
}
.accordion-toggle:hover { background: var(--w05); }
.accordion-title-wrap {
  display: flex;
  flex-direction: column;
  gap: .18rem;
  min-width: 0;
}
.accordion-title {
  display: flex;
  align-items: center;
  gap: .45rem;
  font-family: var(--font-display);
  font-size: 1.05rem;
  font-weight: 700;
}
.accordion-count {
  font-size: .72rem;
  font-weight: 700;
  letter-spacing: .08em;
  text-transform: uppercase;
  color: var(--w40);
}
.accordion-subtitle { color: var(--w40); font-size: .78rem; }
.accordion-chevron {
  width: 18px;
  height: 18px;
  flex-shrink: 0;
  color: var(--w60);
  transition: transform .25s ease;
}
.accordion-shell.open .accordion-chevron { transform: rotate(180deg); }
.accordion-body {
  max-height: 0;
  overflow: hidden;
  transition: max-height .3s ease;
}
.accordion-shell.open .accordion-body { max-height: 4000px; }
.accordion-body-inner {
  padding: 0 1rem 1rem;
}
.data-list {
  display: grid;
  gap: .7rem;
}
.data-row {
  display: grid;
  grid-template-columns: minmax(0, 1fr) auto auto;
  gap: .75rem;
  align-items: center;
  padding: .8rem .9rem;
  border-radius: 12px;
  background: var(--surface2);
  border: 1px solid var(--border);
}
.data-name {
  font-size: .85rem;
  font-weight: 600;
  color: var(--white);
  word-break: break-word;
}
.data-status {
  font-size: .68rem;
  font-weight: 800;
  letter-spacing: .08em;
  text-transform: uppercase;
  border-radius: 999px;
  padding: .25rem .55rem;
  border: 1px solid transparent;
}
.data-status.ran { background: rgba(0,200,100,.12); color: #7af0ad; border-color: rgba(0,200,100,.2); }
.data-status.pending { background: rgba(255,170,0,.12); color: #ffcc66; border-color: rgba(255,170,0,.2); }
.data-status.failed { background: rgba(255,77,106,.12); color: #ff9cae; border-color: rgba(255,77,106,.2); }
.mini-btn {
  border: 1px solid var(--border-b);
  background: var(--blue);
  color: #fff;
  border-radius: 10px;
  padding: .55rem .85rem;
  font-size: .75rem;
  font-weight: 700;
}
.mini-btn:disabled { opacity: .45; cursor: not-allowed; }
.action-card { padding: 1.1rem; border: 1px solid var(--border); border-radius: 16px; background: var(--surface); }
.action-title { font-family: var(--font-display); font-size: 1rem; font-weight: 700; margin-bottom: .3rem; }
.action-desc { color: var(--w60); font-size: .8rem; min-height: 2.4em; }
.action-form { margin-top: .9rem; display: grid; gap: .7rem; }
.action-row { display: flex; gap: .6rem; flex-wrap: wrap; align-items: center; }
.action-btn {
  border: 1px solid var(--border-b);
  background: var(--blue);
  color: #fff;
  border-radius: 10px;
  padding: .72rem 1rem;
  font-size: .8rem;
  font-weight: 700;
  letter-spacing: .03em;
}
.action-btn.secondary { background: var(--surface2); color: var(--white); border-color: var(--border); }
.action-btn.danger { background: var(--red); border-color: rgba(255,77,106,.4); }
.action-btn:disabled { opacity: .45; cursor: not-allowed; }
.confirm-input {
  width: min(260px, 100%);
  background: var(--surface2);
  border: 1px solid var(--border);
  color: var(--white);
  border-radius: 10px;
  padding: .75rem .85rem;
}
.result-card pre {
  margin-top: .9rem;
  background: #030305;
  border: 1px solid var(--border);
  border-radius: 12px;
  padding: 1rem;
  color: #d8dee9;
  white-space: pre-wrap;
  word-break: break-word;
  min-height: 180px;
  max-height: 420px;
  overflow: auto;
  font-size: .8rem;
}
.result-badge {
  display: inline-flex;
  align-items: center;
  gap: .35rem;
  border-radius: 999px;
  padding: .25rem .7rem;
  font-size: .72rem;
  font-weight: 700;
}
.result-badge.success { background: rgba(0,200,100,.12); color: #7af0ad; }
.result-badge.error { background: rgba(255,77,106,.12); color: #ff9cae; }
.modal-overlay {
  position: fixed; inset: 0;
  background: rgba(0,0,0,.7);
  backdrop-filter: blur(6px);
  z-index: 200;
  display: flex; align-items: center; justify-content: center;
  padding: 1.5rem;
  opacity: 0; pointer-events: none;
  transition: opacity .25s;
}
.modal-overlay.show { opacity: 1; pointer-events: auto; }
.modal {
  background: var(--surface); border: 1px solid var(--border); border-radius: 18px;
  padding: 2.2rem 2rem; max-width: 380px; width: 100%;
  text-align: center; transform: scale(.96); transition: transform .25s;
}
.modal-overlay.show .modal { transform: scale(1); }
.modal-icon {
  width: 52px; height: 52px; border-radius: 50%;
  background: rgba(255,77,106,.1); border: 1px solid rgba(255,77,106,.25);
  display: flex; align-items: center; justify-content: center;
  margin: 0 auto 1.2rem; color: var(--red);
}
.modal-icon svg { width: 24px; height: 24px; stroke: currentColor; fill: none; stroke-width: 1.8; }
.modal h3 { font-family: var(--font-display); font-size: 1.05rem; font-weight: 700; margin-bottom: .5rem; }
.modal p { font-size: .82rem; color: var(--w60); line-height: 1.6; margin-bottom: 1.5rem; }
.modal-btns { display: flex; gap: .7rem; }
.modal-btn {
  flex: 1; padding: .7rem; border-radius: 9px;
  font-size: .82rem; font-weight: 600; border: 1px solid var(--border);
  transition: all .2s; cursor: pointer; font-family: var(--font-body);
}
.modal-btn.cancel { background: var(--surface2); color: var(--w60); }
.modal-btn.cancel:hover { color: var(--white); }
.modal-btn.confirm-del { background: var(--red); color: #fff; border-color: var(--red); }
.modal-btn.confirm-del:hover { box-shadow: 0 0 20px rgba(255,77,106,.35); }
@media (max-width: 1100px) {
  .summary-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
  .actions-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
@php
  $result = $result ?? null;
  $resultSuccess = (bool) ($result['success'] ?? false);
@endphp

<div class="tools-wrap">
  <div class="tools-hero">
    <h1>System Tools</h1>
    <p>Run common maintenance commands directly from the browser. These tools are available only to authenticated admin users and every action uses a POST request with CSRF protection.</p>

    @if($isProduction)
      <div class="tools-warning">
        Production environment detected. Destructive actions like rollback and fresh migrate are hidden here for safety.
      </div>
    @else
      <div class="tools-warning">
        These tools can change application state quickly. Use the destructive actions only when you are sure.
      </div>
    @endif
  </div>

  <div class="summary-grid">
    <div class="summary-card">
      <div class="summary-label">Migration files</div>
      <div class="summary-value">{{ $migrationFileCount }}</div>
      <div class="summary-meta">Files in `database/migrations`</div>
    </div>
    <div class="summary-card">
      <div class="summary-label">Ran migrations</div>
      <div class="summary-value">{{ $ranMigrations }}</div>
      <div class="summary-meta">Rows in the migrations table</div>
    </div>
    <div class="summary-card">
      <div class="summary-label">Pending migrations</div>
      <div class="summary-value">{{ $pendingMigrations }}</div>
      <div class="summary-meta">File count minus recorded rows</div>
    </div>
    <div class="summary-card">
      <div class="summary-label">Seeder classes</div>
      <div class="summary-value">{{ $seederCount }}</div>
      <div class="summary-meta">PHP files in `database/seeders` excluding `DatabaseSeeder.php`</div>
    </div>
    <div class="summary-card">
      <div class="summary-label">Ran seeders</div>
      <div class="summary-value">{{ $ranSeeders }}</div>
      <div class="summary-meta">Seeders run in the current admin session</div>
    </div>
    <div class="summary-card">
      <div class="summary-label">Pending seeders</div>
      <div class="summary-value">{{ $pendingSeeders }}</div>
      <div class="summary-meta">Seeders not yet run in the current admin session</div>
    </div>
    <div class="summary-card">
      <div class="summary-label">Drivers</div>
      <div class="summary-value" style="font-size:1rem; line-height:1.5;">
        <div>Cache: {{ $cacheDriver }}</div>
        <div>Session: {{ $sessionDriver }}</div>
        <div>Queue: {{ $queueDriver }}</div>
      </div>
      <div class="summary-meta">Current config values for reference</div>
    </div>
  </div>

  <div class="list-grid">
    <div class="accordion-shell" data-accordion>
      <button class="accordion-toggle" type="button" data-accordion-toggle aria-expanded="false">
        <div class="accordion-title-wrap">
          <div class="accordion-title">Migration Files <span class="accordion-count">({{ $migrationFileCount }})</span></div>
          <div class="accordion-subtitle">Each migration file and whether it has already run.</div>
        </div>
        <svg class="accordion-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
      </button>
      <div class="accordion-body">
        <div class="accordion-body-inner">
      <div class="data-list">
        @forelse($migrationFiles as $migration)
          <div class="data-row">
            <div class="data-name">{{ $migration['name'] }}</div>
            <div class="data-status {{ strtolower($migration['status']) }}">{{ $migration['status'] }}</div>
            <div>
              @if($migration['pending'])
                <form method="POST" action="{{ route('admin.tools.run') }}" class="action-form" style="margin:0;">
                  @csrf
                  <input type="hidden" name="action" value="migrate">
                  <input type="hidden" name="migration" value="{{ $migration['file'] }}">
                  <button class="mini-btn js-open-destructive-modal" type="button" data-action="migrate" data-title="Run Migration?" data-description="This will run only this migration file: {{ $migration['name'] }}." data-confirm-text="Run Migration">Run</button>
                </form>
              @endif
            </div>
          </div>
        @empty
          <div class="data-row">
            <div class="data-name">No migration files found.</div>
            <div></div><div></div>
          </div>
        @endforelse
      </div>
        </div>
      </div>
    </div>

    <div class="accordion-shell" data-accordion>
      <button class="accordion-toggle" type="button" data-accordion-toggle aria-expanded="false">
        <div class="accordion-title-wrap">
          <div class="accordion-title">Seeder Classes <span class="accordion-count">({{ $seederCount }})</span></div>
          <div class="accordion-subtitle">Run a single seeder class without launching the full seeder batch.</div>
        </div>
        <svg class="accordion-chevron" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
      </button>
      <div class="accordion-body">
        <div class="accordion-body-inner">
      <div class="data-list">
        @forelse($seederClasses as $seeder)
          @php
            $seederState = $seederRunStatus[$seeder['class']] ?? null;
            $seederLabel = $seederState === 'ran' ? 'RAN' : ($seederState === 'failed' ? 'FAILED' : null);
            $seederStatusClass = $seederState === 'ran' ? 'ran' : ($seederState === 'failed' ? 'failed' : '');
          @endphp
          <div class="data-row">
            <div class="data-name">{{ $seeder['name'] }}</div>
            <div>
              @if($seederLabel)
                <span class="data-status {{ $seederStatusClass }}">{{ $seederLabel }}</span>
              @endif
            </div>
            <div>
              <form method="POST" action="{{ route('admin.tools.run') }}" class="action-form" style="margin:0;">
                @csrf
                <input type="hidden" name="action" value="db:seed">
                <input type="hidden" name="seeder" value="{{ $seeder['class'] }}">
                <input type="hidden" name="confirmed" value="1">
                <button class="mini-btn js-open-destructive-modal" type="button" data-action="db:seed" data-title="Run Seeder?" data-description="This will run only the {{ $seeder['name'] }} seeder." data-confirm-text="Run Seeder">Run</button>
              </form>
            </div>
          </div>
        @empty
          <div class="data-row">
            <div class="data-name">No seeder classes found.</div>
            <div></div><div></div>
          </div>
        @endforelse
      </div>
        </div>
      </div>
    </div>
  </div>

  <div class="panel-card">
    <div class="section-hd" style="margin-bottom:1rem;">
      <h2 style="font-family:var(--font-display); font-size:1.15rem;">Artisan Actions</h2>
    </div>

    <div class="actions-grid">
      <div class="action-card">
        <div class="action-title">Run Migrations</div>
        <div class="action-desc">Executes `php artisan migrate`.</div>
        <form class="action-form" method="POST" action="{{ route('admin.tools.run') }}">
          @csrf
          <input type="hidden" name="action" value="migrate">
          <div class="action-row">
            <button class="action-btn" type="submit">Run Migrations</button>
          </div>
        </form>
      </div>

      @if(! $isProduction)
      <div class="action-card">
        <div class="action-title">Rollback Last Migration</div>
        <div class="action-desc">Executes `php artisan migrate:rollback`. This is destructive and will remove the latest batch.</div>
        <form class="action-form destructive-form" method="POST" action="{{ route('admin.tools.run') }}">
          @csrf
          <input type="hidden" name="action" value="migrate:rollback">
          <input type="hidden" name="confirmed" value="1">
          <div class="action-row">
            <button class="action-btn danger js-confirm" type="submit" data-confirm="Rollback the last migration batch?">Rollback Last Migration</button>
          </div>
        </form>
      </div>
      @endif

      <div class="action-card">
        <div class="action-title">Run Seeders</div>
        <div class="action-desc">Executes `php artisan db:seed`.</div>
        <form class="action-form destructive-form" method="POST" action="{{ route('admin.tools.run') }}">
          @csrf
          <input type="hidden" name="action" value="db:seed">
          <input type="hidden" name="confirmed" value="1">
          <div class="action-row">
            <button class="action-btn danger js-open-destructive-modal" type="button" data-action="db:seed" data-title="Run Seeders?" data-description="This will run all database seeders. Make sure you are ready before continuing." data-confirm-text="Run Seeders">Run Seeders</button>
          </div>
        </form>
      </div>

      @if(! $isProduction)
      <div class="action-card">
        <div class="action-title">Fresh Migrate + Seed</div>
        <div class="action-desc">Executes `php artisan migrate:fresh --seed`. This deletes all tables and recreates them before seeding.</div>
        <form class="action-form destructive-form" method="POST" action="{{ route('admin.tools.run') }}" data-fresh-form>
          @csrf
          <input type="hidden" name="action" value="migrate:fresh">
          <input type="hidden" name="confirmed" value="1">
          <div class="action-row" style="width:100%;">
            <input class="confirm-input" type="text" name="confirm_word" placeholder='Type CONFIRM to enable' autocomplete="off" data-fresh-input>
          </div>
          <div class="action-row">
            <button class="action-btn danger js-open-destructive-modal js-fresh-submit" type="button" disabled data-action="migrate:fresh" data-title="Fresh Migrate + Seed?" data-description="This will wipe all data, recreate the database schema, and seed it again. Type CONFIRM to unlock the final action." data-confirm-text="Fresh Migrate + Seed">Fresh Migrate + Seed</button>
          </div>
        </form>
      </div>
      @endif

      <div class="action-card">
        <div class="action-title">Clear Config Cache</div>
        <div class="action-desc">Executes `php artisan config:clear`.</div>
        <form class="action-form" method="POST" action="{{ route('admin.tools.run') }}">
          @csrf
          <input type="hidden" name="action" value="config:clear">
          <div class="action-row">
            <button class="action-btn secondary" type="submit">Clear Config Cache</button>
          </div>
        </form>
      </div>

      <div class="action-card">
        <div class="action-title">Clear Route Cache</div>
        <div class="action-desc">Executes `php artisan route:clear`.</div>
        <form class="action-form" method="POST" action="{{ route('admin.tools.run') }}">
          @csrf
          <input type="hidden" name="action" value="route:clear">
          <div class="action-row">
            <button class="action-btn secondary" type="submit">Clear Route Cache</button>
          </div>
        </form>
      </div>

      <div class="action-card">
        <div class="action-title">Clear View Cache</div>
        <div class="action-desc">Executes `php artisan view:clear`.</div>
        <form class="action-form" method="POST" action="{{ route('admin.tools.run') }}">
          @csrf
          <input type="hidden" name="action" value="view:clear">
          <div class="action-row">
            <button class="action-btn secondary" type="submit">Clear View Cache</button>
          </div>
        </form>
      </div>

      <div class="action-card">
        <div class="action-title">Clear Application Cache</div>
        <div class="action-desc">Executes `php artisan cache:clear`.</div>
        <form class="action-form" method="POST" action="{{ route('admin.tools.run') }}">
          @csrf
          <input type="hidden" name="action" value="cache:clear">
          <div class="action-row">
            <button class="action-btn secondary" type="submit">Clear Application Cache</button>
          </div>
        </form>
      </div>

      <div class="action-card">
        <div class="action-title">Clear All Caches</div>
        <div class="action-desc">Runs config, route, view, and application cache clears together.</div>
        <form class="action-form" method="POST" action="{{ route('admin.tools.run') }}">
          @csrf
          <input type="hidden" name="action" value="clear-all">
          <div class="action-row">
            <button class="action-btn secondary" type="submit">Clear All Caches</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="panel-card result-card">
    <div class="section-hd" style="margin-bottom:.25rem;">
      <h2 style="font-family:var(--font-display); font-size:1.15rem;">Last Command Result</h2>
      @if($result)
        <span class="result-badge {{ $resultSuccess ? 'success' : 'error' }}">{{ $resultSuccess ? 'Success' : 'Error' }}</span>
      @endif
    </div>
    <div style="color:var(--w60); font-size:.82rem;">
      @if($result)
        {{ $result['message'] ?? 'No message available.' }}
      @else
        Run any action above and the console output will appear here.
      @endif
    </div>
    <pre>{{ $result['output'] ?? 'No Artisan output yet.' }}</pre>
  </div>
</div>

<div class="modal-overlay" id="destructiveModal">
  <div class="modal">
    <div class="modal-icon">
      <svg viewBox="0 0 24 24"><path d="M12 9v4"/><path d="M12 17h.01"/><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
    </div>
    <h3 id="destructiveModalTitle">Confirm Action?</h3>
    <p id="destructiveModalDescription">This action cannot be undone.</p>
    <div id="freshConfirmWrap" style="display:none; width:100%; margin-top:.9rem;">
      <input class="confirm-input" type="text" id="freshConfirmWord" placeholder='Type CONFIRM to continue' autocomplete="off" style="width:100%;">
    </div>
    <div class="modal-btns">
      <button class="modal-btn cancel" type="button" id="destructiveModalCancel">Cancel</button>
      <button class="modal-btn confirm-del" type="button" id="destructiveModalConfirm">Confirm</button>
    </div>
  </div>
</div>
@endsection

@push('page_scripts')
<script>
let destructiveForm = null;
let destructiveAction = null;

const destructiveModal = document.getElementById('destructiveModal');
const destructiveModalTitle = document.getElementById('destructiveModalTitle');
const destructiveModalDescription = document.getElementById('destructiveModalDescription');
const destructiveModalConfirm = document.getElementById('destructiveModalConfirm');
const destructiveModalCancel = document.getElementById('destructiveModalCancel');
const freshConfirmWrap = document.getElementById('freshConfirmWrap');
const freshConfirmWord = document.getElementById('freshConfirmWord');

document.querySelectorAll('.js-open-destructive-modal').forEach((button) => {
  button.addEventListener('click', function () {
    const form = this.closest('form');
    if (!form) return;

    destructiveForm = form;
    destructiveAction = this.dataset.action || '';
    destructiveModalTitle.textContent = this.dataset.title || 'Confirm Action?';
    destructiveModalDescription.textContent = this.dataset.description || 'This action cannot be undone.';
    destructiveModalConfirm.textContent = this.dataset.confirmText || 'Confirm';

    const isFresh = destructiveAction === 'migrate:fresh';
    freshConfirmWrap.style.display = isFresh ? 'block' : 'none';
    freshConfirmWord.value = '';
    destructiveModalConfirm.disabled = isFresh;
    destructiveModal.classList.add('show');

    if (isFresh) {
      freshConfirmWord.focus();
    }
  });
});

function closeDestructiveModal() {
  destructiveModal.classList.remove('show');
  destructiveForm = null;
  destructiveAction = null;
  freshConfirmWord.value = '';
  destructiveModalConfirm.disabled = false;
  freshConfirmWrap.style.display = 'none';
}

destructiveModalCancel.addEventListener('click', closeDestructiveModal);
destructiveModal.addEventListener('click', function (e) {
  if (e.target === this) closeDestructiveModal();
});

freshConfirmWord.addEventListener('input', function () {
  if (destructiveAction !== 'migrate:fresh') return;
  destructiveModalConfirm.disabled = this.value.trim().toUpperCase() !== 'CONFIRM';
});

destructiveModalConfirm.addEventListener('click', function () {
  if (!destructiveForm) return;
  if (destructiveAction === 'migrate:fresh' && freshConfirmWord.value.trim().toUpperCase() !== 'CONFIRM') {
    return;
  }
  destructiveForm.submit();
});

document.querySelectorAll('[data-accordion]').forEach((accordion) => {
  const toggle = accordion.querySelector('[data-accordion-toggle]');
  const body = accordion.querySelector('.accordion-body');
  if (!toggle || !body) return;

  toggle.addEventListener('click', () => {
    const isOpen = accordion.classList.toggle('open');
    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    if (isOpen) {
      body.style.maxHeight = body.scrollHeight + 'px';
    } else {
      body.style.maxHeight = '0px';
    }
  });

  body.style.maxHeight = '0px';
});
</script>
@endpush
