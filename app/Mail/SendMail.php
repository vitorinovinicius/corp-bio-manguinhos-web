<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    private $viewName;
    private $destinatario;
    private $subjectSend;
    private $remetente;
    private $secao;
    private $corpo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($view, $destinatario, $subjectSend, $remetente, $secao, $corpo)
    {
        $this->viewName = $view;
        $this->destinatario = $destinatario;
        $this->subjectSend = $subjectSend;
        $this->remetente = $remetente;
        $this->secao = $secao;
        $this->corpo = $corpo;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $from_email = env('MAIL_FROM_ADDRESS', $this->remetente->email);
        $from_name  = env('MAIL_FROM_NAME', $this->remetente->name);

        try {
            return $this->view($this->viewName)
                ->from($from_email, $from_name)
                ->subject($this->subjectSend)
                ->with([
                    'destinatario' => $this->destinatario,
                    'remetente' => $this->remetente,
                    'secao' => $this->secao,
                    'corpo' => $this->corpo
                ]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }
}
