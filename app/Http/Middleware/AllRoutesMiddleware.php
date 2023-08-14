<?php
namespace App\Http\Middleware;
use Closure;

class AllRoutesMiddleware
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
    if(env('APP_DEBUG') === true && env('APP_ENV') === 'local')
      sleep(env('APP_DEBUG_SIMULATE_LOCAL_DELAY', 0));

    return $next($request);
  }

}
