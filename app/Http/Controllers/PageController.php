<?php

namespace App\Http\Controllers;

use App\Models\CmsPage;
use App\Models\ContactInquiry;
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
        $data = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:30',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|max:3000',
        ]);

        ContactInquiry::create(array_merge($data, [
            'ip_address' => $request->ip(),
        ]));

        return redirect()->route('contact')->with('success', 'Thank you! Your message has been received. We\'ll get back to you within 2–4 hours.');
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
