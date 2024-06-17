<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailStart extends Mailable
{
    use Queueable, SerializesModels;

    private $viewName;
    private $data;
    private $subjectSend;
    private $formulario;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($view, $data, $subjectSend, $formulario)
    {
        $this->viewName = $view;
        $this->data = $data;
        $this->subjectSend = $subjectSend;
        $this->formulario = $formulario;
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
            $this->view($this->viewName)
                ->from($from_email, $from_name)
                ->subject($this->subjectSend)
                ->with([
                    'data'=>$this->data,
                    'formulario'=> $this->formulario
                ]);
        }catch(\Exception $e){
            return $e->getMessage();
        }
        
    }
}
