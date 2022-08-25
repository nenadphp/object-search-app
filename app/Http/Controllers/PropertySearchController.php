<?php

namespace App\Http\Controllers;

use App\Exceptions\PropertySearchControllerException;
use App\Http\Requests\PropertySearchRequest;
use App\Repositories\Interfaces\PropertyRepositoryInterface;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class PropertySearchController extends Controller
{
    /**
     * @param PropertySearchRequest $searchRequest
     * @param PropertyRepositoryInterface $propertyRepository
     * @return Application|ResponseFactory|Response
     * @throws PropertySearchControllerException
     */
    public function search(PropertySearchRequest $searchRequest, PropertyRepositoryInterface $propertyRepository)
    {
        try {
            $data = $propertyRepository->getPropertyByTerms($searchRequest->validated());

            return response($data, 200);
        } catch (Exception $exception) {
            logger(
                $message = sprintf('Error with getting property by terms, error: %s', $exception->getMessage())
            );

            throw new PropertySearchControllerException($message);
        }

    }
}
