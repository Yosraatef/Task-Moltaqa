<?php

namespace App\Http\Middleware;

use App\Support\Actions\Response;
use Illuminate\Routing\Middleware\ThrottleRequests as
BaseThrottleRequests;
use Closure;
class ThrottleRequests extends BaseThrottleRequests
{
    use Response;
    private int $code = 400;
    private string $message = '';
    private array $body = [];
    public function handle($request, Closure $next, $maxAttempts = 60, $decayMinutes = 1, $prefix = '')
    {
        $key = $prefix.$this->resolveRequestSignature($request);

        $maxAttempts = $this->resolveMaxAttempts($request, $maxAttempts);

        if ($this->limiter->tooManyAttempts($key, $maxAttempts)) {
            $retryAfter = $this->getTimeUntilNextRetry($key);
            //here you can change response according to requirements

            $this->message = 'Too Many Attempts. Please try after '.$retryAfter .' seconds';
            return self::apiResponse($this->code,$this->message, info:
                'ThrottleRequestsMiddleware ');
        }

        $this->limiter->hit($key, $decayMinutes * 60);

        $response = $next($request);

        return $this->addHeaders(
            $response, $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts)
        );
    }
}
