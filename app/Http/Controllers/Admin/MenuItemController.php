<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function store(MenuItemRequest $request)
    {
        $max = MenuItem::where('menu_id', $request->menu_id)
                       ->whereNull('parent_id')
                       ->max('sort_order') ?? -1;

        MenuItem::create(array_merge($request->validated(), ['sort_order' => $max + 1]));

        return back()->with('success', 'Menu item added.');
    }

    public function update(MenuItemRequest $request, MenuItem $menuItem)
    {
        $menuItem->update($request->validated());
        return back()->with('success', 'Menu item updated.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->children()->delete();
        $menuItem->delete();
        return back()->with('success', 'Menu item deleted.');
    }

    public function reorder(Request $request)
    {
        $request->validate(['items' => 'required|array']);

        foreach ($request->items as $index => $item) {
            MenuItem::where('id', $item['id'])->update([
                'sort_order' => $index,
                'parent_id'  => $item['parent_id'] ?? null,
            ]);
        }

        return response()->json(['success' => true]);
    }
}
