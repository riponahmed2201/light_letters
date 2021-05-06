<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ClientRegConfirm extends Mailable
{
    use Queueable, SerializesModels;
    public $client;
    public $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client, $password)
    {
        $this->client = $client;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $client = $this->client;
        $password = $this->password;
        return $this->view('clientRegEmail', compact('client','password'))->subject('Welcome to Light-Letters Client App');
    }
}
