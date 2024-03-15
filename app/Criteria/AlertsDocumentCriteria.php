<?php

namespace App\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class AlertsDocumentCriteria.
 *
 * @package namespace App\Criteria;
 */
class AlertsDocumentCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param string              $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        // Retorna os alertas gerados a partir dos documentos proximos do vencimento
//        $model = $model->whereNotNull('document_id');
        return $model;
    }
}
