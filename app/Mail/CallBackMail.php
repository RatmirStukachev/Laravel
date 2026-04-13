<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CallBackMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($request)
    {
        $this->data = $request->validated();
    }

    public function build()
    {
        $mail = $this->view('emails.callback')
            ->subject('Форма обратной связи')
            ->with('data', $this->data);

        return $mail;
    }
}
