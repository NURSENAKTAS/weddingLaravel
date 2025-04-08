<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Yönetim Paneli')</title>

    <!-- Bootstrap Styles -->
    <link href="{{ asset('admin/assets/css/bootstrap.css') }}" rel="stylesheet" />
    <!-- FontAwesome Styles -->
    <link href="{{ asset('admin/assets/css/font-awesome.css') }}" rel="stylesheet" />
    <!-- Morris Chart Styles -->
    <link href="{{ asset('admin/assets/js/morris/morris-0.4.3.min.css') }}" rel="stylesheet" />
    <!-- Custom Styles -->
    <link href="{{ asset('admin/assets/css/custom-styles.css') }}" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

    @yield('styles')
</head>

<body>
    <div id="wrapper">
        <!-- Navbar -->
        <nav class="navbar navbar-default top-navbar" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{route('dashboard')}}"><b>Panel</b></a>
            </div>

            <ul class="nav navbar-top-links navbar-right" style="margin-right:20px;">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <span style="color: black;">{{Auth::user()->name}}</span>
                    </a>
                </li>
            </ul>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </nav>

        <!-- Sidebar -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a href="{{route('dashboard')}}" class="{{ request()->is('panel') ? 'active-menu' : '' }}"><i class="fa fa-dashboard"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="{{route('appointments')}}" class="{{ request()->is('panel/randevular*') ? 'active-menu' : '' }}"><i class="fa fa-calendar"></i> Randevular</a>
                    </li>
                    <li>
                        <a href="{{route('users')}}" class="{{ request()->is('panel/kullanicilar*') ? 'active-menu' : '' }}"><i class="fa fa-users"></i> Kullanıcılar</a>
                    </li>
                    <li>
                        <a href="{{route('iletisim')}}" class="{{ request()->is('panel/iletisim*') ? 'active-menu' : '' }}"><i class="fa fa-envelope"></i> İletişim</a>
                    </li>
                    <li>
                        <a href="{{route('anasayfa')}}" class="{{ request()->is('panel/iletisim*') ? 'active-menu' : '' }}"><i class="fa fa-home"></i> Anasayfa</a>
                    </li>
                    <li>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> Çıkış</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Content -->
        <div id="page-wrapper">
            <div id="page-inner">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session('success') }}
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    {{ session('error') }}
                </div>
                @endif

                @yield('content')

                <footer>
                    <p>Copyright &copy; {{ date('Y') }} - Tüm Hakları Saklıdır</p>
                </footer>
            </div>
        </div>
    </div>

    <!-- JavaScript -->

    <!-- jQuery -->
    <script src="{{ asset('admin/assets/js/jquery-1.10.2.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{ asset('admin/assets/js/bootstrap.min.js') }}"></script>
    <!-- Metis Menu -->
    <script src="{{ asset('admin/assets/js/jquery.metisMenu.js') }}"></script>
    <!-- Morris Chart -->
    <script src="{{ asset('admin/assets/js/morris/raphael-2.1.0.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/morris/morris.js') }}"></script>
    <!-- Custom Scripts -->
    <script src="{{ asset('admin/assets/js/custom-scripts.js') }}"></script>

    @yield('scripts')
</body>
</html>
