<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $testimonials = Testimonial::query()->select('testimonials.*');

            return DataTables::of($testimonials)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($t) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$t->id.'">';
                })
                ->addColumn('image_thumb', function ($t) {
                    $img = $t->image ? asset('storage/'.$t->image) : asset('images/default-avatar.png');
                    return '<img src="'.$img.'" style="width:50px;height:50px;object-fit:cover;" class="rounded-circle">';
                })
                ->addColumn('rating_display', fn($t) => str_repeat('⭐', $t->rating))
                ->addColumn('status_switch', function ($t) {
                    $checked = $t->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.testimonials.update', $t).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($t) {
                    return '<a href="'.route('admin.testimonials.edit', $t->id).'" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.testimonials.destroy', $t->id).'" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                            </form>';
                })
                ->rawColumns(['checkbox', 'image_thumb', 'rating_display', 'status_switch', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('image_thumb', false)
                ->orderColumn('rating_display', false)
                ->orderColumn('status_switch', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        return view('admin.pages.testimonials.index');
    }

    public function create()
    {
        return view('admin.pages.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'company'     => 'nullable|string|max:255',
            'content'     => 'required|string',
            'rating'      => 'required|integer|min:1|max:5',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order'  => 'nullable|integer',
            'is_featured' => 'boolean',
            'status'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create($validated);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial created successfully.');
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.pages.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        // AJAX status toggle
        if ($request->ajax() || $request->wantsJson()) {
            $testimonial->update(['status' => $request->status ?? $testimonial->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'designation' => 'nullable|string|max:255',
            'company'     => 'nullable|string|max:255',
            'content'     => 'required|string',
            'rating'      => 'required|integer|min:1|max:5',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order'  => 'nullable|integer',
            'is_featured' => 'boolean',
            'status'      => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($testimonial->image) Storage::disk('public')->delete($testimonial->image);
            $validated['image'] = $request->file('image')->store('testimonials', 'public');
        }

        $testimonial->update($validated);
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->image) Storage::disk('public')->delete($testimonial->image);
        $testimonial->delete();
        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        Testimonial::whereIn('id', $ids)->each(function ($t) {
            if ($t->image) Storage::disk('public')->delete($t->image);
            $t->delete();
        });
        return redirect()->route('admin.testimonials.index')->with('success', count($ids) . ' testimonials deleted.');
    }
}
