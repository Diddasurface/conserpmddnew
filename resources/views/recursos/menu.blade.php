<ul class="mainmenu">
    <li class="{{ request()->routeIs('inicio') ? 'active' : '' }}">
        <a href="{{ route('inicio') }}">Inicio</a>
    </li>
    <li class="has-dropdown has-menu-child-item">
        <a href="{{ route('inicio') }}#cursos">Cursos <i class="feather-chevron-down" aria-hidden="true"></i></a>
        <ul class="submenu">
            <li><a href="{{ route('inicio') }}#cursos">Ver cursos</a></li>
            <li><a href="{{ route('inicio') }}#capacitaciones-sst">Capacitaciones en SST</a></li>
            <li><a href="{{ route('certificates.index') }}">Verificar certificado</a></li>
        </ul>
    </li>
    <li class="has-dropdown has-menu-child-item">
        <a href="{{ route('inicio') }}#servicios">Servicios <i class="feather-chevron-down" aria-hidden="true"></i></a>
        <ul class="submenu">
            <li><a href="{{ route('inicio') }}#documentacion-sst">Documentación del sistema SST</a></li>
            <li><a href="{{ route('inicio') }}#riesgos-laborales">Evaluación de riesgos laborales</a></li>
            <li><a href="{{ route('inicio') }}#capacitaciones-sst">Capacitaciones y simulacros</a></li>
            <li><a href="{{ route('inicio') }}#comite-sst">Comité SST y brigadas</a></li>
            <li><a href="{{ route('inicio') }}#cumplimiento-legal">Cumplimiento legal y SUNAFIL</a></li>
            <li><a href="{{ route('inicio') }}#auditorias-sst">Auditorías del sistema SST</a></li>
            <li><a href="{{ route('inicio') }}#homologacion">Homologación de proveedores</a></li>
        </ul>
    </li>
    <li class="has-dropdown has-menu-child-item">
        <a href="{{ route('inicio') }}#sistemas-iso">Sistemas ISO <i class="feather-chevron-down" aria-hidden="true"></i></a>
        <ul class="submenu">
            <li><a href="{{ route('inicio') }}#iso-45001">ISO 45001 · Seguridad y salud</a></li>
            <li><a href="{{ route('inicio') }}#iso-9001">ISO 9001 · Calidad</a></li>
            <li><a href="{{ route('inicio') }}#iso-14001">ISO 14001 · Gestión ambiental</a></li>
            <li><a href="{{ route('inicio') }}#iso-22000">ISO 22000 · Seguridad alimentaria</a></li>
            <li><a href="{{ route('inicio') }}#iso-27001">ISO 27001 · Seguridad de la información</a></li>
            <li><a href="{{ route('inicio') }}#iso-37001">ISO 37001 · Gestión antisoborno</a></li>
        </ul>
    </li>
    <li class="{{ request()->routeIs('nosotros') ? 'active' : '' }}">
        <a href="{{ route('nosotros') }}">Nosotros</a>
    </li>
    <li class="{{ request()->routeIs('contactanos') ? 'active' : '' }}">
        <a href="{{ route('contactanos') }}">Contáctanos</a>
    </li>
</ul>
