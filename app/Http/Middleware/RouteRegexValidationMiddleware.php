<?php

namespace App\Http\Middleware;

use App\Builders\ValidationErrorResponseBuilder;
use App\Facade\ResponseFacade;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RouteRegexValidationMiddleware
{
    public function handle(Request $request, Closure $next, string $parameterName, string $pattern): Response
    {
        $parameter = $request->route($parameterName);
        $pattern = "#" . $pattern . "#";

        if (!preg_match($pattern, $parameter)) {
            return ResponseFacade::routeParameterValidationErrorResponse(
                parameterName: $parameterName,
                message: "The given parameter is in wrong format."
            );
        }

        return $next($request);
    }
}
