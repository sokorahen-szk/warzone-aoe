<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

use Config;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $token;
    private $email;
    private $expireHours;

    private $config;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token, $email, $expireHours)
    {
        $this->token = $token;
        $this->email = $email;
        $this->expireHours = $expireHours;

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
                'supportName' => $this->config->support_name,
                'email' => $this->email,
                'url' => $url,
                'expireHours' => $this->expireHours,
            ]);
    }
}
