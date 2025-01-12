<?php

namespace App\Http\Controllers;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Facade\ResponseFacade;
use App\Services\ElectionService;
use Exception;
use Illuminate\Http\JsonResponse;

class ElectionController extends Controller
{
    public function __construct(
        private readonly ElectionService $electionService
    )
    {
    }

    public function findAll(): JsonResponse
    {
        try {
            $elections = $this->electionService->findAll();
        }
        catch (EntityNotFoundException | DBOperationException $e) {
            return ResponseFacade::errorResponse(exception: $e);
        }
        catch (Exception $e) {
            return ResponseFacade::unhandledExceptionResponse(exception: $e);
        }

        return response()->json($elections);
    }
}
