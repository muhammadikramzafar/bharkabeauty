<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactInquiry;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactInquiry::latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) =>
                $q->where('name', 'like', "%$s%")
                  ->orWhere('email', 'like', "%$s%")
                  ->orWhere('subject', 'like', "%$s%")
            );
        }

        $inquiries = $query->paginate(25)->withQueryString();

        $counts = [
            'all'     => ContactInquiry::count(),
            'new'     => ContactInquiry::where('status', 'new')->count(),
            'read'    => ContactInquiry::where('status', 'read')->count(),
            'replied' => ContactInquiry::where('status', 'replied')->count(),
        ];

        return view('admin.inquiries.index', compact('inquiries', 'counts'));
    }

    public function show(ContactInquiry $inquiry)
    {
        $inquiry->markRead();
        return view('admin.inquiries.show', compact('inquiry'));
    }

    public function update(Request $request, ContactInquiry $inquiry)
    {
        $data = $request->validate([
            'status'      => 'required|in:new,read,replied',
            'admin_notes' => 'nullable|string|max:2000',
        ]);

        $inquiry->update($data);

        return back()->with('success', 'Inquiry updated.');
    }

    public function destroy(ContactInquiry $inquiry)
    {
        $inquiry->delete();
        return redirect()->route('admin.inquiries.index')->with('success', 'Inquiry deleted.');
    }
}
