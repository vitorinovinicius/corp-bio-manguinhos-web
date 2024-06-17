<?php

namespace App\Services;

use App\Repositories\ImagemRepository;
use App\Repositories\SecaoImagemRepository;
use App\Repositories\EmailRepository;

class EmailService
{
    /**
     * @var EmailRepository
     */
    private $emailRepository;

    /**
     * @var SecaoImagemRepository
     */
    private $secaoImagemRepository;

    /**
     * EmailService constructor.
     * @param EmailRepository $emailRepository
     */
    public function __construct(
        EmailRepository $emailRepository
    ){
        $this->emailRepository = $emailRepository;
    }

    public function store($request)
    {
        $data = $request->all();
    }
}