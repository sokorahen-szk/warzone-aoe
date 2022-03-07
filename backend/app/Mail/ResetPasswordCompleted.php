<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Config;
use URL;

class ResetPasswordCompleted extends Mailable
{
    use Queueable, SerializesModels;

    private $email;

    private $config;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;

        $this->config = Config::get('notification');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('パスワードリセット完了のお知らせ')
            ->from($this->config->support_mail_address, $this->config->support_name)
            ->to($this->email)
            ->view('mails.password_completed')
            ->with([
                'supportName' => $this->config->support_name,
                'email' => $this->email,
            ]);
    }
}
