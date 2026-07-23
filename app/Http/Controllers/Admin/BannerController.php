<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('sort_order')->paginate(20);
        return view('admin.pages.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.pages.banners.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
            'link' => 'nullable|url',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        Banner::create($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner created successfully.');
    }

    public function edit(Banner $banner)
    {
        return view('admin.pages.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        // AJAX toggle status
        if ($request->expectsJson()) {
            $banner->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'link' => 'nullable|url',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image) {
                \Storage::disk('public')->delete($banner->image);
            }
            $validated['image'] = $request->file('image')->store('banners', 'public');
        }

        $banner->update($validated);

        return redirect()->route('admin.banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image) {
            \Storage::disk('public')->delete($banner->image);
        }
        $banner->delete();
        return redirect()->route('admin.banners.index')->with('success', 'Banner deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true) ?? [];
        if (empty($ids)) {
            return redirect()->route('admin.banners.index')->with('error', 'No items selected.');
        }
        $banners = Banner::whereIn('id', $ids)->get();
        foreach ($banners as $banner) {
            if ($banner->image) {
                \Storage::disk('public')->delete($banner->image);
            }
            $banner->delete();
        }
        return redirect()->route('admin.banners.index')->with('success', count($ids) . ' banners deleted.');
    }
}
