<?php

namespace App\Http\Middleware;

use App\Models\CarePlan;
use App\Models\Patient;
use Closure;
use Illuminate\Http\Request;

class CanSendForApproval
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
        $care_plan = CarePlan::findOrFail($request->care_plan_id);
        $patient = Patient::findOrFail($care_plan->patient_id);
        $minutes = 20;
        if($patient->ccm_type == "Complex"){
            $minutes = 60;
        }
        if($care_plan->minutes < $minutes) {
            abort(403, 'Please complete your '.$minutes.' minutes before sending it for approval');
        }
        return $next($request);
    }
}
