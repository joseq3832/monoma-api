<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiResponseMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $response = $next($request);

        if ($response->getContent() && $this->hasErrors($response)) {
            $errorMessage = $response->getOriginalContent()['errors'];

            return $this->handleErrorResponse($response, $errorMessage);
        }

        $data = $response->getOriginalContent();
        $statusCode = $response->status();

        $formattedResponse = $this->formatResponse($statusCode, $data);

        return response()->json($formattedResponse, $statusCode);
    }

    /**
     * Check if the response has errors.
     *
     * @param  \Illuminate\Http\Response  $response
     */
    private function hasErrors($response): bool
    {
        $content = json_decode($response->getContent(), true);

        return is_array($content) && array_key_exists('errors', $content);
    }

    /**
     * Handle an error response.
     *
     * @param  \Illuminate\Http\Response  $response
     * @param  string  $errorMessage
     */
    private function handleErrorResponse($response, $errorMessage): JsonResponse
    {
        $statusCode = $response->status();

        $data = [
            'meta' => [
                'success' => false,
                'errors' => [
                    $errorMessage,
                ],
            ],
        ];

        return response()->json($data, $statusCode);
    }

    /**
     * Format the response data.
     *
     * @param  int  $statusCode
     * @param  mixed  $data
     */
    private function formatResponse($statusCode, $data): array
    {
        return [
            'meta' => [
                'success' => $statusCode >= 200 && $statusCode < 300,
                'errors' => [],
            ],
            'data' => $data,
        ];
    }
}
