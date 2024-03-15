<?php

namespace App\Mail;

use App\Repositories\FormGroupRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class SendMAilTest extends Mailable
{
    use Queueable, SerializesModels;

    private $contractor;
    

    /**
     * Create a new message instance.
     *
     * @param $occurrence
     * @param $form_groups
     */
    public function __construct($contractor)
    {
        //
        $this->contractor = $contractor;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->contractor->mail_from_address) {
            $from_email = $this->contractor->mail_from_address;
            $from_name = $this->contractor->name;
        }else{
            $from_email = env('MAIL_FROM_ADDRESS');
            $from_name = env('MAIL_FROM_NAME');
        }
        
        return $this
            ->from($from_email,$from_name)
            ->replyTo($from_email,$from_name)
            ->subject("Teste de envio de e-mail")
            ->view('mail.mail_teste')
            ->with([
                "contractor" => $this->contractor,
            ])
            
        ;
    }
}
