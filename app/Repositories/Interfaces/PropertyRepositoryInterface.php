<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface PropertyRepositoryInterface
{
    /**
     * @param array $terms
     * @return mixed
     */
    public function getPropertyByTerms(array $terms): Collection;
}
