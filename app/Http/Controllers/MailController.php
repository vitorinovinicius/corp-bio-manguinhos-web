<?php

namespace App\Http\Controllers;

use App\Models\Occurrence;
use App\Models\Contractor;
use App\Services\MailService;

class MailController extends Controller
{
    /**
     * @var MailService
     */
    private $mailService;

    /**
     * MailController constructor.
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function envia_os_completa(Occurrence $occurrence)
    {
        return $this->mailService->envia_os_completa($occurrence);
    }

    public function test_send_email(Contractor $contractor)
    {
        $to = \Request::get('to');
        return $this->mailService->test_send_email($contractor, trim($to));
    }
}
