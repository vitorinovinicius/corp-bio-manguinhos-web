<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\occurrence_imagesRepository;
use App\Models\OccurrenceImage;
use App\Validators\OccurrenceImagesValidator;

/**
 * Class OccurrenceImageRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class OccurrenceImageRepositoryEloquent extends BaseRepository implements OccurrenceImageRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return OccurrenceImage::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
