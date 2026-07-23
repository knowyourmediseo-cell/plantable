<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->paginate(20);
        return view('admin.pages.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.pages.sliders.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'mobile_image' => 'nullable|image|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            $validated['mobile_image'] = $request->file('mobile_image')->store('sliders', 'public');
        }

        Slider::create($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider created successfully.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.pages.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        // AJAX toggle status
        if ($request->expectsJson()) {
            $slider->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'mobile_image' => 'nullable|image|max:2048',
            'button_text' => 'nullable|string|max:255',
            'button_link' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $validated['image'] = $request->file('image')->store('sliders', 'public');
        }

        if ($request->hasFile('mobile_image')) {
            if ($slider->mobile_image) {
                Storage::disk('public')->delete($slider->mobile_image);
            }
            $validated['mobile_image'] = $request->file('mobile_image')->store('sliders', 'public');
        }

        $slider->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated successfully.');
    }

    public function destroy(Slider $slider)
    {
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        if ($slider->mobile_image) {
            Storage::disk('public')->delete($slider->mobile_image);
        }

        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true) ?? [];
        if (empty($ids)) {
            return redirect()->route('admin.sliders.index')->with('error', 'No items selected.');
        }
        $sliders = Slider::whereIn('id', $ids)->get();
        foreach ($sliders as $slider) {
            if ($slider->image) Storage::disk('public')->delete($slider->image);
            if ($slider->mobile_image) Storage::disk('public')->delete($slider->mobile_image);
            $slider->delete();
        }
        return redirect()->route('admin.sliders.index')->with('success', count($ids) . ' sliders deleted.');
    }
}
