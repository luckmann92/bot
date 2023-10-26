<?php
/**
 * @author Lukmanov Mikhail <lukmanof92@gmail.com>
 */
namespace App\Http\Middlewar\Telegram;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Log extends Middleware
{
    public function handle($request, Closure $next, ...$guards)
    {
        \Illuminate\Support\Facades\Log::info('telegram', $request->toArray());

        return $next($request);
    }
}
