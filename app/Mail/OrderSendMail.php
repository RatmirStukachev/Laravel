<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct( protected Order $order)
    {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Новый заказ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order',
            with: [
                'order' => $this->order,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
