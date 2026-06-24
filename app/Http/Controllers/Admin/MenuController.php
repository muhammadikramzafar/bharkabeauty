<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Models\Menu;
use App\Models\CmsPage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::withCount('allItems')->latest()->get();
        return view('admin.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('admin.menus.create');
    }

    public function store(MenuRequest $request)
    {
        Menu::create($request->validated());
        return redirect()->route('admin.menus.index')->with('success', 'Menu created.');
    }

    public function edit(Menu $menu)
    {
        $menu->load(['items.children']);
        $pages = CmsPage::published()->orderBy('title')->get();
        return view('admin.menus.edit', compact('menu', 'pages'));
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());
        return back()->with('success', 'Menu updated.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu deleted.');
    }
}
