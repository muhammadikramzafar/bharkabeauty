<?php

namespace App\Services;

class SmsService
{
    public static function send(string $mobile, string $message): bool
    {
        // ── Swap this block for your SMS gateway (Twilio, Zong, Telenor Business, etc.) ──
        // Example Twilio:
        // $twilio = new \Twilio\Rest\Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
        // $twilio->messages->create($mobile, ['from' => env('TWILIO_FROM'), 'body' => $message]);

        // For now: log the SMS so you can see the OTP during development
        logger()->info("[SMS] To: {$mobile} | {$message}");

        return true;
    }
}
