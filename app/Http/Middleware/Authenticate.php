<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate {
    /**
     * The authentication guard factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory  $auth
     * @return void
     */
    public function __construct(Auth $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null) {
        if ($this->auth->guard($guard)->guest()) {
            return response(json_encode(array('error' => 'Unauthorized.')), 401);
        }
        $response = response('', 200);
        /* add Allowed Domain */
        $origin = env('ORIGIN');
        $allowedDomains = explode(',', $origin);
        $origin = $request->server('HTTP_ORIGIN');
        if (in_array($origin, $allowedDomains)) {
            //Intercepts OPTIONS requests

            if ($request->isMethod('OPTIONS')) {
                $response = response('', 200);
            } else {
                // Pass the request to the next middleware
                $response = $next($request);
            }
            // Adds headers to the response
        } else {
            return response(json_encode(array('error' => 'Unauthorized.')), 401);
        }
        $response->header('Access-Control-Allow-Origin', '*');
        $response->header('Access-Control-Allow-Methods', 'OPTIONS, GET, POST, PUT, PATCH, DELETE');
        $response->header('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
        return $response;
        /* add Allowed Domain */

        /* otherwise simply return $next($request);
         * 
         */
    }

}
