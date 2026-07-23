<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $clients = Client::query()->select('clients.*');

            return DataTables::of($clients)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($c) {
                    return '<input type="checkbox" class="item-checkbox" value="'.$c->id.'">';
                })
                ->addColumn('logo_img', function ($c) {
                    $img = $c->logo ? asset('storage/'.$c->logo) : asset('images/placeholder.png');
                    return '<img src="'.$img.'" style="width:80px;height:50px;object-fit:contain;" class="rounded">';
                })
                ->addColumn('website_link', fn($c) => $c->website ? '<a href="'.$c->website.'" target="_blank"><i class="fas fa-external-link-alt"></i></a>' : '—')
                ->addColumn('status_switch', function ($c) {
                    $checked = $c->status ? 'checked' : '';
                    return '<div class="form-check form-switch"><input class="form-check-input toggle-status" type="checkbox" role="switch" data-url="'.route('admin.clients.update', $c).'" '.$checked.'></div>';
                })
                ->addColumn('action', function ($c) {
                    return '<a href="'.route('admin.clients.edit', $c->id).'" class="btn btn-sm btn-outline-primary"><i class="fas fa-edit"></i></a>
                            <form action="'.route('admin.clients.destroy', $c->id).'" method="POST" class="d-inline">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn"><i class="fas fa-trash"></i></button>
                            </form>';
                })
                ->rawColumns(['checkbox', 'logo_img', 'website_link', 'status_switch', 'action'])
                ->orderColumn('DT_RowIndex', 'id $1')
                ->orderColumn('checkbox', false)
                ->orderColumn('logo_img', false)
                ->orderColumn('website_link', false)
                ->orderColumn('status_switch', false)
                ->orderColumn('action', false)
                ->make(true);
        }

        return view('admin.pages.clients.index');
    }

    public function create()
    {
        return view('admin.pages.clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'logo'       => 'required|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'website'    => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
            'status'     => 'boolean',
        ]);
        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('clients', 'public');
        }
        Client::create($validated);
        return redirect()->route('admin.clients.index')->with('success', 'Client created successfully.');
    }

    public function edit(Client $client)
    {
        return view('admin.pages.clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $client->update(['status' => $request->status ?? $client->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'logo'       => 'nullable|image|mimes:jpeg,png,jpg,webp,svg|max:2048',
            'website'    => 'nullable|url|max:255',
            'sort_order' => 'nullable|integer',
            'status'     => 'boolean',
        ]);
        if ($request->hasFile('logo')) {
            if ($client->logo) Storage::disk('public')->delete($client->logo);
            $validated['logo'] = $request->file('logo')->store('clients', 'public');
        }
        $client->update($validated);
        return redirect()->route('admin.clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        if ($client->logo) Storage::disk('public')->delete($client->logo);
        $client->delete();
        return redirect()->route('admin.clients.index')->with('success', 'Client deleted.');
    }

    public function bulkDelete(Request $request)
    {
        $ids = json_decode($request->ids, true);
        Client::whereIn('id', $ids)->each(function ($c) {
            if ($c->logo) Storage::disk('public')->delete($c->logo);
            $c->delete();
        });
        return redirect()->route('admin.clients.index')->with('success', count($ids) . ' clients deleted.');
    }
}
