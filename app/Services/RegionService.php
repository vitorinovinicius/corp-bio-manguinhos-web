<?php
/**
 * Created by PhpStorm.
 * User: CELTAPHP
 * Date: 21/12/2016
 * Time: 13:15
 */

namespace App\Services;


use App\Repositories\RegionRepository;

class RegionService
{
    private $regionRepository;

    public function __construct(RegionRepository $regionRepository)
    {
        $this->regionRepository = $regionRepository;
    }

    public function listRegions(){
        return $this->regionRepository
            ->orderBy('name', 'asc')
            ->paginate();
    }

}