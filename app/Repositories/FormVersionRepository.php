<?php

namespace App\Repositories;

use App\Models\FormVersion;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Interface TypeServiceRepository.
 *
 * @package namespace App\Repositories;
 */
class FormVersionRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'uuid',
        'form_id',
        'version',
        'json',
    ];
    /**
     * Configure the Model
     **/
    public function model()
    {
        return FormVersion::class;
    }
}
