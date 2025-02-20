<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Wiki;

use App\Enums\Http\Api\Paging\PaginationStrategy;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Wiki\Series\SeriesDestroyRequest;
use App\Http\Requests\Api\Wiki\Series\SeriesForceDeleteRequest;
use App\Http\Requests\Api\Wiki\Series\SeriesIndexRequest;
use App\Http\Requests\Api\Wiki\Series\SeriesRestoreRequest;
use App\Http\Requests\Api\Wiki\Series\SeriesShowRequest;
use App\Http\Requests\Api\Wiki\Series\SeriesStoreRequest;
use App\Http\Requests\Api\Wiki\Series\SeriesUpdateRequest;
use App\Models\Wiki\Series;
use Illuminate\Http\JsonResponse;
use Spatie\RouteDiscovery\Attributes\Route;

/**
 * Class SeriesController.
 */
class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  SeriesIndexRequest  $request
     * @return JsonResponse
     */
    #[Route(fullUri: 'series', name: 'series.index')]
    public function index(SeriesIndexRequest $request): JsonResponse
    {
        $query = $request->getQuery();

        if ($query->hasSearchCriteria()) {
            return $query->search(PaginationStrategy::OFFSET())->toResponse($request);
        }

        return $query->index()->toResponse($request);
    }

    /**
     * Store a newly created resource.
     *
     * @param  SeriesStoreRequest  $request
     * @return JsonResponse
     */
    #[Route(fullUri: 'series', name: 'series.store', middleware: 'auth:sanctum')]
    public function store(SeriesStoreRequest $request): JsonResponse
    {
        $resource = $request->getQuery()->store();

        return $resource->toResponse($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  SeriesShowRequest  $request
     * @param  Series  $series
     * @return JsonResponse
     */
    #[Route(fullUri: 'series/{series}', name: 'series.show')]
    public function show(SeriesShowRequest $request, Series $series): JsonResponse
    {
        $resource = $request->getQuery()->show($series);

        return $resource->toResponse($request);
    }

    /**
     * Update the specified resource.
     *
     * @param  SeriesUpdateRequest  $request
     * @param  Series  $series
     * @return JsonResponse
     */
    #[Route(fullUri: 'series/{series}', name: 'series.update', middleware: 'auth:sanctum')]
    public function update(SeriesUpdateRequest $request, Series $series): JsonResponse
    {
        $resource = $request->getQuery()->update($series);

        return $resource->toResponse($request);
    }

    /**
     * Remove the specified resource.
     *
     * @param  SeriesDestroyRequest  $request
     * @param  Series  $series
     * @return JsonResponse
     */
    #[Route(fullUri: 'series/{series}', name: 'series.destroy', middleware: 'auth:sanctum')]
    public function destroy(SeriesDestroyRequest $request, Series $series): JsonResponse
    {
        $resource = $request->getQuery()->destroy($series);

        return $resource->toResponse($request);
    }

    /**
     * Restore the specified resource.
     *
     * @param  SeriesRestoreRequest  $request
     * @param  Series  $series
     * @return JsonResponse
     */
    #[Route(method: 'patch', fullUri: 'restore/series/{series}', name: 'series.restore', middleware: 'auth:sanctum')]
    public function restore(SeriesRestoreRequest $request, Series $series): JsonResponse
    {
        $resource = $request->getQuery()->restore($series);

        return $resource->toResponse($request);
    }

    /**
     * Hard-delete the specified resource.
     *
     * @param  SeriesForceDeleteRequest  $request
     * @param  Series  $series
     * @return JsonResponse
     */
    #[Route(method: 'delete', fullUri: 'forceDelete/series/{series}', name: 'series.forceDelete', middleware: 'auth:sanctum')]
    public function forceDelete(SeriesForceDeleteRequest $request, Series $series): JsonResponse
    {
        return $request->getQuery()->forceDelete($series);
    }
}
