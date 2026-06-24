@extends('layouts.app')

@section('title', 'Checkout — BharkaBeauty')

@section('content')

    <div class="checkout-layout container">

        <!-- Steps -->
        <div class="checkout-steps">
            <div class="checkout-step {{ $step >= 1 ? 'active' : '' }}">
                <span class="step-number">1</span>
                <span class="step-label">Address</span>
            </div>
            <div class="checkout-step-divider"></div>
            <div class="checkout-step {{ $step >= 2 ? 'active' : '' }}">
                <span class="step-number">2</span>
                <span class="step-label">Delivery</span>
            </div>
            <div class="checkout-step-divider"></div>
            <div class="checkout-step {{ $step >= 3 ? 'active' : '' }}">
                <span class="step-number">3</span>
                <span class="step-label">Payment</span>
            </div>
        </div>

        <div class="checkout-content">

            @if(($step ?? 1) == 1)
                <!-- Step 1: Address -->
                <div class="checkout-step-content">
                    <h2 class="checkout-step-title">Delivery Address</h2>
                    <form method="POST" action="{{ route('checkout.address') }}" class="checkout-form">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', Auth::user()->name ?? '') }}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="address">Street Address</label>
                            <input type="text" id="address" name="address" value="{{ old('address') }}" required class="form-control">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" value="{{ old('city') }}" required class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="postal_code">Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" class="form-control">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">Continue to Delivery</button>
                    </form>
                </div>

            @elseif(($step ?? 1) == 2)
                <!-- Step 2: Delivery Method -->
                <div class="checkout-step-content">
                    <h2 class="checkout-step-title">Choose Delivery Method</h2>
                    <form method="POST" action="{{ route('checkout.delivery') }}" class="checkout-form">
                        @csrf
                        <label class="delivery-option">
                            <input type="radio" name="delivery_method" value="standard" checked>
                            <div>
                                <strong>Standard Delivery</strong>
                                <p>3–5 business days · Free above PKR 2,000</p>
                            </div>
                        </label>
                        <label class="delivery-option">
                            <input type="radio" name="delivery_method" value="express">
                            <div>
                                <strong>Express Delivery</strong>
                                <p>1–2 business days · PKR 300</p>
                            </div>
                        </label>
                        <label class="delivery-option">
                            <input type="radio" name="delivery_method" value="same_day">
                            <div>
                                <strong>Same-Day Delivery</strong>
                                <p>Within Lahore only · PKR 500</p>
                            </div>
                        </label>
                        <button type="submit" class="btn btn-primary btn-lg">Continue to Payment</button>
                    </form>
                </div>

            @elseif(($step ?? 1) == 3)
                <!-- Step 3: Payment -->
                <div class="checkout-step-content">
                    <h2 class="checkout-step-title">Payment Method</h2>
                    <form method="POST" action="{{ route('checkout.place-order') }}" class="checkout-form">
                        @csrf
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="cod" checked>
                            <span>Cash on Delivery</span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="jazzcash">
                            <span>JazzCash</span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="easypaisa">
                            <span>EasyPaisa</span>
                        </label>
                        <label class="payment-option">
                            <input type="radio" name="payment_method" value="card">
                            <span>Credit / Debit Card</span>
                        </label>
                        <button type="submit" class="btn btn-primary btn-lg">Place Order</button>
                    </form>
                </div>
            @endif

        </div>

    </div>

@endsection
