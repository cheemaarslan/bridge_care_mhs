<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CanCreateMonthlyReview
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
        $patient = $patient->load('care_plan');
        if($patient->care_plan){
            $month = Carbon::parse($patient->care_plan->completed_at)->month;
            $year = Carbon::parse($patient->care_plan->completed_at)->year;

            //            if(Carbon::now()->month == $month && Carbon::now()->year == $year){
            //                abort(403, 'You can not create monthly review at this point. It may be due to care plan was created in the same month. For further information, contact your admin');
            //            }
            if($patient->care_plan->status != "Approved"){
                abort(403, 'Care Plan must be approved to create monthly review. For further information, contact your admin');
            }
            if($patient->monthly_review){
                $month = Carbon::parse($patient->monthly_review->completed_at)->month;
                $year = Carbon::parse($patient->monthly_review->completed_at)->year;
                // if(Carbon::now()->month == $month && Carbon::now()->year == $year){
                //     abort(403, 'You can not create monthly review at this point. Monthly Review already exists for this month. For further information, contact your admin');
                // }
            }
        }
        else{
            abort(403, 'You must create care plan first. For further information, contact your admin');
        }

        return $next($request);
    }
}
