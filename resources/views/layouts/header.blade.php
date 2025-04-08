<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>WEB PROJESİ</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{asset("assets/img/favicon.png")}}" rel="icon">
    <link href="{{asset("assets/img/apple-touch-icon.png")}}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Dosyası -->
    <link href="{{asset("assets/vendor/bootstrap/css/bootstrap.min.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/bootstrap-icons/bootstrap-icons.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/aos/aos.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/glightbox/css/glightbox.min.css")}}" rel="stylesheet">
    <link href="{{asset("assets/vendor/swiper/swiper-bundle.min.css")}}" rel="stylesheet">

    <!-- Main CSS Dosyası -->
    <link href="{{asset("assets/css/main.css")}}" rel="stylesheet">
    <link href="{{asset("assets/css/randevu.css")}}" rel="stylesheet">
    <link href="{{asset("assets/css/register.css")}}" rel="stylesheet">
</head>

<!-- Header -->
<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center justify-content-between">

        <a href="/" class="logo d-flex align-items-center me-auto me-xl-0">
            <img src="{{asset("assets/img/logo.png")}}" alt="Logo" class="img-fluid w-50 h-50">
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="#anasayfa" class="active">Anasayfa<br></a></li>
                <li><a href="#hakkimizda">Hakkımızda</a></li>
                <li><a href="#susleme2">Mekanlarımız</a></li>
                <li><a href="#susleme2">Süslemeler</a></li>
                <li><a href="#susleme">Menülerimiz</a></li>
                <li><a href="#iletisim">İletişim</a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        @auth
            <div class="d-flex">
                <a class="btn-getstarted me-2" href="/panel-kul" style="font-weight: bold">Kullanıcı Paneli</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-getstarted me-2">Çıkış Yap</button>
                </form>
            </div>
        @else
            <a class="btn-getstarted ms-2" href="/login">Giriş Yap</a>
        @endauth

    </div>
</header>
