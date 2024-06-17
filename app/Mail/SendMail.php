<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    private $viewName;
    private $destinatario;
    private $subjectSend;
    private $remetente;
    private $secao;
    private $corpo;
    private $anexo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($view, $destinatario, $subjectSend, $remetente, $secao, $corpo, $anexo = null)
    {
        $this->viewName = $view;
        $this->destinatario = $destinatario;
        $this->subjectSend = $subjectSend;
        $this->remetente = $remetente;
        $this->secao = $secao;
        $this->corpo = $corpo;
        $this->anexo = $anexo;
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
            $email = $this->view($this->viewName)
                ->from($from_email, $from_name)
                ->subject($this->subjectSend)
                ->with(
                    [
                        'destinatario' => $this->destinatario,
                        'remetente' => $this->remetente,
                        'secao' => $this->secao,
                        'corpo' => $this->corpo
                    ]
            );

            if ($this->anexo) {
                $email->attach(Storage::disk('public')->path($this->anexo));
            }

            return $email;
        } catch (\Exception $e) {
            // Aqui você pode decidir o que fazer com a exceção
            // Pode registrar no log, enviar uma notificação, etc.
            return $e->getMessage();
        }
    }
}
