<?php

namespace App\Http\Controllers;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Facade\ResponseFacade;
use App\Services\ElectionTypeService;
use Exception;
use Illuminate\Http\JsonResponse;

class ElectionTypeController extends Controller
{
    public function __construct(
        private readonly ElectionTypeService $electionTypeService
    )
    {
    }

    public function findAll(): JsonResponse
    {
        try {
            $electionTypes = $this->electionTypeService->findAll();
        }
        catch (EntityNotFoundException $e) {
            return ResponseFacade::errorResponse(exception: $e);
        }
        catch (Exception $e) {
            return ResponseFacade::unhandledExceptionResponse(exception: $e);
        }

        return response()->json($electionTypes);
    }

    public function findOneById(int $electionTypeId): JsonResponse
    {
        try {
            $electionType = $this->electionTypeService->findOneById($electionTypeId);
        }
        catch (EntityNotFoundException | DBOperationException $e) {
            return ResponseFacade::errorResponse(exception: $e);
        }
        catch (Exception $e) {
            return ResponseFacade::unhandledExceptionResponse(exception: $e);
        }

        return response()->json($electionType);
    }
}
