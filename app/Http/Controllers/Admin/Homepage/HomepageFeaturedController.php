<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\HomepageFeatured;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageFeaturedController extends Controller
{
    public function index()
    {
        $featured = HomepageFeatured::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.homepage.featured.index', compact('featured'));
    }

    public function create()
    {
        return view('admin.homepage.featured.form', ['item' => new HomepageFeatured]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('homepage/featured', 'public');
        }
        HomepageFeatured::create($data);
        return redirect()->route('admin.homepage.featured.index')->with('success', 'Featured item created.');
    }

    public function edit(HomepageFeatured $featured)
    {
        return view('admin.homepage.featured.form', ['item' => $featured]);
    }

    public function update(Request $request, HomepageFeatured $featured)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($featured->image) Storage::disk('public')->delete($featured->image);
            $data['image'] = $request->file('image')->store('homepage/featured', 'public');
        }
        $featured->update($data);
        return redirect()->route('admin.homepage.featured.index')->with('success', 'Featured item updated.');
    }

    public function destroy(HomepageFeatured $featured)
    {
        if ($featured->image) Storage::disk('public')->delete($featured->image);
        $featured->delete();
        return back()->with('success', 'Featured item deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'eyebrow'     => 'nullable|string|max:60',
            'title'       => 'required|string|max:120',
            'description' => 'nullable|string|max:400',
            'image'       => 'nullable|image|max:5120',
            'button_text' => 'nullable|string|max:60',
            'button_url'  => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer|min:0',
        ]);
    }
}
