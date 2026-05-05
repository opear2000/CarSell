<header class="navbar">
  <div class="container navbar-content">

    <!-- Logo -->
    <a href="{{ url('/') }}" class="logo-wrapper">
      <img 
        src="{{ asset('img/salautomarket-logo.png') }}" 
        alt="SalAutoMarket - Compra y venta de carros"
        class="logo-img"
      />
    </a>

    <!-- Mobile Toggle -->
    <button 
      class="btn btn-default btn-navbar-toggle" 
      aria-label="Abrir menú"
      aria-controls="navbar-menu"
      aria-expanded="false"
    >
      <svg class="icon-md" viewBox="0 0 24 24" fill="none" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
      </svg>
    </button>

    <!-- Right Section -->
    <div class="navbar-auth" id="navbar-menu">

      @auth
        @php $user = auth()->user(); @endphp

        @if ($user->hasVerifiedEmail())
          <a href="{{ route('car.create') }}" class="btn btn-primary btn-add">
            <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M12 9v6m3-3H9"/>
            </svg>
            Publicar Carro
          </a>

          <a href="{{ route('car.watchlist') }}" class="btn btn-secondary">
            Favoritos
          </a>
        @endif

        <!-- User Dropdown -->
        <div class="navbar-menu" x-data="{ open: false }">
          <button 
            @click="open = !open"
            class="navbar-menu-handler"
            aria-haspopup="true"
            :aria-expanded="open"
          >
            {{ $user->name }}
            <svg class="icon-sm" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
            </svg>
          </button>

          <ul x-show="open" @click.outside="open = false" class="submenu">
            @if ($user->hasVerifiedEmail())
              <li><a href="{{ route('profile.index') }}">Mi Perfil</a></li>
              <li><a href="{{ route('car.index') }}">Mis Carros</a></li>
              <li><a href="{{ route('car.watchlist') }}">Favoritos</a></li>
            @else
              <li><a href="{{ route('verification.notice') }}">Verificar Correo</a></li>
            @endif

            <li>
              <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-logout">Cerrar Sesión</button>
              </form>
            </li>
          </ul>
        </div>

      @endauth

      @guest
        <a href="{{ route('signup') }}" class="btn btn-primary">
          Crear Cuenta
        </a>

        <a href="{{ route('login') }}" class="btn btn-outline">
          Iniciar Sesión
        </a>
      @endguest

    </div>
  </div>
</header>