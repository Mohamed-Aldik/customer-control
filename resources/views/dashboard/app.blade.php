<!DOCTYPE html>
<html dir="rtl" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png')}}" sizes="16x16" href="assets/images/favicon.png')}}">
    <title>Material pro admin Template - The Ultimate Multipurpose admin template</title>
    <link rel="canonical" href="https://www.wrappixel.com/templates/xtremeadmin/" />
    <link href="{{ asset('assets/libs/chartist/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('dist/js/pages/chartist/chartist-init.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/libs/c3/c3.min.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('dist/css/style.min.css') }}" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js') }}"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js') }}"></script>
<![endif]-->
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header">
                    <!-- This is for the sidebar toggle which is visible on mobile only -->
                    <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i
                            class="ti-menu ti-close"></i></a>
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                            <!-- Dark Logo icon -->
                            <img src="{{ asset('assets/images/logo-icon.png')}}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo icon -->
                            <img src="{{ asset('assets/images/logo-light-icon.png')}}" alt="homepage"
                                class="light-logo" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="{{ asset('assets/images/logo-text.png')}}" alt="homepage" class="dark-logo" />
                            <!-- Light Logo text -->
                            <img src="{{ asset('assets/images/logo-light-text.png')}}" class="light-logo"
                                alt="homepage" />
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- Toggle which is visible on mobile only -->
                    <!-- ============================================================== -->
                    <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)"
                        data-toggle="collapse" data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i
                            class="ti-more"></i></a>
                </div>
                <!-- ============================================================== -->
                <!-- End Logo -->
                <!-- ============================================================== -->
                <div class="navbar-collapse collapse" id="navbarSupportedContent">
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav mr-auto float-left">
                        <!-- This is  -->
                        <li class="nav-item"> <a
                                class="nav-link sidebartoggler d-none d-md-block waves-effect waves-dark"
                                href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- ============================================================== -->
                        <!-- Search -->
                        <!-- ============================================================== -->
                        <li class="nav-item d-none d-md-block search-box"> <a
                                class="nav-link d-none d-md-block waves-effect waves-dark" href="javascript:void(0)"><i
                                    class="ti-search"></i></a>
                            <form class="app-search">
                                <input type="text" class="form-control" placeholder="Search & enter">
                                <a class="srh-btn"><i class="ti-close"></i></a>
                            </form>
                        </li>

                    </ul>
                    <!-- ============================================================== -->
                    <!-- Right side toggle and nav items -->
                    <!-- ============================================================== -->
                    <ul class="navbar-nav float-right">
                        <!-- ============================================================== -->
                        <!-- Comment -->
                        <!-- ============================================================== -->
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
                                        <div class="message-center notifications position-relative"
                                            style="height:250px;">
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-danger rounded-circle btn-circle"><i
                                                        class="fa fa-link"></i></span>
                                                <div class="w-75 d-inline-block v-middle pl-2">
                                                    <h5 class="message-title mb-0 mt-1">Luanch Admin</h5> <span
                                                        class="font-12 text-nowrap d-block text-muted text-truncate">Just
                                                        see the my new admin!</span> <span
                                                        class="font-12 text-nowrap d-block text-muted">9:30 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-success rounded-circle btn-circle"><i
                                                        class="ti-calendar"></i></span>
                                                <div class="w-75 d-inline-block v-middle pl-2">
                                                    <h5 class="message-title mb-0 mt-1">Event today</h5> <span
                                                        class="font-12 text-nowrap d-block text-muted text-truncate">Just
                                                        a reminder that you have event</span> <span
                                                        class="font-12 text-nowrap d-block text-muted">9:10 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-info rounded-circle btn-circle"><i
                                                        class="ti-settings"></i></span>
                                                <div class="w-75 d-inline-block v-middle pl-2">
                                                    <h5 class="message-title mb-0 mt-1">Settings</h5> <span
                                                        class="font-12 text-nowrap d-block text-muted text-truncate">You
                                                        can customize this template as you want</span> <span
                                                        class="font-12 text-nowrap d-block text-muted">9:08 AM</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="javascript:void(0)"
                                                class="message-item d-flex align-items-center border-bottom px-3 py-2">
                                                <span class="btn btn-primary rounded-circle btn-circle"><i
                                                        class="ti-user"></i></span>
                                                <div class="w-75 d-inline-block v-middle pl-2">
                                                    <h5 class="message-title mb-0 mt-1">Pavan kumar</h5> <span
                                                        class="font-12 text-nowrap d-block text-muted text-truncate">Just
                                                        see the my admin!</span> <span
                                                        class="font-12 text-nowrap d-block text-muted">9:02 AM</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link border-top text-center text-dark pt-3"
                                            href="javascript:void(0);"> <strong>Check all notifications</strong> <i
                                                class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- Profile -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('assets/images/users/1.jpg')}}" alt="user" width="30"
                                    class="profile-pic rounded-circle" />
                            </a>
                            <div class="dropdown-menu mailbox dropdown-menu-right scale-up">
                                <ul class="dropdown-user list-style-none">
                                    <li>
                                        <div class="dw-user-box p-3 d-flex">
                                            <div class="u-img"><img src="{{ asset('assets/images/users/1.jpg')}}"
                                                    alt="user" class="rounded" width="80"></div>
                                            <div class="u-text ml-2">
                                                <h4 class="mb-0">Steave Jobs</h4>
                                                <p class="text-muted mb-1 font-14">varun@gmail.com</p>
                                                <a href="pages-profile.html"
                                                    class="btn btn-rounded btn-danger btn-sm text-white d-inline-block">View
                                                    Profile</a>
                                            </div>
                                        </div>
                                    </li>
                                    <li role="separator" class="dropdown-divider"></li>
                                    <li class="user-list"><a class="px-3 py-2" href="#"><i class="ti-user"></i> My
                                            Profile</a></li>
                                    <li class="user-list"><a class="px-3 py-2" href="#"><i class="ti-wallet"></i> My
                                            Balance</a></li>
                                    <li class="user-list"><a class="px-3 py-2" href="#"><i class="ti-email"></i>
                                            Inbox</a></li>
                                    <li role="separator" class="dropdown-divider"></li>
                                    <li class="user-list"><a class="px-3 py-2" href="#"><i class="ti-settings"></i>
                                            Account Setting</a></li>
                                    <li role="separator" class="dropdown-divider"></li>
                                    <li class="user-list"><a class="px-3 py-2" href="#"><i class="fa fa-power-off"></i>
                                            Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <!-- ============================================================== -->
                        <!-- Language -->
                        <!-- ============================================================== -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i
                                    class="flag-icon flag-icon-us"></i></a>
                            <div class="dropdown-menu dropdown-menu-right scale-up">
                                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)

                                <a class="dropdown-item"
                                    href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                                    <img src="{{asset('assets/media/flags/' . $localeCode . '.svg')}}" alt="" />
                                    {{ $properties['native'] }}</a>
                                @endforeach
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- User profile -->
                <div class="user-profile position-relative"
                    style="background: url(assets/images/background/user-info.jpg) no-repeat;">
                    <!-- User profile image -->
                    <div class="profile-img"> <img src="{{ asset('assets/images/users/profile.png')}}" alt="user"
                            class="w-100" />
                    </div>
                    <!-- User profile text-->
                    <div class="profile-text pt-1">
                        <a href="#" class="dropdown-toggle u-dropdown w-100 text-white d-block position-relative"
                            data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">Markarn
                            Doe</a>
                        <div class="dropdown-menu animated flipInY">
                            <a href="#" class="dropdown-item"><i class="ti-user"></i>
                                My Profile</a>
                            <a href="#" class="dropdown-item"><i class="ti-wallet"></i> My
                                Balance</a>
                            <a href="#" class="dropdown-item"><i class="ti-email"></i> Inbox</a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item"><i class="ti-settings"></i> Account Setting</a>
                            <div class="dropdown-divider"></div>
                            <a href="authentication-login1.html" class="dropdown-item"><i class="fa fa-power-off"></i>
                                Logout</a>
                        </div>
                    </div>
                </div>
                <!-- End User profile text-->
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="nav-small-cap">
                            <i class="mdi mdi-dots-horizontal"></i>
                            <span class="hide-menu">Personal</span>
                        </li>

                        @canany(['view_roles', 'create_roles', 'update_roles', 'update_roles', 'delete'])
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span class="hide-menu">{{__('Dashboard')}}</span></a>
                        </li>
                        @endcan

                        @canany(['view_roles', 'create_roles', 'update_roles', 'update_roles', 'delete'])
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.roles.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span class="hide-menu">{{__('All Roles')}}</span></a>
                        </li>
                        @endcan


                        @canany(['view_users','create_users', 'update_users'])
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.companies.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span class="hide-menu">{{__('Companies')}}</span></a>
                        </li>
                        @endcanany


                        @canany(['view_violations','create_violations'])
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.violations.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span
                                    class="hide-menu">{{__('Violations Panel')}}</span></a></li>
                        @endcanany

                        @canany(['view_employees','create_employees'])
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.employees.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span class="hide-menu">{{__('Employees')}}</span></a>
                        </li>
                        @endcanany

                        @canany(['view_employees_fordeal', 'create_employees_fordeal'])
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.fordeal.employees_special.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span class="hide-menu">{{__('Employees')}}</span></a>
                        </li>
                        @endcanany

                        @can('view_employees')
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.employees.ended_employees')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span
                                    class="hide-menu">{{__('Ended Employees')}}</span></a></li>
                        @endcan

                        @can('view_employees')
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.suspend_salaries.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span
                                    class="hide-menu">{{__('Suspended Employees')}}</span></a></li>
                        @endcan
















                        @canany(['not-company'])
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.candidates.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span class="hide-menu">{{__('Candidates')}}</span></a>
                        </li>
                        @endcanany

                        @canany(['view_employees_violations','create_employees_violations'])
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.employees_violations.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span
                                    class="hide-menu">{{__('Employees Violations')}}</span></a></li>
                        @endcanany

                        @canany(['view_reports','create_reports'])
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.reports.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span class="hide-menu">{{__('Reports')}}</span></a>
                        </li>
                        @endcan

                        @can('not-company')
                        @canany(['view_conversations','create_conversations'])
                        <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                href="{{route('dashboard.conversations.index')}}" aria-expanded="false"><i
                                    class="mdi mdi-calendar"></i><span
                                    class="hide-menu">{{__('Conversations')}}</span></a></li>
                        @endcan
                        @endcan






                        @canany(['view_payrolls','view_my_salaries'])
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-gauge"></i>
                                <span class="hide-menu">{{__('Payrolls')}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">

                                @can('view_payrolls')

                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.payrolls.index')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('All Payrolls')}} </span>
                                    </a>
                                </li>


                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.payrolls.pending')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('Pending Payrolls')}} </span>
                                    </a>
                                </li>
                                @endcan
                                @can(['view_my_salaries', 'must_be_employee'])

                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.payrolls.my_salaries')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('My Salaries')}} </span>
                                    </a>
                                </li>
                                @endcan

                            </ul>
                        </li>
                        @endcan





                        @canany(['view_requests', 'view_my_requests'])
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-gauge"></i>
                                <span class="hide-menu">{{__('Requests')}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">

                                @can('view_requests')

                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.requests.index')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('All Requests')}} </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.requests.vacation')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('All vacation')}} </span>
                                    </a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.requests.pending_requests')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('Pending Requests')}} </span>
                                    </a>
                                </li>
                                @endcan
                                @can(['view_my_requests', 'must_be_employee'])
                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.requests.my_requests')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('My Requests')}} </span>
                                    </a>
                                </li>
                                @endcan

                            </ul>
                        </li>
                        @endcan


                        {{-- @can('not-company')--}}
                        @canany(['create_vacation_request', 'create_attendance_record_forgotten_request'])
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-gauge"></i>
                                <span class="hide-menu">{{__('Employees Services')}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">

                                @can('create_vacation_request')
                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.vacations.create')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('Vacation Request')}} </span>
                                    </a>
                                </li>
                                @endcan
                                @can('create_vacation_request')
                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.vacations.assign_vacation')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('Assign Vacation')}} </span>
                                    </a>
                                </li>
                                @endcan
                                @can('create_attendance_record_forgotten_request')
                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.attendance_forgottens.create')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('Attendance Record Forgetting Request')}} </span>
                                    </a>
                                </li>
                                @endcan
                                {{--                            @can('create_attendance_record_forgotten_request')--}}

                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.resignations.create')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('Resignation Request')}} </span>
                                    </a>
                                </li>
                                {{--                            @endcan--}}
                            </ul>
                        </li>
                        @endcan



                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-gauge"></i>
                                <span class="hide-menu">{{__('Decisions')}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">


                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.decisions.end_services.create')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('End Service')}} </span>
                                    </a>
                                </li>

                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.decisions.index')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('All Decisions')}} </span>
                                    </a>
                                </li>

                            </ul>

                        </li>




                        @canany(['view_attendance_record_page','view_attendance_sheet', 'view_my_attendance_history'])
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-gauge"></i>
                                <span class="hide-menu">{{__('Attendance')}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">

                                @can('view_attendance_record_page')
                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.attendances.create')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('Attendance Record')}} </span>
                                    </a>
                                </li>
                                @endcan
                                @can('view_attendance_record_page')
                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.attendances.create_manually')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('Attendance Record Manually')}} </span>
                                    </a>
                                </li>
                                @endcan
                                @can('view_attendance_sheet')
                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.attendances.index')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('Attendance Sheet')}} </span>
                                    </a>
                                </li>
                                @endcan
                                @can(['view_my_attendance_history', 'must_be_employee'])
                                <li class="sidebar-item">
                                    <a href="{{route('dashboard.attendances.my_attendances')}}" class="sidebar-link">
                                        <i class="mdi mdi-adjust"></i>
                                        <span class="hide-menu"> {{__('My Attendance')}} </span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                        @endcan




                        @can('view_settings')
                        <li class="sidebar-item">
                            <a class="sidebar-link has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false">
                                <i class="mdi mdi-gauge"></i>
                                <span class="hide-menu">{{__('Settings')}}</span>
                            </a>
                            <ul aria-expanded="false" class="collapse  first-level">


                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.settings.payrolls')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('General Settings')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.branches.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Branches')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.nationalities.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Nationalities')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.cities.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Cities')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.job_titles.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Job Titles')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.allowances.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Allowances')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.work_shifts.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Work Shifts')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.leave_balances.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Leave Balances')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.vacation_types.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Vacations Types')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.departments.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Departments')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.sections.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Sections')}}</span></a></li>
                                <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link"
                                        href="{{route('dashboard.providers.index')}}" aria-expanded="false"><i
                                            class="mdi mdi-calendar"></i><span
                                            class="hide-menu">{{__('Providers')}}</span></a></li>

                            </ul>
                        </li>
                        @endcan







































































                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
            <!-- Bottom points-->
            <div class="sidebar-footer">
                <!-- item-->
                <a href="" class="link" data-toggle="tooltip" title="Settings"><i class="ti-settings"></i></a>
                <!-- item-->
                <a href="" class="link" data-toggle="tooltip" title="Email"><i class="mdi mdi-gmail"></i></a>
                <!-- item-->
                <a href="" class="link" data-toggle="tooltip" title="Logout"><i class="mdi mdi-power"></i></a>
            </div>
            <!-- End Bottom points-->
        </aside>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <div class="row page-titles">
                <div class="col-md-5 col-12 align-self-center">
                    <h3 class="text-themecolor mb-0">Dashboard</h3>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
                <div class="col-md-7 col-12 align-self-center d-none d-md-block">
                    <div class="d-flex mt-2 justify-content-end">
                        <div class="d-flex mr-3 ml-2">
                            <div class="chart-text mr-2">
                                <h6 class="mb-0"><small>THIS MONTH</small></h6>
                                <h4 class="mt-0 text-info">$58,356</h4>
                            </div>
                            <div class="spark-chart">
                                <div id="monthchart"></div>
                            </div>
                        </div>
                        <div class="d-flex ml-2">
                            <div class="chart-text mr-2">
                                <h6 class="mb-0"><small>LAST MONTH</small></h6>
                                <h4 class="mt-0 text-primary">$48,356</h4>
                            </div>
                            <div class="spark-chart">
                                <div id="lastmonthchart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- End Bread crumb and right sidebar toggle -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">

                @yield('content')

            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer">
                © 2020 Material Pro Admin by wrappixel.com
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="{{ asset('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- apps -->
    <script src="{{ asset('dist/js/app.min.js') }}"></script>
    <script src="{{ asset('dist/js/app.init.js') }}"></script>
    <script src="{{ asset('dist/js/app-style-switcher.js') }}"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="{{ asset('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extra-libs/sparkline/sparkline.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('dist/js/waves.js') }}"></script>
    <!--Menu sidebar -->
    <script src="{{ asset('dist/js/sidebarmenu.js') }}"></script>
    <!--Custom JavaScript -->
    <script src="{{ asset('dist/js/custom.min.js') }}"></script>
    <!--This page JavaScript -->
    <!-- chartist chart -->
    <script src="{{ asset('assets/libs/chartist/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!--c3 JavaScript -->
    <script src="{{ asset('assets/libs/d3/dist/d3.min.js') }}"></script>
    <script src="{{ asset('assets/libs/c3/c3.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('dist/js/pages/dashboards/dashboard1.js') }}"></script>
</body>

</html>