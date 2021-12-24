<!DOCTYPE html>
<html lang="en" >

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <!-- <link  rel='stylesheet' type='text/css'> -->
  <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
  <!-- <style>
    body {
    font-family: 'Lato' !important;
}
  </style> -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/dist/css/adminlte.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.min.css">
  <link rel="stylesheet" href="/dist/css/style.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <!-- Preloader -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div> -->

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" id="main-header">
      <!-- Left navbar links -->
      <ul class="navbar-nav" style="width: 350px;">
        <li class="nav-item" style="width: inherit;">
          <div class="form-group has-search">
            <!-- <span class="fa fa-search fa-sm form-control-feedback" style="background-color: #FAFBFD;"></span> -->
            <img src="/dist/img/search-interface-symbol.svg" class="searchIcon" id="searchIcon">
            <input type="text" class="form-control" placeholder="Search... " style="background-color: #FAFBFD;" id="search">
          </div>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto" style="padding: 0px;" id="navbar-nav">



        <!-- Notifications Dropdown Menu -->
        <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <div class="nav-link mb-3" data-toggle="dropdown" href="#" style="width: 320px; ">
          <div class="row mr-3">
            <div class="col-3">
              <img src="/dist/img/user2-160x160.jpg" style="height: 50px;border-radius: 50%;" alt="User Image">
            </div>
            <div class="col-9 user" id="user">
              <h5>{{ __('Hi! ') }}</h5>
              <h6>{{ auth()->user()->name() }} <i class="fas fa-chevron-down"></i></h6>
            </div>
          </div>
            
        </div>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right langDropDown">
          <div  class="dropdown-item">
              @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}" class="kt-nav__link">
                            <h5  class="language"><img src="{{asset('assets/media/flags/' . $localeCode . '.svg')}}" class="flagIcons">{{ $properties['native'] }}</h5>
                        </a>
                @endforeach
          </div>
          
        </div>
      </li>

        <!-- User Dropdown Menu -->
        <li class="nav-item dropdown marginRight" id="bellNotifi">
          <a class="nav-link notification" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i>
            <span class="redDot"></span>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
            <span class="dropdown-item dropdown-header">15 Notifications</span>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-envelope mr-2"></i> 4 new messages
              <span class="float-right text-muted text-sm">3 mins</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-users mr-2"></i> 8 friend requests
              <span class="float-right text-muted text-sm">12 hours</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item">
              <i class="fas fa-file mr-2"></i> 3 new reports
              <span class="float-right text-muted text-sm">2 days</span>
            </a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
          </div>
        </li>

      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar  elevation-4">
      <!-- Brand Logo -->
      <a href="/index3.html" class="brand-link text-center">
        <img src="/dist/img/Profile-01.png" style="max-width: 200px;">
        <!-- <span class="brand-text font-weight-light">LogoHere</span> -->
      </a>
      <!-- Sidebar Menu -->
      <nav class="mt-2" id="nav">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="ul">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


          <li class="nav-header">General</li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('Home')" id="Home">
              <img src="/dist/img/house.svg" class="icon">
              <p>
                Home
              </p>
            </a>
          </li>

          <li class="nav-header">Employees</li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('Employees')" id="Employees">
              <img src="/dist/img/group (1).svg" >
              <p>
                Employees
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('Requests')" id="Requests">
              <img src="/dist/img/layers.svg">
              <p>
                Requests
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('Structure')" id="Structure" >
              <img src="/dist/img/hierarchical-structure.svg">
              <p>
                Structure
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('EmployeesServices')" id="EmployeesServices" >
              <img src="/dist/img/businessman.svg">
              <p>
                Employees Services
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('EmployeesViolations')" id="EmployeesViolations">
              <img src="/dist/img/bad-review.svg">
              <p>
                Employees Violations
              </p>
            </a>
          </li>

          <li class="nav-header">Attendance</li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('Shifts')" id="Shifts">
              <img src="/dist/img/working-time.svg">
              <p>
                Shifts
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('TimeSheet')" id="TimeSheet">
              <img src="/dist/img/paper.svg">
              <p>
                Time Sheet
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('Vacations')" id="Vacations">
              <img src="/dist/img/calendar.svg">
              <p>
                Vacations
              </p>
            </a>
          </li>

          <li class="nav-header">Payroll</li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('PayrollTable')" id="PayrollTable">
              <img src="/dist/img/salary.svg">
              <p>
                Payroll Table
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('PaymentProcessing')" id="PaymentProcessing">
              <img src="/dist/img/continuous.svg">
              <p>
                Payment Processing
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('Reports')" id="Reports">
              <img src="/dist/img/clipboard.svg">
              <p>
                Reports
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active-ar" onclick="setActive('Settings')" id="Settings">
              <img src="/dist/img/settings.svg">
              <p>
                Settings
              </p>
            </a>
          </li>
          <!-- <li class="nav-header" style="text-align: center; font-size: 220px;">9</li> -->

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
  
    <!-- /.sidebar -->
     </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" id="content-wrapper">


    <!-- Main content -->
    <section class="content" style="margin-top: -17px; padding: 0px;">
      <div class="container-fluid" style="padding: 0px; padding-top: 15px; ">
        <div>
          <div class=" p-4 borderForDiv">
            <div class="row">
              <h4 class="h4">Attendance Overview</h4>
            </div>

            <div class="row" style="align-items: center;">
              <div class="col">
                <div class="set-size charts-container">
                  <div class="pie-wrapper progress-95 style-2">
                    <h6 class="label purble">{{$employeesStatistics['totalActiveEmployees']}}</h6>
                    <h6 class="label2 purble">{{__('All Employees')}}</h6>
                    <div class="pie">
                      <div class="left-side half-circle"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col">
                <div class="set-size charts-container">
                  <div class="pie-wrapper progress-95 style-2">
                    <h6 class="label" style="color: #464648;">{{$attendanceSummary['totalAttendees']}}</h6>
                    <h6 class="label2" style="color: #464648;">{{__('Attendees')}}</h6>
                    <div class="pie">
                      <div class="left-side half-circle" style="border-color: #464648;"></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="set-size charts-container">
                  <div class="pie-wrapper progress-95 style-2 bigOne" style="height: 1.4em; width: 1.4em;">
                    <h6 class="label " style="line-height: 10.5em; color: #007CC4;">{{$attendanceSummary['absent']}}</h6>
                    <h6 class="label2 " style="line-height: 15.8em; color: #007CC4;">{{__('Absent')}}</h6>
                    <div class="pie">
                      <div class="left-side half-circle" style="border-color: #007CC4;"></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="set-size charts-container">
                  <div class="pie-wrapper progress-95 style-2">
                    <h6 class="label" style="color: #FF0A0A;">64</h6>
                    <h6 class="label2" style="color: #FF0A0A;">Attendees</h6>
                    <div class="pie">
                      <div class="left-side half-circle" style="border-color: #FF0A0A;"></div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="set-size charts-container">
                  <div class="pie-wrapper progress-95 style-2">
                    <h6 class="label" style="color: #8479FF;">{{$employeesStatistics['total_saudis']}}</h6>
                    <h6 class="label2" style="color: #8479FF;">{{__('Saudis')}}</h6>
                    <div class="pie">
                      <div class="left-side half-circle" style="border-color: #8479FF;"></div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>

          <div class="divPadding">
            <div class="row">
              <div class="col-7">
                <div class="row">
                <h4 class="h3">{{__('Rate Of Employees In Department')}}</h4>
               </div>
                <table class="mt-4">
                  <tr>
                    <th>{{__('Department')}}</th>
                    <th>{{__('In Service')}}</th>
                  </tr>
                  
                  
                  
                  
                  @foreach($departmentsStatistics as $department)
                        <tr>
                        <td>{{$department->name}}</td>
                        <td style="color: #007CC4;">{{$department->in_service}} <img src="/dist/img/view (1).svg" class="eyeIcon"></td>
                      </tr>
                        @endforeach
                  
                
                </table>
                <h4 class="showingMore"><span onclick="goBack()"><</span> Showing 1 of 7 <span>></span> </h4>
                
              </div>
              <div class="col-5">

              
                  
                  <div class="card-body">
                    <figure class="highcharts-figure">
                      <div id="pieChart"></div>
                  </figure>
                    <!-- <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas> -->
                  </div>
                  <!-- /.card-body -->
                
                <!-- /.card -->

              </div>
            </div>
          </div>

          <div class="divPadding">
            <div class="row">
              <div class="col-7">
                <div class="row">
                <h4 class="h3">Absence Chart</h4>
              </div>
                
                 
                    <div id="absenceChart" style="min-width: 350px; max-width: 600px;height: 300px;"></div>
                 
                
              </div>
              <div class="col-5">
                <div class="row">
                <h4 class="h3 mr-5 ml-5">Expiring Documents</h4>
              </div>
                <div class="card-body1">
                  <div class="round">
                    37
                    <h6 class="ExpiringDocuments">Employees in trail</h6>
                  </div>
                </div>
              
            

              </div>
            </div>
          </div>


        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

  </div>
  <!-- ./wrapper -->
  <!-- jQuery -->
  <script src="/plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <!-- <script src="/plugins/jquery-ui/jquery-ui.min.js"></script> -->
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <!-- <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script> -->
  <!-- Bootstrap 4 -->
  <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="/plugins/chart.js/Chart.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
  <script src="https://code.highcharts.com/modules/export-data.js"></script>
  <script src="https://code.highcharts.com/modules/accessibility.js"></script>
  <!-- Sparkline -->
  <script src="/plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <!-- <script src="/plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="/plugins/jqvmap/maps/jquery.vmap.usa.js"></script> -->
  <!-- jQuery Knob Chart -->
  <script src="/plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="/plugins/moment/moment.min.js"></script>
  <script src="/plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="/plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="/dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="/dist/js/logic.js"></script>
  <script src="/dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="/dist/js/pages/dashboard.js"></script>
  
  @if(App::isLocale('ar'))
  <script>
      changeToRTL();
  </script>
  @endif
  
</body>

</html>