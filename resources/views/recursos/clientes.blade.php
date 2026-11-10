<section class="conserp-clients bg-color-extra2 rbt-section-gap overflow-hidden" aria-labelledby="clientes-title">
    <div class="container">
        <div class="row justify-content-center mb--40">
            <div class="col-lg-8">
                <div class="section-title text-center">
                    <span class="subtitle bg-primary-opacity">{{ $siteContent->value('clients_section.eyebrow') }}</span>
                    <h2 class="title" id="clientes-title">{{ $siteContent->value('clients_section.title') }}</h2>
                    <p class="description mt--15">{{ $siteContent->value('clients_section.description') }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid px-0">
        <div class="swiper client-logo-swiper">
            <div class="swiper-wrapper">
                @foreach ($siteContent->clients() as $client)
                    <div class="swiper-slide">
                        <div class="conserp-client-logo">
                            <img src="{{ $siteContent->imageUrl($client['logo']) }}"
                                alt="{{ $client['name'] }}" loading="lazy">
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
