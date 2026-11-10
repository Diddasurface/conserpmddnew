<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    @include('recursos.seo')
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/png" href="{{ asset('images/images/favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sal.css') }}">
    <link rel="stylesheet" href="{{ asset('css/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/euclid-circulara.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnify.css') }}">
    <link rel="stylesheet" href="{{ asset('css/odometer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnigy-popup.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/plyr.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body class="rbt-header-sticky">
    <header class="rbt-header rbt-header-10">
        <div class="rbt-sticky-placeholder"></div>
        <div class="rbt-header-wrapper header-space-betwween header-sticky">
            <div class="container-fluid">
                <div class="mainbar-row rbt-navigation-center align-items-center">
                    <div class="header-left rbt-header-content">
                        <div class="header-info">
                            <div class="logo">
                                <a href="{{ route('inicio') }}">
                                    <img class="conserp-brand-logo" src="{{ asset('images/images/logo-oficial-recortado.png') }}" alt="ConserpMDD">
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="rbt-main-navigation d-none d-xl-block">
                        <nav class="mainmenu-nav" aria-label="Navegación principal">
                            @include('recursos.menu')
                        </nav>
                    </div>

                    <div class="header-right">
                        <div class="rbt-btn-wrapper d-none d-xl-block">
                            <a class="rbt-btn btn-border radius-round btn-sm hover-transform-none" href="{{ url('/admin') }}">
                                <span>Iniciar sesión</span>
                            </a>
                        </div>
                        <div class="mobile-menu-bar d-block d-xl-none">
                            <div class="hamberger">
                                <button class="hamberger-button rbt-round-btn" aria-label="Abrir menú">
                                    <i class="feather-menu"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <div class="popup-mobile-menu">
        <div class="inner-wrapper">
            <div class="inner-top">
                <div class="content">
                    <div class="logo">
                        <a href="{{ route('inicio') }}">
                            <img class="conserp-brand-logo" src="{{ asset('images/images/logo-oficial-recortado.png') }}" alt="ConserpMDD">
                        </a>
                    </div>
                    <div class="rbt-btn-close">
                        <button class="close-button rbt-round-btn" aria-label="Cerrar menú"><i class="feather-x"></i></button>
                    </div>
                </div>
                <p class="description">Seguridad, salud ocupacional y cumplimiento para tu empresa.</p>
                <ul class="navbar-top-left rbt-information-list justify-content-start">
                    <li><a href="tel:+51982604441"><i class="feather-phone"></i>982 604 441</a></li>
                </ul>
            </div>
            <nav class="mainmenu-nav" aria-label="Navegación móvil">
                @include('recursos.menu')
            </nav>
            <div class="mobile-menu-bottom">
                <div class="rbt-btn-wrapper mb--20">
                    <a class="rbt-btn btn-border radius-round btn-sm hover-transform-none" href="{{ url('/admin') }}">
                        <span>Iniciar sesión</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="rbt-main-wrapper">
        @yield('principal')
        @yield('nosotros')
        @yield('contactanos')

        <footer class="rbt-footer footer-style-1">
            <div class="footer-top">
                <div class="container">
                    <div class="row row--15 mt_dec--30">
                        <div class="col-lg-4 col-md-6 col-12 mt--30">
                            <div class="footer-widget">
                                <div class="logo">
                                    <a href="{{ route('inicio') }}">
                                        <img class="conserp-brand-logo" src="{{ asset('images/images/logo-oficial-recortado.png') }}" alt="ConserpMDD">
                                    </a>
                                </div>
                                <p class="description mt--20">
                                    Consultoría en Seguridad y Salud en el Trabajo, salud ocupacional, capacitación y cumplimiento normativo.
                                </p>
                                <div class="contact-btn mt--25">
                                    <a class="rbt-btn hover-icon-reverse btn-border-gradient radius-round" href="{{ route('contactanos') }}">
                                        <span class="icon-reverse-wrapper">
                                            <span class="btn-text">Contáctanos</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-6 col-12 mt--30">
                            <div class="footer-widget">
                                <h2 class="ft-title">Navegación</h2>
                                <ul class="ft-link">
                                    <li><a href="{{ route('inicio') }}">Inicio</a></li>
                                    <li><a href="{{ route('services.index') }}">Servicios</a></li>
                                    <li><a href="{{ route('inicio') }}#cursos">Cursos</a></li>
                                    <li><a href="{{ route('nosotros') }}">Nosotros</a></li>
                                    <li><a href="{{ route('certificates.index') }}">Verificar certificado</a></li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mt--30">
                            <div class="footer-widget">
                                <h2 class="ft-title">Servicios</h2>
                                <ul class="ft-link">
                                    @foreach (array_slice($siteContent->services(), 0, 5, true) as $slug => $service)
                                        <li><a href="{{ route('services.show', $slug) }}">{{ $service['short_title'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mt--30">
                            <div class="footer-widget">
                                <h2 class="ft-title">Contacto</h2>
                                <ul class="ft-link">
                                    <li><span>Teléfonos:</span> <a href="tel:+51982604441">982 604 441</a> / <a href="tel:+51941460400">941 460 400</a></li>
                                    <li><span>WhatsApp:</span> <a href="https://wa.me/51982604441" target="_blank" rel="noopener">Escríbenos</a></li>
                                    <li><span>Email:</span> <a href="mailto:consultas@conserp.com">consultas@conserp.com</a></li>
                                    <li><span>Dirección:</span> Jr. 28 de Julio N.° 440, Puerto Maldonado, Perú</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <div class="rbt-separator-mid"><div class="container"><hr class="rbt-separator m-0"></div></div>
        <div class="copyright-area copyright-style-1 ptb--20">
            <div class="container">
                <p class="rbt-link-hover text-center text-lg-start">ConserpMDD © {{ now()->year }}</p>
            </div>
        </div>
    </main>

    <div class="whatsapp-button" style="margin-right: 5px;">
        <a href="https://wa.me/51982604441" target="_blank" rel="noopener" aria-label="Contactar por WhatsApp">
            <img src="{{ asset('images/images/whatssap.png') }}" alt="WhatsApp">
        </a>
    </div>
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
        </svg>
    </div>

    <script src="{{ asset('js/modernizr.min.js') }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sal.js') }}"></script>
    <script src="{{ asset('js/swiper.js') }}"></script>
    <script src="{{ asset('js/magnify.min.js') }}"></script>
    <script src="{{ asset('js/jquery-appear.js') }}"></script>
    <script src="{{ asset('js/odometer.js') }}"></script>
    <script src="{{ asset('js/backtotop.js') }}"></script>
    <script src="{{ asset('js/isotop.js') }}"></script>
    <script src="{{ asset('js/imageloaded.js') }}"></script>
    <script src="{{ asset('js/wow.js') }}"></script>
    <script src="{{ asset('js/waypoint.min.js') }}"></script>
    <script src="{{ asset('js/easypie.js') }}"></script>
    <script src="{{ asset('js/text-type.js') }}"></script>
    <script src="{{ asset('js/jquery-one-page-nav.js') }}"></script>
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/magnify-popup.min.js') }}"></script>
    <script src="{{ asset('js/paralax-scroll.js') }}"></script>
    <script src="{{ asset('js/paralax.min.js') }}"></script>
    <script src="{{ asset('js/countdown.js') }}"></script>
    <script src="{{ asset('js/plyr.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
