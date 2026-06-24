<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\HomepageBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageBannerController extends Controller
{
    public function index()
    {
        $banners = HomepageBanner::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.homepage.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.homepage.banners.form', ['banner' => new HomepageBanner]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('homepage/banners', 'public');
        }
        HomepageBanner::create($data);
        return redirect()->route('admin.homepage.banners.index')->with('success', 'Banner created.');
    }

    public function edit(HomepageBanner $banner)
    {
        return view('admin.homepage.banners.form', compact('banner'));
    }

    public function update(Request $request, HomepageBanner $banner)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($banner->image) Storage::disk('public')->delete($banner->image);
            $data['image'] = $request->file('image')->store('homepage/banners', 'public');
        }
        $banner->update($data);
        return redirect()->route('admin.homepage.banners.index')->with('success', 'Banner updated.');
    }

    public function destroy(HomepageBanner $banner)
    {
        if ($banner->image) Storage::disk('public')->delete($banner->image);
        $banner->delete();
        return back()->with('success', 'Banner deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'       => 'required|string|max:160',
            'subtitle'    => 'nullable|string|max:255',
            'badge_text'  => 'nullable|string|max:40',
            'image'       => 'nullable|image|max:5120',
            'button_text' => 'nullable|string|max:60',
            'button_url'  => 'nullable|string|max:255',
            'position'    => 'required|in:top,middle,bottom',
            'sort_order'  => 'nullable|integer|min:0',
        ]);
    }
}
