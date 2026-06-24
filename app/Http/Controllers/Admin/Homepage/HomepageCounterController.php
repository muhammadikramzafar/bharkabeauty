<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\HomepageCounter;
use Illuminate\Http\Request;

class HomepageCounterController extends Controller
{
    public function index()
    {
        $counters = HomepageCounter::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.homepage.counters.index', compact('counters'));
    }

    public function create()
    {
        return view('admin.homepage.counters.form', ['counter' => new HomepageCounter]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        HomepageCounter::create($data);
        return redirect()->route('admin.homepage.counters.index')->with('success', 'Counter created.');
    }

    public function edit(HomepageCounter $counter)
    {
        return view('admin.homepage.counters.form', compact('counter'));
    }

    public function update(Request $request, HomepageCounter $counter)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        $counter->update($data);
        return redirect()->route('admin.homepage.counters.index')->with('success', 'Counter updated.');
    }

    public function destroy(HomepageCounter $counter)
    {
        $counter->delete();
        return back()->with('success', 'Counter deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'number'      => 'required|string|max:20',
            'suffix'      => 'nullable|string|max:10',
            'label'       => 'required|string|max:80',
            'description' => 'nullable|string|max:200',
            'sort_order'  => 'nullable|integer|min:0',
        ]);
    }
}
