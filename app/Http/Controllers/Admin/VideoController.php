<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $videos = Video::query()->select('videos.*');

            return DataTables::of($videos)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($v) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$v->id.'">';
                })
                ->addColumn('thumbnail_img', function ($v) {
                    $img = $v->thumbnail ? asset('storage/'.$v->thumbnail) : asset('images/placeholder.png');
                    return '<img src="'.$img.'" style="width:80px;height:50px;object-fit:cover;" class="rounded">';
                })
                ->addColumn('type_badge', function($v) {
                    $colors = ['youtube' => 'danger', 'vimeo' => 'info', 'upload' => 'success'];
                    return '<span class="badge bg-'.($colors[$v->type] ?? 'secondary').'">'.ucfirst($v->type).'</span>';
                })
                ->addColumn('status_switch', function ($v) {
                    $checked = $v->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.videos.update', $v).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($v) {
                    return '<a href="'.route('admin.videos.edit', $v->id).'" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.videos.destroy', $v->id).'" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                            </form>';
                })
                ->rawColumns(['checkbox', 'thumbnail_img', 'type_badge', 'status_switch', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('thumbnail_img', false)
                ->orderColumn('type_badge', false)
                ->orderColumn('status_switch', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        return view('admin.pages.videos.index');
    }

    public function create()
    {
        return view('admin.pages.videos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:youtube,vimeo,upload',
            'video_url'   => 'required_if:type,youtube,vimeo|nullable|string|max:500',
            'video_file'  => 'required_if:type,upload|nullable|mimes:mp4,mov,avi,webm|max:102400',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order'  => 'nullable|integer',
            'is_featured' => 'boolean',
            'status'      => 'boolean',
        ]);

        if ($request->hasFile('video_file')) {
            $validated['video_file'] = $request->file('video_file')->store('videos', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('videos/thumbnails', 'public');
        }

        Video::create($validated);
        return redirect()->route('admin.videos.index')->with('success', 'Video created successfully.');
    }

    public function edit(Video $video)
    {
        return view('admin.pages.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $video->update(['status' => $request->status ?? $video->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|in:youtube,vimeo,upload',
            'video_url'   => 'required_if:type,youtube,vimeo|nullable|string|max:500',
            'video_file'  => 'nullable|mimes:mp4,mov,avi,webm|max:102400',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order'  => 'nullable|integer',
            'is_featured' => 'boolean',
            'status'      => 'boolean',
        ]);

        if ($request->hasFile('video_file')) {
            if ($video->video_file) Storage::disk('public')->delete($video->video_file);
            $validated['video_file'] = $request->file('video_file')->store('videos', 'public');
        }
        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) Storage::disk('public')->delete($video->thumbnail);
            $validated['thumbnail'] = $request->file('thumbnail')->store('videos/thumbnails', 'public');
        }

        $video->update($validated);
        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully.');
    }

    public function destroy(Video $video)
    {
        if ($video->video_file) Storage::disk('public')->delete($video->video_file);
        if ($video->thumbnail)  Storage::disk('public')->delete($video->thumbnail);
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'Video deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        Video::whereIn('id', $ids)->each(function ($v) {
            if ($v->video_file) Storage::disk('public')->delete($v->video_file);
            if ($v->thumbnail)  Storage::disk('public')->delete($v->thumbnail);
            $v->delete();
        });
        return redirect()->route('admin.videos.index')->with('success', count($ids) . ' videos deleted.');
    }
}
