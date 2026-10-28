<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'Conserp | MDD')</title>
    <meta name="robots" content="noindex, follow">
    <meta name="description" content>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/images/favicon.png') }}">

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
        <div class="rbt-header-wrapper header-space-betwween header-sticky">
            <div class="container-fluid">
                <div class="mainbar-row rbt-navigation-center align-items-center">
                    <div class="header-left rbt-header-content">
                        <div class="header-info">
                            <div class="logo">
                                <a href="{{ route('inicio') }}">
                                    <img src="{{ asset('images/images/logo.png') }}" alt="Conserp MDD">
                                </a>
                            </div>
                        </div>
                        {{-- <div class="header-info">
                            <div class="rbt-category-menu-wrapper">
                                <div class="rbt-category-btn rbt-side-offcanvas-activation">
                                    <div class="rbt-offcanvas-trigger md-size icon">
                                        <span class="d-none d-xl-block">
                                            <i class="feather-grid"></i>
                                        </span>
                                        <i title="Category" class="feather-grid d-block d-xl-none"></i>
                                    </div>
                                    <span class="category-text d-none d-xl-block">Category</span>
                                </div>

                                <div class="category-dropdown-menu d-none d-xl-block">
                                    <div class="category-menu-item">
                                        <div class="rbt-vertical-nav">
                                            <ul class="rbt-vertical-nav-list-wrapper vertical-nav-menu">
                                                <li class="vertical-nav-item active">
                                                    <a href="#tab1">Course School</a>
                                                </li>
                                                <li class="vertical-nav-item">
                                                    <a href="#tab2">Online School</a>
                                                </li>
                                                <li class="vertical-nav-item">
                                                    <a href="#tab3">kindergarten</a>
                                                </li>
                                                <li class="vertical-nav-item">
                                                    <a href="#tab4">Classic LMS</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="rbt-vertical-nav-content">
                                            <!-- Start One Item  -->
                                            <div class="rbt-vertical-inner tab-content" id="tab1"
                                                style="display: block">
                                                <div class="rbt-vertical-single">
                                                    <div class="row">
                                                        <div class="col-lg-6 col-sm-6 col-6">
                                                            <div class="vartical-nav-content-menu">
                                                                <h3 class="rbt-short-title">Course Title</h3>
                                                                <ul class="rbt-vertical-nav-list-wrapper">
                                                                    <li><a href="#">Web Design</a></li>
                                                                    <li><a href="#">Art</a></li>
                                                                    <li><a href="#">Figma</a></li>
                                                                    <li><a href="#">Adobe</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6 col-sm-6 col-6">
                                                            <div class="vartical-nav-content-menu">
                                                                <h3 class="rbt-short-title">Course Title</h3>
                                                                <ul class="rbt-vertical-nav-list-wrapper">
                                                                    <li><a href="#">Photo</a></li>
                                                                    <li><a href="#">English</a></li>
                                                                    <li><a href="#">Math</a></li>
                                                                    <li><a href="#">Read</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End One Item  -->

                                            <!-- Start One Item  -->
                                            <div class="rbt-vertical-inner tab-content" id="tab2">
                                                <div class="rbt-vertical-single">
                                                    <div class="row">
                                                        <div class="col-lg-6">
                                                            <div class="vartical-nav-content-menu">
                                                                <h3 class="rbt-short-title">Course Title</h3>
                                                                <ul class="rbt-vertical-nav-list-wrapper">
                                                                    <li><a href="#">Photo</a></li>
                                                                    <li><a href="#">English</a></li>
                                                                    <li><a href="#">Math</a></li>
                                                                    <li><a href="#">Read</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <div class="vartical-nav-content-menu">
                                                                <h3 class="rbt-short-title">Course Title</h3>
                                                                <ul class="rbt-vertical-nav-list-wrapper">
                                                                    <li><a href="#">Web Design</a></li>
                                                                    <li><a href="#">Art</a></li>
                                                                    <li><a href="#">Figma</a></li>
                                                                    <li><a href="#">Adobe</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End One Item  -->

                                            <!-- Start One Item  -->
                                            <div class="rbt-vertical-inner tab-content" id="tab3">
                                                <div class="rbt-vertical-single">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="vartical-nav-content-menu">
                                                                <h3 class="rbt-short-title">Course Title</h3>
                                                                <ul class="rbt-vertical-nav-list-wrapper">
                                                                    <li><a href="#">Photo</a></li>
                                                                    <li><a href="#">English</a></li>
                                                                    <li><a href="#">Math</a></li>
                                                                </ul>
                                                                <div class="read-more-btn">
                                                                    <a class="rbt-btn-link" href="#">Learn
                                                                        More<i class="feather-arrow-right"></i></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End One Item  -->

                                            <!-- Start One Item  -->
                                            <div class="rbt-vertical-inner tab-content" id="tab4">
                                                <div class="rbt-vertical-single">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="vartical-nav-content-menu">
                                                                <h3 class="rbt-short-title">Course Title</h3>
                                                                <ul class="rbt-vertical-nav-list-wrapper">
                                                                    <li><a href="#">Photo</a></li>
                                                                    <li><a href="#">English</a></li>
                                                                    <li><a href="#">Math</a></li>
                                                                    <li><a href="#">Read</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- End One Item  -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                    <div class="rbt-main-navigation d-none d-xl-block">
                        <nav class="mainmenu-nav" aria-label="Navegación principal">
                            @include('recursos.menu')
                        </nav>
                    </div>

                    <div class="header-right">

                        <!-- Botón de inicio de sesión -->
                        <div class="rbt-btn-wrapper d-none d-xl-block">
                            <a class="rbt-btn btn-border radius-round btn-sm hover-transform-none" href="{{ url('/admin') }}"
                                aria-label="Iniciar sesión">
                                <span data-text="Iniciar sesión">Iniciar sesión</span>
                            </a>
                        </div>

                        <!-- Menú hamburguesa para móvil -->
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
            <!-- Start Search Dropdown  -->
            <div class="rbt-search-dropdown">
                <div class="wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <form action="#">
                                <input type="text" placeholder="What are you looking for?">
                                <div class="submit-btn">
                                    <a class="rbt-btn btn-gradient btn-md" href="#">Search</a>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="rbt-separator-mid">
                        <hr class="rbt-separator m-0">
                    </div>

                    <div class="row g-4 pt--30 pb--60">
                        <div class="col-lg-12">
                            <div class="section-title">
                                <h5 class="rbt-title-style-2">Our Top Course</h5>
                            </div>
                        </div>

                        <!-- Start Single Card  -->
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="rbt-card variation-01 rbt-hover">
                                <div class="rbt-card-img">
                                    <a href="course-details.html">
                                        <img src="images/course-online-01.jpg" alt="Card image">
                                    </a>
                                </div>
                                <div class="rbt-card-body">
                                    <h5 class="rbt-card-title"><a href="course-details.html">React Js</a>
                                    </h5>
                                    <div class="rbt-review">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count"> (15 Reviews)</span>
                                    </div>
                                    <div class="rbt-card-bottom">
                                        <div class="rbt-price">
                                            <span class="current-price">$15</span>
                                            <span class="off-price">$25</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Card  -->

                        <!-- Start Single Card  -->
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="rbt-card variation-01 rbt-hover">
                                <div class="rbt-card-img">
                                    <a href="course-details.html">
                                        <img src="images/course-online-02.jpg" alt="Card image">
                                    </a>
                                </div>
                                <div class="rbt-card-body">
                                    <h5 class="rbt-card-title"><a href="course-details.html">Java Program</a>
                                    </h5>
                                    <div class="rbt-review">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count"> (15 Reviews)</span>
                                    </div>
                                    <div class="rbt-card-bottom">
                                        <div class="rbt-price">
                                            <span class="current-price">$10</span>
                                            <span class="off-price">$40</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Card  -->

                        <!-- Start Single Card  -->
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="rbt-card variation-01 rbt-hover">
                                <div class="rbt-card-img">
                                    <a href="course-details.html">
                                        <img src="images/course-online-03.jpg" alt="Card image">
                                    </a>
                                </div>
                                <div class="rbt-card-body">
                                    <h5 class="rbt-card-title"><a href="course-details.html">Web Design</a>
                                    </h5>
                                    <div class="rbt-review">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count"> (15 Reviews)</span>
                                    </div>
                                    <div class="rbt-card-bottom">
                                        <div class="rbt-price">
                                            <span class="current-price">$10</span>
                                            <span class="off-price">$20</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Card  -->

                        <!-- Start Single Card  -->
                        <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                            <div class="rbt-card variation-01 rbt-hover">
                                <div class="rbt-card-img">
                                    <a href="course-details.html">
                                        <img src="images/course-online-04.jpg" alt="Card image">
                                    </a>
                                </div>
                                <div class="rbt-card-body">
                                    <h5 class="rbt-card-title"><a href="course-details.html">Web Design</a>
                                    </h5>
                                    <div class="rbt-review">
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                        </div>
                                        <span class="rating-count"> (15 Reviews)</span>
                                    </div>
                                    <div class="rbt-card-bottom">
                                        <div class="rbt-price">
                                            <span class="current-price">$20</span>
                                            <span class="off-price">$40</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Single Card  -->
                    </div>

                </div>
            </div>
            <!-- End Search Dropdown  -->
        </div>
        <!-- Start Side Vav -->
        <div class="rbt-offcanvas-side-menu rbt-category-sidemenu">
            <div class="inner-wrapper">
                <div class="inner-top">
                    <div class="inner-title">
                        <h4 class="title">Course Category</h4>
                    </div>
                    <div class="rbt-btn-close">
                        <button class="rbt-close-offcanvas rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </div>
                <nav class="side-nav w-100">
                    <ul class="rbt-vertical-nav-list-wrapper vertical-nav-menu">
                        <li class="vertical-nav-item">
                            <a href="#">Course School</a>
                            <div class="vartical-nav-content-menu-wrapper">
                                <div class="vartical-nav-content-menu">
                                    <h3 class="rbt-short-title">Course Title</h3>
                                    <ul class="rbt-vertical-nav-list-wrapper">
                                        <li><a href="#">Web Design</a></li>
                                        <li><a href="#">Art</a></li>
                                        <li><a href="#">Figma</a></li>
                                        <li><a href="#">Adobe</a></li>
                                    </ul>
                                </div>
                                <div class="vartical-nav-content-menu">
                                    <h3 class="rbt-short-title">Course Title</h3>
                                    <ul class="rbt-vertical-nav-list-wrapper">
                                        <li><a href="#">Photo</a></li>
                                        <li><a href="#">English</a></li>
                                        <li><a href="#">Math</a></li>
                                        <li><a href="#">Read</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="vertical-nav-item">
                            <a href="#">Online School</a>
                            <div class="vartical-nav-content-menu-wrapper">
                                <div class="vartical-nav-content-menu">
                                    <h3 class="rbt-short-title">Course Title</h3>
                                    <ul class="rbt-vertical-nav-list-wrapper">
                                        <li><a href="#">Photo</a></li>
                                        <li><a href="#">English</a></li>
                                        <li><a href="#">Math</a></li>
                                        <li><a href="#">Read</a></li>
                                    </ul>
                                </div>
                                <div class="vartical-nav-content-menu">
                                    <h3 class="rbt-short-title">Course Title</h3>
                                    <ul class="rbt-vertical-nav-list-wrapper">
                                        <li><a href="#">Web Design</a></li>
                                        <li><a href="#">Art</a></li>
                                        <li><a href="#">Figma</a></li>
                                        <li><a href="#">Adobe</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="vertical-nav-item">
                            <a href="#">kindergarten</a>
                            <div class="vartical-nav-content-menu-wrapper">
                                <div class="vartical-nav-content-menu">
                                    <h3 class="rbt-short-title">Course Title</h3>
                                    <ul class="rbt-vertical-nav-list-wrapper">
                                        <li><a href="#">Photo</a></li>
                                        <li><a href="#">English</a></li>
                                        <li><a href="#">Math</a></li>
                                        <li><a href="#">Read</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="vertical-nav-item">
                            <a href="#">Classic LMS</a>
                            <div class="vartical-nav-content-menu-wrapper">
                                <div class="vartical-nav-content-menu">
                                    <h3 class="rbt-short-title">Course Title</h3>
                                    <ul class="rbt-vertical-nav-list-wrapper">
                                        <li><a href="#">Web Design</a></li>
                                        <li><a href="#">Art</a></li>
                                        <li><a href="#">Figma</a></li>
                                        <li><a href="#">Adobe</a></li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="read-more-btn">
                        <div class="rbt-btn-wrapper mt--20">
                            <a class="rbt-btn btn-border-gradient radius-round btn-sm hover-transform-none w-100 justify-content-center text-center"
                                href="#">
                                <span>Learn More</span>
                            </a>
                        </div>
                    </div>
                </nav>
                <div class="rbt-offcanvas-footer">

                </div>
            </div>
        </div>
        <!-- End Side Vav -->
        <a class="rbt-close_side_menu" href="javascript:void(0);"></a>
    </header>


    <!-- Mobile Menu Section -->
    <div class="popup-mobile-menu">
        <div class="inner-wrapper">
            <div class="inner-top">
                <div class="content">
                    <div class="logo">
                        <a href="{{ route('inicio') }}">
                            <img src="{{ asset('images/images/logo.png') }}" alt="Conserp MDD">
                        </a>
                    </div>
                    <div class="rbt-btn-close">
                        <button class="close-button rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </div>
                <p class="description">Fortalece tu empresa
                    con sistemas de gestión certificados</p>
                <ul class="navbar-top-left rbt-information-list justify-content-start">
                    <li>
                        <a href="mailto:hello@example.com"><i class="feather-mail"></i>example@gmail.com</a>
                    </li>
                    <li>
                        <a href="#"><i class="feather-phone"></i>(302) 555-0107</a>
                    </li>
                </ul>
            </div>

            <nav class="mainmenu-nav" aria-label="Navegación principal">
                            @include('recursos.menu')
                        </nav>

            <div class="mobile-menu-bottom">
                <div class="rbt-btn-wrapper mb--20">
                    <a class="rbt-btn btn-border radius-round btn-sm hover-transform-none" href="{{ url('/admin') }}">
                        <span>Iniciar sesión</span>
                    </a>
                </div>


                <div class="social-share-wrapper">
                    <span class="rbt-short-title d-block">Buscanos</span>
                    <ul class="social-icon social-default transparent-with-border justify-content-start mt--20">
                        <li><a href="https://www.facebook.com/">
                                <i class="feather-facebook"></i>
                            </a>
                        </li>
                        <li><a href="https://www.twitter.com">
                                <i class="feather-twitter"></i>
                            </a>
                        </li>
                        <li><a href="https://www.instagram.com/">
                                <i class="feather-instagram"></i>
                            </a>
                        </li>
                        <li><a href="https://www.linkdin.com/">
                                <i class="feather-linkedin"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <!-- Start Side Vav -->
    <div class="rbt-cart-side-menu">
        <div class="inner-wrapper">
            <div class="inner-top">
                <div class="content">
                    <div class="title">
                        <h4 class="title mb--0">Your shopping cart</h4>
                    </div>
                    <div class="rbt-btn-close" id="btn_sideNavClose">
                        <button class="minicart-close-button rbt-round-btn"><i class="feather-x"></i></button>
                    </div>
                </div>
            </div>
            <nav class="side-nav w-100">
                <ul class="rbt-minicart-wrapper">
                    <li class="minicart-item">
                        <div class="thumbnail">
                            <a href="#">
                                <img src="images/1.jpg" alt="Product Images">
                            </a>
                        </div>
                        <div class="product-content">
                            <h6 class="title"><a href="single-product.html">Miracle Morning</a></h6>

                            <span class="quantity">1 * <span class="price">$22</span></span>
                        </div>
                        <div class="close-btn">
                            <button class="rbt-round-btn"><i class="feather-x"></i></button>
                        </div>
                    </li>

                    <li class="minicart-item">
                        <div class="thumbnail">
                            <a href="#">
                                <img src="images/7.jpg" alt="Product Images">
                            </a>
                        </div>
                        <div class="product-content">
                            <h6 class="title"><a href="single-product.html">Happy Strong</a></h6>

                            <span class="quantity">1 * <span class="price">$30</span></span>
                        </div>
                        <div class="close-btn">
                            <button class="rbt-round-btn"><i class="feather-x"></i></button>
                        </div>
                    </li>

                    <li class="minicart-item">
                        <div class="thumbnail">
                            <a href="#">
                                <img src="images/3.jpg" alt="Product Images">
                            </a>
                        </div>
                        <div class="product-content">
                            <h6 class="title"><a href="single-product.html">Rich Dad Poor Dad</a></h6>

                            <span class="quantity">1 * <span class="price">$50</span></span>
                        </div>
                        <div class="close-btn">
                            <button class="rbt-round-btn"><i class="feather-x"></i></button>
                        </div>
                    </li>

                    <li class="minicart-item">
                        <div class="thumbnail">
                            <a href="#">
                                <img src="images/4.jpg" alt="Product Images">
                            </a>
                        </div>
                        <div class="product-content">
                            <h6 class="title"><a href="single-product.html">Momentum Theorem</a></h6>

                            <span class="quantity">1 * <span class="price">$50</span></span>
                        </div>
                        <div class="close-btn">
                            <button class="rbt-round-btn"><i class="feather-x"></i></button>
                        </div>
                    </li>
                </ul>
            </nav>

            <div class="rbt-minicart-footer">
                <hr class="mb--0">
                <div class="rbt-cart-subttotal">
                    <p class="subtotal"><strong>Subtotal:</strong></p>
                    <p class="price">$121</p>
                </div>
                <hr class="mb--0">
                <div class="rbt-minicart-bottom mt--20">
                    <div class="view-cart-btn">
                        <a class="rbt-btn btn-border icon-hover w-100 text-center" href="#">
                            <span class="btn-text">View Cart</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </a>
                    </div>
                    <div class="checkout-btn mt--20">
                        <a class="rbt-btn btn-gradient icon-hover w-100 text-center" href="#">
                            <span class="btn-text">Checkout</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Side Vav -->
    <a class="close_side_menu" href="javascript:void(0);"></a>


    <main class="rbt-main-wrapper">

        {{-- vistas --}}

        @yield('principal')
        @yield('nosotros')
        @yield('contactanos')
        {{-- vistas --}}


        <!-- Start Footer aera -->
        <footer class="rbt-footer footer-style-1">
            <div class="footer-top">
                <div class="container">
                    <div class="row row--15 mt_dec--30">

                        <!-- LOGO Y DESCRIPCIÓN -->
                        <div class="col-lg-4 col-md-6 col-sm-6 col-12 mt--30">
                            <div class="footer-widget">
                                <div class="logo">
                                    <a href="{{ route('inicio') }}">
                                        <img src="{{ asset('images/images/logo.png') }}" alt="Conserp MDD">
                                    </a>
                                </div>

                                <p class="description mt--20">
                                    Consultoría especializada en sistemas de Gestión de Seguridad y Salud en el Trabajo,
                                    Normas ISO y cumplimiento normativo. Comprometidos con la excelencia y mejora
                                    continua.
                                </p>

                                <div class="contact-btn mt--30">
                                    <a class="rbt-btn hover-icon-reverse btn-border-gradient radius-round"
                                        href="{{ route('contactanos') }}">
                                        <div class="icon-reverse-wrapper">
                                            <span class="btn-text">Contáctanos</span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- ENLACES ÚTILES -->
                        <div class="offset-lg-1 col-lg-2 col-md-6 col-sm-6 col-12 mt--30">
                            <div class="footer-widget">
                                <h5 class="ft-title">Enlaces Útiles</h5>
                                <ul class="ft-link">
                                    <li><a href="{{ route('inicio') }}">Inicio</a></li>
                                    <li><a href="{{ route('nosotros') }}">Nosotros</a></li>
                                    <li><a href="{{ route('contactanos') }}">Contáctanos</a></li>
                                    <li><a href="#">Servicios</a></li>
                                    <li><a href="#">Clientes</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- SOBRE NOSOTROS -->
                        <div class="col-lg-2 col-md-6 col-sm-6 col-12 mt--30">
                            <div class="footer-widget">
                                <h5 class="ft-title">La Empresa</h5>
                                <ul class="ft-link">
                                    <li><a href="#">Misión y Visión</a></li>
                                    <li><a href="#">Valores</a></li>
                                    <li><a href="#">Normas ISO</a></li>
                                    <li><a href="#">Preguntas Frecuentes</a></li>
                                    <li><a href="#">Trabaja con Nosotros</a></li>
                                </ul>
                            </div>
                        </div>

                        <!-- CONTACTO -->
                        <div class="col-lg-3 col-md-6 col-sm-6 col-12 mt--30">
                            <div class="footer-widget">
                                <h5 class="ft-title">Contáctanos</h5>
                                <ul class="ft-link">
                                    <li><span>Teléfonos:</span> <a href="#">982604441 / 941460400</a></li>
                                    <li><span>WhatsApp:</span> <a href="#">992288186 / 918392711</a></li>
                                    <li><span>Email:</span> <a
                                            href="mailto:consultas@conserp.com">consultas@conserp.com</a></li>
                                    <li><span>Dirección:</span> Jr. 28 de Julio N°440, Puerto Maldonado - Perú</li>
                                </ul>
                                <ul class="social-icon social-default icon-naked justify-content-start mt--20">
                                    <li><a href="https://www.facebook.com/">
                                            <i class="feather-facebook"></i>
                                        </a>
                                    </li>
                                    <li><a href="https://www.instagram.com/">
                                            <i class="feather-instagram"></i>
                                        </a>
                                    </li>
                                    <li><a href="https://www.linkedin.com/">
                                            <i class="feather-linkedin"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </footer>

        <!-- End Footer aera -->
        <div class="rbt-separator-mid">
            <div class="container">
                <hr class="rbt-separator m-0">
            </div>
        </div>
        <!-- Start Copyright Area  -->
        <div class="copyright-area copyright-style-1 ptb--20">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-12">
                        <p class="rbt-link-hover text-center text-lg-start">Conserp © 2025
                        </p>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Copyright Area  -->

    </main>
    <div class="whatsapp-button" style="margin-right: 5px;">
        <a href="https://wa.me/51982604441" target="_blank">
            <img src="images/images/whatssap.png" alt="WhatsApp" />
        </a>
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
<script>
var swiper = new Swiper(".banner-swiper-active", {
    effect: "cards",
    grabCursor: true,
    loop: false,  // ← IMPORTANTE: NO usar loop real
    cardsEffect: {
        slideShadows: false
    },

    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },

    pagination: {
        el: ".rbt-swiper-pagination",
        clickable: true,
    },

    on: {
        slideChange: function () {
            // Si llegó al último → volver al primero
            if (this.activeIndex === this.slides.length ) {
                setTimeout(() => {
                    swiper.slideTo(0, 0); // sin animación
                }, 10);
            }
        }
    }
});
</script>
</html>
