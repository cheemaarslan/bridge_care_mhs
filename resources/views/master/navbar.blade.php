<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <!-- User Profile-->
                <li class="sidebar-item"> <a
                        class="sidebar-link waves-effect waves-dark {{ Route::is('home') ? 'active' : '' }}"
                        href="{{ route('home') }}" aria-expanded="false"><span class="hide-menu">Dashboard </span></a></li>
                @can('approve_care_plan')
                    @php
                        $care_plan = App\Models\CarePlan::with(['patient' => function($query){
                                            $query->where('status', '1');
                                            $query->where('enrol_in_ccm', true);
                                        }])->where('status', 'Awaiting Approval')->count();
                    @endphp
                    <li class="sidebar-item">
                        <a class="sidebar-link waves-effect waves-dark {{ Route::is('care-plan.index') ? 'active' : '' }}"
                        href="{{ route('care-plan.index') }}" aria-expanded="false">Pending Approval
                        @if ($care_plan >0)
                        <span class="btn btn-danger btn-sm ml-2">{{$care_plan}}</span>
                        @endif
                        </a>
                    </li>
                @endcan
                <li class="sidebar-item ml-2 {{ request()->is('patient*') ? 'selected' : '' }}"> <a
                        class="sidebar-link has-arrow waves-effect waves-dark sidebar-link " href="javascript:void(0)"
                        aria-expanded="false"><span class="hide-menu">Patient</span></a>
                    <ul aria-expanded="false"
                        class="collapse first-level {{ request()->is('patient.*') ? 'active' : '' }}">
                        @can('create_patient')
                            <li class="sidebar-item "> <a
                                    class="sidebar-link waves-effect waves-dark sidebar-link {{ Route::is('patient.create') ? 'active' : '' }}"
                                    href="{{ route('patient.create') }}" aria-expanded="false"><i
                                        class="mdi mdi-image-filter-tilt-shift"></i><span class="hide-menu">Add New
                                        Patient</span></a></li>
                        @endcan
                        @can('view_all_patient')
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('patient.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-svg"></i><span class="hide-menu">View All Patients</span></a></li>

                        @endcan
                    </ul>
                </li>
                @can('crud_appointment')
                    <li class="sidebar-item"> <a
                            class="sidebar-link waves-effect waves-dark {{ request()->is('appointment') ? 'active' : '' }}"
                            href="{{ route('appointment.index') }}" aria-expanded="false"><span
                                class="hide-menu">Appointment </span></a></li>
                @endcan
                <li class="sidebar-item ml-2 {{ Route::is('billing.*') ? 'selected' : '' }}"> <a
                        class="sidebar-link has-arrow waves-effect waves-dark sidebar-link " href="javascript:void(0)"
                        aria-expanded="false"><span class="hide-menu">Billing</span></a>
                    <ul aria-expanded="false"
                        class="collapse first-level {{ request()->is('patient.*') ? 'active' : '' }}">
                        <!--@can('create_patient')-->
                        <!--    <li class="sidebar-item "> <a class="sidebar-link waves-effect waves-dark sidebar-link"-->
                        <!--            href="{{ route('billing.ccm.index') }}" aria-expanded="false"><i-->
                        <!--                class="mdi mdi-image-filter-tilt-shift"></i><span class="hide-menu">CCM-->
                        <!--                Billing</span></a></li>-->
                        <!--@endcan-->
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{ route('billing.rpm.index') }}" aria-expanded="false"><i
                                    class="mdi mdi-svg"></i><span class="hide-menu">RPM Billing</span></a></li>
                    </ul>
                </li>
                @can('read_message')
                    <li class="sidebar-item"> <a
                            class="sidebar-link waves-effect waves-dark {{ request()->is('message') ? 'active' : '' }}"
                            href="{{ route('message.index') }}" aria-expanded="false"><span class="hide-menu">Message
                            </span></a></li>
                @endcan
                @can('crud_device')
                    <li class="sidebar-item ml-2 {{ Route::is('device.*') ? 'selected' : '' }}"> <a
                            class="sidebar-link has-arrow waves-effect waves-dark sidebar-link " href="javascript:void(0)"
                            aria-expanded="false"><span class="hide-menu">Device</span></a>
                        <ul aria-expanded="false"
                            class="collapse first-level {{ request()->is('patient.*') ? 'active' : '' }}">
                            @can('create_patient')
                                <li class="sidebar-item "> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{ route('device.create') }}" aria-expanded="false"><i
                                            class="mdi mdi-image-filter-tilt-shift"></i><span class="hide-menu">Add New
                                            Device</span></a></li>
                            @endcan
                            <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                    href="{{ route('device.index') }}" aria-expanded="false"><i
                                        class="mdi mdi-svg"></i><span class="hide-menu">View All device</span></a></li>
                        </ul>
                    </li>
                @endcan
                @can('crud_care_team')
                    <li class="sidebar-item"> <a
                            class="sidebar-link waves-effect waves-dark {{ request()->is('care-team') ? 'active' : '' }}"
                            href="{{ route('care-team.index') }}" aria-expanded="false"><span class="hide-menu">Care-Team
                            </span></a></li>
                @endcan
                @can('crud_report')
                    <li class="sidebar-item"> <a
                            class="sidebar-link waves-effect waves-dark {{ request()->is('report') ? 'active' : '' }}"
                            href="{{ route('report.index') }}" aria-expanded="false"><span class="hide-menu">Report
                            </span></a></li>
                @endcan
                        @can('crud_report')
                <li class="sidebar-item {{ request()->routeIs('getActivityLog') ? 'active' : '' }}">
                    <a class="sidebar-link waves-effect waves-dark" href="{{ route('getActivityLog') }}"
                        aria-expanded="false" title="View Activity Logs">
                        <!-- Replace with a relevant icon -->
                        <span class="hide-menu"> Activity Logs</span>
                    </a>
                </li>
                @endcan



            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>
