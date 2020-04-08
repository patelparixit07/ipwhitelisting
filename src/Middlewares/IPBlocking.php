<?php

namespace WebToppings\IPWhitelisting\Middlewares;

use Closure;
use WebToppings\IPWhitelisting\Helpers\IPAddress;

class IPBlocking {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {        
        foreach ($request->getClientIps() as $ip) {
            if (!IPAddress::isWhitelisted($ip)) {
                abort(403);
            }
        }
        return $next($request);
    }

}
