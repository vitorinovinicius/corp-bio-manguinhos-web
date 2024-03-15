<?php

namespace App\Mail;

use App\Repositories\FormGroupRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class SendMAilClient extends Mailable
{
    use Queueable, SerializesModels;
    private $occurrence;
    /**
     * @var FormGroupRepository
     */
    private $form_groups;

    /**
     * Create a new message instance.
     *
     * @param $occurrence
     * @param $form_groups
     */
    public function __construct($occurrence, $form_groups)
    {
        //
        $this->occurrence = $occurrence;
        $this->form_groups = $form_groups;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->occurrence->contractor->mail_from_address) {
            $from_email = $this->occurrence->contractor->mail_from_address;
            $from_name = $this->occurrence->contractor->name;
        }else{
            $from_email = env('MAIL_FROM_ADDRESS');
            $from_name = env('MAIL_FROM_NAME');
        }
        $occurrence = $this->occurrence;
        $form_groups = $this->form_groups;
        $image = '';
        $formId = '';

        $pdfs = $occurrence->pdfs->where('type', '=', 1)->first();
        if($pdfs){

            $url =  $pdfs->url;
            $filename = "OS_" . $this->occurrence->id.".pdf";
            copy($url, $filename);

            glob($filename);

            return $this
                ->from($from_email,$from_name)
                ->replyTo($from_email,$from_name)
                ->subject("OS " . $occurrence->id)
                ->view('mail.mail_occurrence')
                ->with([
                    "occurrence" => $this->occurrence,
                ])
                ->attach(public_path() . "/" . $filename, [
                    "as" => $filename,
                    'mime' => 'application/pdf',
                ]);


        }else{
            $pdf = PDF::loadView("pdfs.pdf_os", compact('occurrence','form_groups','image', 'formId'));
            return $this
                ->from($from_email,$from_name)
                ->replyTo($from_email,$from_name)
                ->subject("OS " . $occurrence->id)
                ->view('mail.mail_occurrence')
                ->with([
                    "occurrence" => $this->occurrence,
                ])
                ->attachData($pdf->output(), "OS_" . $this->occurrence->id.".pdf", [
                    'mime' => 'application/pdf',
                ])
                ;
        }
    }
}
