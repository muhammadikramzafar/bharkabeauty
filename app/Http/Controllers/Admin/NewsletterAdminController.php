<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class NewsletterAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::latest('subscribed_at');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) =>
                $q->where('email', 'like', "%$s%")
                  ->orWhere('name', 'like', "%$s%")
            );
        }

        $subscribers = $query->paginate(30)->withQueryString();

        $counts = [
            'total'        => NewsletterSubscriber::count(),
            'active'       => NewsletterSubscriber::where('status', 'active')->count(),
            'unsubscribed' => NewsletterSubscriber::where('status', 'unsubscribed')->count(),
        ];

        return view('admin.newsletter.index', compact('subscribers', 'counts'));
    }

    public function export(): StreamedResponse
    {
        $subscribers = NewsletterSubscriber::active()->orderBy('subscribed_at', 'desc')->get();

        return response()->streamDownload(function () use ($subscribers) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Email', 'Name', 'Status', 'Subscribed At']);
            foreach ($subscribers as $s) {
                fputcsv($handle, [$s->email, $s->name, $s->status, $s->subscribed_at?->format('Y-m-d H:i')]);
            }
            fclose($handle);
        }, 'newsletter-subscribers-' . now()->format('Y-m-d') . '.csv', ['Content-Type' => 'text/csv']);
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'Subscriber removed.');
    }
}
