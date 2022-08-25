<?php

namespace App\Repositories;

use App\Models\Property;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class PropertyRepository implements PropertyRepositoryInterface
{
    private const VALIDITY = 5 * 60;

    /**
     * @param array $terms
     * @return mixed
     * @throws Exception
     */
    public function getPropertyByTerms(array $terms): Collection
    {
        $cleanedTerms = array_filter($terms, function ($term){
            return strcasecmp($term, '0') !== 0;
        });

        $cacheKey = implode('-', $terms);

        if ($cache = Cache::get($cacheKey)) {
            return $cache;
        }

        $query = Property::where('name', 'like', '%' . $terms['name'] . '%');
        if (isset($cleanedTerms['bedrooms'])) {
            $query->where('bedrooms', '=', $terms['bedrooms']);
        }

        if (isset($cleanedTerms['bathrooms'])) {
            $query->where('bathrooms', '=', $terms['bathrooms']);
        }

        if (isset($cleanedTerms['storeys'])) {
            $query->where('storeys', '=', $terms['storeys']);
        }

        if (isset($cleanedTerms['garages'])) {
            $query->where('garages', '=', $terms['garages']);
        }

        if (isset($cleanedTerms['priceMin'])) {
            $query->where('price', '>=', $terms['priceMin']);
        }

        if (isset($cleanedTerms['priceMax'])) {
            $query->where('price', '<=', $terms['priceMax']);
        }

        $data = $query->get();
        Cache::add($cacheKey, $data, self::VALIDITY);

        return $data;
    }
}
