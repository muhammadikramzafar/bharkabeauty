<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\OtpToken;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    // ── Show login form ────────────────────────────────────────
    public function showLogin()
    {
        if (Auth::check()) return redirect()->route('customer.dashboard');
        return view('auth.otp-login');
    }

    // ── Show register form ─────────────────────────────────────
    public function showRegister()
    {
        if (Auth::check()) return redirect()->route('customer.dashboard');
        return view('auth.otp-register');
    }

    // ── Register: name + mobile + email → OTP to both ─────────
    public function register(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:100',
            'phone'  => ['required', 'string', 'max:20', 'regex:/^(\+92|0)[0-9]{9,10}$/'],
            'email'  => 'required|email|max:255',
        ], [
            'phone.regex' => 'Enter a valid Pakistani mobile number (e.g. 0300-1234567).',
        ]);

        $email = strtolower(trim($request->email));
        $phone = preg_replace('/\s+/', '', $request->phone);

        if (User::where('email', $email)->exists()) {
            return back()->withErrors(['email' => 'This email is already registered. Please log in.'])->withInput();
        }
        if (User::where('phone', $phone)->exists()) {
            return back()->withErrors(['phone' => 'This mobile number is already registered. Please log in.'])->withInput();
        }

        User::create([
            'name'     => $request->name,
            'email'    => $email,
            'phone'    => $phone,
            'password' => bcrypt(str()->random(32)),
        ]);

        return $this->dispatchOtp($email, $phone);
    }

    // ── Login: email OR mobile → find user → OTP to both ──────
    public function sendOtp(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string|max:255',
        ]);

        $identifier = trim($request->identifier);

        // Detect if mobile or email
        $user = filter_var($identifier, FILTER_VALIDATE_EMAIL)
            ? User::where('email', strtolower($identifier))->first()
            : User::where('phone', $identifier)->first();

        if (!$user) {
            return back()->withErrors(['identifier' => 'No account found with that email or mobile number.'])->withInput();
        }

        return $this->dispatchOtp($user->email, $user->phone);
    }

    // ── Show OTP verify form ───────────────────────────────────
    public function showVerify(Request $request)
    {
        if (!$request->session()->has('otp_email')) {
            return redirect()->route('customer.login');
        }
        return view('auth.otp-verify', [
            'email' => $request->session()->get('otp_email'),
            'phone' => $request->session()->get('otp_phone'),
        ]);
    }

    // ── Verify OTP and log in ──────────────────────────────────
    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|digits:6',
        ]);

        $email = strtolower($request->email);

        $otp = OtpToken::where('email', $email)
            ->where('token', $request->token)
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp) {
            return back()->withErrors(['token' => 'Invalid or expired code. Please try again.']);
        }

        $otp->update(['used_at' => now()]);

        $user = User::where('email', $email)->firstOrFail();
        Auth::login($user, true);

        $request->session()->forget(['otp_email', 'otp_phone']);
        $request->session()->regenerate();

        return redirect()->intended(route('customer.dashboard'));
    }

    // ── Resend OTP ─────────────────────────────────────────────
    public function resend(Request $request)
    {
        $email = $request->session()->get('otp_email');
        $phone = $request->session()->get('otp_phone');

        if (!$email) return redirect()->route('customer.login');

        return $this->dispatchOtp($email, $phone);
    }

    // ── Generate OTP → save → send to email + SMS → redirect ──
    private function dispatchOtp(string $email, ?string $phone)
    {
        $token = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        OtpToken::create([
            'email'      => $email,
            'token'      => $token,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send to email
        try {
            Mail::to($email)->send(new OtpMail($token));
        } catch (\Throwable $e) {
            logger()->error("OTP email failed ({$email}): " . $e->getMessage());
        }

        // Send to mobile via SMS
        if ($phone) {
            SmsService::send($phone, "Your Amsaz Cosmetics verification code is: {$token}. Valid for 10 minutes. Do not share.");
        }

        session(['otp_email' => $email, 'otp_phone' => $phone]);

        return redirect()->route('otp.verify');
    }
}
