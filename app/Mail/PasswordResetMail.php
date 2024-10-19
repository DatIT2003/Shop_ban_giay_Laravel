<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;


class PasswordResetMail extends Mailable {
    use Queueable, SerializesModels;

    public $password;

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('datbe8086@gmail.com', 'From Đạt'),
            replyTo: [
                new Address('datbe8086@gmail.com', 'To user'),
            ],
            subject: 'Yêu cầu cấp lại mật khẩu của bạn ở shop giày K-Shoe',
        );
    }

    public function __construct($password) {
        $this->password = $password;
    }

    public function build() {
        return $this->view('pages.mails.password_reset')
                    ->with(['token' => $this->password]);
    }
}

