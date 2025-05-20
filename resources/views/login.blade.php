<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Conserp MDD</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="images/images/favicon.png">

    <!-- CSS
 ============================================ -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/slick.css">
    <link rel="stylesheet" href="css/slick-theme.css">
    <link rel="stylesheet" href="css/sal.css">
    <link rel="stylesheet" href="css/feather.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
    <link rel="stylesheet" href="css/euclid-circulara.css">
    <link rel="stylesheet" href="css/swiper.css">
    <link rel="stylesheet" href="css/magnify.css">
    <link rel="stylesheet" href="css/odometer.css">
    <link rel="stylesheet" href="css/animation.css">
    <link rel="stylesheet" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/magnigy-popup.min.css">
    <link rel="stylesheet" href="css/plyr.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body class="rbt-header-sticky">

    <!-- Start Header Area -->
    <header class="rbt-header rbt-header-10">
        <div class="rbt-sticky-placeholder"></div>
        <!-- Start Header Top  -->
        <div
            class="rbt-header-top rbt-header-top-1 header-space-betwween bg-not-transparent bg-color-darker top-expended-activation">
            <div class="container-fluid">
                <div class="top-expended-wrapper">
                    <div class="top-expended-inner rbt-header-sec align-items-center ">
                        <div class="rbt-header-sec-col rbt-header-left d-none d-xl-block">
                            <div class="rbt-header-content">
                                <!-- Start Header Information List  -->
                                <div class="header-info">
                                    <ul class="rbt-information-list">

                                        <li>
                                            <a href="#"><i class="fab fa-facebook-square"></i> <span
                                                    class="d-none d-xxl-block">Facebook</span></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="feather-phone"></i>+51 999999999</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- End Header Information List  -->
                            </div>
                        </div>
                        <div class="rbt-header-sec-col rbt-header-center">
                            <div class="rbt-header-content justify-content-start justify-content-xl-center">
                                <div class="header-info">
                                    <div class="rbt-header-top-news">
                                        <div class="inner">
                                            <div class="content">
                                                <span
                                                    class="rbt-badge variation-02 bg-color-primary color-white radius-round">Ver</span>
                                                <span class="news-text"><img src="fonts/hand-emojji.svg"
                                                        alt="Hand Emojji Images"> Mira nuestros descuentos que tenemos
                                                    para ti.</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="rbt-header-sec-col rbt-header-right mt_md--10 mt_sm--10">
                            <div class="rbt-header-content justify-content-start justify-content-lg-end">
                                <div class="header-info d-none d-xl-block">
                                    <ul class="social-share-transparent">
                                        <li>
                                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="fab fa-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="fab fa-instagram"></i></a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="rbt-separator d-none d-xl-block"></div>




                            </div>
                        </div>
                    </div>
                    <div class="header-info">
                        <div class="top-bar-expended d-block d-lg-none">
                            <button class="topbar-expend-button rbt-round-btn"><i class="feather-plus"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <div class="rbt-contact-me bg-color-white rbt-section-gapBottom">
        <div class="container">
            <div class="row mb--60">
                <div class="col-lg-12">
                    
                </div>
            </div>
            <div class="row g-5 justify-content-center">
                <div class="col-lg-6">
                    <div class="rbt-contact-form contact-form-style-1 max-width-auto">
                        <div class="section-title text-start">
                            <span class="subtitle bg-primary-opacity">Bienvenido de nuevo</span>
                        </div>
                        <h3 class="title">Accede a tu cuenta</h3>

                        @if (session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="">
                            @csrf

                            <div class="form-group">
                                <input type="email" name="email" required autofocus>
                                <label>Correo electrónico</label>
                                <span class="focus-border"></span>
                            </div>

                            <div class="form-group">
                                <input type="password" name="password" required>
                                <label>Contraseña</label>
                                <span class="focus-border"></span>
                            </div>

                            <div class="form-submit-group">
                                <button type="submit" class="rbt-btn btn-md btn-gradient hover-icon-reverse w-100">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">INICIAR SESIÓN</span>
                                        <span class="btn-icon"><i class="feather-log-in"></i></span>
                                        <span class="btn-icon"><i class="feather-log-in"></i></span>
                                    </span>
                                </button>
                            </div>
                        </form>

                        <div class="mt-3 text-center">
                            <small>¿No tienes una cuenta? <a href="#">Contáctanos</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Wrapper Area -->
    <div class="rbt-progress-parent">
        <svg class="rbt-back-circle svg-inner" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>

    <!-- JS
============================================ -->
    <!-- Modernizer JS -->
    <script src="js/modernizr.min.js"></script>
    <!-- jQuery JS -->
    <script src="js/jquery.js"></script>
    <!-- Bootstrap JS -->
    <script src="js/bootstrap.min.js"></script>
    <!-- sal.js -->
    <script src="js/sal.js"></script>
    <script src="js/swiper.js"></script>
    <script src="js/magnify.min.js"></script>
    <script src="js/jquery-appear.js"></script>
    <script src="js/odometer.js"></script>
    <script src="js/backtotop.js"></script>
    <script src="js/isotop.js"></script>
    <script src="js/imageloaded.js"></script>

    <script src="js/wow.js"></script>
    <script src="js/waypoint.min.js"></script>
    <script src="js/easypie.js"></script>
    <script src="js/text-type.js"></script>
    <script src="js/jquery-one-page-nav.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/magnify-popup.min.js"></script>
    <script src="js/paralax-scroll.js"></script>
    <script src="js/paralax.min.js"></script>
    <script src="js/countdown.js"></script>
    <script src="js/plyr.js"></script>
    <!-- Main JS -->
    <script src="js/main.js"></script>


</body>

</html>
