<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Admin pages index — list all manageable site pages.
     */
    /**
     * Admin pages index — list all manageable site pages.
     */
    public function index()
    {
        $pages = \App\Models\Page::all()->map(function($page) {
            // Re-adding the dynamic URL for the view to use
            $page->url = route($page->slug == 'home' ? 'home' : $page->slug);
            $page->desc = $page->description; // Alias for backward compatibility with existing view
            return $page;
        });

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the edit form for a specific page.
     */
    public function edit($slug)
    {
        $page = \App\Models\Page::where('slug', $slug)->with(['sections' => function($q) {
            $q->orderBy('sort_order', 'asc');
        }])->firstOrFail();
        
        // Return a specialized view based on the page slug if needed,
        // or a generic one that handles the sections.
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the page and its sections.
     */
    public function update(Request $request, $slug)
    {
        $page = \App\Models\Page::where('slug', $slug)->firstOrFail();
        
        // Update core page metadata
        $page->update($request->only([
            'name', 'meta_title', 'meta_description', 'meta_keywords'
        ]));

        // Handle Sections update
        if ($request->has('sections')) {
            foreach ($request->input('sections') as $key => $content) {
                $section = $page->sections()->where('section_key', $key)->first();
                if ($section) {
                    $section->update(['content' => $content]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Page content updated successfully!',
            'redirect' => route('admin.pages.index')
        ]);
    }
}
