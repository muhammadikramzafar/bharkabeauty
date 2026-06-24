<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.homepage.hero.index', compact('slides'));
    }

    public function create()
    {
        return view('admin.homepage.hero.form', ['slide' => new HeroSlide]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('homepage/hero', 'public');
        }

        HeroSlide::create($data);
        return redirect()->route('admin.homepage.hero.index')->with('success', 'Slide created.');
    }

    public function edit(HeroSlide $hero)
    {
        return view('admin.homepage.hero.form', ['slide' => $hero]);
    }

    public function update(Request $request, HeroSlide $hero)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($hero->image) Storage::disk('public')->delete($hero->image);
            $data['image'] = $request->file('image')->store('homepage/hero', 'public');
        }

        $hero->update($data);
        return redirect()->route('admin.homepage.hero.index')->with('success', 'Slide updated.');
    }

    public function destroy(HeroSlide $hero)
    {
        if ($hero->image) Storage::disk('public')->delete($hero->image);
        $hero->delete();
        return back()->with('success', 'Slide deleted.');
    }

    public function reorder(Request $request)
    {
        foreach ($request->input('order', []) as $index => $id) {
            HeroSlide::where('id', $id)->update(['sort_order' => $index]);
        }
        return response()->json(['ok' => true]);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'eyebrow'          => 'nullable|string|max:80',
            'title'            => 'required|string|max:120',
            'title_highlight'  => 'nullable|string|max:80',
            'description'      => 'nullable|string|max:400',
            'image'            => 'nullable|image|max:5120',
            'badge_text'       => 'nullable|string|max:60',
            'button1_text'     => 'nullable|string|max:60',
            'button1_url'      => 'nullable|string|max:255',
            'button2_text'     => 'nullable|string|max:60',
            'button2_url'      => 'nullable|string|max:255',
            'sort_order'       => 'nullable|integer|min:0',
        ]);
    }
}
