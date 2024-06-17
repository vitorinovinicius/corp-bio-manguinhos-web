<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailTest extends Mailable
{
    use Queueable, SerializesModels;

    private $viewName;
    private $data;
    private $subjectSend;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($view, $data, $subjectSend)
    {
        $this->viewName = $view;
        $this->data = $data;
        $this->subjectSend = $subjectSend;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from_email = env('MAIL_FROM_ADDRESS');
        $from_name = env('MAIL_FROM_NAME');

        try{
            $this->view($this->viewName, ['data'=>$this->data])
                ->from($from_email, $from_name)
                ->subject($this->subjectSend);
        }catch(\Exception $e){
            return $e->getMessage();
        }
        
    }
}
