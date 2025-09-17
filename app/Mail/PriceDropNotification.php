<?php

namespace App\Mail;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceDropNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    public $oldPrice;
    public $newPrice;

    /**
     * Create a new message instance.
     */
    public function __construct(Product $product, float $oldPrice, float $newPrice)
    {
        $this->product = $product;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Price Drop Alert: ' . $this->product->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.price-drop',
            with: [
                'product' => $this->product,
                'oldPrice' => $this->oldPrice,
                'newPrice' => $this->newPrice,
                'savings' => $this->oldPrice - $this->newPrice,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
