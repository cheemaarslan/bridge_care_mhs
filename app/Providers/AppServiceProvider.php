<?php

namespace App\Providers;

use App\Models\CarePlan;
use App\Models\TimeTrack;
use App\Models\PatientData;
use App\Models\MonthlyReview;
use App\Observers\CarePlanObserver;
use App\Observers\TimeTrackObserver;
use App\Observers\PatientDataObserver;
use Illuminate\Support\ServiceProvider;
use App\Observers\MonthlyReviewObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use App\Observers\RPMPatientDataObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        PatientData::observe(PatientDataObserver::class);
        TimeTrack::observe(TimeTrackObserver::class);
        PatientData::observe(RPMPatientDataObserver::class);
        CarePlan::observe(CarePlanObserver::class);
        MonthlyReview::observe(MonthlyReviewObserver::class);

        Schema::defaultStringLength(191);
        //  URL::forceScheme('https');  


    }
}
