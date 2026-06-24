<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\HomepageLogo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageLogoController extends Controller
{
    public function index()
    {
        $logos = HomepageLogo::orderBy('sort_order')->orderBy('id')->paginate(30);
        return view('admin.homepage.logos.index', compact('logos'));
    }

    public function create()
    {
        return view('admin.homepage.logos.form', ['logo' => new HomepageLogo]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('homepage/logos', 'public');
        }
        HomepageLogo::create($data);
        return redirect()->route('admin.homepage.logos.index')->with('success', 'Logo created.');
    }

    public function edit(HomepageLogo $logo)
    {
        return view('admin.homepage.logos.form', compact('logo'));
    }

    public function update(Request $request, HomepageLogo $logo)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('logo')) {
            if ($logo->logo) Storage::disk('public')->delete($logo->logo);
            $data['logo'] = $request->file('logo')->store('homepage/logos', 'public');
        }
        $logo->update($data);
        return redirect()->route('admin.homepage.logos.index')->with('success', 'Logo updated.');
    }

    public function destroy(HomepageLogo $logo)
    {
        if ($logo->logo) Storage::disk('public')->delete($logo->logo);
        $logo->delete();
        return back()->with('success', 'Logo deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name'       => 'required|string|max:100',
            'tagline'    => 'nullable|string|max:60',
            'logo'       => 'nullable|image|max:2048',
            'url'        => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
        ]);
    }
}
