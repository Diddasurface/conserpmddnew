@extends('recursos.barras')
@section('title', 'Nosotros | ConserpMDD')
@section('description', 'Conoce a ConserpMDD, nuestra misión, visión y valores como consultora de Seguridad y Salud en el Trabajo y sistemas de gestión en Perú.')
@section('nosotros')
    <section class="rbt-about-area about-style-1 bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <img class="conserp-about-photo" src="{{ $siteContent->imageUrl($siteContent->value('about.image')) }}"
                        alt="Capacitación empresarial desarrollada por ConserpMDD">
                </div>
                <div class="col-lg-6" data-sal="slide-up" data-sal-duration="700">
                    <div class="inner pl--40 pl_sm--0 pl_md--0">
                        <div class="section-title text-start">
                            <span class="subtitle bg-primary-opacity">{{ $siteContent->value('about.eyebrow') }}</span>
                            <h1 class="title">{{ $siteContent->value('about.title') }}</h1>
                            <p class="description mt--20">
                                {{ $siteContent->value('about.description') }}
                            </p>
                        </div>
                        <div class="row g-4 mt--10">
                            <div class="col-md-6">
                                <div class="service-card service-card-6 bg-color bg-card-color-1 h-100">
                                    <div class="inner"><div class="content">
                                        <h2 class="title">Misión</h2>
                                        <p class="description">{{ $siteContent->value('about.mission') }}</p>
                                    </div></div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="service-card service-card-6 bg-color bg-card-color-2 h-100">
                                    <div class="inner"><div class="content">
                                        <h2 class="title">Visión</h2>
                                        <p class="description">{{ $siteContent->value('about.vision') }}</p>
                                    </div></div>
                                </div>
                            </div>
                        </div>
                        <div class="read-more-btn mt--35">
                            <a class="rbt-btn btn-gradient radius-round" href="{{ route('contactanos') }}">Solicitar asesoría</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="rbt-service-area bg-color-extra2 rbt-section-gap">
        <div class="container">
            <div class="row justify-content-center mb--30">
                <div class="col-lg-8">
                    <div class="section-title text-center">
                        <span class="subtitle bg-coral-opacity">NUESTROS VALORES</span>
                        <h2 class="title">Principios que guían nuestro trabajo</h2>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-4 col-md-6">
                    <div class="service-card service-card-6 bg-color bg-card-color-1 h-100">
                        <div class="inner"><div class="content">
                            <h3 class="title">Conocimiento</h3>
                            <p class="description">Contamos con profesionales calificados y comprometidos con la mejora continua para contribuir al éxito de cada organización.</p>
                        </div></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card service-card-6 bg-color bg-card-color-2 h-100">
                        <div class="inner"><div class="content">
                            <h3 class="title">Integridad</h3>
                            <p class="description">Trabajamos con objetividad, transparencia y responsabilidad en cada diagnóstico, recomendación y servicio.</p>
                        </div></div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="service-card service-card-6 bg-color bg-card-color-3 h-100">
                        <div class="inner"><div class="content">
                            <h3 class="title">Alto nivel de exigencia</h3>
                            <p class="description">Buscamos crear valor y desarrollar mejoras continuas mediante un equipo multidisciplinario y una atención rigurosa.</p>
                        </div></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
