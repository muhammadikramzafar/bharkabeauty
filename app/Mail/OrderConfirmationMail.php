<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public bool  $isAdmin = false
    ) {}

    public function envelope(): Envelope
    {
        $subject = $this->isAdmin
            ? 'New Order #' . $this->order->order_number . ' — BharkaBeauty'
            : 'Order Confirmed! #' . $this->order->order_number . ' — BharkaBeauty';

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        $view = $this->isAdmin ? 'emails.order-admin' : 'emails.order-customer';
        return new Content(view: $view);
    }
}
