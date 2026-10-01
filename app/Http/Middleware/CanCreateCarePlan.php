<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CanCreateCarePlan
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $patient = $request->route()->parameter('patient');
        if(!$patient->allow_care_plan){
            abort(403, 'You not have permission to create a new care plan at this moment, please contact your admin. Thank you!');
        }

        return $next($request);    
    }
}
