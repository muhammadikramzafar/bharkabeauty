<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Order Confirmed — BharkaBeauty</title>
<style>
  body { margin:0; padding:0; background:#f5f0eb; font-family:'Helvetica Neue',Arial,sans-serif; color:#2d2016; }
  .wrap { max-width:600px; margin:32px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
  .header { background:#2d2016; padding:32px 40px; text-align:center; }
  .header h1 { margin:0; color:#c8a882; font-size:26px; letter-spacing:2px; text-transform:uppercase; }
  .header p { margin:6px 0 0; color:#a8907a; font-size:13px; letter-spacing:1px; }
  .body { padding:36px 40px; }
  .greeting { font-size:18px; font-weight:600; margin-bottom:8px; }
  .subtext { color:#6b5a48; font-size:14px; line-height:1.6; margin-bottom:28px; }
  .info-box { background:#f9f5f0; border-radius:8px; padding:20px 24px; margin-bottom:24px; }
  .info-row { display:flex; justify-content:space-between; font-size:14px; margin-bottom:8px; }
  .info-row:last-child { margin-bottom:0; }
  .info-label { color:#6b5a48; }
  .info-value { font-weight:600; color:#2d2016; }
  .section-title { font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#6b5a48; margin:0 0 14px; }
  .items-table { width:100%; border-collapse:collapse; margin-bottom:24px; }
  .items-table th { text-align:left; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; color:#a8907a; padding:0 0 10px; border-bottom:1px solid #ede8e0; }
  .items-table th:last-child { text-align:right; }
  .items-table td { padding:12px 0; border-bottom:1px solid #f0ece6; font-size:14px; vertical-align:top; }
  .items-table td:last-child { text-align:right; font-weight:600; }
  .item-name { font-weight:600; color:#2d2016; }
  .item-brand { font-size:12px; color:#a8907a; margin-top:2px; }
  .totals { border-top:2px solid #ede8e0; padding-top:16px; }
  .total-row { display:flex; justify-content:space-between; font-size:14px; margin-bottom:8px; color:#6b5a48; }
  .total-row.grand { font-size:16px; font-weight:700; color:#2d2016; margin-top:8px; padding-top:8px; border-top:1px solid #ede8e0; }
  .address-box { background:#f9f5f0; border-radius:8px; padding:20px 24px; margin-bottom:24px; font-size:14px; line-height:1.7; }
  .address-box .section-title { margin-bottom:8px; }
  .cta { text-align:center; margin:28px 0; }
  .cta a { background:#c8a882; color:#fff; text-decoration:none; padding:14px 36px; border-radius:50px; font-weight:700; font-size:14px; letter-spacing:.05em; display:inline-block; }
  .footer { background:#f9f5f0; padding:24px 40px; text-align:center; font-size:12px; color:#a8907a; line-height:1.7; border-top:1px solid #ede8e0; }
  .footer a { color:#c8a882; text-decoration:none; }
  .badge { display:inline-block; background:#d1fae5; color:#065f46; padding:3px 12px; border-radius:50px; font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.05em; }
  @media(max-width:600px) {
    .body { padding:24px 20px; }
    .header { padding:24px 20px; }
    .footer { padding:20px; }
  }
</style>
</head>
<body>
<div class="wrap">

  <div class="header">
    <h1>BharkaBeauty</h1>
    <p>Your order is confirmed ✓</p>
  </div>

  <div class="body">
    <p class="greeting">Hi {{ $order->shipping_address['first_name'] ?? $order->user?->name ?? 'Valued Customer' }},</p>
    <p class="subtext">
      Thank you for shopping with BharkaBeauty! We've received your order and it's being prepared.
      You'll receive another update when it's on its way.
    </p>

    <!-- Order Info -->
    <div class="info-box">
      <div class="info-row">
        <span class="info-label">Order Number</span>
        <span class="info-value">#{{ $order->order_number }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Order Date</span>
        <span class="info-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Status</span>
        <span class="info-value"><span class="badge">{{ ucfirst($order->status) }}</span></span>
      </div>
      <div class="info-row">
        <span class="info-label">Payment Method</span>
        <span class="info-value">{{ match($order->payment_method) {
          'cod'       => 'Cash on Delivery',
          'jazzcash'  => 'JazzCash',
          'easypaisa' => 'EasyPaisa',
          default     => ucfirst($order->payment_method),
        } }}</span>
      </div>
    </div>

    <!-- Items -->
    <p class="section-title">Items Ordered</p>
    <table class="items-table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Qty</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td>
            <div class="item-name">{{ $item->product_name }}</div>
          </td>
          <td style="color:#6b5a48;">×{{ $item->qty }}</td>
          <td>PKR {{ number_format($item->total) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <!-- Totals -->
    <div class="totals">
      <div class="total-row">
        <span>Subtotal</span>
        <span>PKR {{ number_format($order->subtotal) }}</span>
      </div>
      <div class="total-row">
        <span>Delivery</span>
        <span>{{ $order->shipping == 0 ? 'Free' : 'PKR '.number_format($order->shipping) }}</span>
      </div>
      @if($order->discount > 0)
      <div class="total-row" style="color:#059669;">
        <span>Discount</span>
        <span>− PKR {{ number_format($order->discount) }}</span>
      </div>
      @endif
      <div class="total-row grand">
        <span>Total</span>
        <span>PKR {{ number_format($order->total) }}</span>
      </div>
    </div>

    <!-- Delivery Address -->
    @if($order->shipping_address)
    @php $addr = $order->shipping_address; @endphp
    <div class="address-box" style="margin-top:24px;">
      <p class="section-title">Delivery Address</p>
      <strong>{{ $addr['first_name'] ?? '' }}</strong><br>
      {{ $addr['address'] ?? '' }}<br>
      {{ $addr['city'] ?? '' }}@if(!empty($addr['postal_code'])), {{ $addr['postal_code'] }}@endif<br>
      {{ $addr['phone'] ?? '' }}<br>
      {{ $addr['email'] ?? '' }}
    </div>
    @endif

    <div class="cta">
      <a href="{{ url('/') }}">Continue Shopping</a>
    </div>
  </div>

  <div class="footer">
    <p>Questions? Email us at <a href="mailto:support@bharkabeauty.com">support@bharkabeauty.com</a></p>
    <p style="margin-top:8px;">© {{ date('Y') }} BharkaBeauty. All rights reserved.</p>
  </div>

</div>
</body>
</html>
