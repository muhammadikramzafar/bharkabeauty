<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\HomepageTestimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomepageTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = HomepageTestimonial::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.homepage.testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        return view('admin.homepage.testimonials.form', ['testimonial' => new HomepageTestimonial]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        foreach (['reviewer_image', 'product_image'] as $field) {
            if ($request->hasFile($field)) {
                $data[$field] = $request->file($field)->store('homepage/testimonials', 'public');
            }
        }
        HomepageTestimonial::create($data);
        return redirect()->route('admin.homepage.testimonials.index')->with('success', 'Testimonial created.');
    }

    public function edit(HomepageTestimonial $testimonial)
    {
        return view('admin.homepage.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, HomepageTestimonial $testimonial)
    {
        $data = $this->validated($request);
        $data['is_active'] = $request->boolean('is_active');
        foreach (['reviewer_image', 'product_image'] as $field) {
            if ($request->hasFile($field)) {
                if ($testimonial->$field) Storage::disk('public')->delete($testimonial->$field);
                $data[$field] = $request->file($field)->store('homepage/testimonials', 'public');
            }
        }
        $testimonial->update($data);
        return redirect()->route('admin.homepage.testimonials.index')->with('success', 'Testimonial updated.');
    }

    public function destroy(HomepageTestimonial $testimonial)
    {
        foreach (['reviewer_image', 'product_image'] as $f) {
            if ($testimonial->$f) Storage::disk('public')->delete($testimonial->$f);
        }
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'reviewer_name'     => 'required|string|max:100',
            'reviewer_location' => 'nullable|string|max:100',
            'review_text'       => 'required|string|max:600',
            'rating'            => 'required|integer|min:1|max:5',
            'reviewer_image'    => 'nullable|image|max:2048',
            'product_brand'     => 'nullable|string|max:100',
            'product_name'      => 'nullable|string|max:160',
            'product_image'     => 'nullable|image|max:2048',
            'sort_order'        => 'nullable|integer|min:0',
        ]);
    }
}
