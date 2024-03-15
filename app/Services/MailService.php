<?php
    /**
     * Created by PhpStorm.
     * User: user
     * Date: 13/05/2019
     * Time: 16:20
     */

    namespace App\Services;

    use App\Mail\SendMAilClient;
    use App\Mail\SendMAilTest;
    use App\Repositories\FormGroupRepository;
    use App\Repositories\OccurrenceRepository;
    use Illuminate\Support\Facades\Mail;
    use Swift_Mailer;
    use Swift_SmtpTransport;
    use App\Repositories\ContractorRepository;

    class MailService
    {
        /**
         * @var FormGroupRepository
         */
        private $formGroupRepository;

        private $occurrenceRepository;

        private $contractorRepository;

        /**
         * MailService constructor.
         * @param FormGroupRepository $formGroupRepository
         */
        public function __construct(FormGroupRepository $formGroupRepository, OccurrenceRepository $occurrenceRepository, ContractorRepository $contractorRepository)
        {
            $this->formGroupRepository = $formGroupRepository;
            $this->occurrenceRepository = $occurrenceRepository;
            $this->contractorRepository = $contractorRepository;
        }

        /**
         * @param $occurrence
         * @return \Illuminate\Http\JsonResponse
         */
        public function envia_os_completa($occurrence)
        {
            $contractor = $this->contractorRepository->find($occurrence->contractor_id);
            if ($contractor->send_mail == 0) {
                return response()->json([
                    "retorno" => 2,
                    "mensagem" => "Empreiteira sem prermissão de envio de e-mail"
                ]);
            }

            $form_groups = $this->formGroupRepository->all();

            // Backup your default mailer
            $backup = Mail::getSwiftMailer();

            // Setup your gmail mailer

            if ((env('APP_CS_MAIL') == false) == true) { // é local

                $host = env('MAIL_HOST');
                $port = env('MAIL_PORT');
                $encryption = env('MAIL_ENCRYPTION');
                $username = env('MAIL_USERNAME');
                $password = env('MAIL_PASSWORD');
            } else {

                $host = optional($occurrence->contractor)->mail_host ? $occurrence->contractor->mail_host : env('MAIL_HOST');
                $port = optional($occurrence->contractor)->mail_port ? $occurrence->contractor->mail_port : env('MAIL_PORT');
                $encryption = optional($occurrence->contractor)->mail_encryption ? $occurrence->contractor->mail_encryption : env('MAIL_ENCRYPTION');
                $username = optional($occurrence->contractor)->mail_username ? $occurrence->contractor->mail_username : env('MAIL_USERNAME');
                $password = optional($occurrence->contractor)->mail_password ? $occurrence->contractor->mail_password : env('MAIL_PASSWORD');
            }


            $transport = new Swift_SmtpTransport($host, $port, $encryption);
            $transport->setUsername($username);
            $transport->setPassword($password);

            // Any other mailer configuration stuff needed...

            $new_mail = new Swift_Mailer($transport);

            // Set the mailer as new_mail
            Mail::setSwiftMailer($new_mail);

            // Send your message
            if (empty($occurrence->occurrence_client->email) && empty($occurrence->occurrence_data_client->cliente_email)) {

                $this->occurrenceRepository->update(['send_mail' => 2], $occurrence->id);

                return response()->json([
                    "retorno" => 2,
                    "mensagem" => "Não foi possível encontrar o email!\nE-mail não encontrado"
                ]);
            }


            if ($occurrence->contractor->send_email_bbc != null) {
                switch ($occurrence->contractor->send_email_bbc) {

                    case 1:
                        if (!empty($occurrence->occurrence_client->email)) {
                            $to = $occurrence->occurrence_client->email;
                        } else if (!empty($occurrence->occurrence_data_client->cliente_email)) {
                            $to = $occurrence->occurrence_data_client->cliente_email;
                        } else {
                            $to = '';
                        }

                        $bcc = '';
                        break;

                    case 2:
                        $to = ($occurrence->operator) ? $occurrence->operator->email : '';
                        $bcc = '';
                        break;

                    case 3:

                        if (!empty($occurrence->occurrence_client->email)) {
                            $to = $occurrence->occurrence_client->email;
                        } else if (!empty($occurrence->occurrence_data_client->cliente_email)) {
                            $to = $occurrence->occurrence_data_client->cliente_email;
                        } else {
                            $to = '';
                        }

                        $bcc = ($occurrence->operator) ? $occurrence->operator->email : '';
                        break;

                    default:
                        if (!empty($occurrence->occurrence_client->email)) {
                            $to = $occurrence->occurrence_client->email;
                        } else if (!empty($occurrence->occurrence_data_client->cliente_email)) {
                            $to = $occurrence->occurrence_data_client->cliente_email;
                        } else {
                            $to = '';
                        }
                        $bcc = '';
                }
            }

            if (!isset($to) || empty($to)) {
                $this->occurrenceRepository->update(['send_mail' => 2], $occurrence->id);

                return array(
                    "retorno" => 2,
                    "mensagem" => "Não foi possível encontrar o email para envio!\n"
                );
            } else {

                try {

                    if (isset($bcc) || !empty($bcc)) {
                        Mail::to($to)->bcc($bcc)->bcc($occurrence->contractor->mail_from_address)->send(new SendMAilClient($occurrence, $form_groups));
                    } else {
                        Mail::to($to)->bcc($occurrence->contractor->mail_from_address)->send(new SendMAilClient($occurrence, $form_groups));
                    }

                    // Restore your original mailer
                    Mail::setSwiftMailer($backup);

                    $this->occurrenceRepository->update(['send_mail' => 1], $occurrence->id);

                    if (is_file("OS_" . $occurrence->id . ".pdf")) {
                        unlink("OS_" . $occurrence->id . ".pdf");
                    }

                    return response()->json([
                        "retorno" => 1,
                        "mensagem" => "E-mail enviado com sucesso"
                    ]);


                } catch (\Exception $e) {

                    $this->occurrenceRepository->update(['send_mail' => 2], $occurrence->id);

                    if (is_file("OS_" . $occurrence->id . ".pdf")) {
                        unlink("OS_" . $occurrence->id . ".pdf");
                    }

                    return response()->json([
                        "retorno" => 2,
                        "mensagem" => "Não foi possível enviar o email",
                        "exception" => $e->getMessage(),
                        //                "line" => $e->getLine(),
                        //                "trace"=> $e->getTrace()
                    ]);
                }
            }
        }

        public function test_send_email($contractor, $to)
        {
            if (empty($to)) {
                return response()->json(array(
                    "retorno" => 2,
                    "mensagem" => "O campo e-mail está em branco.",
                ));
            }

            $backup = Mail::getSwiftMailer();

            if ((env('APP_CS_MAIL') == false) == true) { // é local

                $host = env('MAIL_HOST');
                $port = env('MAIL_PORT');
                $encryption = env('MAIL_ENCRYPTION');
                $username = env('MAIL_USERNAME');
                $password = env('MAIL_PASSWORD');
            } else {

                $host = $contractor->mail_host ? $contractor->mail_host : env('MAIL_HOST');
                $port = $contractor->mail_port ? $contractor->mail_port : env('MAIL_PORT');
                $encryption = $contractor->mail_encryption ? $contractor->mail_encryption : env('MAIL_ENCRYPTION');
                $username = $contractor->mail_username ? $contractor->mail_username : env('MAIL_USERNAME');
                $password = $contractor->mail_password ? $contractor->mail_password : env('MAIL_PASSWORD');
            }

            $transport = new Swift_SmtpTransport($host, $port, $encryption);
            $transport->setUsername($username);
            $transport->setPassword($password);
            // Any other mailer configuration stuff needed...

            $new_mail = new Swift_Mailer($transport);

            // Set the mailer as new_mail
            Mail::setSwiftMailer($new_mail);

            try {

                Mail::to($to)->send(new SendMAilTest($contractor));

                // Restore your original mailer
                Mail::setSwiftMailer($backup);

                return response()->json(array(
                    "retorno" => 1,
                    "mensagem" => "E-mail enviado com sucesso"
                ));


            } catch (\Exception $e) {

                return response()->json(array(
                    "retorno" => 2,
                    "mensagem" => "Não foi possível enviar o email! \nErro: " . $e->getMessage(),
                    "exception" => $e->getMessage(),
                    "line" => $e->getLine(),
                    "trace" => $e->getTrace()
                ));
            }

        }
    }
