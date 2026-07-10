<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255'],
            'name'  => ['nullable', 'string', 'max:100'],
        ]);

        $existing = NewsletterSubscriber::where('email', $request->email)->first();

        if ($existing) {
            if ($existing->status === 'unsubscribed') {
                $existing->resubscribe();
                $message = "Welcome back! You've been re-subscribed.";
            } else {
                $message = 'You are already subscribed. Thank you!';
            }
        } else {
            NewsletterSubscriber::create([
                'email' => $request->email,
                'name'  => $request->name,
            ]);
            $message = "Thank you for subscribing to AmsazBeauty!";
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('newsletter_success', $message);
    }

    public function unsubscribe(string $token)
    {
        $subscriber = NewsletterSubscriber::where('token', $token)->firstOrFail();

        if ($subscriber->status === 'active') {
            $subscriber->unsubscribe();
            $message = "You have been unsubscribed from AmsazBeauty newsletters.";
        } else {
            $message = "You are already unsubscribed.";
        }

        return view('newsletter.unsubscribed', compact('message'));
    }
}
