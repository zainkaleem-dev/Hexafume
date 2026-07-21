<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Challenge;
use App\Models\TimelineEntry;
use App\Models\RelatedProject;
use App\Models\TechTag;
use App\Models\ServiceTag;
use App\Models\TeamMember;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Admin dashboard — load dynamic stats and recent activity.
     */
    public function adminDashboard()
    {
        $totalProjects = Project::count();
        $liveProjects = Project::where('status', 'live')->count();
        $inProgressProjects = Project::where('status', 'progress')->count();
        $teamMembers = TeamMember::count();
        $teamDepartments = TeamMember::query()->whereNotNull('dept')->distinct('dept')->count('dept');

        $recentProjects = Project::query()
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        $recentProjectAdds = Project::query()
            ->where('created_at', '>=', now()->subDays(30))
            ->count();
        $recentLive = Project::query()
            ->where('status', 'live')
            ->where('updated_at', '>=', now()->subDays(30))
            ->count();

        $projectActivity = Project::query()
            ->latest('updated_at')
            ->take(3)
            ->get()
            ->map(function (Project $project) {
                return [
                    'type' => $project->status === 'live' ? 'live' : 'project',
                    'text' => $project->status === 'live'
                        ? "{$project->name} marked as Live"
                        : "Updated {$project->name} details",
                    'time' => optional($project->updated_at)->diffForHumans() ?? 'Recently',
                    'sort_at' => optional($project->updated_at),
                ];
            });

        $memberActivity = TeamMember::query()
            ->latest('created_at')
            ->take(2)
            ->get()
            ->map(function (TeamMember $member) {
                return [
                    'type' => 'team',
                    'text' => "Added team member: {$member->name}",
                    'time' => optional($member->created_at)->diffForHumans() ?? 'Recently',
                    'sort_at' => optional($member->created_at),
                ];
            });

        $recentActivity = $projectActivity
            ->concat($memberActivity)
            ->sortByDesc('sort_at')
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'totalProjects',
            'liveProjects',
            'inProgressProjects',
            'teamMembers',
            'teamDepartments',
            'recentProjects',
            'recentProjectAdds',
            'recentLive',
            'recentActivity',
        ));
    }

    /**
     * Public home page — load featured projects.
     */
    public function homePage()
    {
        $featuredProjects = Project::with(['techTags'])
            ->where('is_featured', true)
            ->orderByDesc('finish_date')
            ->take(4) // Show up to 4 featured projects on the homepage
            ->get();

        $page = \App\Models\Page::where('slug', 'home')->first();
        $services = \App\Models\Service::orderBy('order_index')->get();
        $process_steps = \App\Models\ProcessStep::orderBy('order_index')->get();
        $testimonials = \App\Models\Testimonial::query()
            ->where('is_active', true)
            ->orderBy('order_index')
            ->get();

        return view('home', compact('featuredProjects', 'page', 'services', 'process_steps', 'testimonials'));
    }

    /**
     * Public about page — show dynamic people section.
     */
    public function aboutPage()
    {
        $aboutTeamMembers = TeamMember::query()
            ->where('show_on_team', true)
            ->orderByDesc('is_featured')
            ->orderBy('first_name')
            ->take(10)
            ->get()
            ->map(function (TeamMember $member) {
                return [
                    'name' => $member->name,
                    'initials' => $member->initials ?: strtoupper(substr($member->name, 0, 2)),
                    'dept' => $member->dept_label ?: ucfirst((string) $member->dept),
                    'exp' => $member->exp,
                    'photo' => $member->photo_path ? asset('storage/' . $member->photo_path) : null,
                ];
            })
            ->values();

        $aboutTeamDepartments = TeamMember::query()
            ->where('show_on_team', true)
            ->get()
            ->map(function (TeamMember $member) {
                return trim((string) ($member->dept_label ?: ucfirst((string) $member->dept)));
            })
            ->filter()
            ->unique()
            ->take(5)
            ->values();

        $aboutTestimonial = \App\Models\Testimonial::query()
            ->where('is_active', true)
            ->orderBy('order_index')
            ->first();

        $page = \App\Models\Page::where('slug', 'about')->first();
        $teamTeaserSection = $page ? $page->getSectionContent('team_teaser') : [];
        $aboutTeamHighlights = collect($teamTeaserSection['highlights'] ?? [])
            ->filter(fn ($item) => filled(trim((string) $item)))
            ->values();

        if ($aboutTeamHighlights->isEmpty()) {
            $aboutTeamHighlights = collect([
                'active team members',
                'core disciplines represented',
                'Built from live team data',
                'Updated as members are added',
            ]);
        }

        return view('about', compact('aboutTeamMembers', 'aboutTeamDepartments', 'aboutTeamHighlights', 'aboutTestimonial', 'page'));
    }
    
    public function servicesPage()
    {
        $page = \App\Models\Page::where('slug', 'services')->first();
        $services = \App\Models\Service::orderBy('order_index')->get();
        $technologies = \App\Models\Technology::orderBy('order_index')->get()->groupBy('category');

        return view('services', compact('page', 'services', 'technologies'));
    }

    public function processPage()
    {
        $page = \App\Models\Page::where('slug', 'process')->first();
        $process_steps = \App\Models\ProcessStep::orderBy('order_index')->get();
        $faqs = \App\Models\Faq::orderBy('order_index')->get();

        return view('process', compact('page', 'process_steps', 'faqs'));
    }

    public function contactPage()
    {
        $page = \App\Models\Page::where('slug', 'contact')->first();

        return view('contact', compact('page'));
    }

    /**
     * Public portfolio page — list all visible projects grouped by category.
     */
    public function index()
    {
        $projects = Project::with(['techTags'])
            ->orderByDesc('is_featured')
            ->orderByDesc('finish_date')
            ->get();

        // Collect unique categories for the filter bar
        $categories = $projects->pluck('type')->unique()->filter()->values();
        
        $page = \App\Models\Page::where('slug', 'work')->first();
        $testimonials = \App\Models\Testimonial::query()
            ->where('is_active', true)
            ->orderBy('order_index')
            ->get();
        $technologies = \App\Models\Technology::orderBy('order_index')->get()->groupBy('category');

        return view('work', compact('projects', 'categories', 'page', 'testimonials', 'technologies'));
    }

    /**
     * Public project detail page — load one project by its URL slug.
     */
    public function show(string $slug)
    {
        $project = Project::with([
            'techTags',
            'serviceTags',
            'challenges',
            'timelineEntries',
            'relatedProjects',
        ])->where('url_slug', $slug)
          ->firstOrFail();

        return view('project-detail', compact('project'));
    }

    /**
     * Admin projects page — list all projects from the database.
     */
    public function adminIndex()
    {
        $projects = Project::query()
            ->orderByDesc('created_at')
            ->get()
            ->map(function (Project $project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name,
                    'type' => $project->type,
                    'status' => $project->status,
                    'timeline' => trim(
                        (($project->start_date?->format('M Y')) ?? '')
                        . ' - '
                        . (($project->finish_date?->format('M Y')) ?? '')
                    , ' -'),
                    'team' => $project->team ?? 'N/A',
                    'category' => $project->client_name ?? 'N/A',
                    'desc' => \Illuminate\Support\Str::limit($project->overview_p1 ?? '', 130),
                    'delivered' => (bool) $project->delivered_on_time,
                    'logo_image_url' => $project->display_image_url,
                ];
            })
            ->values();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Admin create page.
     */
    public function adminCreate()
    {
        return view('admin.projects.create');
    }

    /**
     * Admin edit page.
     */
    public function adminEdit(Project $project)
    {
        $project->load([
            'techTags',
            'serviceTags',
            'challenges',
            'timelineEntries',
            'relatedProjects',
        ]);

        return view('admin.projects.create', [
            'editingProject' => $project,
        ]);
    }

    /**
     * Admin store — create a new project from the admin form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url_slug' => 'required|string|unique:projects,url_slug',
            'type' => 'required|string',
            'client_name' => 'required|string',
            'site_url' => 'nullable|url',
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'status' => 'required|in:live,progress,review,paused,draft',
            'delivered_on_time' => 'boolean',
            'hero_image' => 'nullable|image|max:5120',
            'logo_image' => 'nullable|image|max:2048',
            'overview_heading' => 'required|string',
            'overview_p1' => 'required|string',
            'overview_p2' => 'nullable|string',
            'overview_p3' => 'nullable|string',
            'stat1_num' => 'nullable|string',
            'stat1_lbl' => 'nullable|string',
            'stat2_num' => 'nullable|string',
            'stat2_lbl' => 'nullable|string',
            'stat3_num' => 'nullable|string',
            'stat3_lbl' => 'nullable|string',
            'stack_description' => 'nullable|string',
            'timeline_heading' => 'nullable|string',
            'timeline_subtext' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_image_url' => 'nullable|url',
            'twitter_card' => 'nullable|in:summary,summary_large_image',
            'seo_index' => 'boolean',
            'show_portfolio' => 'boolean',
            'is_featured' => 'boolean',
            'visibility' => 'required|in:public,private,password',
            'publish_at' => 'nullable|date',
        ]);

        // Handle File Uploads
        if ($request->hasFile('hero_image')) {
            $validated['hero_image_path'] = $request->file('hero_image')->store('projects/heroes', 'public');
        }
        if ($request->hasFile('logo_image')) {
            $validated['logo_image_path'] = $request->file('logo_image')->store('projects/logos', 'public');
        }

        $project = Project::create($validated);

        $notification = AdminNotification::create([
            'type' => 'project',
            'title' => 'Project published',
            'message' => "\"{$project->name}\" was published.",
            'link' => route('admin.projects.edit', $project),
        ]);

        // Handle Tags (Many-to-Many)
        if ($request->has('tech_tags')) {
            $tags = json_decode($request->tech_tags, true);
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = TechTag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $project->techTags()->sync($tagIds);
        }

        if ($request->has('service_tags')) {
            $tags = json_decode($request->service_tags, true);
            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = ServiceTag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $project->serviceTags()->sync($tagIds);
        }

        // Handle Challenges
        if ($request->has('challenges')) {
            $challenges = json_decode($request->challenges, true);
            foreach ($challenges as $c) {
                if (!empty($c['title'])) {
                    $project->challenges()->create([
                        'title' => $c['title'],
                        'solution' => $c['solution'] ?? '',
                    ]);
                }
            }
        }

        // Handle Timeline
        if ($request->has('timeline')) {
            $timeline = json_decode($request->timeline, true);
            foreach ($timeline as $t) {
                if (!empty($t['title'])) {
                    $project->timelineEntries()->create([
                        'date_label' => $t['date_label'] ?? '',
                        'title' => $t['title'],
                        'description' => $t['description'] ?? '',
                        'tag_text' => $t['tag_text'] ?? null,
                        'tag_color' => $t['tag_color'] ?? null,
                        'is_milestone' => $t['is_milestone'] ?? false,
                    ]);
                }
            }
        }

        // Handle Related Projects
        if ($request->has('related_projects')) {
            $related = json_decode($request->related_projects, true);
            foreach ($related as $r) {
                if (!empty($r['name'])) {
                    $project->relatedProjects()->create([
                        'name' => $r['name'],
                        'category' => $r['category'] ?? '',
                        'description' => $r['description'] ?? '',
                        'image_path' => $r['image_path'] ?? '',
                        'link_url' => $r['link_url'] ?? '',
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Project published successfully!',
            'project_id' => $project->id,
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
            ],
        ]);
    }

    /**
     * Admin update — update an existing project from the admin form.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'url_slug' => 'required|string|unique:projects,url_slug,' . $project->id,
            'type' => 'required|string',
            'client_name' => 'required|string',
            'site_url' => 'nullable|url',
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'status' => 'required|in:live,progress,review,paused,draft',
            'delivered_on_time' => 'boolean',
            'hero_image' => 'nullable|image|max:5120',
            'logo_image' => 'nullable|image|max:2048',
            'overview_heading' => 'required|string',
            'overview_p1' => 'required|string',
            'overview_p2' => 'nullable|string',
            'overview_p3' => 'nullable|string',
            'stat1_num' => 'nullable|string',
            'stat1_lbl' => 'nullable|string',
            'stat2_num' => 'nullable|string',
            'stat2_lbl' => 'nullable|string',
            'stat3_num' => 'nullable|string',
            'stat3_lbl' => 'nullable|string',
            'stack_description' => 'nullable|string',
            'timeline_heading' => 'nullable|string',
            'timeline_subtext' => 'nullable|string',
            'meta_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'canonical_url' => 'nullable|url',
            'og_image_url' => 'nullable|url',
            'twitter_card' => 'nullable|in:summary,summary_large_image',
            'seo_index' => 'boolean',
            'show_portfolio' => 'boolean',
            'is_featured' => 'boolean',
            'visibility' => 'required|in:public,private,password',
            'publish_at' => 'nullable|date',
        ]);

        if ($request->hasFile('hero_image')) {
            $validated['hero_image_path'] = $request->file('hero_image')->store('projects/heroes', 'public');
        }
        if ($request->hasFile('logo_image')) {
            $validated['logo_image_path'] = $request->file('logo_image')->store('projects/logos', 'public');
        }

        $project->update($validated);

        $notification = AdminNotification::create([
            'type' => 'project',
            'title' => 'Project updated',
            'message' => "\"{$project->name}\" was updated.",
            'link' => route('admin.projects.edit', $project),
        ]);

        $techTagIds = [];
        if ($request->has('tech_tags')) {
            $tags = json_decode($request->tech_tags, true) ?? [];
            foreach ($tags as $tagName) {
                $tag = TechTag::firstOrCreate(['name' => $tagName]);
                $techTagIds[] = $tag->id;
            }
        }
        $project->techTags()->sync($techTagIds);

        $serviceTagIds = [];
        if ($request->has('service_tags')) {
            $tags = json_decode($request->service_tags, true) ?? [];
            foreach ($tags as $tagName) {
                $tag = ServiceTag::firstOrCreate(['name' => $tagName]);
                $serviceTagIds[] = $tag->id;
            }
        }
        $project->serviceTags()->sync($serviceTagIds);

        $project->challenges()->delete();
        if ($request->has('challenges')) {
            $challenges = json_decode($request->challenges, true) ?? [];
            foreach ($challenges as $c) {
                if (!empty($c['title'])) {
                    $project->challenges()->create([
                        'title' => $c['title'],
                        'solution' => $c['solution'] ?? '',
                    ]);
                }
            }
        }

        $project->timelineEntries()->delete();
        if ($request->has('timeline')) {
            $timeline = json_decode($request->timeline, true) ?? [];
            foreach ($timeline as $t) {
                if (!empty($t['title'])) {
                    $project->timelineEntries()->create([
                        'date_label' => $t['date_label'] ?? '',
                        'title' => $t['title'],
                        'description' => $t['description'] ?? '',
                        'tag_text' => $t['tag_text'] ?? null,
                        'tag_color' => $t['tag_color'] ?? null,
                        'is_milestone' => $t['is_milestone'] ?? false,
                    ]);
                }
            }
        }

        $project->relatedProjects()->delete();
        if ($request->has('related_projects')) {
            $related = json_decode($request->related_projects, true) ?? [];
            foreach ($related as $r) {
                if (!empty($r['name'])) {
                    $project->relatedProjects()->create([
                        'name' => $r['name'],
                        'category' => $r['category'] ?? '',
                        'description' => $r['description'] ?? '',
                        'image_path' => $r['image_path'] ?? '',
                        'link_url' => $r['link_url'] ?? '',
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Project updated successfully!',
            'project_id' => $project->id,
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
            ],
        ]);
    }

    /**
     * Admin destroy — delete a project and its related records.
     */
    public function destroy(Project $project)
    {
        $projectName = $project->name;

        DB::transaction(function () use ($project) {
            if (!empty($project->hero_image_path) && Storage::disk('public')->exists($project->hero_image_path)) {
                Storage::disk('public')->delete($project->hero_image_path);
            }

            if (!empty($project->logo_image_path) && Storage::disk('public')->exists($project->logo_image_path)) {
                Storage::disk('public')->delete($project->logo_image_path);
            }

            $project->challenges()->delete();
            $project->timelineEntries()->delete();
            $project->relatedProjects()->delete();
            $project->techTags()->detach();
            $project->serviceTags()->detach();
            $project->delete();
        });

        $notification = AdminNotification::create([
            'type' => 'project',
            'title' => 'Project deleted',
            'message' => "\"{$projectName}\" was deleted.",
            'link' => route('admin.projects.index'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.',
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
            ],
        ]);
    }
}
