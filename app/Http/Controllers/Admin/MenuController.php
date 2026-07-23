<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::withCount('items')->paginate(20);
        return view('admin.pages.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.pages.menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        
        $validated['status'] = $request->has('status') ? 1 : 0;

        Menu::create($validated);

        return redirect()->route('admin.menus.index')->with('success', 'Menu created successfully.');
    }

    public function edit(Menu $menu)
    {
        $menu->load('items');
        return view('admin.pages.menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        // AJAX toggle status
        if ($request->expectsJson()) {
            $menu->update(['status' => $request->status]);
            return response()->json(['success' => true, 'message' => 'Status updated.']);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);
        
        $validated['status'] = $request->has('status') ? 1 : 0;

        $menu->update($validated);

        return redirect()->back()->with('success', 'Menu updated successfully.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted successfully.');
    }
    
    public function storeItem(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'target' => 'nullable|string|max:50',
        ]);
        
        $validated['menu_id'] = $menu->id;
        $validated['target'] = $request->has('target') ? '_blank' : '_self';
        $validated['sort_order'] = $menu->items()->max('sort_order') + 1;
        $validated['status'] = true;

        MenuItem::create($validated);

        return redirect()->back()->with('success', 'Menu item added successfully.');
    }

    public function destroyItem(Menu $menu, MenuItem $item)
    {
        $item->delete();
        return redirect()->back()->with('success', 'Menu item deleted successfully.');
    }
    
    public function updateItem(Request $request, Menu $menu, MenuItem $item)
    {
        $validated = $request->validate([
            'title'     => 'required|string|max:255',
            'url'       => 'required|string|max:255',
            'icon'      => 'nullable|string|max:255',
            'target'    => 'nullable|string|max:50',
            'parent_id' => 'nullable|exists:menu_items,id',
            'status'    => 'nullable',
        ]);

        $validated['target'] = $request->has('target') && $request->input('target') === '_blank' ? '_blank' : '_self';
        $validated['status'] = $request->boolean('status', true);

        $item->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Item updated successfully.']);
        }

        return redirect()->back()->with('success', 'Menu item updated successfully.');
    }
    
    public function sortItems(Request $request, Menu $menu)
    {
        $items = $request->input('items', []);
        
        foreach ($items as $item) {
            MenuItem::where('id', $item['id'])->update(['sort_order' => $item['sort_order']]);
        }
        
        return response()->json(['success' => true, 'message' => 'Menu items sorted successfully.']);
    }
}
