<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $cartContent;
    public $shipping_fee;
    public $total_after_discount;

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('datbe8086@gmail.com', 'From Đạt'),
            replyTo: [
                new Address('datbe8086@gmail.com', 'To user'),
            ],
            subject: 'Đặt hàng từ shop giày K-Shoe',
        );
    }
//ádasdads
    public function __construct($order, $shipping_fee, $total_after_discount)
    {
        $this->order = $order;
        $this->cartContent = Cart::content();
        $this->shipping_fee = $shipping_fee;
        $this->total_after_discount = $total_after_discount;
    }

    public function build()
    {
        return $this->view('pages.mails.order')
                    ->subject('Chi tiết đơn hàng của bạn')
                    ->with([
                        'order' => $this->order,
                        'cartContent' => $this->cartContent,
                        'subtotal' => Cart::subtotal(),
                        'tax' => Cart::tax(),
                        'total' => Cart::total(),
                        'shipping_fee' => $this->shipping_fee,
                        'total_after_discount' => $this->total_after_discount,
                    ]);
    }
}
