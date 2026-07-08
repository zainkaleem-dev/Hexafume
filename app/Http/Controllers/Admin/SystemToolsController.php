<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use RuntimeException;

class SystemToolsController extends Controller
{
    public function index(): View
    {
        $this->ensureAdmin();

        $migrationFiles = collect(glob(database_path('migrations/*.php')) ?: [])
            ->map(function (string $path) {
                $file = basename($path);
                $name = preg_replace('/^\d{4}_\d{2}_\d{2}_\d{6}_/', '', $file) ?: $file;

                return [
                    'file' => $file,
                    'path' => $path,
                    'name' => $name,
                    'status' => DB::table('migrations')->where('migration', pathinfo($file, PATHINFO_FILENAME))->exists() ? 'Ran' : 'Pending',
                    'pending' => ! DB::table('migrations')->where('migration', pathinfo($file, PATHINFO_FILENAME))->exists(),
                ];
            })->values();
        $migrationFileCount = $migrationFiles->count();
        $ranMigrations = $migrationFiles->where('status', 'Ran')->count();
        $pendingMigrations = $migrationFiles->where('status', 'Pending')->count();

        $seeders = collect(glob(database_path('seeders/*.php')) ?: []);
        $seederClasses = $seeders
            ->filter(fn (string $path) => basename($path) !== 'DatabaseSeeder.php')
            ->map(function (string $path) {
                $file = basename($path);
                $class = pathinfo($file, PATHINFO_FILENAME);

                return [
                    'file' => $file,
                    'name' => $class,
                    'class' => $class,
                ];
            })
            ->values();
        $seederCount = $seederClasses->count();
        $seederRunStatus = session('system_tools_seeder_status', []);
        $ranSeeders = $seederClasses->filter(function (array $seeder) use ($seederRunStatus) {
            return ($seederRunStatus[$seeder['class']] ?? null) === 'ran';
        })->count();
        $pendingSeeders = max($seederCount - $ranSeeders, 0);

        return view('admin.system-tools.index', [
            'migrationFileCount' => $migrationFileCount,
            'ranMigrations' => $ranMigrations,
            'pendingMigrations' => $pendingMigrations,
            'seederCount' => $seederCount,
            'ranSeeders' => $ranSeeders,
            'pendingSeeders' => $pendingSeeders,
            'migrationFiles' => $migrationFiles,
            'seederClasses' => $seederClasses,
            'seederRunStatus' => $seederRunStatus,
            'cacheDriver' => config('cache.default'),
            'sessionDriver' => config('session.driver'),
            'queueDriver' => config('queue.default'),
            'isProduction' => app()->environment('production'),
            'result' => session('system_tools_result'),
        ]);
    }

    public function run(Request $request): RedirectResponse
    {
        $this->ensureAdmin();

        $validated = $request->validate([
            'action' => ['required', 'string'],
            'confirm_word' => ['nullable', 'string'],
            'migration' => ['nullable', 'string'],
            'seeder' => ['nullable', 'string'],
        ]);

        $action = $validated['action'];
        $destructive = in_array($action, ['migrate:rollback', 'migrate:fresh'], true) || $action === 'db:seed';

        if (app()->environment('production') && in_array($action, ['migrate:rollback', 'migrate:fresh'], true)) {
            return back()->with('system_tools_result', [
                'success' => false,
                'action' => $action,
                'message' => 'This action is blocked in production.',
                'output' => 'Production safeguard prevented the command from running.',
            ]);
        }

        if ($action === 'migrate:fresh' && strtoupper(trim((string) $validated['confirm_word'])) !== 'CONFIRM') {
            return back()->with('system_tools_result', [
                'success' => false,
                'action' => $action,
                'message' => 'Fresh migrate requires typing CONFIRM.',
                'output' => 'The destructive confirmation word did not match.',
            ]);
        }

        if ($destructive && ! $request->boolean('confirmed')) {
            return back()->with('system_tools_result', [
                'success' => false,
                'action' => $action,
                'message' => 'Confirmation is required before running this command.',
                'output' => 'The request was rejected because the destructive confirmation flag was missing.',
            ]);
        }

        try {
            $output = $this->callCommand($action, $validated['migration'] ?? null, $validated['seeder'] ?? null);
            if ($this->shouldMarkAllSeedersAsRan($action, $validated['seeder'] ?? null)) {
                $this->markAllSeedersAsRan();
            } elseif (! empty($validated['seeder'])) {
                $this->markSeederStatus($validated['seeder'], 'ran');
            }

            return back()->with('system_tools_result', [
                'success' => true,
                'action' => $action,
                'message' => 'Command completed successfully.',
                'output' => $output,
            ]);
        } catch (\Throwable $e) {
            if (! empty($validated['seeder'])) {
                $this->markSeederStatus($validated['seeder'], 'failed');
            }

            return back()->with('system_tools_result', [
                'success' => false,
                'action' => $action,
                'message' => 'Command failed: ' . $e->getMessage(),
                'output' => Artisan::output() ?: 'No Artisan output was captured.',
            ]);
        }
    }

    private function callCommand(string $action, ?string $migration = null, ?string $seeder = null): string
    {
        $commandOutput = '';
        $exitCode = 0;

        switch ($action) {
            case 'migrate':
                $parameters = [];
                if ($migration) {
                    $parameters['--path'] = 'database/migrations/' . $migration;
                    $parameters['--force'] = true;
                }
                $exitCode = Artisan::call('migrate', $parameters);
                break;
            case 'migrate:rollback':
                $exitCode = Artisan::call('migrate:rollback');
                break;
            case 'db:seed':
                $parameters = [];
                if ($seeder) {
                    $parameters['--class'] = $seeder;
                    $parameters['--force'] = true;
                }
                $exitCode = Artisan::call('db:seed', $parameters);
                break;
            case 'migrate:fresh':
                $exitCode = Artisan::call('migrate:fresh', ['--seed' => true]);
                break;
            case 'config:clear':
                $exitCode = Artisan::call('config:clear');
                break;
            case 'route:clear':
                $exitCode = Artisan::call('route:clear');
                break;
            case 'view:clear':
                $exitCode = Artisan::call('view:clear');
                break;
            case 'cache:clear':
                $exitCode = Artisan::call('cache:clear');
                break;
            case 'clear-all':
                $exitCode = Artisan::call('config:clear');
                $commandOutput .= Artisan::output();
                $exitCode = Artisan::call('route:clear');
                $commandOutput .= PHP_EOL . Artisan::output();
                $exitCode = Artisan::call('view:clear');
                $commandOutput .= PHP_EOL . Artisan::output();
                $exitCode = Artisan::call('cache:clear');
                $commandOutput .= PHP_EOL . Artisan::output();
                return trim($commandOutput);
            default:
                throw new RuntimeException('Unsupported system tool action.');
        }

        $commandOutput = Artisan::output();

        if ($exitCode !== 0 && trim($commandOutput) === '') {
            throw new RuntimeException('Artisan returned a non-zero exit code.');
        }

        return trim($commandOutput);
    }

    private function shouldMarkAllSeedersAsRan(string $action, ?string $seeder = null): bool
    {
        return $seeder === null && in_array($action, ['db:seed', 'migrate:fresh'], true);
    }

    private function markAllSeedersAsRan(): void
    {
        $seederStatus = session('system_tools_seeder_status', []);

        foreach ($this->seederClassNames() as $class) {
            $seederStatus[$class] = 'ran';
        }

        session()->flash('system_tools_seeder_status', $seederStatus);
    }

    private function markSeederStatus(string $seeder, string $status): void
    {
        $seederStatus = session('system_tools_seeder_status', []);
        $seederStatus[$seeder] = $status;
        session()->flash('system_tools_seeder_status', $seederStatus);
    }

    private function seederClassNames(): array
    {
        return collect(glob(database_path('seeders/*.php')) ?: [])
            ->filter(fn (string $path) => basename($path) !== 'DatabaseSeeder.php')
            ->map(fn (string $path) => pathinfo(basename($path), PATHINFO_FILENAME))
            ->values()
            ->all();
    }

    private function ensureAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()?->role === 'admin', 403);
    }
}
