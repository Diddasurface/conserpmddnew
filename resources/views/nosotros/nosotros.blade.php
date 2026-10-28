@extends('recursos.barras')
@section('title', 'Nosotros | ConserpMDD')
@section('description', 'Conoce a ConserpMDD y nuestra asesoría en seguridad y salud en el trabajo, cumplimiento legal y sistemas integrados de gestión para empresas en Perú.')
@section('nosotros')
    {{-- aqui prry --}}
    <div class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="content">
                        <img src="images/about-06.png" alt="About Images">
                    </div>
                </div>
                <div class="col-lg-6" data-sal="slide-up" data-sal-duration="700">
                    <div class="inner pl--50 pl_sm--5">
                        <div class="section-title text-start">
                            <span class="subtitle bg-primary-opacity">Nosotros</span>
                            <h2 class="title">CONSERP MDD</h2>
                            <p class="description mt--20">
                                <strong>“Un buen servicio al cliente cuesta menos Fradel que un mal servicio al
                                    cliente”</strong>
                            </p>

                            <!-- Contenedor de Misión y Visión en columnas -->
                            <div class="row mt--20">
                                <div class="col-md-6">
                                    <h3>Misión</h3>
                                    <p class="description">
                                        Brindar servicios de calidad en consultoría, capacitación y asesoría en sistemas de
                                        gestión,
                                        con la finalidad de mejorar el nivel de competitividad en las empresas.
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h3>Visión</h3>
                                    <p class="description">
                                        Ser una de las consultorías más reconocidas a nivel nacional, garantizando el éxito
                                        en las
                                        empresas en todos los rubros económicos.
                                    </p>
                                </div>
                            </div>

                            <div class="read-more-btn mt--40">
                                <a class="rbt-btn btn-gradient radius-round" href="#">
                                    <span>Contactanos</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="rbt-service-area bg-color-white rbt-section-gapBottom">
        <div class="container">
            <div class="row row--15 mt_dec--30">
                <div class="col-lg-4 col-xl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="section-title text-start">
                        <h2 class="title">Valores</h2>
                        <p class="description mt--20">
                            En CONSERP MDD trabajamos con principios firmes que guían nuestro compromiso con la excelencia y
                            la mejora continua.
                        </p>
                        <div class="read-more-btn">
                            <a class="rbt-btn btn-gradient radius" href="#">
                                <span>Descargar</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Valor: Conocimiento -->
                <div class="col-lg-4 col-xl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-1">
                        <div class="inner">
                            <div class="icon">
                                <img src="images/service-01.png" alt="Icono Conocimiento">
                                <img class="opacity_image" src="images/service-01.png" alt="Icono Conocimiento">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Conocimiento</a></h6>
                                <p class="description">
                                    Contamos con un equipo de profesionales altamente calificados, comprometidos con la
                                    mejora continua para alcanzar el éxito en tu empresa.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Valor: Integridad -->
                <div class="col-lg-4 col-xl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-2">
                        <div class="inner">
                            <div class="icon">
                                <img src="images/service-04.png" alt="Icono Integridad">
                                <img class="opacity_image" src="images/service-04.png" alt="Icono Integridad">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Integridad</a></h6>
                                <p class="description">
                                    Nuestra estructura propia nos proporciona libertad para ser completamente objetivos.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Valor: Alto nivel de exigencia -->
                <div class="col-lg-4 col-xl-4 col-md-6 col-sm-6 col-12 mt--30">
                    <div class="service-card service-card-6 bg-color bg-card-color-3">
                        <div class="inner">
                            <div class="icon">
                                <img src="images/service-03.png" alt="Icono Exigencia">
                                <img class="opacity_image" src="images/service-03.png" alt="Icono Exigencia">
                            </div>
                            <div class="content">
                                <h6 class="title"><a href="#">Alto nivel de exigencia</a></h6>
                                <p class="description">
                                    Aunque estamos orgullosos de nuestra integridad y conocimientos, lo que más valoramos es
                                    la creación de valor y el desarrollo de una mejora continua del negocio.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Fin de tarjetas -->
            </div>
        </div>
    </div>




@endsection
