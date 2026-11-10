<section class="rbt-categories-area bg-color-extra2 rbt-section-gap" id="sistemas-iso">
    <div class="container">
        <div class="row align-items-end mb--30">
            <div class="col-lg-8">
                <div class="section-title text-start">
                    <span class="subtitle bg-primary-opacity">{{ $siteContent->value('iso_section.eyebrow') }}</span>
                    <h2 class="title">{{ $siteContent->value('iso_section.title') }}</h2>
                    <p class="description mt--15">{{ $siteContent->value('iso_section.description') }}</p>
                </div>
            </div>
            <div class="col-lg-4 text-lg-end mt_md--20 mt_sm--20">
                <a class="rbt-btn-link" href="{{ route('contactanos') }}">Consultar por una norma ISO <i class="feather-arrow-right"></i></a>
            </div>
        </div>
        <div class="row g-4">
            @foreach ($siteContent->standards() as $standard)
                <div class="col-lg-2 col-md-4 col-6" id="iso-{{ $standard['number'] }}">
                    <a class="rbt-cat-box rbt-cat-box-1 text-center h-100" href="{{ route('contactanos') }}">
                        <div class="inner h-100">
                            <div class="icons"><img src="{{ $siteContent->imageUrl($standard['image']) }}" alt="ISO {{ $standard['number'] }}" style="height: 70px; width: 100%; object-fit: contain;"></div>
                            <div class="content"><h3 class="title" style="font-size: 16px; line-height: 1.3;">ISO {{ $standard['number'] }}</h3><p class="description" style="font-size: 13px;">{{ $standard['name'] }}</p></div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>
