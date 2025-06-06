<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Closure;

class TrimStrings
{
    /**
     * The attributes that should not be trimmed.
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $this->trim($request);

        return $next($request);
    }

    /**
     * Trim the attributes of the request.
     */
    protected function trim(Request $request): void
    {
        $request->merge($this->cleanArray($request->all()));
    }

    /**
     * Clean the data in the given array.
     */
    protected function cleanArray(array $data): array
    {
        return collect($data)->map(function ($value, $key) {
            return $this->cleanValue($key, $value);
        })->all();
    }

    /**
     * Clean the given value.
     */
    protected function cleanValue(string $key, mixed $value): mixed
    {
        if (is_array($value)) {
            return $this->cleanArray($value);
        }

        return in_array($key, $this->except, true) || !is_string($value)
            ? $value
            : trim($value);
    }
}
