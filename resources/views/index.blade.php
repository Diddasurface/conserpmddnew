@extends('recursos.barras')
@section('title', 'ConserpMDD | Seguridad y Salud en el Trabajo')
@section('description', 'Consultoría en Seguridad y Salud en el Trabajo, salud ocupacional, monitoreos, capacitaciones y cumplimiento legal en Puerto Maldonado y Madre de Dios.')
@section('principal')

    <section class="rbt-banner-area rbt-banner-1">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pb--120 pt--20">
                    <div class="content">
                        <div class="inner">
                            <div class="rbt-new-badge rbt-new-badge-one">
                                <span class="rbt-new-badge-icon">✓</span> {{ $siteContent->value('hero.badge') }}
                            </div>
                            <h1 class="title">{!! nl2br(e($siteContent->value('hero.title'))) !!}</h1>
                            <p class="description">
                                {{ $siteContent->value('hero.description') }}<br>
                                <strong>{{ $siteContent->value('hero.highlight') }}</strong>
                            </p>
                            <div class="slider-btn d-flex flex-wrap gap-3">
                                <a class="rbt-btn btn-gradient hover-icon-reverse" href="{{ route('services.index') }}">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Conocer nuestros servicios</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                                <a class="rbt-btn btn-border-gradient radius-round" href="{{ route('contactanos') }}">Solicitar asesoría</a>
                            </div>
                        </div>
                        <div class="shape-wrapper" id="scene">
                            <img src="{{ $siteContent->imageUrl($siteContent->value('hero.image')) }}"
                                alt="Especialista en Seguridad y Salud en el Trabajo">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="rbt-categories-area bg-color-white rbt-section-gap" id="servicios">
        <div class="container">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="section-title text-start">
                        <span class="subtitle bg-primary-opacity">{{ $siteContent->value('services_section.eyebrow') }}</span>
                        <h2 class="title">{{ $siteContent->value('services_section.title') }}</h2>
                        <p class="description mt--15">{{ $siteContent->value('services_section.description') }}</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt_md--20 mt_sm--20">
                    <a class="rbt-btn-link" href="{{ route('services.index') }}">Ver todos los servicios <i class="feather-arrow-right"></i></a>
                </div>
            </div>
            <div class="row g-5 mt--20">
                @foreach (array_slice($services, 0, 6, true) as $slug => $service)
                    <div class="col-lg-4 col-md-6 col-12">
                        <a class="rbt-cat-box rbt-cat-box-1 text-center h-100" href="{{ route('services.show', $slug) }}">
                            <div class="inner h-100">
                                <div class="conserp-service-photo">
                                    <img src="{{ $siteContent->imageUrl($service['image']) }}" alt="{{ $service['short_title'] }}" loading="lazy">
                                </div>
                                <div class="content">
                                    <h3 class="title" style="font-size: 18px; line-height: 1.35;">{{ $service['short_title'] }}</h3>
                                    <p class="description mt--10" style="font-size: 14px;">{{ $service['summary'] }}</p>
                                    <div class="read-more-btn">
                                        <span class="rbt-btn-link">Conocer más <i class="feather-arrow-right"></i></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt--40">
                <a class="rbt-btn btn-gradient" href="{{ route('services.index') }}">Explorar los 9 servicios</a>
            </div>
        </div>
    </section>

    @include('recursos.cursos')

    <section class="rbt-about-area bg-color-white rbt-section-gap about-style-1">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5 text-center">
                    <img class="conserp-about-photo" src="{{ $siteContent->imageUrl($siteContent->value('about.image')) }}"
                        alt="Equipo de trabajo durante una jornada de consultoría" loading="lazy">
                </div>
                <div class="col-lg-7">
                    <div class="inner pl--50 pl_sm--0 pl_md--0">
                        <div class="section-title text-start">
                            <span class="subtitle bg-coral-opacity">{{ $siteContent->value('about.eyebrow') }}</span>
                            <h2 class="title">{{ $siteContent->value('about.title') }}</h2>
                        </div>
                        <p class="description mt--25">
                            {{ $siteContent->value('about.description') }}
                        </p>
                        <div class="row g-4 mt--10">
                            <div class="col-md-6">
                                <div class="service-card service-card-6 bg-color bg-card-color-1 h-100">
                                    <div class="inner">
                                        <div class="content">
                                            <h3 class="title">Nuestra misión</h3>
                                            <p class="description">{{ $siteContent->value('about.mission') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="service-card service-card-6 bg-color bg-card-color-2 h-100">
                                    <div class="inner">
                                        <div class="content">
                                            <h3 class="title">Nuestra visión</h3>
                                            <p class="description">{{ $siteContent->value('about.vision') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="about-btn mt--35">
                            <a class="rbt-btn btn-gradient hover-icon-reverse" href="{{ route('nosotros') }}">
                                <span class="icon-reverse-wrapper">
                                    <span class="btn-text">Conoce ConserpMDD</span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('recursos.clientes')

    @include('recursos.iso')

    <section class="rbt-call-to-action-area rbt-section-gap bg-gradient-8">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="section-title text-start">
                        <span class="subtitle bg-white-opacity">¿NO SABES POR DÓNDE COMENZAR?</span>
                        <h2 class="title color-white">Conversemos sobre las necesidades de tu empresa</h2>
                        <p class="description color-white mt--15">Te orientamos para identificar los servicios y acciones que deben atenderse primero.</p>
                    </div>
                </div>
                <div class="col-lg-4 text-lg-end mt_md--25 mt_sm--25">
                    <a class="rbt-btn btn-white hover-icon-reverse" href="{{ route('contactanos') }}">
                        <span class="icon-reverse-wrapper">
                            <span class="btn-text">Solicitar orientación</span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                            <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new Swiper('.client-logo-swiper', {
                loop: true,
                speed: 700,
                spaceBetween: 24,
                slidesPerView: 2,
                autoplay: {
                    delay: 1800,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
                breakpoints: {
                    576: { slidesPerView: 3 },
                    768: { slidesPerView: 4 },
                    1200: { slidesPerView: 6 }
                }
            });
        });
    </script>
@endpush
