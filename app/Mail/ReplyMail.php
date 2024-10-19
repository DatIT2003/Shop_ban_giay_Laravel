<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;


class ReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reply;
    public $contact;

    /**
     * Create a new message instance.
     *
     * @return void
     */

     public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('datbe8086@gmail.com', 'From Đạt'),
            replyTo: [
                new Address('datbe8086@gmail.com', 'To user'),
            ],
            subject: 'Gửi phản hồi từ shop giày K-Shoe',
        );
    }
    public function __construct($reply, $contact)
    {
        $this->reply = $reply;
        $this->contact = $contact;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Reply to your contact message')
                    ->view('pages.mails.reply')
                    ->with([
                        'reply' => $this->reply,
                        'contact' => $this->contact,
                    ]);
    }
}

