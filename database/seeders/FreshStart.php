<?php

namespace Database\Seeders;

use App\Models\CareManager;
use App\Models\CarePlanQuestion;
use App\Models\CarePlanScheme;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Insurance;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\ChronicCondition;
use App\Models\Doctor;
use App\Models\MonthlyReviewQuestion;
use App\Models\MonthlyReviewScheme;
use Spatie\Permission\Models\Role;
use App\Models\PlannedIntervention;
use App\Models\Practice;
use App\Models\Screening;
use App\Models\Setting;
use App\Models\Test;
use App\Models\TreatmentGoal;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class FreshStart extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'create_role',
            ],
            [
                'name' => 'read_role',
            ],
            [
                'name' => 'update_role',
            ],
            [
                'name' => 'delete_role',
            ],
            [
                'name' => 'crud_role',
            ],
            [
                'name' => 'create_permission',
            ],
            [
                'name' => 'read_permission',
            ],
            [
                'name' => 'update_permission',
            ],
            [
                'name' => 'delete_permission',
            ],
            [
                'name' => 'crud_permission',
            ],
            [
                'name' => 'create_user',
            ],
            [
                'name' => 'read_user',
            ],
            [
                'name' => 'update_user',
            ],
            [
                'name' => 'delete_user',
            ],
            [
                'name' => 'crud_user',
            ],
            [
                'name' => 'create_super_admin',
            ],
            [
                'name' => 'read_super_admin',
            ],
            [
                'name' => 'update_super_admin',
            ],
            [
                'name' => 'delete_super_admin',
            ],
            [
                'name' => 'crud_super_admin',
            ],
            [
                'name' => 'create_admin',
            ],
            [
                'name' => 'read_admin',
            ],
            [
                'name' => 'update_admin',
            ],
            [
                'name' => 'delete_admin',
            ],
            [
                'name' => 'crud_admin',
            ],
            [
                'name' => 'create_care_team',
            ],
            [
                'name' => 'read_care_team',
            ],
            [
                'name' => 'update_care_team',
            ],
            [
                'name' => 'delete_care_team',
            ],
            [
                'name' => 'crud_care_team',
            ],
            [
                'name' => 'create_patient',
            ],
            [
                'name' => 'read_patient',
            ],
            [
                'name' => 'update_patient',
            ],
            [
                'name' => 'delete_patient',
            ],
            [
                'name' => 'crud_patient',
            ],
            [
                'name' => 'enrol_patient',
            ],
            [
                'name' => 'unenrolled_patient',
            ],
            [
                'name' => 'view_all_patient',
            ],
            [
                'name' => 'view_practice_patient',
            ],
            [
                'name' => 'create_care_plan',
            ],
            [
                'name' => 'read_care_plan',
            ],
            [
                'name' => 'update_care_plan',
            ],
            [
                'name' => 'delete_care_plan',
            ],
            [
                'name' => 'crud_care_plan',
            ],
            [
                'name' => 'approve_care_plan',
            ],
            [
                'name' => 'create_care_plan_scheme',
            ],
            [
                'name' => 'read_care_plan_scheme',
            ],
            [
                'name' => 'update_care_plan_scheme',
            ],
            [
                'name' => 'delete_care_plan_scheme',
            ],
            [
                'name' => 'crud_care_plan_scheme',
            ],
            [
                'name' => 'create_care_plan_question',
            ],
            [
                'name' => 'read_care_plan_question',
            ],
            [
                'name' => 'update_care_plan_question',
            ],
            [
                'name' => 'delete_care_plan_question',
            ],
            [
                'name' => 'crud_care_plan_question',
            ],
            [
                'name' => 'create_monthly_review',
            ],
            [
                'name' => 'read_monthly_review',
            ],
            [
                'name' => 'update_monthly_review',
            ],
            [
                'name' => 'delete_monthly_review',
            ],
            [
                'name' => 'crud_monthly_review',
            ],
            [
                'name' => 'create_monthly_review_scheme',
            ],
            [
                'name' => 'read_monthly_review_scheme',
            ],
            [
                'name' => 'update_monthly_review_scheme',
            ],
            [
                'name' => 'delete_monthly_review_scheme',
            ],
            [
                'name' => 'crud_monthly_review_scheme',
            ],
            [
                'name' => 'create_monthly_review_question',
            ],
            [
                'name' => 'read_monthly_review_question',
            ],
            [
                'name' => 'update_monthly_review_question',
            ],
            [
                'name' => 'delete_monthly_review_question',
            ],
            [
                'name' => 'crud_monthly_review_question',
            ],
            [
                'name' => 'create_patient_data',
            ],
            [
                'name' => 'read_patient_data',
            ],
            [
                'name' => 'update_patient_data',
            ],
            [
                'name' => 'delete_patient_data',
            ],
            [
                'name' => 'crud_patient_data',
            ],
            [
                'name' => 'create_time_track',
            ],
            [
                'name' => 'read_time_track',
            ],
            [
                'name' => 'update_time_track',
            ],
            [
                'name' => 'delete_time_track',
            ],
            [
                'name' => 'crud_time_track',
            ],
            [
                'name' => 'create_message',
            ],
            [
                'name' => 'read_message',
            ],
            [
                'name' => 'update_message',
            ],
            [
                'name' => 'delete_message',
            ],
            [
                'name' => 'crud_message',
            ],
            [
                'name' => 'create_medication',
            ],
            [
                'name' => 'read_medication',
            ],
            [
                'name' => 'update_medication',
            ],
            [
                'name' => 'delete_medication',
            ],
            [
                'name' => 'crud_medication',
            ],
            [
                'name' => 'create_note',
            ],
            [
                'name' => 'read_note',
            ],
            [
                'name' => 'update_note',
            ],
            [
                'name' => 'delete_note',
            ],
            [
                'name' => 'crud_note',
            ],
            [
                'name' => 'create_insurance',
            ],
            [
                'name' => 'read_insurance',
            ],
            [
                'name' => 'update_insurance',
            ],
            [
                'name' => 'delete_insurance',
            ],
            [
                'name' => 'crud_insurance',
            ],
            [
                'name' => 'create_device',
            ],
            [
                'name' => 'read_device',
            ],
            [
                'name' => 'update_device',
            ],
            [
                'name' => 'delete_device',
            ],
            [
                'name' => 'crud_device',
            ],
            [
                'name' => 'create_chronic_condition',
            ],
            [
                'name' => 'read_chronic_condition',
            ],
            [
                'name' => 'update_chronic_condition',
            ],
            [
                'name' => 'delete_chronic_condition',
            ],
            [
                'name' => 'crud_chronic_condition',
            ],
            [
                'name' => 'create_test',
            ],
            [
                'name' => 'read_test',
            ],
            [
                'name' => 'update_test',
            ],
            [
                'name' => 'delete_test',
            ],
            [
                'name' => 'crud_test',
            ],
            [
                'name' => 'create_screening',
            ],
            [
                'name' => 'read_screening',
            ],
            [
                'name' => 'update_screening',
            ],
            [
                'name' => 'delete_screening',
            ],
            [
                'name' => 'crud_screening',
            ],
            [
                'name' => 'create_appointment',
            ],
            [
                'name' => 'read_appointment',
            ],
            [
                'name' => 'update_appointment',
            ],
            [
                'name' => 'delete_appointment',
            ],
            [
                'name' => 'crud_appointment',
            ],
            [
                'name' => 'create_practice_application',
            ],
            [
                'name' => 'read_practice_application',
            ],
            [
                'name' => 'update_practice_application',
            ],
            [
                'name' => 'delete_practice_application',
            ],
            [
                'name' => 'crud_practice_application',
            ],
            [
                'name' => 'create_practice',
            ],
            [
                'name' => 'read_practice',
            ],
            [
                'name' => 'update_practice',
            ],
            [
                'name' => 'delete_practice',
            ],
            [
                'name' => 'crud_practice',
            ],
            [
                'name' => 'create_setting',
            ],
            [
                'name' => 'read_setting',
            ],
            [
                'name' => 'update_setting',
            ],
            [
                'name' => 'delete_setting',
            ],
            [
                'name' => 'crud_setting',
            ],
            [
                'name' => 'crud_report',
            ],
        ];

        $admin_permissions = [
            [
                'name' => 'create_user',
            ],
            [
                'name' => 'read_user',
            ],
            [
                'name' => 'update_user',
            ],
            [
                'name' => 'delete_user',
            ],
            [
                'name' => 'create_admin',

            ],
            [
                'name' => 'read_admin',

            ],
            [
                'name' => 'update_admin',

            ],
            [
                'name' => 'delete_admin',

            ],
            [
                'name' => 'crud_admin',

            ],
            [
                'name' => 'create_care_team',
            ],
            [
                'name' => 'read_care_team',
            ],
            [
                'name' => 'update_care_team',
            ],
            [
                'name' => 'delete_care_team',
            ],
            [
                'name' => 'crud_care_team',
            ],
            [
                'name' => 'create_patient',
            ],
            [
                'name' => 'read_patient',
            ],
            [
                'name' => 'update_patient',
            ],
            [
                'name' => 'delete_patient',
            ],
            [
                'name' => 'crud_patient',
            ],
            [
                'name' => 'enrol_patient',
            ],
            [
                'name' => 'unenrolled_patient',
            ],
            [
                'name' => 'view_all_patient',
            ],
            [
                'name' => 'view_practice_patient',
            ],
            [
                'name' => 'create_care_plan',
            ],
            [
                'name' => 'read_care_plan',
            ],
            [
                'name' => 'update_care_plan',
            ],
            [
                'name' => 'delete_care_plan',
            ],
            [
                'name' => 'crud_care_plan',
            ],
            [
                'name' => 'create_monthly_review',
            ],
            [
                'name' => 'read_monthly_review',
            ],
            [
                'name' => 'update_monthly_review',
            ],
            [
                'name' => 'delete_monthly_review',
            ],
            [
                'name' => 'crud_monthly_review',
            ],
            [
                'name' => 'create_patient_data',
            ],
            [
                'name' => 'read_patient_data',
            ],
            [
                'name' => 'update_patient_data',
            ],
            [
                'name' => 'delete_patient_data',
            ],
            [
                'name' => 'crud_patient_data',
            ],
            [
                'name' => 'create_time_track',
            ],
            [
                'name' => 'read_time_track',
            ],
            [
                'name' => 'update_time_track',
            ],
            [
                'name' => 'delete_time_track',
            ],
            [
                'name' => 'crud_time_track',
            ],
            [
                'name' => 'create_message',
            ],
            [
                'name' => 'read_message',
            ],
            [
                'name' => 'update_message',
            ],
            [
                'name' => 'delete_message',
            ],
            [
                'name' => 'crud_message',
            ],
            [
                'name' => 'create_medication',
            ],
            [
                'name' => 'read_medication',
            ],
            [
                'name' => 'update_medication',
            ],
            [
                'name' => 'delete_medication',
            ],
            [
                'name' => 'crud_medication',
            ],
            [
                'name' => 'create_note',
            ],
            [
                'name' => 'read_note',
            ],
            [
                'name' => 'update_note',
            ],
            [
                'name' => 'delete_note',
            ],
            [
                'name' => 'crud_note',
            ],
            [
                'name' => 'create_insurance',
            ],
            [
                'name' => 'read_insurance',
            ],
            [
                'name' => 'update_insurance',
            ],
            [
                'name' => 'delete_insurance',
            ],
            [
                'name' => 'crud_insurance',
            ],
            [
                'name' => 'create_device',

            ],
            [
                'name' => 'read_device',

            ],
            [
                'name' => 'update_device',

            ],
            [
                'name' => 'delete_device',

            ],
            [
                'name' => 'crud_device',

            ],
            [
                'name' => 'create_chronic_condition',

            ],
            [
                'name' => 'read_chronic_condition',

            ],
            [
                'name' => 'update_chronic_condition',

            ],
            [
                'name' => 'delete_chronic_condition',

            ],
            [
                'name' => 'crud_chronic_condition',

            ],
            [
                'name' => 'create_test',

            ],
            [
                'name' => 'read_test',

            ],
            [
                'name' => 'update_test',

            ],
            [
                'name' => 'delete_test',

            ],
            [
                'name' => 'crud_test',

            ],
            [
                'name' => 'create_screening',

            ],
            [
                'name' => 'read_screening',

            ],
            [
                'name' => 'update_screening',

            ],
            [
                'name' => 'delete_screening',

            ],
            [
                'name' => 'crud_screening',

            ],
            [
                'name' => 'create_appointment',

            ],
            [
                'name' => 'read_appointment',

            ],
            [
                'name' => 'update_appointment',

            ],
            [
                'name' => 'delete_appointment',

            ],
            [
                'name' => 'crud_appointment',

            ],
            [
                'name' => 'create_practice_application',

            ],
            [
                'name' => 'read_practice_application',

            ],
            [
                'name' => 'update_practice_application',

            ],
            [
                'name' => 'delete_practice_application',

            ],
            [
                'name' => 'crud_practice_application',

            ],
            [
                'name' => 'create_practice',

            ],
            [
                'name' => 'read_practice',

            ],
            [
                'name' => 'update_practice',

            ],
            [
                'name' => 'delete_practice',

            ],
            [
                'name' => 'crud_practice',

            ],
            [
                'name' => 'create_setting',

            ],
            [
                'name' => 'read_setting',

            ],
            [
                'name' => 'update_setting',

            ],
            [
                'name' => 'delete_setting',

            ],
            [
                'name' => 'crud_setting',

            ],
            [
                'name' => 'crud_report',
            ],

        ];

        $doctor_permissions = [
            [
                'name' => 'create_care_team',
            ],
            [
                'name' => 'read_care_team',
            ],
            [
                'name' => 'update_care_team',
            ],
            [
                'name' => 'delete_care_team',
            ],
            [
                'name' => 'crud_care_team',
            ],
            [
                'name' => 'create_patient',
            ],
            [
                'name' => 'read_patient',
            ],
            [
                'name' => 'update_patient',
            ],
            [
                'name' => 'delete_patient',
            ],
            [
                'name' => 'enrol_patient',
            ],
            [
                'name' => 'unenrolled_patient',
            ],
            [
                'name' => 'crud_patient',
            ],
            [
                'name' => 'create_care_plan',
            ],
            [
                'name' => 'read_care_plan',
            ],
            [
                'name' => 'update_care_plan',
            ],
            [
                'name' => 'delete_care_plan',
            ],
            [
                'name' => 'crud_care_plan',
            ],
            [
                'name' => 'approve_care_plan',
            ],
            [
                'name' => 'create_monthly_review',
            ],
            [
                'name' => 'read_monthly_review',
            ],
            [
                'name' => 'update_monthly_review',
            ],
            [
                'name' => 'delete_monthly_review',
            ],
            [
                'name' => 'crud_monthly_review',
            ],
            [
                'name' => 'create_patient_data',
            ],
            [
                'name' => 'read_patient_data',
            ],
            [
                'name' => 'update_patient_data',
            ],
            [
                'name' => 'delete_patient_data',
            ],
            [
                'name' => 'crud_patient_data',
            ],
            [
                'name' => 'create_time_track',
            ],
            [
                'name' => 'read_time_track',
            ],
            [
                'name' => 'update_time_track',
            ],
            [
                'name' => 'delete_time_track',
            ],
            [
                'name' => 'crud_time_track',
            ],
            [
                'name' => 'create_message',
            ],
            [
                'name' => 'read_message',
            ],
            [
                'name' => 'update_message',
            ],
            [
                'name' => 'delete_message',
            ],
            [
                'name' => 'crud_message',
            ],
            [
                'name' => 'create_medication',
            ],
            [
                'name' => 'read_medication',
            ],
            [
                'name' => 'update_medication',
            ],
            [
                'name' => 'delete_medication',
            ],
            [
                'name' => 'crud_medication',
            ],
            [
                'name' => 'create_note',
            ],
            [
                'name' => 'read_note',
            ],
            [
                'name' => 'update_note',
            ],
            [
                'name' => 'delete_note',
            ],
            [
                'name' => 'crud_note',
            ],
            [
                'name' => 'create_insurance',
            ],
            [
                'name' => 'read_insurance',
            ],
            [
                'name' => 'update_insurance',
            ],
            [
                'name' => 'delete_insurance',
            ],
            [
                'name' => 'crud_insurance',
            ],
            [
                'name' => 'create_device',
            ],
            [
                'name' => 'read_device',
            ],
            [
                'name' => 'update_device',
            ],
            [
                'name' => 'delete_device',
            ],
            [
                'name' => 'crud_device',
            ],
            [
                'name' => 'create_chronic_condition',
            ],
            [
                'name' => 'read_chronic_condition',
            ],
            [
                'name' => 'update_chronic_condition',
            ],
            [
                'name' => 'delete_chronic_condition',
            ],
            [
                'name' => 'crud_chronic_condition',
            ],
            [
                'name' => 'create_test',
            ],
            [
                'name' => 'read_test',
            ],
            [
                'name' => 'update_test',
            ],
            [
                'name' => 'delete_test',
            ],
            [
                'name' => 'crud_test',
            ],
            [
                'name' => 'create_screening',
            ],
            [
                'name' => 'read_screening',
            ],
            [
                'name' => 'update_screening',
            ],
            [
                'name' => 'delete_screening',
            ],
            [
                'name' => 'crud_screening',
            ],
            [
                'name' => 'create_appointment',
            ],
            [
                'name' => 'read_appointment',
            ],
            [
                'name' => 'update_appointment',
            ],
            [
                'name' => 'delete_appointment',
            ],
            [
                'name' => 'crud_appointment',
            ],
        ];


        $care_manager_permissions = [
            [
                'name' => 'create_patient',
            ],
            [
                'name' => 'read_patient',
            ],
            [
                'name' => 'update_patient',
            ],
            [
                'name' => 'create_care_plan',
            ],
            [
                'name' => 'read_care_plan',
            ],
            [
                'name' => 'update_care_plan',
            ],
            [
                'name' => 'create_monthly_review',
            ],
            [
                'name' => 'read_monthly_review',
            ],
            [
                'name' => 'update_monthly_review',
            ],
            [
                'name' => 'create_patient_data',
            ],
            [
                'name' => 'read_patient_data',
            ],
            [
                'name' => 'update_patient_data',
            ],
            [
                'name' => 'delete_patient_data',
            ],
            [
                'name' => 'crud_patient_data',
            ],
            [
                'name' => 'create_time_track',
            ],
            [
                'name' => 'read_time_track',
            ],
            [
                'name' => 'update_time_track',
            ],
            [
                'name' => 'delete_time_track',
            ],
            [
                'name' => 'crud_time_track',
            ],
            [
                'name' => 'create_message',
            ],
            [
                'name' => 'read_message',
            ],
            [
                'name' => 'update_message',
            ],
            [
                'name' => 'delete_message',
            ],
            [
                'name' => 'crud_message',
            ],
            [
                'name' => 'create_medication',
            ],
            [
                'name' => 'read_medication',
            ],
            [
                'name' => 'update_medication',
            ],
            [
                'name' => 'delete_medication',
            ],
            [
                'name' => 'crud_medication',
            ],
            [
                'name' => 'create_note',
            ],
            [
                'name' => 'read_note',
            ],
            [
                'name' => 'update_note',
            ],
            [
                'name' => 'delete_note',
            ],
            [
                'name' => 'crud_note',
            ],
            [
                'name' => 'create_appointment',
            ],
            [
                'name' => 'read_appointment',
            ],
            [
                'name' => 'update_appointment',
            ],
            [
                'name' => 'delete_appointment',
            ],
            [
                'name' => 'crud_appointment',
            ],
        ];

        foreach ($permissions as $permission) {
            Permission::create($permission);
        }

        $practice = Practice::create([
            'practice_name' => 'Test Practice',
            'slug' => 'test-practice',
            'address' => 'test address',
            'contact_no' => '123456789012',
            'default' => true,
        ]);


        $super_admin_role = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        $admin_role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $doctor_role = Role::create(['name' => 'doctor', 'guard_name' => 'web']);
        $care_manager_role = Role::create(['name' => 'care-manager', 'guard_name' => 'web']);


        $super_admin = User::create([
            'first_name' => 'Rana',
            'last_name' => 'Abdul Rauf',
            'user_name' => 'Super Admin',
            'slug' => 'super-admin',
            'email' => 'abdulrauf735@gmail.com',
            'email_verified_at' => Carbon::now()->today(),
            'password' => Hash::make('12345678'),
            'practice_id' => $practice->id,
        ]);
        $super_admin_role->givePermissionTo($permissions);
        $super_admin->assignRole($super_admin_role);

        $admin = User::create([
            'first_name' => 'Rana',
            'last_name' => 'Abdul Rauf',
            'user_name' => 'Admin',
            'slug' => 'admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now()->today(),
            'password' => Hash::make('12345678'),
            'practice_id' => $practice->id,
        ]);
        $admin_role->givePermissionTo($admin_permissions);
        $admin->assignRole($admin_role);


        $doctor = User::create([
            'first_name' => 'Rana',
            'last_name' => 'Abdul Rauf',
            'user_name' => 'Dr.Abdul Rauf',
            'slug' => 'doctor-rauf',
            'email' => 'doctor@gmail.com',
            'email_verified_at' => Carbon::now()->today(),
            'password' => Hash::make('12345678'),
            'practice_id' => $practice->id,

        ]);
        $doctor_role->givePermissionTo($doctor_permissions);
        $doctor->assignRole($doctor_role);


        $care_manager = User::create([
            'first_name' => 'Rana',
            'last_name' => 'Abdul Rauf',
            'user_name' => 'Test Care Manager',
            'slug' => 'test-manager',
            'email' => 'care_manager@gmail.com',
            'email_verified_at' => Carbon::now()->today(),
            'password' => Hash::make('12345678'),
            'practice_id' => $practice->id,

        ]);
        $care_manager_role->givePermissionTo($care_manager_permissions);
        $care_manager->assignRole($care_manager_role);

        $insurances = [
            [
                'insurance_name' => '1199 National Benefit Fund',
                'address_line' => 'PO BOX 1007',
                'city' => 'NEW YORK',
                'state' => 'NY',
                'zip' => '10108',
                'contact_no' => '646-473-7160',
                'alternate_no' => '800-575-7771'
            ],
            [
                'insurance_name' => 'Affinity Medicare',
                'address_line' => 'PO Box 2845',
                'city' => 'NEW YORK',
                'state' => 'NY',
                'zip' => '10116',
                'contact_no' => '866-247-5678',
                'alternate_no' => '866-247-5678'
            ],
            [
                'insurance_name' => 'Aetna',
                'address_line' => 'PO Box 981106',
                'city' => 'El Paso',
                'state' => 'TX',
                'zip' => '79998',
                'contact_no' => '800-624-0756',
                'alternate_no' => '888-632-3862'
            ],
            [
                'insurance_name' => 'Amerigroup Health Plus',
                'address_line' => 'PO Box 61010',
                'city' => 'VIRGINIA BEACH',
                'state' => 'VA',
                'zip' => '23466',
                'contact_no' => '800-450-8753',
                'alternate_no' => '800-454-3730'
            ],
            [
                'insurance_name' => 'Care Connect',
                'address_line' => 'PO BOX 830259',
                'city' => 'BIRMINGHAM',
                'state' => 'AL',
                'zip' => '35283',
                'contact_no' => '855-706-7545',
                'alternate_no' => '855-706-7545'
            ],
            [
                'insurance_name' => 'Cigna Healthcare',
                'address_line' => 'PO BOX 182223',
                'city' => 'CHATTANOOGA',
                'state' => 'TN',
                'zip' => '37422',
                'contact_no' => '866-494-2111',
                'alternate_no' => '800-244-6224'
            ],
            [
                'insurance_name' => 'Elderplan Inc',
                'address_line' => 'PO BOX 73111',
                'city' => 'NEWNAN',
                'state' => 'GA',
                'zip' => '30271',
                'contact_no' => '718-921-7979',
                'alternate_no' => '800-353-3765'
            ],
            [
                'insurance_name' => 'Emblem - Group Health (GHI)',
                'address_line' => 'PO BOX 2861',
                'city' => 'NEW YORK',
                'state' => 'NY',
                'zip' => '10116',
                'contact_no' => '212-501-4444',
                'alternate_no' => '877-842-3625'
            ],
            [
                'insurance_name' => 'Empire Blue Cross Blue Shield',
                'address_line' => 'PO BOX 3877',
                'city' => 'NEW YORK',
                'state' => 'NY',
                'zip' => '10008',
                'contact_no' => '800-992-2583',
                'alternate_no' => '800-552-6630'
            ],
            [
                'insurance_name' => 'Fidelis Care New York',
                'address_line' => 'PO BOX 805',
                'city' => 'AMHERST',
                'state' => 'NY',
                'zip' => '14226',
                'contact_no' => '888-343-3547',
                'alternate_no' => '888-343-3547'
            ],
            [
                'insurance_name' => 'Group Health Inc',
                'address_line' => ' PO Box 2814',
                'city' => 'NEW YORK',
                'state' => 'NY',
                'zip' => '10036',
                'contact_no' => '212-501-4444',
                'alternate_no' => '800-624-2414'
            ],
            [
                'insurance_name' => 'Healthfirst, Inc',
                'address_line' => 'PO BOX 5196',
                'city' => 'NEW YORK',
                'state' => 'NY',
                'zip' => '10274',
                'contact_no' => '212-801-1686',
                'alternate_no' => '888-801-1660'
            ],
            [
                'insurance_name' => 'HIP - Health Insurance Plan',
                'address_line' => 'PO Box 2845',
                'city' => 'NEW YORK',
                'state' => 'NY',
                'zip' => '10116',
                'contact_no' => '800-447-8255',
                'alternate_no' => '866-447-9717'
            ],
            [
                'insurance_name' => 'Magnacare',
                'address_line' => '825 East Gate Blvd',
                'city' => 'Garden City',
                'state' => 'NY',
                'zip' => '11530',
                'contact_no' => '800-235-7267',
                'alternate_no' => '888-624-6202'
            ],
            [
                'insurance_name' => 'Metro Plus Health Plan',
                'address_line' => '160 Water Street',
                'city' => 'NEW YORK',
                'state' => 'NY',
                'zip' => '10038',
                'contact_no' => '800-303-9626',
                'alternate_no' => '800-303-9626'
            ],
            [
                'insurance_name' => 'Oxford Health Plans',
                'address_line' => 'PO BOX 7082',
                'city' => 'BRIDGEPORT',
                'state' => 'CT',
                'zip' => '66017',
                'contact_no' => '800-201-4911',
                'alternate_no' => '800-444-6222'
            ],
            [
                'insurance_name' => 'United Healthcare Community',
                'address_line' => 'PO Box 5240',
                'city' => 'KINGSTON',
                'state' => 'NY',
                'zip' => '12402',
                'contact_no' => '800-493-4647',
                'alternate_no' => '866-362-3368'
            ],
            [
                'insurance_name' => 'United Healthcare',
                'address_line' => 'PO BOX 30304',
                'city' => 'SALT LAKE CITY',
                'state' => 'UT',
                'zip' => '84130',
                'contact_no' => '800-545-9075',
                'alternate_no' => '800-842-9905'
            ],
            [
                'insurance_name' => 'United Healthcare Medicare',
                'address_line' => 'PO BOX 31352',
                'city' => 'SALT LAKE CITY',
                'state' => 'UT',
                'zip' => '84130',
                'contact_no' => '800-545-9075',
                'alternate_no' => '877-842-3210'
            ],
            [
                'insurance_name' => 'United Healthcare Empire Plan',
                'address_line' => 'PO Box 740800',
                'city' => 'Atlanta',
                'state' => 'GA',
                'zip' => '30374',
                'contact_no' => '877-769-7447',
                'alternate_no' => '877-769-7447'
            ],
            [
                'insurance_name' => 'VNS Choice',
                'address_line' => '1250 BROADWAY FL 11',
                'city' => 'NEW YORK',
                'state' => 'NY',
                'zip' => '10001',
                'contact_no' => '877-769-7448',
                'alternate_no' => '212-609-5600'
            ],
            [
                'insurance_name' => 'Wellcare Of New York',
                'address_line' => 'P O BOX 31372',
                'city' => 'TAMPA',
                'state' => 'FL',
                'zip' => '33631',
                'contact_no' => '877-769-7449',
                'alternate_no' => '800-288-5441'
            ],
            [
                'insurance_name' => 'Humana',
                'address_line' => 'P.O. Box 14601',
                'city' => 'Lexington',
                'state' => 'KY',
                'zip' => '40512',
                'contact_no' => '877-769-7450',
                'alternate_no' => '800-457-4708'
            ],

        ];

        foreach($insurances as $item){
            Insurance::create($item);
        }
        $goals = [
            [
                'goal_name' => 'HgbAlc',            
            ],
            [
                'goal_name' => 'LDL',
            ],
            [
                'goal_name' => 'Blood Pressure',
            ],
            [
                'goal_name' => 'Blood Sugar Before Meal',
            ],
            [
                'goal_name' => 'Blood Sugar After Meal',
            ],
            [
                'goal_name' => 'Urine Microalbumin',
            ],
            [
                'goal_name' => 'Peak Flow Rate',
            ],
        ];
        foreach($goals as $item){
            TreatmentGoal::create($item);
        }


        $care_plan_schemes = [
            [
                'scheme_name' => 'Physical and Cognitive Evaluation',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Psycho-Social Analysis',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Psycho-Social Analysis II',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Functional and Environmental Analysis',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Medication',
                'type' => 'Custom',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Medication Adherence Review',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Patient\'s Contact',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Planned Intervention',
                'type' => 'Custom',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Treatment Goals',
                'type' => 'Custom',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Screening',
                'type' => 'Custom',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Test',
                'type' => 'Custom',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Utilization',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Social Determinants',
                'type' => 'Default',
                'order' => 1,
            ],
        ];
        foreach($care_plan_schemes as $item){
            CarePlanScheme::create($item);
        }
        $care_plan_questions = [
            [
                'care_plan_scheme_id' => 1,
                'question' => 'Do you recently have trouble recalling past events?',
                'input_type' => 'select',
                'screening' => 'AMT-10',
                'option' => ['No', 'Yes']
            ],
            [
                'care_plan_scheme_id' => 1,
                'question' => 'Do you have more trouble recalling recent conversations?',
                'input_type' => 'select',
                'screening' => 'AMT-10',
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 1,
                'question' => 'Do you have difficulty finding the right word to use?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 1,
                'question' => 'Do you have recent trouble managing your finances?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 1,
                'question' => 'Have you been diagnosed with dementia?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 2,
                'question' => 'Do you lack friends?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 2,
                'question' => 'Do you have trouble falling asleep or staying asleep?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 2,
                'question' => 'Do you have a dependency on alcohol?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 2,
                'question' => 'Have you been diagnosed with an anxiety disorder?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 2,
                'question' => 'Have you been diagnosed with Obsessive Compulsive Disorder?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 2,
                'question' => 'Have you been diagnosed with Bipolar disorder?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 3,
                'question' => 'Do you suffer from panic attack?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 3,
                'question' => 'Have you been diagnosed with a substance abuse disorder?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 3,
                'question' => 'Have you been diagnosed with Schizophrenia or Schizoaffective disorder?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 3,
                'question' => 'Little interest or pleasure in doing things',
                'input_type' => 'select',
                'screening' => 'PHQ-9',
                'option' => ['Not at all', 'Several Days', 'More than half the days', 'Nearly everyday']

            ],
            [
                'care_plan_scheme_id' => 3,
                'question' => 'Feeling down depressed, or helpless',
                'input_type' => 'select',
                'screening' => 'PHQ-9',
                'option' => ['Not at all', 'Several Days', 'More than half the days', 'Nearly everyday']

            ],
            [
                'care_plan_scheme_id' => 4,
                'question' => 'Are you unsteady when you walk?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 4,
                'question' => 'Are you unable to walk?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 4,
                'question' => 'Is your home unsafe?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 4,
                'question' => 'Do you have hearing difficulties?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 4,
                'question' => 'Do you have vision difficulties?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 4,
                'question' => 'Please select if you have to use any of the following adaptive equipment?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['Wheel Chair', 'Walker','Cane','Grab Bar','Hearing Device']

            ],
            [
                'care_plan_scheme_id' => 6,
                'question' => 'Have you stopped taking your medications?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']
            ],
            [
                'care_plan_scheme_id' => 12,
                'question' => 'In the past 6 months how many times have you been admitted to the hospital?',
                'input_type' => 'input',
                'screening' => null,
                'option' => null,

            ],
            [
                'care_plan_scheme_id' => 12,
                'question' => 'In the past 6 months how many times have you visited the emergency room?',
                'input_type' => 'input',
                'screening' => null,
                'option' => null,

            ],
            [
                'care_plan_scheme_id' => 12,
                'question' => 'Are you under the care of more than two doctors?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 12,
                'question' => 'Have you had any major surgical procedures with in this year?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 13,
                'question' => 'Is your housing situation currently unstable?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 13,
                'question' => 'Do you feel you have a language barrier when communicating with your medical providers?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 13,
                'question' => 'Do you feel it is difficult to arrange or obtain transportation to and from your medical appointments?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 13,
                'question' => 'Do you feel you have a learning disability?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 13,
                'question' => 'Have you missed any of your follow up appointments?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],
            [
                'care_plan_scheme_id' => 13,
                'question' => 'Do you visit the ER frequently?',
                'input_type' => 'select',
                'screening' => null,
                'option' => ['No', 'Yes']

            ],

        ];
        foreach($care_plan_questions as $item){
            CarePlanQuestion::create($item);
        }

        $monthly_review_schemes = [
            [
                'scheme_name' => 'Physical Review',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Physical Review II',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Physical Review III',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Status Review',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Lab Visit Review',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Medication Adherence Review',
                'type' => 'Default',
                'order' => 1,
            ],
            [
                'scheme_name' => 'Medication List',
                'type' => 'Customer',
                'order' => 1,
            ],

        ];
        foreach($monthly_review_schemes as $item){
            MonthlyReviewScheme::create($item);
        }

        $monthly_review_questions = [
            [
                'monthly_review_scheme_id' => 1,
                'question' => 'Have you noticed any change in your weight this month?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']
            ],
            [
                'monthly_review_scheme_id' => 1,
                'question' => 'Has there been change in your strength or exercise tolerance?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 1,
                'question' => 'Have you noticed any difference in your vision?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 1,
                'question' => 'Have you noticed any difference in your hearing?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 1,
                'question' => 'Have you experienced any dental difficulties?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 2,
                'question' => 'Have you experienced any gum bleeding?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 2,
                'question' => 'Female: Have you noticed any lumps, discharge or swelling of your breasts',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 2,
                'question' => 'Have you experienced any new shortness of breath, wheezing or coughing?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 2,
                'question' => 'Have you been diagnosed with an anxiety disorder?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 2,
                'question' => 'Have you had any chest pain or heart palpitations this month which are new for you?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 2,
                'question' => 'Have you had any change in your appetite',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 3,
                'question' => 'Any new difficulty swallowing?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 3,
                'question' => 'Any nausea or vomiting?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 3,
                'question' => 'How often do you have bowel movement?',
                'input_type' => 'input',
                'option' => null,

            ],
            [
                'monthly_review_scheme_id' => 3,
                'question' => 'Have you noticed any blood in your stool?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 3,
                'question' => 'Do you have any  burning  when you urinate?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 4,
                'question' => 'Have you had any falls in the past month?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 4,
                'question' => 'Do you feel down or depressed?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 4,
                'question' => 'Have you been recently hospitalized  this month?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 4,
                'question' => 'If yes, Have you seen your PCP since that time ?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 4,
                'question' => 'Have you seen other specialists this month?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']

            ],
            [
                'monthly_review_scheme_id' => 5,
                'question' => 'Did you have any labs done anywhere outside your PCPs office this month?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']
            ],
            [
                'monthly_review_scheme_id' => 5,
                'question' => 'Have you had any imaging (Xray, MRI, CT scan etc) done this month?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']
            ],
            [
                'monthly_review_scheme_id' => 6,
                'question' => 'Have you had any change to your medications this month?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']
            ],
            [
                'monthly_review_scheme_id' => 6,
                'question' => 'Have you missed any of your medications this month?',
                'input_type' => 'select',
                'option' => ['No', 'Yes']
            ],

        ];
        foreach($monthly_review_questions as $item){
            MonthlyReviewQuestion::create($item);
        }


        $chronic_conditions = [
            [
                'chronic_condition_name' => 'CHF',
            ],
            [
                'chronic_condition_name' => 'Coronary Artery Disease',
            ],
            [
                'chronic_condition_name' => 'Hyperlipidemia'
            ],
            [
                'chronic_condition_name' => 'Hypertension'
            ],
            [
                'chronic_condition_name' => 'Atrial Fibrillation'
            ],
            [
                'chronic_condition_name' => 'Asthma'
            ],
            [
                'chronic_condition_name' => 'COPD'
            ],
            [
                'chronic_condition_name' => 'Dementia'
            ],
            [
                'chronic_condition_name' => 'parkinsaon,s Disease'
            ],
            [
                'chronic_condition_name' => 'Depression'
            ],
            [
                'chronic_condition_name' => 'Diabetes'
            ],
            [
                'chronic_condition_name' => 'Hyperthyroidism'
            ],
            [
                'chronic_condition_name' => 'Hypothyroidism'
            ],
            [
                'chronic_condition_name' => 'Obesity'
            ],
            [
                'chronic_condition_name' => 'HIV'
            ],
            [
                'chronic_condition_name' => 'Hepatitis C'
            ],
            [
                'chronic_condition_name' => 'CKD/ESRD Stage 3, 4 and 5'
            ],
            [
                'chronic_condition_name' => 'Chronic Pain'
            ],
            [
                'chronic_condition_name' => 'stroke'
            ],
            [
                'chronic_condition_name' => 'Arthritis'
            ],
            [
                'chronic_condition_name' => 'Anxiety Disorder'
            ],
            [
                'chronic_condition_name' => 'Schizophrenia'
            ],
            [
                'chronic_condition_name' => 'Alcoholic'
            ],
            [
                'chronic_condition_name' => 'Substance Abuse'
            ],
            [
                'chronic_condition_name' => 'Lupus'
            ],
            [
                'chronic_condition_name' => 'PSTD'
            ],
            [
                'chronic_condition_name' => 'Bipolar Disorder'
            ],
            [
                'chronic_condition_name' => 'Insomnia'
            ],
            [
                'chronic_condition_name' => 'Glaucoma'
            ],
            [
                'chronic_condition_name' => 'Cataract'
            ],
            [
                'chronic_condition_name' => 'Neuropathy'
            ],
            [
                'chronic_condition_name' => 'Osteoarthritis'
            ],
            [
                'chronic_condition_name' => 'Alzheimer,s'
            ],
            [
                'chronic_condition_name' => 'Heart Failure'
            ],
            [
                'chronic_condition_name' => 'Osteoporosis'
            ],
            [
                'chronic_condition_name' => 'Ischemic Heart Diseases'
            ],
            [
                'chronic_condition_name' => 'Anemia'
            ],
            [
                'chronic_condition_name' => 'Autism Spectrum Disorder'
            ],
            [
                'chronic_condition_name' => 'Psychotic Disorders'
            ],
            [
                'chronic_condition_name' => 'Acquired Syphills'
            ],
            [
                'chronic_condition_name' => 'Tuberculosis'
            ],
        ];
        foreach($chronic_conditions as $item){
            ChronicCondition::create($item);
        }

        $tests = [
            [
                'test_name' => 'Eye Exam',
                'max_age' => null,
                'min_age'=> null,
                'gender' => 'Both',
                'duration' => 'Yearly',
                'consent' => 'We have discussed with the patient that they have yearly screenings with an optometrist and or an ophthalmologist specially if they have diabetes'

            ],
            [
                'test_name' => 'Hearing Test',
                'max_age' => null,
                'min_age'=> null,
                'gender' => 'Both',
                'duration' => 'Yearly',
                'consent' => 'We have discussed the importance of having a hearing test done at a regular basis.'

            ],
            [
                'test_name' => 'Dental Exam',
                'max_age' => null,
                'min_age'=> null,
                'gender' => 'Both',
                'duration' => 'Yearly',
                'consent' => 'We have discussed with the patient the importance of having regular dental visits as dental disease has been linked to general health disease.'

            ],
            [
                'test_name' => 'Flu Shot',
                'max_age' => null,
                'min_age'=> null,
                'gender' => 'Both',
                'duration' => 'Yearly',
                'consent' => 'We have discussed with the patient that Everyone 6 months of age and older should get a flu vaccine every season. CDC 
                recommends use of the flu shot (inactivated influenza vaccine or IIV) and the recombinant influenza vaccine (RIV)'

            ],
            [
                'test_name' => 'Tetanus-Diphtheria-Booster',
                'max_age' => null,
                'min_age'=> null,
                'gender' => 'Both',
                'duration' => 'Every 10 Years',
                'consent' => 'We have discussed with the patient that all Adults should receive a single dose of Td every 10 years. For adults who did not 
                receive Tdap as an adolescent, a dose of Tdap can replace one of the 10-year Td booster doses'

            ],
            [
                'test_name' => 'Covid-19 Vaccine',
                'max_age' => null,
                'min_age'=> null,
                'gender' => 'Both',
                'duration' => 'Now',
                'consent' => 'We have discussed the importance of having a COVID-19 Vaccine done'

            ],
            [
                'test_name' => 'Herp Zoster',
                'max_age' => null,
                'min_age'=> 65,
                'gender' => 'Both',
                'duration' => 'After 10 years',
                'consent' => ''

            ],

        ];
        foreach($tests as $item){
            Test::create($item);
        }


        $screenings = [
            [
                'screening_name' => 'Colonoscopy',
                'min_age' => 50,
                'max_age'=> 70,
                'gender' => 'Male',
                'duration' => 'Every 10 Years',
                'consent' => 'Patient was educated on the fact that screening for colon cancer is very important and plays a large role in preventing patients 
                from having colon cancer. We have discussed that the guidelines state all men and women ages 50-75 need to have a 
                colonoscopy starting at the age Patient was educated on the fact that screening for colon cancer is very important and plays a 
                large role in preventing patients from having of 50. The frequency of screening will be based on what is found on the initial 
                colonoscopy and discussed with the patient by their gastroenterologist.'
            ],
            [
                'screening_name' => 'Osteoporosis',
                'min_age' => 65,
                'max_age'=> null,
                'gender' =>  'Female',
                'duration' => 'After 10 Years',
                'consent' => null
            ],
            [
                'screening_name' => 'Abdominal Aortic Screening',
                'min_age' => 65,
                'max_age'=> 75,
                'gender' => 'Male',
                'duration' => 'After 10 Years',
                'consent' => null

            ],
            [
                'screening_name' => 'Lung Cancer Screening',
                'min_age' => 55,
                'max_age'=> 80,
                'gender' => 'Both',
                'duration' => 'After 10 Years',
                'consent' => null

            ],
            [
                'screening_name' => 'Mammography',
                'min_age' => 55,
                'max_age'=> 74,
                'gender' => 'Female',
                'duration' => 'After 10 Years',
                'consent' => null

            ],
            [
                'screening_name' => 'Pap Smear',
                'min_age' => 21,
                'max_age'=> 65,
                'gender' => 'Female',
                'duration' => 'After 10 Years',
                'consent' => null

            ],

        ];
        foreach($screenings as $item){
            Screening::create($item);
        }


        $planned_interventions = [
            [
                'chronic_condition_id' => 1,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctors Weigh yourself daily and if you see an increase in your weight please call your doctor to make an appointment',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 1,
                'symptom' => 'Chronically Feeling Tired',
                'planned_intervention' => 'Limit Fluid Intake to l liter a day Limit Salt intake to less than 2 grams ad Take my medications regularly Weight Myself Daily Keep Regular Appointments with my cardiologist',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 1,
                'symptom' => 'Chronic Swelling In the Feet',
                'planned_intervention' => 'Limit Fluid Intake to l liter a day Limit Salt intake to less than 2 grams ad Take my medications regularly Weight Myself Daily Keep Regular Appointments with my cardiologist',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'

            ],
            [
                'chronic_condition_id' => 1,
                'symptom' => 'Baseline (No New) Shortness Of Breath',
                'planned_intervention' => 'Limit Fluid Intake to l liter a day Limit Salt intake to less than 2 grams ad Take my medications regularly Weight Myself Daily Keep Regular Appointments with my cardiologist ',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 1,
                'symptom' => 'New Swelling Of The Feet',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 1,
                'symptom' => 'Feeling More Tired Than Baseline',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 1,
                'symptom' => 'New Shortness Of Breath',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
            ],
            [
                'chronic_condition_id' => 1,
                'symptom' => 'Increased Heart Rate',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 1,
                'symptom' => 'Unable to lay flat in bed',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 1,
                'symptom' => 'Chest pain',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 2,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow up  regularly with your doctors ',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 2,
                'symptom' => 'Chest Pressure',
                'planned_intervention' => 'Continue to take your medications and follow up  regularly with your doctor will suggest the next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 2,
                'symptom' => 'New Shortness of Breath',
                'planned_intervention' => 'Continue to take your medications and follow up  regularly with your doctor will suggest the next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 2,
                'symptom' => 'Numbness in the Left Arm',
                'planned_intervention' => 'Continue to take your medications and follow up  regularly with your doctor will suggest the next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 3,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow regularly with your doctors Exercise On A regular Basis Know What my Total Cholesterol, LDL or HDL levels are, Eat More Vegetables',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 4,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctors Measure Blood pressure Daily Keep a log book of my blood pressure Show the log book to my doctor on each visit Take my medications on a regular basis Decrease my salt intake',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 4,
                'symptom' => 'Chest Pressure',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 4,
                'symptom' => 'New Shortness of Breath',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 4,
                'symptom' => 'Numbness in the Left Arm',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 4,
                'symptom' => 'New Headache',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 4,
                'symptom' => 'New onset of blurred vision',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 4,
                'symptom' => 'New onset of Dizziness when blood pressure is high',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 5,
                'symptom' => 'Chest Pressure',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 5,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow up regularly  with your  doctors ',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 5,
                'symptom' => 'New Shortness of Breath',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 5,
                'symptom' => 'Palpitations which have been constant and are lasting more than prior',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 5,
                'symptom' => 'Fluttering or "thumping of the chest"',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 6,
                'symptom' => 'New onset of wheezing',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 6,
                'symptom' => 'New onset of shortness of breath',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 6,
                'symptom' => 'New Onset Of Rapid Breathing',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 6,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctor Continue to use your inhalers as directed Avoid environmental triggers. See my pulmonologists for regular follow appointments.
                Ensure I receive my Flu shot every year ',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'person_responsible' => '',
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 7,
                'symptom' => 'New onset of wheezing',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 7,
                'symptom' => 'New onset of shortness of breath',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 7,
                'symptom' => 'New Onset Of Rapid Breathing',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 7,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctor Continue to use your inhalers as directed Avoid environmental triggers See my pulmonologists for regular follow
                appointments. Ensure I receive my Flu shot every year ',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctor See my Neurologist for regular follow up appointments Write things down in my daily planner Prepare healthcare proxy and advanced directives',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'Memory Loss',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'Depression',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'Unable to Manage Executive tasks',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'More rigidity in my body than baseline',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'Inability to find the right words',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'Confusion',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'Fever',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'Chills',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'Hallucinations',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 8,
                'symptom' => 'Altered Mental Status',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctor See my Neurologist for regular follow up appointments Write things down in my daily planner Prepare healthcare proxy and advanced directives',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'Memory Loss',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'Depression',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'Unable to Manage Executive tasks',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'More rigidity in my body than baseline',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'Inability to find the right words',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'Confusion',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'Fever',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'Chills',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'Hallucinations',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 9,
                'symptom' => 'Altered Mental Status',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 10,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctor',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 10,
                'symptom' => 'Feelings of Hopelessness',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 10,
                'symptom' => 'Less pleasure in hobbies and activities',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 10,
                'symptom' => 'Feeling more down and depressed than baseline',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 10,
                'symptom' => 'Low appetite',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 10,
                'symptom' => 'Weight Loss',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 10,
                'symptom' => 'Feeling like hurtling myself or killing myself',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 11,
                'symptom' => 'No Symptoms',
                'planned_intervention' => 'Continue to take your medications and follow up  regularly with your  doctor Make sure I see my foot doctor once a year. Make sure I see my eye doctor once a ye Make sure I know what my 3 month bloc sugar level is (HgbAlc)
                Check my urine for protein at regular intervals',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 11,
                'symptom' => 'Increased thirst',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 11,
                'symptom' => 'Increased blood sugars more than baseline but less than 250',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 11,
                'symptom' => 'Feeling like my blood sugars are low occasionally ',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 11,
                'symptom' => 'Blood Sugar is higher than 350 ',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 11,
                'symptom' => 'Confusion',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 11,
                'symptom' => 'New Onset of Blurry vision',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 11,
                'symptom' => 'Blood Sugar levels fall to less than 70 multiple times',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 12,
                'symptom' => 'No Symptom',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctor Make sure you know what your TSH level Take your thyroid medications on an empty stomach',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 12,
                'symptom' => 'Increased Sweating',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 12,
                'symptom' => 'More heart palpitations than baseline',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 12,
                'symptom' => 'New onset of tremors or shakiness',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 12,
                'symptom' => 'Thinning of hair',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 13,
                'symptom' => 'No Symptom',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctor Make sure you know what your TSH level Take your thyroid medications on an empty stomach',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 13,
                'symptom' => 'Increased sensitivity to cold',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 13,
                'symptom' => 'Constipation',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 13,
                'symptom' => 'Vocal Hoarseness',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 13,
                'symptom' => 'Weight gain',
                'planned_intervention' => 'Appointment needs to be made to discuss these findings with the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 14,
                'symptom' => 'Weight gain',
                'planned_intervention' => 'Exercise
                Follow a healthy eating plan Monitor Weight on a regular basis Consider discussing with your doctor no surgical and surgical options for obesity Have a sleep study ',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 14,
                'symptom' => 'No Symptom',
                'planned_intervention' => 'Exercise
                Follow a healthy eating plan Monitor Weight on a regular basis. Consider discussing with your doctor no surgical and surgical options for obesity Have a sleep study',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 15,
                'symptom' => 'No Symptom',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctor',
                'person_responsible' => ['Self'],
                'time' => '4 week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 15,
                'symptom' => 'Rashes',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 15,
                'symptom' => 'Night Sweats',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 15,
                'symptom' => 'Shortness Of Breath',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 15,
                'symptom' => 'Chills',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 15,
                'symptom' => 'Fever',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 16,
                'symptom' => 'Fever',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 16,
                'symptom' => 'Chills',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 16,
                'symptom' => 'New Onset Of Bleeding',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 16,
                'symptom' => 'Confusion',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action ',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 16,
                'symptom' => 'New Swelling In The Feet',
                'planned_intervention' => 'Care Manager to schedule appointment to see PMD with in next 2 days',
                'person_responsible' => ['Care Manager'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'

            ],
            [
                'chronic_condition_id' => 16,
                'symptom' => 'New Weight Loss',
                'planned_intervention' => 'Care Manager to schedule appointment to see PMD with in next week',
                'person_responsible' => ['Care Manager'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 16,
                'symptom' => 'Poor Appetite',
                'planned_intervention' => 'Care Manager to schedule appointment to see PMD with in next week',
                'person_responsible' => ['Care Manager'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 16,
                'symptom' => 'No Symptom',
                'planned_intervention' => 'Continue to take your medications and all your follow up appointments',
                'person_responsible' => ['Self'],
                'time' => '4 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Loss of appetite',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Nausea or vomiting',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Headaches',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Exhaustion',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Loss of concentration',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Making little or no urine',
                'planned_intervention' => 'Verify CKD Stage 3, 4, or 5 and follow protocol accordingly Monitor CKD/ESRD and other disease states separately SHPT & PGx Labs are required Panels per protocol Medication Reconciliation must be verified, complete, updated Follow protocol for screening, identifying and treating patients with SHPT/Vitamin D deficiency. Secondary to CKD 3 or4 If stage 5 initiate protocol for screening, identifying and treating patients with CKD5 ailments and symptoms',
                'person_responsible' => ['Care Manager'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Swelling, chiefly around the eyes feet & ankles',
                'planned_intervention' => 'Verify CKD Stage 3, 4, or 5 and follow protocol accordingly. Monitor CKD/ESRD and other disease states separately SHPT & PGx Labs are required Panels per protocol. Follow protocol for screening, identifying and treating patients with SHPT/Vitamin D deficiency Secondary to CKD 3 or4',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Muscle cramps ',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Tingling in hands or feet',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Changes in skin pigmentation',
                'planned_intervention' => 'Verify CKD Stage 3, 4, or 5 and follow protocol accordingly. Follow protocol for screening, identifying and treating patients with SHPT/Vitamir deficiency Secondary to CKD 3 or 4. Medication Reconciliation must be verify complete, updated. Complete OPKO Service Request Form ',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Persistent itching',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Chest pain',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'Shortness of breath',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 17,
                'symptom' => 'High blood pressure',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 18,
                'symptom' => 'inflammation or dysfunctional nerves',
                'planned_intervention' => 'Physical Therapy visits taking medication. Pain management Visits',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '2 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 18,
                'symptom' => 'burning or aching sensation in the affected areas',
                'planned_intervention' => 'Taking medication. Pain management Visits',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 18,
                'symptom' => 'headache',
                'planned_intervention' => 'taking medication',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter'],
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 19,
                'symptom' => 'hemiplegia',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 19,
                'symptom' => 'paraplegia',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 19,
                'symptom' => 'one-sided vision loss',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 19,
                'symptom' => 'severe headache',
                'planned_intervention' => 'care manager is to immediately contact the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 19,
                'symptom' => 'trouble walking',
                'planned_intervention' => 'care manager is to immediately contact the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 19,
                'symptom' => 'facial paralysis/drooping',
                'planned_intervention' => 'care manager is to immediately contact the doctor',
                'person_responsible' => ['Care Manager'],
                'time' => 'immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 19,
                'symptom' => 'no symptoms',
                'planned_intervention' => 'continue current regimen and follow-up with the pep',
                'person_responsible' => ['self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 20,
                'symptom' => 'Pain',
                'planned_intervention' => 'Continue with current treatment from your PCP or specialist. Additionally, alternative options of the following will be consulted to you as an option. Medications, therapy and exercise',
                'person_responsible' => ['Self',],
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 20,
                'symptom' => 'Stiffness',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 20,
                'symptom' => 'Swelling',
                'planned_intervention' => 'Medications. Continue with current treatment from your PCP or Specialist . Additionally, alternative options of the following will be consulted you as an option. Weight loss (If applicable). Exercise. Heat and cold',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other','Care Manager'],
                'time' => '2 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 20,
                'symptom' => 'Redness',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 20,
                'symptom' => 'Decreased range of motion',
                'planned_intervention' => 'Therapy. Medications. Continue with current treatment from your PCP or Specialist . Additionally, alternative options of the following will be consulted you as an option.  ',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other','Care Manager'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 21,
                'symptom' => 'Nervous',
                'planned_intervention' => 'psychological counseling relaxation techniques Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other','Care Manager'],
                'time' => '2 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 21,
                'symptom' => 'Restless',
                'planned_intervention' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 21,
                'symptom' => 'Excessive worry ',
                'planned_intervention' => 'Psychological counseling relaxation techniques
                Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other','Care Manager'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 21,
                'symptom' => 'Trembling',
                'planned_intervention' => 'Relaxation techniques psychological counseling
                Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other','Care Manager'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 22,
                'symptom' => 'no symptoms',
                'planned_intervention' => 'Continue current medication regimen and f/u with psychology',
                'person_responsible' => ['Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 22,
                'symptom' => 'paranoia agitation',
                'planned_intervention' => '',
                'person_responsible' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 22,
                'symptom' => 'suicidal thoughts ',
                'planned_intervention' => 'Seek emergency care',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','other'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 22,
                'symptom' => 'homicidal thoughts ',
                'planned_intervention' => 'Immediately f/u with
                PCP/PSYCH',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','other'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 22,
                'symptom' => 'hearing voices/ seeing things ',
                'planned_intervention' => 'Immediately f/u with
                PCP/PSYCH. Seek emergency care',
                'person_responsible' => ['Self','Care Manager','Home Health','Aid','Son/Daughter','other'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 23,
                'symptom' => 'no symptoms ',
                'planned_intervention' => 'continue current regimen',
                'person_responsible' => ['Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 23,
                'symptom' => 'delirium ',
                'planned_intervention' => '',
                'person_responsible' => '',
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 23,
                'symptom' => 'hallucinations ',
                'planned_intervention' => 'immediately seek emergency care f/u with PCP/PSYCH',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','other'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 23,
                'symptom' => 'alcohol withdrawal ',
                'planned_intervention' => 'f/u with PCP/PSYCH continue current regimen immediately seek emergency care',
                'person_responsible' => ['self','Care Manager','Home Health','Aid','Son/Daughter','other'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 24,
                'symptom' => 'no symptoms ',
                'planned_intervention' => 'continue current
                regimen and follow-
                up regularly with
                your doctors
                 ',
                'person_responsible' => ['Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 24,
                'symptom' => 'substance withdrawal ',
                'planned_intervention' => 'Care manager must notify the doctor immediately and the doctor will suggest the new plan of action',
                 'person_responsible' => ['Care Manager'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 24,
                'symptom' => ' hallucinations',
                'planned_intervention' => ' Patient must seek emergency help immediately',
                'person_responsible' => ['Care Manager'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 25,
                'symptom' => 'high fever ',
                'planned_intervention' => 'Appointment needs to be  made to discuss these findings with the doctor
                 ',
                 'person_responsible' => ['Self','Home Health','Aid','Son/Daughter'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 25,
                'symptom' => 'body aches/joint pain ',
                'planned_intervention' => ' ',
                'person_responsible' => [],
                'time' => '',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 25,
                'symptom' => ' skin lesions/ rash',
                'planned_intervention' => 'continue current regimen appointment needs to be made to discuss these findings with the doctor',
                 'person_responsible' => ['Home Health','Aid','Son/Daughter','Care Manager'],
                'time' => '48 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 25,
                'symptom' => ' memory loss',
                'planned_intervention' => 'Care manager must notify the doctor immediately and the doctor will suggest the new plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 25,
                'symptom' => 'shortness of breath ',
                'planned_intervention' =>  'Care manager must notify the doctor immediately and the doctor will suggest the new plan of action',
                'person_responsible' => ['Care Manager'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 25,
                'symptom' => ' No Symptoms',
                'planned_intervention' => 'continue current regimen ',
                'person_responsible' => ['Self'],
                'time' => '8 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 26,
                'symptom' => 'psychological flashback, fear, severe anxiety, or mistrust ',
                'planned_intervention' => ' Continue to take your medications and follow up regularly with your doctors. Care Manager must notify the doctor Immediately
                and the doctor will suggest the next plan of action Appointment needs to be made to discuss these findings with the doctor  ',
                 'person_responsible' => ['Self','Care Manager','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 26,
                'symptom' => 'Mood: loss of interest or pleasure in activities guilt loneliness',
                'planned_intervention' => ' Continue to take your medications and follow up regularly with your doctors. Care Manager. Appointment needs to be made to discuss these findings with the doctor ',
                'person_responsible' => ['Self','Care Manager','Home Health','Aid','Son/Daughter','other'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 26,
                'symptom' => 'Sleep: insomnia or nightmares  ',
                'planned_intervention' => ' Continue to take your medications and follow up regularly with your doctors. Appointment needs to be made to discuss these findings with the doctor. Care Manager must notify the doctor Immediately and the doctor will suggest the next plan of action',
               'person_responsible' => ['Self','Care Manager','Home Health','Aid','Son/Daughter','other'],
               'time' => '1 Weeks',
               'desired_outcome' => 'Improve current symptoms',
               'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 26,
                'symptom' => 'Behavioral: agitation, irritability, hostility, hypervigilance, self-destructive behavior or social isolation',
                'planned_intervention' => ' Care Manager must notify the doctor immediately
                and the doctor will suggest the next plan of action appointment needs to be made to
                discuss these findings with the doctor Continue to take your medications and follow up regularly with your doctor',
                 'person_responsible' => ['Care Manager','Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            //Bipolar Disorder
            [
                'chronic_condition_id' => 27,
                'symptom' => 'no symptoms ',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 27,
                'symptom' => 'Manic episode ',
                'planned_intervention' => 'seek emergency care follow up with your PCP or Psych psychological counseling',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 27,
                'symptom' => ' depressive episode',
                'planned_intervention' => 'Follow up with your PCP or Psych psychological counseling relaxation techniques',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '2 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            //Insomnia
            [
                'chronic_condition_id' => 28,
                'symptom' => 'Trouble falling asleep ',
                'planned_intervention' => 'Patient must see doctor Yoga/exercise meditation ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 28,
                'symptom' => ' Failure to sleep through the night',
                'planned_intervention' => 'Patient must see doctor Yoga/exercise meditation and follow up regularly with your doctor Yoga/exercise ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 28,
                'symptom' => ' Irritability',
                'planned_intervention' => 'Patient must see doctor Yoga/exercise meditation and follow up regularly with your doctor Yoga/exercise ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 29,
                'symptom' => ' Severe throbbing eye pain',
                'planned_intervention' => 'go to an emergency room immediately See an ophthalmologist immediately Care Manager MUST notify the doctor Immediately
                and the doctor will suggest the next plan of action',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                 'time' => 'Immediately',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 29,
                'symptom' => 'No Symptoms ',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 29,
                'symptom' => ' Blurry or foggy vision ',
                'planned_intervention' => 'See an ophthalmologist immediately',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 29,
                'symptom' => 'Halos around lights ',
                'planned_intervention' => ' go to an emergency room immediately. See an ophthalmologist immediately. Care Manager must notify the doctor immediately and the doctor will suggest the next plan of action ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 29,
                'symptom' => ' Dilated pupil ',
                'planned_intervention' => ' See an ophthalmologist immediately. Care Manager must notify the doctor immediately and the doctor will suggest the next plan of action ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 30,
                'symptom' => 'no symptoms ',
                'planned_intervention' => ' Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 30,
                'symptom' => 'increased
                sensitivity to glare ',
                'planned_intervention' => 'protect your eyes from UVBrays by wearing sunglasses outside. See an ophthalmologist immediately',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 30,
                'symptom' => ' double vision in the affected eye',
                'planned_intervention' => 'See an ophthalmologist immediately Care Manager must notify the doctor immediately and the doctor will suggest the next plan of action ',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 30,
                'symptom' => ' trouble seeing at night',
                'planned_intervention' => 'See an ophthalmologist immediately',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 30,
                'symptom' => ' seeing colors as faded',
                'planned_intervention' => ' protect your eyes
                from UVB rays by wearing sunglasses outside. See an ophthalmologist immediately',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 31,
                'symptom' => 'No symptoms ',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 31,
                'symptom' => 'Nausea, indigestion or vomiting  ',
                'planned_intervention' => 'Check b ood sugar level regularly Exercising regularly Follow healthy, low carbon, low sugar diet Care Manager must notify the
                doctor immediately and the doctor will suggest the next plan of action. Exercising regularly. Continue to take your medications and follow up regularly with your doctors
                     ',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 31,
                'symptom' => 'Restless leg syndrome ',
                'planned_intervention' => ' Check blood sugar level regularly Exercising regularly Continue to take your medications and follow up regularly with your doctors.
                Care Manager must notify the doctor Immediately and the doctor will suggest the next plan of action. Use alternate therapies like acupuncture, physical therapy, etc.',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 31,
                'symptom' => 'Tingling or
                burning sensation ',
                'planned_intervention' => 'Care Manager must notify the doctor immediately and the doctor will suggest the next plan of action. Check blood sugar level regularly',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 31,
                'symptom' => 'Numbness reduced ability to feel pain',
                'planned_intervention' => ' Exercising regularly. Continue to take your medications and follow up regularly with your doctors. Care Manager must notify the doctor Immediately and the doctor will suggest the next plan of action. Use alternate therapies like acupuncture, physical therapy, etc. Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 32,
                'symptom' => ' No Symptoms',
                'planned_intervention' => ' Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Self'],
                'time' => '12 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 32,
                'symptom' => ' Pain. Affected joints might hurt during or after movement',
                'planned_intervention' => ' Continue to take your medications and follow up regularly with your doctors. Take my medications, regularly physical therapy',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other','Care Manager'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 32,
                'symptom' => ' Stiffness. Joint stiffness might be most noticeable upon awakening or after being inactive.',
                'planned_intervention' => 'Physical therapy, take my medications regularly get enough rest. Maintain a moderate weight. Continue to take your medications and follow up regularly with your doctors',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 32,
                'symptom' => 'Swelling: This might be caused by soft tissue inflammation around the joint ',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctors. Physical therapy and maintain a moderate weight',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 32,
                'symptom' => ' Loss of flexibility. You might not be able to move your joint through its full range of motion.',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action Physical therapy and maintain a moderate weight Continue to take your medications and follow up regularly with your doctors',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                 'time' => '4 Weeks',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 32,
                'symptom' => 'Tenderness Your joint might feel tender when you apply light pressure to or near it.',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctors physical Therapy Maintain a moderate weight',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                 'time' => '4 Weeks',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 32,
                'symptom' => ' Grating sensation: You might feel a grating sensation when you use the joint, and you might hear popping or crackling',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctors Eat a nutritious diet Take my medications regularly   Physical Therapy Maintain a moderate weight',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                 'time' => '4 Weeks',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 32,
                'symptom' => 'Bone spurs: These extra bits of bone, which feel like hard lumps, can form around the affected joint ',
                'planned_intervention' => 'Care Manager must notify the doctor Immediately and the doctor will suggest next plan of action Continue to take your medications and follow up regularly with your doctors. Take my medications regularly, eat a nutritious diet. Physical Therapy. Get enough rest and maintain a moderate weight
                 ',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                 'time' => '4 Weeks',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 33,
                'symptom' => 'Memory loss that disrupts daily life ',
                'planned_intervention' => 'Care Manager must notify the doctor immediately and the doctor will suggest the next plan of action Continue to take your medications and follow up regularly with your doctors regular health checkups making sure your blood pressure is checked and controlled. keeping alcohol to a minimum',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 33,
                'symptom' => 'Misplacing things and losing the ability to retrace steps ',
                'planned_intervention' => 'Continue to take your medications and follow up regularly with your doctors Care Manager  MUST notify the doctor Immediately and the doctor will suggest next plan of action keeping alcohol to a minimum
                regular health check ups ',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self','other'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 33,
                'symptom' => 'Challenges in planning or solving problems ',
                'planned_intervention' => 'stopping smoking regular health check ups
                keeping alcohol to a minimum making sure your blood pressure is checked and controlled Continue to take your medications and follow up regularly with your doctors. Care Manager MUST notify the doctor Immediately and the doctor will suggest the next plan of action ',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter',],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 33,
                'symptom' => ' Confusion with time or place',
                'planned_intervention' => 'eating a healthy balanced diet exercising, such as cycling or fast walking, regularly keeping alcohol to a minimum stopping smoking Care Manager MUST notify the doctor Immediately and the doctor will suggest the next plan of action regular health checkups',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter',],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 34,
                'symptom' => ' Chest pain or discomfort',
                'planned_intervention' => 'Care Manager must notify the doctor Keep Regular Appointments with my cardiologist Continue to take your medications and follow up regularly with your doctors. Control your blood pressure. Keep your cholesterol and triglyceride levels under control ',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                 'time' => 'Immediately',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 34,
                'symptom' => ' Shortness of breath',
                'planned_intervention' => ' Care Manager
                must notify the doctor. Keep regular appointments with my cardiologist. Control your blood pressure',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 34,
                'symptom' => 'Dizziness ',
                'planned_intervention' => 'Limit alcohol. Do not smoke. Eat a healthy diet. Care Manager must notify the doctor. Make sure that you get enough sleep. Continue to take your medications and follow up regularly with your doctors. Keep Regular appointments with my cardiologist',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                 'time' => 'Immediately',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 34,
                'symptom' => 'Feeling weak, light-headed, or faint One may also break out into a cold sweat  ',
                'planned_intervention' => ' Contra your b ood pressure. Keep your cholesterol and triglyceride levels under control Care Manager must notify the doctor. Continue to take your medications and follow up regularly with your doctors. Keep Regular Appointments with my cardiologist
                ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 34,
                'symptom' => 'Pain or discomfort in the jaw, neck, or back ',
                'planned_intervention' => 'Contra your b ood pressure
                Stay at a healthy weight. Keep your cholesterol and triglyceride levels under control Limit alcohol Do not smoke Manage stress Manage diabetes Care Manager must notify the doctor. Continue to take your medications and follow up regularly with your doctors. Keep Regular Appointments with my cardiologist
                 ',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                 'time' => 'Immediately',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'

            ],
            [
                'chronic_condition_id' => 35,
                'symptom' => 'Back pain, caused by a fractured or collapsed vertebra ',
                'planned_intervention' => ' Continue with current treatment from your PCP or specialist. additionally, alternative options of the following will be consulted to you as an option. Medications. Physical therapy. Visits Weight loss (If applicable) Eat a healthy diet rich in calcium Take Vitamin D. Go for regular screenings and tests',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 35,
                'symptom' => ' Loss of  height over time',
                'planned_intervention' => 'Physical therapy visits. Go for regular screenings and tests. Continue with current treatment from your PCP or specialist. Additionally alternative options of the following will be consulted to you as an option.',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 35,
                'symptom' => ' A stooped posture',
                'planned_intervention' => 'Physical therapy visits. Go for regular screenings and tests. Continue with current treatment from your PCP or specialist. Additionally alternative options of the following will be consulted to you as an option..
                 ',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 35,
                'symptom' => ' A bone that breaks much more easily than expected',
                'planned_intervention' => 'Go for regular screenings and tests Physical Therapy visits Weight loss (If applicable) Take Vitamin D. Eat a healthy diet rich in calcium Continue with current treatment from your PCP or specialist. Addition ally , alternative   options of the following will be consulted to you as an option. Medications
                ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 36,
                'symptom' => 'Chest pain, typically on the left side of the body (angina pectoris) ',
                'planned_intervention' => 'Seek immediate medical care Continue to take your medications and follow up regularly with your doctors keep regular appointments with my cardiologist Eat a healthy diet Get regular exercise. Quitting smoking and other tobacco use carefully managing your diabetes, if applicable. Keeping your cholesterol at a healthy level ',
                  'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter',],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 36,
                'symptom' => 'Rapid breathing
                (tachypnoea) or shortness of breath ',
                'planned_intervention' => 'Seek immediate medical care Continue to take your medications and follow up regularly with your doctors keep regular appointments with my cardiologist Eat a healthy diet Get regular exercise. Quitting smoking and other tobacco use carefully managing your diabetes. Stay at a healthy weight',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter',],
                 'time' => '48 Hours',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 36,
                'symptom' => 'Clammy skin ',
                'planned_intervention' => ' Keep regular appointments with my cardiologist. Continue to take your medications and follow up regularly with your doctors. Get regular exercise. Eat a healthy diet ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 37,
                'symptom' => 'fatigue ',
                'planned_intervention' => '	Iron supplements Continue to take your medications and follow up regularly with your doctors. Care Manager must notify the doctor',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter',],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 37,
                'symptom' => 'dizziness or a fast heartbeat ',
                'planned_intervention' => 'Care Manager must notify the doctor ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 37,
                'symptom' => 'no symptoms ',
                'planned_intervention' => ' Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Self'],
                'time' => '12 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 37,
                'symptom' => 'shortness of breath ',
                'planned_intervention' => 'Care Manager must notify the doctor ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 37,
                'symptom' => 'Cold hands and Feet',
                'planned_intervention' => 'Ingestion of iron-rich foods Iron supplements. Continue to take your medications and follow up regularly with your doctors',
                'person_responsible' => ['Self','Home Health','Aid','Son/Daughter','other'],
                'time' => '48 Hours',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 38,
                'symptom' => 'Epilepsy or seizure disorder ',
                'planned_intervention' => 'Continue current medication regimen and f/u with Psych
                immediately f/u with PCP/PSYCH. Medication ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter',],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'

            ],
            [
                'chronic_condition_id' => 38,
                'symptom' => 'Delayed cognitive or learning skills ',
                'planned_intervention' => ' Different forms of therapy like occupational therapy, speech therapy, physical therapy, and pharmacological therapy. Continue current medication regimen and f/u with Psych Immediately f/u with PCP/PSYCH Complementary and Alternative Medicine applied behavioral analysis (ABA)',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 38,
                'symptom' => 'Delayed language skills and movement skills ',
                'planned_intervention' => ' Different forms of therapy like occupational therapy, speech therapy, physical therapy, and pharmacological therapy. Continue current medication regimen and f/u with Psych Immediately f/u with PCP/PSYCH Complementary and Alternative Medicine applied behavioral analysis (ABA)',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 39,
                'symptom' => 'Hallucinations means seeing, hearing, or feeling
                things that do not exist. ',
                'planned_intervention' => 'Continue current medication regimen and f/u with Psych
                Immediately f/u with PCP/PSYCH. Antipsychotic Medications antidepressants, depending on patients problems. Seek emergency Care. Different forms of mental health Therapy',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                 'time' => 'Immediately',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'

            ],
            [
                'chronic_condition_id' => 39,
                'symptom' => 'Delusions are false beliefs that  do not go away even after they have been shown to be false.',
                'planned_intervention' => 'Antipsychotic Medications antidepressants, depending on patients problems. Seek emergency Care. Different forms of mental health Therapy',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 39,
                'symptom' => ' Mood swings or other mood symptoms, such as depression or Mania',
                'planned_intervention' => ' Continue current medication regimen and f/u with Psych
                immediately f/u with PCP/PSYCH. Antidepressants, depending on patients problems.  Antipsychotic Medications. Different forms of mental health. ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 39,
                'symptom' => 'Strange, possibly dangerous Behavior',
                'planned_intervention' => 'Antipsychotic Medications Continue current medication regimen and f/u with Psych immediately f/u with PCP/PSYCH. Seek emergency care Antidepressants, depending on patients problems. Different forms of mental health therapy ',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                 'time' => 'Immediately',
                 'desired_outcome' => 'Improve current symptoms',
                 'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 39,
                'symptom' => 'Loss of interest in personal hygiene and/or activities',
                'planned_intervention' => 'Antipsychotic medications Antidepressants, depending on patients problems Continue current medication regimen and f/u with Psych immediately f/u with PCP/PSYCH. Different forms of mental health therapy',
                 'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '4 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 40,
                'symptom' => ' no symptoms',
                'planned_intervention' => ' follow up regularly with your doctor to repeat syphillis testing',
                'person_responsible' => ['Self'],
                'time' => '12 Weeks',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 40,
                'symptom' => 'painless penile ulcer',
                'planned_intervention' => 'patient must immediately seek care',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','Self'],
                'time' => '1 Week',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 41,
                'symptom' => 'Coughing for three or more weeks ',
                'planned_intervention' => 'Patient must see doctor immediately and get tested ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','other','Self'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 41,
                'symptom' => 'Chest pain, or pain with breathing or coughing  ',
                'planned_intervention' => ' ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','other','Self'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
            [
                'chronic_condition_id' => 41,
                'symptom' => ' Coughing up blood or mucus',
                'planned_intervention' => 'Patient must see doctor immediately and get tested ',
                'person_responsible' => ['Care Manager','Home Health','Aid','Son/Daughter','other','Self'],
                'time' => 'Immediately',
                'desired_outcome' => 'Improve current symptoms',
                'prognosis' => 'Guarded'
            ],
        ];

        foreach($planned_interventions as $item){
            PlannedIntervention::create($item);
        }
        Setting::create([
            'app_name' => 'CCM'
        ]);



        $device = [
            [
                'device_serial_no' => '123456782234',

            ],
            [
                'device_serial_no' => '123456783333',

            ],
            [
                'device_serial_no' => '123456755555',

            ],
            [
                'device_serial_no' => '123456789908',

            ],
            [
                'device_serial_no' => '123456789666',

            ],
            [
                'device_serial_no' => '123456789777',

            ],
            [
                'device_serial_no' => '888856789345',

            ],
            [
                'device_serial_no' => '999456789345',

            ],
            [
                'device_serial_no' => '123456786665',

            ],
            [
                'device_serial_no' => '098765432145',

            ],
        ];
//        foreach($device as $data){
//            Device::create($data);
//        }



    }
}
