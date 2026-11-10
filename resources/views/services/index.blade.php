@extends('recursos.barras')
@section('title', 'Servicios de Seguridad y Salud en el Trabajo | ConserpMDD')
@section('description', 'Servicios de SST, salud ocupacional, monitoreos, capacitaciones, emergencias y asesoría para el sector minero en Puerto Maldonado y Madre de Dios.')
@section('principal')
    <section class="rbt-breadcrumb-default rbt-breadcrumb-style-3 bg-gradient-1">
        <div class="breadcrumb-inner">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <div class="content text-center">
                            <span class="subtitle bg-primary-opacity">ConserpMDD</span>
                            <h1 class="title">Servicios de Seguridad y Salud en el Trabajo</h1>
                            <p class="description mt--20">Soluciones para prevenir riesgos, cuidar a tus trabajadores y mantener el cumplimiento de tu empresa.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="rbt-categories-area bg-color-white rbt-section-gap">
        <div class="container">
            <div class="row g-5">
                @foreach ($services as $slug => $service)
                    <div class="col-lg-4 col-md-6 col-12">
                        <a class="rbt-cat-box rbt-cat-box-1 text-center h-100" href="{{ route('services.show', $slug) }}">
                            <div class="inner h-100">
                                <div class="conserp-service-photo">
                                    <img src="{{ $siteContent->imageUrl($service['image']) }}" alt="{{ $service['short_title'] }}" loading="lazy">
                                </div>
                                <div class="content">
                                    <h2 class="title" style="font-size: 20px; line-height: 1.35;">{{ $service['short_title'] }}</h2>
                                    <p class="description mt--15">{{ $service['summary'] }}</p>
                                    <div class="read-more-btn mt--15">
                                        <span class="rbt-btn-link">Ver servicio <i class="feather-arrow-right"></i></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('recursos.iso')
@endsection
