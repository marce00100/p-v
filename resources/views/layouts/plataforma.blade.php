<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, user-scalable=yes, initial-scale=0.4, maximum-scale=2, minimum-scale=0.4">
    <meta name="description" content="">
    <meta name="author" content="MFG">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="icon" type="image/png" sizes="16x16" href="plugins/images/favicons.png">

    <title>Pivot V</title>
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('sty-home/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/bootstrap-extension/css/bootstrap-extension.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <link href="{{ asset('plugins/bower_components/custom-select/custom-select.css') }}" rel="stylesheet" type="text/css" />
    <!-- animation CSS -->
    <link href="{{ asset('sty-home/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('sty-home/css/style.css') }}" rel="stylesheet">    
    <!-- color CSS you can use different color css from css/colors folder -->
    {{-- <link href="{{ asset('sty-home/css/colors/default.css') }}" id="theme" rel="stylesheet"> --}}
<link href="{{ asset('sty-home/css/colors/dark-sidebar.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('css/fontello.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('css/auxmenu.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    @yield('header')

</head>

<body class="fix-sidebar">
    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper">
        <!-- Top Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0" style="position: sticky;">
            <div class="navbar-header p2"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="ti-menu"></i></a>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <!-- /.dropdown -->
                    <li class="right-side-toggle">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#">
                          <i class="fa fa-user img-circle"></i> <b class="hidden-xs">{{ Auth::user()->name }}</b>
                        </a>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>


                <div class="top-left-part row bg-white" style="width: 300px">
                  <div class="col-xs-1"><img src="{{ asset('img/pivot_v.png') }}" width="80"/></div>
                  <div class="col-xs-3 mt20">
                    <span style="font-size: 20px; font-weight: 600; margin: 10px 0px 0px 0px ;"  >
                      <span >PIVOT </span>
                      <span style="color: orange;"> V</span>
                    </span>
                    <br><span>Visualizador BI</span>
                  </div>
                </div>
            </div>
            <div style="background-color: #EDF1F5; height: 2px"></div>

        </nav>
        <!-- End Top Navigation -->
        <!-- Left navbar-header -->


        <!-- Left navbar-header end -->
        <!-- Page Content -->

        <div id="page-wrapper">
          <div class="container-fluid" style="padding-left: 0px; padding-right: 0px;">
              <div class="row">
                <div class="col-lg-12">
                     <nav style="background:#5c6175;">
                       <ul class="menu">

                      </ul>
                    </nav>




                </div>
              </div>

                @yield('content')
                <!-- br/>
                <br/ -->
                <!-- /.container-fluid -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> {{ Auth::user()->name }} <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul>
                                <li><b>Opciones</b></li>
                            </ul>
                            <ul class="">
                                <li><a href="#"><i class="ti-user"></i> Mi perfil</a></li>
                                <li><a href="#"><i class="ti-wallet"></i> Cambiar contraseña</a></li>

                                <li role="separator" class="divider"></li>
                                <li><a href="{{ url('/home') }}"><i class="fa icon-logout"></i> Cerrar Modulos </a></li>
                                <li>
                                  <a href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Cerrar Sesión </a>
                                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                          {{ csrf_field() }}
                                  </form>
                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer text-center"> 2018 &copy; PIVOT V - Pivot Visualizer - Análisis BI</footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('sty-home/bootstrap/dist/js/tether.min.js') }}"></script>
    <script src="{{ asset('sty-home/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/bootstrap-extension/js/bootstrap-extension.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <script src="{{ asset('plugins/bower_components/custom-select/custom-select.min.js') }}" type="text/javascript"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('sty-home/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('sty-home/js/waves.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('sty-home/js/custom.js') }}"></script>
    <!--Style Switcher -->
    <script src="{{ asset('plugins/bower_components/styleswitcher/jQuery.style.switcher.js') }}"></script>

    <script src="{{ asset('js/auxmenu.js') }}"></script>

    @stack('script-head')
</body>

</html>
