<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManHeRu - Acerca de</title>
    <link rel="stylesheet" href="{{ asset('css/inicio.css') }}">
    <link rel="stylesheet" href="{{ asset('css/acerca.css') }}">
</head>
<body>
    @include('components.alert')

    <header class="navbar">
        <div class="logo">
            <a href="{{ route('inicio') }}">
                <img src="{{ asset('images/Logo.jpg') }}" alt="Logo ManHeRu">
            </a>
            <span class="nombre">ManHeRu</span>
        </div>

        <nav class="menu">
            <a href="{{ route('acerca') }}">Acerca de</a>
            <a href="#">Productos</a>
            <a href="#">Cotizaciones</a>
            <a href="#">Contacto</a>
            
            @if(session()->has('usuario'))
                @if(session('usuario')->ID_Rol == 1)
                    <a href="{{ route('usuarios.index') }}">Gestión de Usuarios</a>
                @endif
                <a href="{{ route('logout') }}">Cerrar Sesión</a>
            @else
                <a href="{{ route('login.form') }}">Iniciar Sesión</a>
            @endif
        </nav>
    </header>

    <main class="acerca-container">
        <section class="acerca-hero">
            <h1>Acerca de ManHeRu</h1>
            <p class="acerca-subtitulo">
                Nos hemos dedicado a ofrecer soluciones en materiales de calidad para empresas 
                de la ciudad de Querétaro. Nuestro compromiso con la innovación y el servicio 
                nos ha permitido alcanzar estos logros:
            </p>
        </section>

        <section class="logros">
            <div class="logro-card">
                <div class="logro-icon">🏆</div>
                <h3>15+ Años de Experiencia</h3>
                <p>Más de una década y media sirviendo a empresas en Querétaro y alrededores.</p>
            </div>
            
            <div class="logro-card">
                <div class="logro-icon">🤝</div>
                <h3>500+ Clientes Satisfechos</h3>
                <p>Empresas de todos los tamaños confían en nuestros productos y servicios.</p>
            </div>
            
            <div class="logro-card">
                <div class="logro-icon">📈</div>
                <h3>Crecimiento Continuo</h3>
                <p>Expandimos nuestro catálogo y servicios para adaptarnos a las necesidades del mercado.</p>
            </div>
        </section>

        <section class="vision-mision">
            <div class="vmv-card">
                <h2><span class="vmv-icon">👁️</span> Visión</h2>
                <p>Ser la empresa líder en soluciones de mobiliario para empresas en México, reconocida por nuestra calidad, innovación y servicio al cliente, transformando espacios de trabajo en entornos productivos y ergonómicos.</p>
            </div>
            
            <div class="vmv-card">
                <h2><span class="vmv-icon">🎯</span> Misión</h2>
                <p>Proveer mobiliario de alta calidad que optimice los espacios de trabajo, fomentando la productividad, el bienestar y la satisfacción de nuestros clientes a través de soluciones personalizadas y un servicio excepcional.</p>
            </div>
        </section>

        <section class="valores">
            <h2><span class="valores-icon">❤️</span> Valores</h2>
            <div class="valores-grid">
                <div class="valor-item">
                    <h3>Calidad</h3>
                    <p>Ofrecemos productos duraderos y funcionales que superan las expectativas de nuestros clientes.</p>
                </div>
                
                <div class="valor-item">
                    <h3>Innovación</h3>
                    <p>Implementamos las últimas tendencias en diseño y ergonomía para espacios de trabajo.</p>
                </div>
                
                <div class="valor-item">
                    <h3>Compromiso</h3>
                    <p>Nos dedicamos completamente a satisfacer las necesidades específicas de cada cliente.</p>
                </div>
                
                <div class="valor-item">
                    <h3>Integridad</h3>
                    <p>Actuamos con honestidad y transparencia en todas nuestras relaciones comerciales.</p>
                </div>
            </div>
        </section>

        <section class="cta-section">
            <h2>¿Listo para transformar tu espacio de trabajo?</h2>
            <p>Contáctanos hoy mismo y descubre cómo podemos ayudarte a crear el entorno ideal para tu equipo.</p>
            <a href="{{ route('inicio') }}" class="btn-volver">Volver al Inicio</a>
        </section>
    </main>
</body>
</html>