@extends('recursos.barras')
@section('title', $service['title'].' | ConserpMDD')
@section('description', $service['summary'].' Atención para empresas en Puerto Maldonado y Madre de Dios.')
@section('principal')
    <section class="rbt-breadcrumb-default rbt-breadcrumb-style-3 bg-gradient-1">
        <div class="breadcrumb-inner">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="content">
                            <span class="subtitle bg-primary-opacity">Servicio especializado</span>
                            <h1 class="title">{{ $service['title'] }}</h1>
                            <p class="description mt--20">{{ $service['summary'] }}</p>
                            <div class="slider-btn mt--30">
                                <a class="rbt-btn btn-gradient hover-icon-reverse" href="https://wa.me/51982604441?text={{ rawurlencode('Hola, deseo información sobre '.$service['short_title']) }}" target="_blank" rel="noopener">
                                    <span class="icon-reverse-wrapper">
                                        <span class="btn-text">Solicitar información</span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                        <span class="btn-icon"><i class="feather-arrow-right"></i></span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center mt_md--30 mt_sm--30">
                        <img class="conserp-service-hero" src="{{ $siteContent->imageUrl($service['image']) }}"
                            alt="{{ $service['short_title'] }}" loading="eager">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="rbt-service-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="section-title text-start">
                        <span class="subtitle bg-coral-opacity">Alcance del servicio</span>
                        <h2 class="title">¿Qué podemos desarrollar para tu empresa?</h2>
                        <p class="description mt--20">{{ $service['intro'] }}</p>
                    </div>
                    <div class="rbt-feature-wrapper mt--30">
                        @foreach ($service['includes'] as $item)
                            <div class="rbt-feature feature-style-2 rbt-radius mb--15">
                                <div class="icon bg-primary-opacity"><i class="feather-check"></i></div>
                                <div class="feature-content"><p class="feature-description mb--0">{{ $item }}</p></div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="service-card service-card-6 bg-color bg-card-color-1">
                        <div class="inner">
                            <div class="content">
                                <h3 class="title">Resultado esperado</h3>
                                <p class="description">{{ $service['benefit'] }}</p>
                                <a class="rbt-btn-link" href="{{ route('contactanos') }}">Conversemos sobre tu empresa <i class="feather-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="mt--30">
                        <h4>Otros servicios</h4>
                        <ul class="rbt-list-style-1">
                            @foreach ($services as $otherSlug => $other)
                                @if ($otherSlug !== $slug)
                                    <li><i class="feather-arrow-right"></i><a href="{{ route('services.show', $otherSlug) }}">{{ $other['short_title'] }}</a></li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('recursos.iso')
@endsection
