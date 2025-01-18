<?php

namespace App\Http\Controllers;

use App\Exceptions\DBOperationException;
use App\Exceptions\EntityNotFoundException;
use App\Exceptions\FailedConstraintException;
use App\Facade\ResponseFacade;
use App\Http\Requests\AddNewElectionStageRequest;
use App\Http\Requests\ElectionCreateRequest;
use App\Services\ElectionService;
use App\Services\ElectionStageService;
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

    public function create(ElectionCreateRequest $request):  JsonResponse
    {
        try {
            $requestData = $request->validateToDto();
            $newElection = $this->electionService->create($requestData);
        } catch (DBOperationException | EntityNotFoundException | FailedConstraintException $e) {
            return ResponseFacade::errorResponse(exception: $e);
        } catch (Exception $e) {
            return ResponseFacade::unhandledExceptionResponse(exception: $e);
        }

        return response()->json($newElection);
    }

    public function findAllStages(int $electionId, ElectionStageService $electionStageService): JsonResponse
    {
        try {
            $electionStages = $electionStageService->findAllByElectionId($electionId);
        }
        catch (EntityNotFoundException | DBOperationException | FailedConstraintException $e) {
            return ResponseFacade::errorResponse(exception: $e);
        }
        catch (Exception $e) {
            return ResponseFacade::unhandledExceptionResponse(exception: $e);
        }

        return response()->json($electionStages);
    }

    public function addStage(
        AddNewElectionStageRequest $request,
        int $electionId,
        ElectionStageService $electionStageService
    ): JsonResponse
    {
        try {
            $stage = $electionStageService->addStageToElection(
                electionId: $electionId,
                newElectionStageDTO: $request->validateToDto()
            );
        }
        catch (DBOperationException | EntityNotFoundException | FailedConstraintException $e) {
            return ResponseFacade::errorResponse(exception: $e);
        }
        catch (Exception $e) {
            return ResponseFacade::unhandledExceptionResponse(exception: $e);
        }

        return response()->json($stage);
    }

    public function publish(int $electionId): JsonResponse
    {
        try {
            $election = $this->electionService->publishByElectionId(electionId: $electionId);
        } catch (DBOperationException | EntityNotFoundException | FailedConstraintException $e) {
            return ResponseFacade::errorResponse(exception: $e);
        }
        catch (Exception $e) {
            return ResponseFacade::unhandledExceptionResponse(exception: $e);
        }

        return response()->json($election);
    }
}
