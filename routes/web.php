<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\MyNotesController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CarePlanController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\InsuranceController;
use App\Http\Controllers\ScreeningController;
use App\Http\Controllers\TimeTrackController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientDataController;
use App\Http\Controllers\CarePlanGoalController;
use App\Http\Controllers\CarePlanTestController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\MonthlyReviewController;
use App\Http\Controllers\CarePlanSchemeController;
use App\Http\Controllers\CarePlanContactController;
use App\Http\Controllers\CarePlanQuestionController;
use App\Http\Controllers\ChronicConditionController;
use App\Http\Controllers\CarePlanScreeningController;
use App\Http\Controllers\CarePlanTimeTrackController;
use App\Http\Controllers\MonthlyReviewSchemeController;
use App\Http\Controllers\PlannedInterventionController;
use App\Http\Controllers\PracticeApplicationController;
use App\Http\Controllers\MonthlyReviewQuestionController;
use App\Http\Controllers\CoordinatorApplicationController;
use App\Http\Controllers\MonthlyReviewTimeTrackController;
use App\Http\Controllers\CarePlanPlannedInterventionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('optimize', function (){
    Artisan::call('optimize:clear');
    return back();
})->name('optimize');




Route::get('/', function () {
    return redirect()->route('login');
});



Auth::routes(['register' => false]);
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/patients/ccm', [HomeController::class, 'ccmPatients'])->name('patients.ccm');
Route::get('/patients/rpm', [HomeController::class, 'rpmPatients'])->name('patients.rpm');
Route::get('/patients/unenrolled', [HomeController::class, 'unenrolledPatients'])->name('patients.unenrolled');



Route::get('/activity-log', [HomeController::class, 'getActivityLog'])->name('getActivityLog');


Route::resource('role', RoleController::class);
Route::resource('permission', PermissionController::class);

Route::post('notification/mark/all', [NotificationController::class, 'mark_all_as_read'])->name('notification.mark.all');
Route::post('notification/mark', [NotificationController::class, 'mark_as_read'])->name('notification.mark');
Route::post('notification/delete', [NotificationController::class, 'destroy'])->name('notification.delete');
Route::get('notification/unread', [NotificationController::class, 'unread'])->name('notification.unread');
Route::get('notification', [NotificationController::class, 'index'])->name('notification.index');


Route::get('care-team', [UserController::class, 'care_team'])->name('care-team.index');
Route::post('care-team/store', [UserController::class, 'care_team_store'])->name('care-team.store');
Route::get('care-team/edit/{id}', [UserController::class, 'care_team_edit'])->name('care-team.edit');
Route::patch('care-team/update/{id}', [UserController::class, 'care_team_update'])->name('care-team.update');
Route::patch('user/profile/update/{user:slug}', [UserController::class, 'profile_update'])->name('user.profile.update');
Route::get('user/profile/edit/{user:slug}', [UserController::class, 'profile_edit'])->name('user.profile.edit');
Route::get('change-password', [UserController::class, 'change_password_index'])->name('user.password.index');
Route::post('change-password', [UserController::class, 'change_password_store'])->name('user.password.store');
Route::resource('user', UserController::class, ['parameters' => [
    'user' => 'user:slug'
]]);

Route::resource('insurance', InsuranceController::class, ['parameters' => [
    'insurance' => 'insurance:slug'
]]);
Route::resource('medication', MedicationController::class);
Route::post('medication/carry-forward', [MedicationController::class, 'carry_forward'])->name('medication.carry_forward');

Route::resource('note', NoteController::class);
Route::post('selected_practice', [PracticeController::class, 'selected_practice'])->name('selected_practice');
Route::resource('practice', PracticeController::class, ['parameters' => [
    'practice' => 'practice:slug'
]]);


Route::post('billing/ccm/filter', [BillingController::class, 'ccm_billing_filter'])->name('billing.ccm.filter');
Route::get('ccm-billing', [BillingController::class, 'ccm_billing_index'])->name('billing.ccm.index');

Route::post('billing/rpm/filter', [BillingController::class, 'rpm_billing_filter'])->name('billing.rpm.filter');
Route::get('rpm-billing', [BillingController::class, 'rpm_billing_index'])->name('billing.rpm.index');
//Application Routes starts here


Route::post('device/release/{device}', [DeviceController::class, 'release'])->name('device.release');
Route::post('device-data/filter', [DeviceController::class, 'device_data_filter'])->name('device-data.filter');
Route::get('/device/search', [DeviceController::class, 'search_device'])->name('device.search');

Route::resource('device', DeviceController::class, ['parameters' => [
    'device' => 'device:device_serial_no'
]]);
Route::post('patient-data/filter', [PatientDataController::class, 'patient_data_filter'])->name('patient-data.filter');
Route::resource('patient-data', PatientDataController::class);

Route::post('patient/last-checked', [PatientController::class, 'last_checked'])->name('patient.last_checked');
Route::post('patient/enrol/{patient:slug}', [PatientController::class, 'enrol'])->name('patient.enrol');
Route::post('patient/unenrolled/{patient:slug}', [PatientController::class, 'unenrolled'])->name('patient.unenrolled');
Route::get('patient/{patient:slug}/type/{type?}', [PatientController::class, 'show'])->name('patient.show');

Route::post('/patient/get-data', [PatientController::class, 'getData'])->name('patient.getData');
Route::get('/patient/reload', [PatientController::class, 'reload'])->name('patient.reload');
Route::post('/patient-device-update', [PatientController::class, 'update_patient_device'])->name('patient.update_device');


Route::resource('patient', PatientController::class, ['parameters' => [
    'patient' => 'patient:slug'
]])->except('show');

// Route::prefix('application')->group(function(){
//     Route::get('/', [ApplicationController::class, 'index'])->name('application.index');
//     Route::resource('practice-application', PracticeApplicationController::class);
//     Route::resource('coordinator-application', CoordinatorApplicationController::class);
// });


Route::post('selected_chronic_condition', [PlannedInterventionController::class, 'selected_chronic_condition'])->name('selected_chronic_condition');
Route::post('selected_symptom', [PlannedInterventionController::class, 'selected_symptom'])->name('selected_symptom');
Route::post('selected_planned_intervention', [PlannedInterventionController::class, 'selected_planned_intervention'])->name('selected_planned_intervention');
Route::post('selected_person_responsible', [PlannedInterventionController::class, 'selected_person_responsible'])->name('selected_person_responsible');

Route::resource('planned-intervention', PlannedInterventionController::class);
Route::resource('chronic-condition', ChronicConditionController::class, ['parameters' => [
    'chronic-condition' => 'chronic_condition:slug'
]]);

Route::post('conversation/destroy', [MessageController::class, 'conversation_destroy'])->name('conversation.destroy');
Route::post('conversation/index', [MessageController::class, 'conversation_index'])->name('conversation.index');
Route::get('un-read-message', [MessageController::class, 'un_read_message'])->name('un_read_message');
Route::post('message/webhook', [MessageController::class, 'message_webhook'])->name('message.webhook');
Route::resource('message', MessageController::class, ['parameters' => [
    'message' => 'message:sid'
]]);

Route::post('filter_appointment', [AppointmentController::class, 'filter_appointment'])->name('filter_appointment');
Route::resource('appointment', AppointmentController::class, ['parameters' => [
    'appointment' => 'appointment:slug'
]]);


Route::get('care-plan/filter/{filter}', [CarePlanController::class, 'filter'])->name('care-plan.filter');
Route::get('non_application_screening', [CarePlanController::class, 'non_application_screening'])->name('non_application_screening');
Route::get('non_application_test', [CarePlanController::class, 'non_application_test'])->name('non_application_test');

Route::resource('screening', ScreeningController::class, ['parameters' => [
    'screening' => 'screening:slug',
]]);
Route::resource('test', TestController::class, ['parameters' => [
    'test' => 'test:slug',
]]);
Route::resource('my-notes', MyNotesController::class, ['parameters' => [
    'my_notes' => 'my_notes:slug',
]]);


Route::resource('care-plan/contact', CarePlanContactController::class, [
    'as' => 'care-plan',
])->except('index','create','show');

Route::resource('care-plan/planned-intervention', CarePlanPlannedInterventionController::class, [
    'as' => 'care-plan',
])->except('index','create','show');

Route::resource('care-plan/goal', CarePlanGoalController::class, [
    'as' => 'care-plan',
])->except('index','create','show');

Route::resource('care-plan/test', CarePlanTestController::class, [
    'as' => 'care-plan',
])->except('create','show');

Route::resource('care-plan/screening', CarePlanScreeningController::class, [
    'as' => 'care-plan',
])->except('create','show');


Route::post('care-plan/set', [CarePlanController::class, 'set'])->name('care-plan.set');
Route::post('care-plan/approval', [CarePlanController::class, 'send_for_approval'])->name('care-plan.approval');
Route::post('care-plan/approve', [CarePlanController::class, 'approve'])->name('care-plan.approve');
Route::post('care-plan/answer/store', [CarePlanController::class, 'answer'])->name('care-plan.answer.store');
Route::post('care-plan/special-screening/store', [CarePlanController::class, 'special_screening_store'])->name('care-plan.special-screening.store');
Route::get('care-plan/{care_plan:reference_no}/public', [CarePlanController::class, 'care_plan_public'])->name('care-plan.public');
Route::get('care-plan/{patient:slug}/history', [CarePlanController::class, 'history'])->name('care-plan.history');
Route::get('patient/{patient:slug}/care-plan/create', [CarePlanController::class, 'create'])->name('care-plan.create');

Route::post('care-plan/restore/{id}', [CarePlanController::class, 'restore'])->name('care-plan.restore');


Route::resource('care-plan-scheme', CarePlanSchemeController::class, ['parameters' => [
    'care-plan-scheme' => 'care-plan-scheme:slug',
]]);

Route::resource('care-plan/question', CarePlanQuestionController::class, [
    'as' => 'care-plan',
]);

Route::resource('care-plan/time-track', CarePlanTimeTrackController::class, [
    'as' => 'care-plan'
])->except('index');
Route::get('care-plan/{care_plan:reference_no}/logs', [CarePlanTimeTrackController::class, 'index'])->name('care-plan.time-track.index');

Route::resource('care-plan', CarePlanController::class, ['parameters' => [
    'care-plan' => 'care-plan:reference_no',
]])->except('create');




Route::get('monthly-review/filter/{filter}', [MonthlyReviewController::class, 'filter'])->name('monthly-review.filter');
Route::post('monthly-review/answer/store', [MonthlyReviewController::class, 'answer'])->name('monthly-review.answer.store');
Route::get('monthly-review/{patient:slug}/history', [MonthlyReviewController::class, 'history'])->name('monthly-review.history');
Route::get('patient/{patient:slug}/monthly-review/create', [MonthlyReviewController::class, 'create'])->name('monthly-review.create');

Route::resource('monthly-review-scheme', MonthlyReviewSchemeController::class, ['parameters' => [
    'monthly-review-scheme' => 'monthly-review-scheme:slug',
]]);

Route::resource('monthly-review/question', MonthlyReviewQuestionController::class, [
    'as' => 'monthly-review',
]);

Route::resource('monthly-review/time-track', MonthlyReviewTimeTrackController::class, [
    'as' => 'monthly-review'
])->except('index');
Route::get('monthly-review/{monthly_review:reference_no}/logs', [MonthlyReviewTimeTrackController::class, 'index'])->name('monthly-review.time-track.index');

Route::resource('monthly-review', MonthlyReviewController::class, ['parameters' => [
    'monthly-review' => 'monthly-review:reference_no',
]])->except('create');





Route::resource('time-track', TimeTrackController::class, ['parameters' => [
    'time-track' => 'time-track:slug',
]])->except('create');
//Application Routes ends here


Route::post('forwardtelemetry', [DeviceController::class, 'device_data'])->name('device.data')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::post('forwardstatus', [DeviceController::class, 'device_status'])->name('device.status')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

Route::get('setting', [SettingController::class, 'index'])->name('setting.index');
Route::post('setting/general', [SettingController::class, 'setting_general'])->name('setting.general');
Route::post('setting/rpm', [SettingController::class, 'setting_rpm'])->name('setting.rpm');
Route::post('setting/twilio', [SettingController::class, 'setting_twilio'])->name('setting.twilio');
Route::post('setting/smtp', [SettingController::class, 'setting_smtp'])->name('setting.smtp');
Route::post('setting/test', [SettingController::class, 'test'])->name('setting.test');


Route::get('report/{care_manager_id?}/{date?}/{form?}/{to?}', [HomeController::class, 'report'])->name('report.index');


Route::post('custom-sort', [HomeController::class, 'custom_sort'])->name('custom.sort');
Route::post('reset-ccm-sort', [HomeController::class, 'reset_ccm_sort'])->name('reset.ccm.sort');
Route::post('reset-rpm-sort', [HomeController::class, 'reset_rpm_sort'])->name('reset.rpm.sort');


Route::get('/patients/rpm',       [HomeController::class, 'rpmPatients'])->name('rpm.patients.data');
Route::get('/patients/rpm/stats', [HomeController::class, 'rpmStats'])->name('rpm.patients.stats');

