<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 08/05/2019
 * Time: 13:13
 */

namespace App\Services\Api;


use App\Criteria\Api\ConfigurationCriteria;
use App\Repositories\ConfigurationRepository;

class ConfigurationService
{
    /**
     * @var ConfigurationRepository
     */
    private $configurationRepository;

    /**
     * ConfigurationService constructor.
     * @param ConfigurationRepository $configurationRepository
     */
    public function __construct(ConfigurationRepository $configurationRepository)
    {
        $this->configurationRepository = $configurationRepository;
    }

    public function getAll()
    {
        $this->configurationRepository->pushCriteria(new ConfigurationCriteria());

        return $this->configurationRepository->all();

    }
}
