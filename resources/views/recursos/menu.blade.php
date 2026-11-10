<ul class="mainmenu">
    <li class="{{ request()->routeIs('inicio') ? 'active' : '' }}">
        <a href="{{ route('inicio') }}">Inicio</a>
    </li>
    <li class="has-dropdown has-menu-child-item">
        <a href="{{ route('inicio') }}#cursos">Cursos <i class="feather-chevron-down" aria-hidden="true"></i></a>
        <ul class="submenu">
            <li><a href="{{ route('inicio') }}#cursos">Ver cursos</a></li>
            <li><a href="{{ route('services.show', 'capacitaciones-sst') }}">Capacitaciones en SST</a></li>
            <li><a href="{{ route('certificates.index') }}">Verificar certificado</a></li>
        </ul>
    </li>
    <li class="has-dropdown has-menu-child-item {{ request()->routeIs('services.*') ? 'active' : '' }}">
        <a href="{{ route('services.index') }}">Servicios <i class="feather-chevron-down" aria-hidden="true"></i></a>
        <ul class="submenu">
            <li><a href="{{ route('services.index') }}"><strong>Ver todos los servicios</strong></a></li>
            @foreach ($siteContent->services() as $slug => $service)
                <li><a href="{{ route('services.show', $slug) }}">{{ $service['short_title'] }}</a></li>
            @endforeach
        </ul>
    </li>
    <li class="{{ request()->routeIs('nosotros') ? 'active' : '' }}">
        <a href="{{ route('nosotros') }}">Nosotros</a>
    </li>
    <li class="{{ request()->routeIs('contactanos') ? 'active' : '' }}">
        <a href="{{ route('contactanos') }}">Contáctanos</a>
    </li>
</ul>
