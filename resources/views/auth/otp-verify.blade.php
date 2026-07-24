@extends('layouts.app')
@section('title', 'Enter Your Code — Amsaz Cosmetics')

@section('content')
<div style="min-height:70vh;display:flex;align-items:center;justify-content:center;padding:3rem 1rem;background:var(--color-bg-alt);">
<div style="width:100%;max-width:420px;">

    <div style="text-align:center;margin-bottom:2rem;">
        <div style="width:64px;height:64px;background:var(--color-accent-soft,#f5ede0);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
            <svg viewBox="0 0 24 24" fill="none" stroke="var(--color-accent)" stroke-width="1.8" style="width:30px;height:30px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 006 3.75v16.5a2.25 2.25 0 002.25 2.25h7.5A2.25 2.25 0 0018 20.25V3.75a2.25 2.25 0 00-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3.75h3M9.75 17.25h.008v.008H9.75v-.008z"/>
            </svg>
        </div>
        <h1 style="font-size:1.5rem;font-weight:800;margin-bottom:.5rem;">Check your code</h1>
        <p style="color:var(--color-text-muted);font-size:.9rem;line-height:1.6;">
            We sent a 6-digit code to:
        </p>

        {{-- Show both channels --}}
        <div style="display:flex;flex-direction:column;gap:.4rem;margin-top:.75rem;">
            @if($phone)
            <div style="display:inline-flex;align-items:center;gap:.5rem;background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:50px;padding:.4rem 1rem;font-size:.875rem;justify-content:center;">
                <span>📱</span>
                <strong>{{ preg_replace('/(\d{4})(\d+)(\d{3})/', '$1 **** $3', preg_replace('/\D/', '', $phone)) }}</strong>
            </div>
            @endif
            <div style="display:inline-flex;align-items:center;gap:.5rem;background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:50px;padding:.4rem 1rem;font-size:.875rem;justify-content:center;">
                <span>✉️</span>
                <strong>{{ $email }}</strong>
            </div>
        </div>
    </div>

    <div style="background:var(--color-surface);border:1.5px solid var(--color-border);border-radius:var(--radius-xl);padding:2.25rem;">

        @if($errors->any())
        <div style="background:#fee2e2;color:#991b1b;border-radius:8px;padding:.85rem 1rem;margin-bottom:1.25rem;font-size:.875rem;text-align:center;">
            {{ $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ route('otp.verify.submit') }}" id="otp-form">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <label class="form-label" style="text-align:center;display:block;margin-bottom:.9rem;">
                Enter 6-digit code
            </label>

            {{-- 6 individual boxes --}}
            <div style="display:flex;gap:.5rem;justify-content:center;margin-bottom:1.5rem;" id="otp-boxes">
                @for($i = 0; $i < 6; $i++)
                <input type="text" inputmode="numeric" maxlength="1"
                       class="otp-digit"
                       style="width:46px;height:54px;text-align:center;font-size:1.5rem;font-weight:800;border:1.5px solid var(--color-border);border-radius:10px;outline:none;transition:border-color .15s;background:var(--color-surface);"
                       autocomplete="off">
                @endfor
                <input type="hidden" name="token" id="otp-hidden">
            </div>

            <button type="submit" class="btn btn-primary btn-lg" style="width:100%;" id="otp-submit" disabled>
                Verify &amp; Sign In
            </button>
        </form>

        <div style="text-align:center;margin-top:1.5rem;display:flex;align-items:center;justify-content:center;gap:.75rem;">
            <span style="font-size:.875rem;color:var(--color-text-muted);">Didn't receive it?</span>
            <form method="POST" action="{{ route('otp.resend') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;cursor:pointer;color:var(--color-accent);font-weight:600;font-size:.875rem;padding:0;">
                    Resend code
                </button>
            </form>
        </div>
        <div style="text-align:center;margin-top:.6rem;">
            <a href="{{ route('customer.login') }}" style="font-size:.8rem;color:var(--color-text-muted);">
                ← Use different number / email
            </a>
        </div>
    </div>

</div>
</div>

@push('scripts')
<script>
(function () {
    var digits = document.querySelectorAll('.otp-digit');
    var hidden  = document.getElementById('otp-hidden');
    var submit  = document.getElementById('otp-submit');
    var form    = document.getElementById('otp-form');

    function update() {
        var val = Array.from(digits).map(function(d){ return d.value; }).join('');
        hidden.value = val;
        if (val.length === 6) {
            submit.disabled = false;
            digits.forEach(function(d){ d.style.borderColor = 'var(--color-accent)'; });
            // Auto-submit after short delay so user sees all 6 filled
            setTimeout(function(){ form.submit(); }, 300);
        } else {
            submit.disabled = true;
            digits.forEach(function(d){ d.style.borderColor = 'var(--color-border)'; });
        }
    }

    digits.forEach(function(box, idx) {
        box.addEventListener('focus', function(){ this.style.borderColor = 'var(--color-accent)'; });
        box.addEventListener('blur',  function(){ update(); });

        box.addEventListener('input', function() {
            // Allow only digits
            this.value = this.value.replace(/\D/g, '').slice(-1);
            if (this.value && idx < digits.length - 1) {
                digits[idx + 1].focus();
            }
            update();
        });

        box.addEventListener('keydown', function(e) {
            if (e.key === 'Backspace' && !this.value && idx > 0) {
                digits[idx - 1].focus();
                digits[idx - 1].value = '';
                update();
            }
        });

        // Handle paste (e.g. from SMS autofill)
        box.addEventListener('paste', function(e) {
            e.preventDefault();
            var pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/\D/g, '');
            pasted.split('').forEach(function(ch, i) {
                if (digits[i]) digits[i].value = ch;
            });
            var last = Math.min(pasted.length, digits.length) - 1;
            if (digits[last]) digits[last].focus();
            update();
        });
    });

    // Focus first box on load
    if (digits[0]) digits[0].focus();
})();
</script>
@endpush
@endsection
