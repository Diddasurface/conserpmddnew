@php
    $pageTitle = trim($__env->yieldContent('title', 'ConserpMDD | Seguridad y Salud en el Trabajo y Normas ISO'));
    $description = trim($__env->yieldContent('description', config('seo.description')));
    $siteUrl = rtrim(config('seo.url'), '/');
    $canonical = $siteUrl.'/'.ltrim(request()->path(), '/');
    $indexable = config('app.env') === 'production';
    $structuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            [
                '@type' => 'Organization',
                '@id' => $siteUrl.'/#organization',
                'name' => 'ConserpMDD',
                'url' => $siteUrl.'/',
                'logo' => $siteUrl.'/images/images/logo.png',
                'telephone' => '+51982604441',
                'description' => config('seo.description'),
            ],
            [
                '@type' => 'WebSite',
                '@id' => $siteUrl.'/#website',
                'url' => $siteUrl.'/',
                'name' => 'ConserpMDD',
                'inLanguage' => 'es-PE',
                'publisher' => ['@id' => $siteUrl.'/#organization'],
            ],
        ],
    ];
@endphp
<title>{{ $pageTitle }}</title>
<meta name="robots" content="{{ $indexable ? 'index, follow, max-image-preview:large' : 'noindex, nofollow' }}">
<meta name="description" content="{{ $description }}">
<link rel="canonical" href="{{ $canonical }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="es_PE">
<meta property="og:site_name" content="ConserpMDD">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $siteUrl }}/images/images/favicon.png">
<meta property="og:image:alt" content="ConserpMDD">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $description }}">
<meta name="twitter:image" content="{{ $siteUrl }}/images/images/favicon.png">
@if (config('seo.google_verification'))
    <meta name="google-site-verification" content="{{ config('seo.google_verification') }}">
@endif
<script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) !!}</script>
