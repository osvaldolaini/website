<?php

namespace App\Mail;

use App\Model\Admin\Config;
use App\Model\Admin\Email;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class response extends Mailable
{
    use Queueable, SerializesModels;
    private $config;
    private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->config = Config::get()->first();
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $config = $this->config;
        $this->subject($this->email->subject);
        //foreach ($this->partners as $partner) {
            $this->to([$this->email->from],[$this->email->customer]);
            //$this->to('osvaldolaini@hotmail.com','osvaldolaini');
            //$this->bcc([$partner->email]);
            $this->view('admin.email.response',[
                'title_postfix' => $this->email->subject,
                'config'        => $config,
                'email'         => $this->email,
            ]);
        //}
    }
}
