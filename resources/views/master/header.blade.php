<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-lg navbar-dark">
        <div class="navbar-header">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand w-100" href="#">
                <!-- Logo icon -->
                <b class="logo-icon">
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    {{-- <img src="{{asset('images/logo_final.png')}}" alt="homepage" class="light-logo" /> --}}
                    <!-- Light Logo icon -->
                    {{-- <img src="{{asset('images/logo_final.png')}}" alt="homepage" class="light-logo" /> --}}
                </b>
                <!--End Logo icon -->
                <!-- Logo text -->

            </a>
            <a class="topbartoggler d-block d-lg-none waves-effect waves-light" href="javascript:void(0)"
                data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i>
            </a>
        </div>
        <div class="w-75">

        </div>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            @livewire('search')
            <ul class="navbar-nav float-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false"> <i class="mdi mdi-message"></i>
                        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox scale-up">
                        <ul class="list-style-none">
                            <li>
                                <div class="border-bottom rounded-top py-3 px-4">
                                    <h5 class="mb-0 font-weight-medium">Notifications</h5>
                                </div>
                            </li>
                            <li>
                                <div class="message-center notifications position-relative" style="height:250px;"
                                    id="notifications">
                                    <!-- Message -->
                                    @foreach (Auth::user()->unreadNotifications()->take(100)->get() as $item)
                                        <a href="{{ $item->data['url'] }}"
                                            class="message-item d-flex align-items-center border-bottom px-3 py-2"
                                            onclick="mark_as_read('{{ $item->id }}')">
                                            <span class="btn {{ $item->data['color'] }} rounded-circle btn-circle"><i
                                                    class="{{ $item->data['icon'] }}"></i></span>
                                            <div class="w-75 d-inline-block v-middle pl-2">
                                                <h5 class="message-title mb-0 mt-1">{{ $item->data['title'] }}</h5>
                                                <span
                                                    class="font-12 text-nowrap d-block text-muted text-truncate">{{ $item->data['msg'] }}</span>
                                                <span
                                                    class="font-12 text-nowrap d-block text-muted">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}</span>
                                            </div>
                                        </a>
                                    @endforeach
                                    {{-- <!-- Message -->
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-success rounded-circle btn-circle"><i class="ti-calen'da'r"></i></span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Event today</h5> <span class="font-12 text-nowrap d-block text-muted text-truncate">Just a reminder that you have event</span> <span class="font-12 text-nowrap d-block text-muted">9:10 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-info rounded-circle btn-circle"><i class="ti-settings"></i></span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Settings</h5> <span class="font-12 text-nowrap d-block text-muted text-truncate">You can customize this template as you want</span> <span class="font-12 text-nowrap d-block text-muted">9:08 AM</span> </div>
                                    </a>
                                    <!-- Message -->
                                    <a href="javascript:void(0)" class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                        <span class="btn btn-primary rounded-circle btn-circle"><i class="ti-user"></i></span>
                                        <div class="w-75 d-inline-block v-middle pl-2">
                                            <h5 class="message-title mb-0 mt-1">Pavan kumar</h5> <span class="font-12 text-nowrap d-block text-muted text-truncate">Just see the my admin!</span> <span class="font-12 text-nowrap d-block text-muted">9:02 AM</span> </div>
                                    </a> --}}
                                </div>
                            </li>
                            <li>
                                <a class="nav-link border-top text-center text-dark pt-3"
                                    href="{{ route('notification.index') }}"> <strong>Check all notifications</strong>
                                    <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <img src="{{ auth()->user()->user_image }}" alt="user" width="30"
                            class="profile-pic rounded-circle" />
                        {{ auth()->user()->user_name }}
                    <div class="dropdown-menu mailbox dropdown-menu-right scale-up">
                        <ul class="dropdown-user list-style-none">
                            <li>
                                <div class="dw-user-box d-flex">
                                    <div class="u-img"><img src="{{ auth()->user()->user_image }}" alt="user"
                                            class="rounded" width="80"></div>
                                    <div class="u-text">
                                        <h4 class="mb-0">{{ auth()->user()->user_name }}</h4>
                                        <p class="text-muted text-justify mb-1 text-truncate" style="max-width: 200px;">{{ auth()->user()->email }}</p>
                                        <a href="{{ route('user.show', auth()->user()) }}"
                                            class="btn btn-rounded btn-success btn-sm text-white d-inline-block">View
                                            Profile</a>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="dropdown-divider"></li>
                            <li class="user-list"><a class="px-3 py-2" href="{{ route('user.password.index') }}"><i
                                        class="ti-lock mr-2"></i> Change Password</a></li>
                            @can('read_appointment')
                                <li class="user-list"><a class="px-3 py-2" href="{{ route('appointment.index') }}"><i
                                            class="ti-email mr-2"></i> Appointment</a></li>
                            @endcan
                            <li role="separator" class="dropdown-divider"></li>
                            @can('crud_setting')
                                <li class="user-list"><a class="px-3 py-2" href="{{ route('setting.index') }}"><i
                                            class="ti-settings mr-2"></i> Setting</a></li>
                            @endcan
                            <li class="user-list"><a class="px-3 py-2" href="{{ route('optimize') }}"><i
                                        class="fas fa-eraser mr-2"></i> Optimize</a></li>

                            <li role="separator" class="dropdown-divider"></li>
                            <li class="user-list">
                                <a class="px-3 py-2" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power-off mr-2"></i> Logout
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                            </form>

                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
