<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\HomepageCta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageCtaController extends Controller
{
    public function index()
    {
        $ctas = HomepageCta::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.homepage.cta.index', compact('ctas'));
    }

    public function create()
    {
        return view('admin.homepage.cta.form', ['cta' => new HomepageCta]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('homepage/cta', 'public');
        }
        HomepageCta::create($data);
        return redirect()->route('admin.homepage.cta.index')->with('success', 'CTA created.');
    }

    public function edit(HomepageCta $cta)
    {
        return view('admin.homepage.cta.form', compact('cta'));
    }

    public function update(Request $request, HomepageCta $cta)
    {
        $data = $this->validated($request, $cta->id);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            if ($cta->image) Storage::disk('public')->delete($cta->image);
            $data['image'] = $request->file('image')->store('homepage/cta', 'public');
        }
        $cta->update($data);
        return redirect()->route('admin.homepage.cta.index')->with('success', 'CTA updated.');
    }

    public function destroy(HomepageCta $cta)
    {
        if ($cta->image) Storage::disk('public')->delete($cta->image);
        $cta->delete();
        return back()->with('success', 'CTA deleted.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'section_key' => 'required|string|max:60|unique:homepage_ctas,section_key,' . $ignoreId,
            'title'       => 'required|string|max:160',
            'description' => 'nullable|string|max:600',
            'image'       => 'nullable|image|max:5120',
            'button_text' => 'nullable|string|max:60',
            'button_url'  => 'nullable|string|max:255',
            'extra_line1' => 'nullable|string|max:255',
            'extra_line2' => 'nullable|string|max:255',
            'sort_order'  => 'nullable|integer|min:0',
        ]);
    }
}
