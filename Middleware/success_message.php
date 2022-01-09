<?php

namespace App\Http\Middleware;

use Closure;
use Google\Service\Calendar\Event;
use Illuminate\Http\Request;

class success_message
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
  if ($request->filled(['name','meeting-date','meeting-time']))
        {
            return  $next($request);
        }else
            return abort(404);

    }
}
