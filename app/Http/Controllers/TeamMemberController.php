<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamMemberController extends Controller
{
    /**
     * Public team page — dynamic team listing and stats.
     */
    public function teamPage()
    {
        $members = TeamMember::query()
            ->where('show_on_team', true)
            ->orderByDesc('is_featured')
            ->orderBy('first_name')
            ->get();

        $teamMembersPayload = $members->map(function (TeamMember $member) {
            return [
                'id' => $member->url_slug ?: $member->id,
                'name' => $member->name,
                'title' => $member->title,
                'dept' => $member->dept ?: 'other',
                'deptLabel' => $member->dept_label ?: ucfirst((string) $member->dept),
                'bio' => Str::limit((string) ($member->bio ?? ''), 220),
                'skills' => collect($member->skills ?? [])->take(5)->values(),
                'exp' => $member->exp ?: '',
                'photo' => $member->photo_path ? asset('storage/' . $member->photo_path) : '',
                'initials' => $member->initials ?: strtoupper(substr((string) $member->name, 0, 2)),
                'linkedin' => $member->linkedin ?: '',
                'twitter' => $member->twitter ?: '',
                'profile' => route('team-member', ['slug' => $member->url_slug ?: $member->id]),
            ];
        })->values();

        $teamDepartments = $members
            ->map(function (TeamMember $member) {
                return [
                    'key' => $member->dept ?: 'other',
                    'label' => $member->dept_label ?: ucfirst((string) $member->dept),
                ];
            })
            ->unique('key')
            ->values();

        $teamStats = [
            'members' => $members->count(),
            'disciplines' => $teamDepartments->count(),
            'countries' => 4,
            'projects' => 50,
        ];

        $page = \App\Models\Page::where('slug', 'team')->first();

        return view('team', compact('teamMembersPayload', 'teamDepartments', 'teamStats', 'page'));
    }

    /**
     * Public team member profile page.
     */
    public function memberPage(?string $slug = null)
    {
        $member = null;

        if ($slug !== null) {
            $member = TeamMember::query()
                ->where('url_slug', $slug)
                ->orWhere('id', $slug)
                ->first();
        }

        if (!$member) {
            $member = TeamMember::query()
                ->where('show_on_team', true)
                ->orderByDesc('is_featured')
                ->orderBy('first_name')
                ->firstOrFail();
        }

        $member->load(['qualifications', 'achievements']);

        $selectedMemberPayload = [
            'id' => $member->url_slug ?: (string) $member->id,
            'name' => $member->name,
            'title' => $member->title,
            'dept' => $member->dept ?: 'other',
            'deptLabel' => $member->dept_label ?: ucfirst((string) $member->dept),
            'bio' => (string) ($member->bio ?? ''),
            'skills' => collect($member->skills ?? [])->values(),
            'exp' => $member->exp ?: '',
            'photo' => $member->photo_path ? asset('storage/' . $member->photo_path) : '',
            'initials' => $member->initials ?: strtoupper(substr((string) $member->name, 0, 2)),
            'linkedin' => $member->linkedin ?: '',
            'twitter' => $member->twitter ?: '',
            'email' => $member->email ?: '',
            'location' => $member->location ?: '',
            'qualifications' => $member->qualifications->pluck('qualification')->values(),
            'achievements' => $member->achievements->map(function ($achievement) {
                return [
                    'num' => $achievement->num,
                    'lbl' => $achievement->label,
                ];
            })->values(),
            'expertiseTags' => collect($member->expertise_tags ?? [])->values(),
        ];

        $otherMembersPayload = TeamMember::query()
            ->where('show_on_team', true)
            ->where('id', '!=', $member->id)
            ->orderByDesc('is_featured')
            ->orderBy('first_name')
            ->take(4)
            ->get()
            ->map(function (TeamMember $otherMember) {
                return [
                    'id' => $otherMember->url_slug ?: (string) $otherMember->id,
                    'name' => $otherMember->name,
                    'title' => $otherMember->title,
                    'photo' => $otherMember->photo_path ? asset('storage/' . $otherMember->photo_path) : '',
                    'initials' => $otherMember->initials ?: strtoupper(substr((string) $otherMember->name, 0, 2)),
                    'profile' => route('team-member', ['slug' => $otherMember->url_slug ?: $otherMember->id]),
                ];
            })
            ->values();

        return view('team-member', compact('selectedMemberPayload', 'otherMembersPayload'));
    }

    /**
     * Admin add member page.
     */
    public function create()
    {
        return view('admin.add-team-member');
    }

    /**
     * Admin team listing — load all members for the index page.
     */
    public function index()
    {
        $members = TeamMember::query()
            ->orderByDesc('created_at')
            ->get()
            ->map(function (TeamMember $m) {
                $fullName = trim(implode(' ', array_filter([
                    $m->first_name,
                    $m->middle_name,
                    $m->last_name,
                ])));

                return [
                    'id'          => $m->id,
                    'name'        => $fullName !== '' ? $fullName : $m->name,
                    'initials'    => $m->initials,
                    'title'       => $m->title,
                    'dept'        => $m->dept,
                    'dept_label'  => $m->dept_label,
                    'exp'         => $m->exp,
                    'location'    => $m->location,
                    'bio'         => Str::limit($m->bio ?? '', 120),
                    'photo'       => $m->photo_path ? asset('storage/' . $m->photo_path) : null,
                    'email'       => $m->email,
                    'linkedin'    => $m->linkedin,
                    'twitter'     => $m->twitter,
                    'github'      => $m->github,
                    'skills'      => $m->skills ?? [],
                    'is_featured' => (bool) $m->is_featured,
                    'visibility'  => $m->visibility,
                ];
            })
            ->values();

        return view('admin.team.index', compact('members'));
    }

    /**
     * Store a new team member from the admin form.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'middle_name'      => 'nullable|string|max:255',
            'last_name'        => 'required|string|max:255',
            'url_slug'         => 'required|string|unique:team_members,url_slug',
            'initials'         => 'required|string|max:3',
            'title'            => 'required|string|max:255',
            'dept'             => 'required|string',
            'dept_label'       => 'nullable|string|max:255',
            'exp'              => 'nullable|string|max:100',
            'location'         => 'nullable|string|max:255',
            'bio'              => 'required|string',
            'photo'            => 'nullable|image|max:5120',
            'email'            => 'required|email|max:255',
            'linkedin'         => 'nullable|url|max:500',
            'twitter'          => 'nullable|url|max:500',
            'github'           => 'nullable|url|max:500',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string|max:500',
            'canonical_url'    => 'nullable|url|max:500',
            'og_image_url'     => 'nullable|url|max:500',
            'seo_index'        => 'boolean',
            'show_on_team'     => 'boolean',
            'is_featured'      => 'boolean',
            'visibility'       => 'required|in:public,private,unlisted',
            'publish_at'       => 'nullable|date',
        ]);

        $validated['name'] = trim(implode(' ', array_filter([
            $validated['first_name'] ?? null,
            $validated['middle_name'] ?? null,
            $validated['last_name'] ?? null,
        ])));

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('team/photos', 'public');
        }

        $validated['skills'] = json_decode($request->input('skills', '[]'), true) ?? [];
        $validated['expertise_tags'] = json_decode($request->input('expertise_tags', '[]'), true) ?? [];

        $member = TeamMember::create($validated);

        $notification = AdminNotification::create([
            'type' => 'team',
            'title' => 'Team member added',
            'message' => "\"{$member->name}\" was added to the team.",
            'link' => route('admin.team-members.edit', $member),
        ]);

        // Qualifications
        $qualifications = json_decode($request->input('qualifications', '[]'), true) ?? [];
        foreach ($qualifications as $i => $qual) {
            if (!empty(trim($qual))) {
                $member->qualifications()->create([
                    'qualification' => trim($qual),
                    'sort_order'    => $i,
                ]);
            }
        }

        // Achievements
        $achievements = json_decode($request->input('achievements', '[]'), true) ?? [];
        foreach ($achievements as $i => $a) {
            if (!empty($a['num']) || !empty($a['lbl'])) {
                $member->achievements()->create([
                    'num'        => $a['num'] ?? '',
                    'label'      => $a['lbl'] ?? '',
                    'sort_order' => $i,
                ]);
            }
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Team member published successfully!',
            'member_id' => $member->id,
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
            ],
        ]);
    }

    /**
     * Admin edit member page.
     */
    public function edit(TeamMember $teamMember)
    {
        $teamMember->load(['qualifications', 'achievements']);

        return view('admin.add-team-member', [
            'editingMember' => $teamMember,
        ]);
    }

    /**
     * Update an existing team member from the admin form.
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'first_name'       => 'required|string|max:255',
            'middle_name'      => 'nullable|string|max:255',
            'last_name'        => 'required|string|max:255',
            'url_slug'         => 'required|string|unique:team_members,url_slug,' . $teamMember->id,
            'initials'         => 'required|string|max:3',
            'title'            => 'required|string|max:255',
            'dept'             => 'required|string',
            'dept_label'       => 'nullable|string|max:255',
            'exp'              => 'nullable|string|max:100',
            'location'         => 'nullable|string|max:255',
            'bio'              => 'required|string',
            'photo'            => 'nullable|image|max:5120',
            'email'            => 'required|email|max:255',
            'linkedin'         => 'nullable|url|max:500',
            'twitter'          => 'nullable|url|max:500',
            'github'           => 'nullable|url|max:500',
            'meta_title'       => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string|max:500',
            'canonical_url'    => 'nullable|url|max:500',
            'og_image_url'     => 'nullable|url|max:500',
            'seo_index'        => 'boolean',
            'show_on_team'     => 'boolean',
            'is_featured'      => 'boolean',
            'visibility'       => 'required|in:public,private,unlisted',
            'publish_at'       => 'nullable|date',
        ]);

        $validated['name'] = trim(implode(' ', array_filter([
            $validated['first_name'] ?? null,
            $validated['middle_name'] ?? null,
            $validated['last_name'] ?? null,
        ])));

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('team/photos', 'public');
        }

        $validated['skills'] = json_decode($request->input('skills', '[]'), true) ?? [];
        $validated['expertise_tags'] = json_decode($request->input('expertise_tags', '[]'), true) ?? [];

        $teamMember->update($validated);

        $notification = AdminNotification::create([
            'type' => 'team',
            'title' => 'Team member updated',
            'message' => "\"{$teamMember->name}\" profile was updated.",
            'link' => route('admin.team-members.edit', $teamMember),
        ]);

        $teamMember->qualifications()->delete();
        $qualifications = json_decode($request->input('qualifications', '[]'), true) ?? [];
        foreach ($qualifications as $i => $qual) {
            if (!empty(trim($qual))) {
                $teamMember->qualifications()->create([
                    'qualification' => trim($qual),
                    'sort_order'    => $i,
                ]);
            }
        }

        $teamMember->achievements()->delete();
        $achievements = json_decode($request->input('achievements', '[]'), true) ?? [];
        foreach ($achievements as $i => $a) {
            if (!empty($a['num']) || !empty($a['lbl'])) {
                $teamMember->achievements()->create([
                    'num'        => $a['num'] ?? '',
                    'label'      => $a['lbl'] ?? '',
                    'sort_order' => $i,
                ]);
            }
        }

        return response()->json([
            'success'   => true,
            'message'   => 'Team member updated successfully!',
            'member_id' => $teamMember->id,
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
            ],
        ]);
    }

    /**
     * Delete a team member from admin and remove related records.
     */
    public function destroy(TeamMember $teamMember)
    {
        $memberName = $teamMember->name;

        if (!empty($teamMember->photo_path) && Storage::disk('public')->exists($teamMember->photo_path)) {
            Storage::disk('public')->delete($teamMember->photo_path);
        }

        $teamMember->achievements()->delete();
        $teamMember->qualifications()->delete();
        $teamMember->delete();

        $notification = AdminNotification::create([
            'type' => 'team',
            'title' => 'Team member removed',
            'message' => "\"{$memberName}\" was removed from the team.",
            'link' => route('admin.team.index'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Team member removed successfully.',
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
            ],
        ]);
    }
}
