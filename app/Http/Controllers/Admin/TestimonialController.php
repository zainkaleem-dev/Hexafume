<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::query()
            ->orderBy('order_index')
            ->orderByDesc('created_at')
            ->get()
            ->map(function (Testimonial $testimonial) {
                return [
                    'id' => $testimonial->id,
                    'client_name' => $testimonial->client_name,
                    'company' => $testimonial->company,
                    'role' => $testimonial->role,
                    'location' => $testimonial->location,
                    'quote' => Str::limit($testimonial->quote, 120),
                    'initials' => $testimonial->initials,
                    'photo_url' => $testimonial->photo_url,
                    'order_index' => $testimonial->order_index,
                    'is_active' => (bool) $testimonial->is_active,
                ];
            })
            ->values();

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.testimonials.form');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.form', [
            'editingTestimonial' => $testimonial,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validatePayload($request);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('testimonials/photos', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order_index'] = $validated['order_index'] ?? 0;

        $testimonial = Testimonial::create($validated);

        $notification = AdminNotification::create([
            'type' => 'testimonial',
            'title' => 'Testimonial added',
            'message' => "\"{$testimonial->client_name}\" testimonial was added.",
            'link' => route('admin.testimonials.edit', $testimonial),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial created successfully.',
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
            ],
        ]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $this->validatePayload($request, $testimonial->id);

        if ($request->hasFile('photo')) {
            if ($testimonial->photo && Storage::disk('public')->exists($testimonial->photo)) {
                Storage::disk('public')->delete($testimonial->photo);
            }
            $validated['photo'] = $request->file('photo')->store('testimonials/photos', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['order_index'] = $validated['order_index'] ?? 0;

        $testimonial->update($validated);

        $notification = AdminNotification::create([
            'type' => 'testimonial',
            'title' => 'Testimonial updated',
            'message' => "\"{$testimonial->client_name}\" testimonial was updated.",
            'link' => route('admin.testimonials.edit', $testimonial),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial updated successfully.',
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
            ],
        ]);
    }

    public function destroy(Testimonial $testimonial)
    {
        $clientName = $testimonial->client_name;

        if ($testimonial->photo && Storage::disk('public')->exists($testimonial->photo)) {
            Storage::disk('public')->delete($testimonial->photo);
        }

        $testimonial->delete();

        $notification = AdminNotification::create([
            'type' => 'testimonial',
            'title' => 'Testimonial removed',
            'message' => "\"{$clientName}\" testimonial was removed.",
            'link' => route('admin.testimonials.index'),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimonial deleted successfully.',
            'notification' => [
                'id' => $notification->id,
                'title' => $notification->title,
                'message' => $notification->message,
            ],
        ]);
    }

    private function validatePayload(Request $request, ?int $testimonialId = null): array
    {
        return $request->validate([
            'client_name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'company' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'quote' => 'required|string',
            'photo' => 'nullable|image|max:5120',
            'initials' => 'nullable|string|max:4',
            'order_index' => 'nullable|integer|min:0',
        ]);
    }
}
