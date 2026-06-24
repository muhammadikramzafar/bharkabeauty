<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('about');
    }

    public function contact()
    {
        return view('contact');
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:2000',
        ]);

        return redirect()->route('contact')->with('success', 'Thank you! We\'ll get back to you within 2–4 hours.');
    }

    public function storeLocator()
    {
        return view('store-locator');
    }

    public function cmsPage(string $slug)
    {
        $page = CmsPage::where('slug', $slug)->where('status', 'published')->firstOrFail();
        return view('cms-page', compact('page'));
    }
}
