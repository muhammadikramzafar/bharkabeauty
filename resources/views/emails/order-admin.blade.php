<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>New Order — Amsaz Cosmetics Admin</title>
<style>
  body { margin:0; padding:0; background:#f5f0eb; font-family:'Helvetica Neue',Arial,sans-serif; color:#2d2016; }
  .wrap { max-width:600px; margin:32px auto; background:#fff; border-radius:12px; overflow:hidden; box-shadow:0 2px 12px rgba(0,0,0,.08); }
  .header { background:#c8a882; padding:24px 40px; }
  .header h1 { margin:0; color:#fff; font-size:20px; font-weight:700; }
  .header p { margin:4px 0 0; color:rgba(255,255,255,.8); font-size:13px; }
  .body { padding:32px 40px; }
  .alert { background:#fef3c7; border-left:4px solid #d97706; padding:14px 18px; border-radius:0 8px 8px 0; margin-bottom:24px; font-size:14px; font-weight:600; color:#92400e; }
  .info-box { background:#f9f5f0; border-radius:8px; padding:20px 24px; margin-bottom:24px; }
  .info-row { display:flex; justify-content:space-between; font-size:14px; margin-bottom:8px; }
  .info-row:last-child { margin-bottom:0; }
  .info-label { color:#6b5a48; }
  .info-value { font-weight:600; }
  .section-title { font-size:12px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#a8907a; margin:0 0 12px; }
  .items-table { width:100%; border-collapse:collapse; margin-bottom:20px; }
  .items-table th { text-align:left; font-size:11px; font-weight:700; text-transform:uppercase; color:#a8907a; padding:0 0 8px; border-bottom:1px solid #ede8e0; }
  .items-table th:last-child { text-align:right; }
  .items-table td { padding:10px 0; border-bottom:1px solid #f0ece6; font-size:13px; }
  .items-table td:last-child { text-align:right; font-weight:600; }
  .totals { border-top:2px solid #ede8e0; padding-top:14px; }
  .total-row { display:flex; justify-content:space-between; font-size:14px; margin-bottom:6px; color:#6b5a48; }
  .total-row.grand { font-size:16px; font-weight:700; color:#2d2016; border-top:1px solid #ede8e0; padding-top:8px; margin-top:4px; }
  .cta { text-align:center; margin:24px 0 8px; }
  .cta a { background:#2d2016; color:#fff; text-decoration:none; padding:13px 32px; border-radius:50px; font-weight:700; font-size:13px; display:inline-block; }
  .footer { background:#f9f5f0; padding:20px 40px; text-align:center; font-size:12px; color:#a8907a; border-top:1px solid #ede8e0; }
</style>
</head>
<body>
<div class="wrap">

  <div class="header">
    <h1>🛍 New Order Received</h1>
    <p>Amsaz Cosmetics Admin Notification</p>
  </div>

  <div class="body">

    <div class="alert">Order #{{ $order->order_number }} needs your attention — status: {{ strtoupper($order->status) }}</div>

    <!-- Order Details -->
    <p class="section-title">Order Details</p>
    <div class="info-box">
      <div class="info-row">
        <span class="info-label">Order #</span>
        <span class="info-value">{{ $order->order_number }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Placed At</span>
        <span class="info-value">{{ $order->created_at->format('d M Y, h:i A') }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Payment</span>
        <span class="info-value">{{ match($order->payment_method) {
          'cod'       => 'Cash on Delivery',
          'jazzcash'  => 'JazzCash',
          'easypaisa' => 'EasyPaisa',
          default     => ucfirst($order->payment_method),
        } }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Payment Status</span>
        <span class="info-value">{{ ucfirst($order->payment_status) }}</span>
      </div>
    </div>

    <!-- Customer -->
    <p class="section-title">Customer</p>
    <div class="info-box">
      @php $addr = $order->shipping_address ?? []; @endphp
      <div class="info-row">
        <span class="info-label">Name</span>
        <span class="info-value">{{ $addr['first_name'] ?? $order->user?->name ?? 'Guest' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Phone</span>
        <span class="info-value">{{ $addr['phone'] ?? '—' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Delivery Email</span>
        <span class="info-value">{{ $addr['email'] ?? $order->user?->email ?? '—' }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Address</span>
        <span class="info-value">{{ $addr['address'] ?? '' }}, {{ $addr['city'] ?? '' }}</span>
      </div>
    </div>

    <!-- Items -->
    <p class="section-title">Items ({{ $order->items->count() }})</p>
    <table class="items-table">
      <thead>
        <tr><th>Product</th><th>Qty</th><th>Total</th></tr>
      </thead>
      <tbody>
        @foreach($order->items as $item)
        <tr>
          <td>{{ $item->product_name }}</td>
          <td style="color:#6b5a48;">×{{ $item->qty }}</td>
          <td>PKR {{ number_format($item->total) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>

    <div class="totals">
      <div class="total-row"><span>Subtotal</span><span>PKR {{ number_format($order->subtotal) }}</span></div>
      <div class="total-row"><span>Delivery</span><span>{{ $order->shipping == 0 ? 'Free' : 'PKR '.number_format($order->shipping) }}</span></div>
      <div class="total-row grand"><span>TOTAL</span><span>PKR {{ number_format($order->total) }}</span></div>
    </div>

    <div class="cta">
      <a href="{{ url('/admin/orders') }}">View in Admin Panel</a>
    </div>

  </div>

  <div class="footer">Amsaz Cosmetics Admin · {{ date('Y') }}</div>

</div>
</body>
</html>
