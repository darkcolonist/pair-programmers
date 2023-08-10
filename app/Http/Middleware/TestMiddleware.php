<?php
namespace App\Http\Middleware;
use Closure;

class TestMiddleWare
{
    /**
     * Run the request filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (env('APP_ENV') != 'local') {
            return redirect('/you/are/not/permitted/to/test');
        }

        return $next($request);
    }

}
