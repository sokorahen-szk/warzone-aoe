<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Config;
use URL;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public $config;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $email)
    {
        $this->token = $token;
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
        $url = sprintf(
            '%s/%s/%s',
            env('APP_URL'),
            $this->config->password_reset_uri,
            $this->token
        );

        return $this->subject('パスワードリセットのお知らせ')
            ->from($this->config->support_mail_address, $this->config->support_name)
            ->to($this->email)
            ->view('mails.password_reset_mail')
            ->with([
                'url' => $url,
            ]);
    }
}
