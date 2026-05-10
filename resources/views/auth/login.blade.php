<x-layouts.base title="Login" bodyClass="page-login">
<main>
      <div class="container-small page-login">
        <div class="flex" style="gap: 5rem">
          <div class="auth-page-form">
            <div class="text-center">
              <a href="/">
                <img src="/img/CarSell.logo.png" alt="" />
              </a>
            </div>
            <h1 class="auth-page-title">Iniciar Sesión</h1>

            <form action="{{ route('login.store') }}" method="post">
              @csrf

              @if ($errors->any())
                <div class="form-group has-error" style="margin-bottom: 1rem;">
                  <div class="error-message" style="display: block;">
                    {{ $errors->first() }}
                  </div>
                </div>
              @endif

              <div class="form-group @error('email') has-error @enderror">
                <input type="email" placeholder="Tu Correo" name="email" value="{{ old('email') }}" />
                <div class="error-message">
                  {{ $errors->first('email') }}
                </div>
              </div>
              <div class="form-group @error('password') has-error @enderror" style="position: relative;">
                <input id="loginPassword" type="password" placeholder="Tu Contraseña" name="password" style="padding-right: 80px;" />
                <button
                  type="button"
                  data-password-toggle
                  data-target="loginPassword"
                  style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); border: none; background: transparent; color: #666; cursor: pointer; font-weight: 500;"
                  aria-label="Mostrar contraseña"
                  aria-pressed="false"
                >
                  Mostrar
                </button>
                <div class="error-message">
                  {{ $errors->first('password') }}
                </div>
              </div>
              <div class="text-right mb-medium">
                <a href="{{ route('password.request') }}" class="auth-page-password-reset"
                  >¿Olvidaste tu contraseña?</a
                >
                
              </div>

              <button class="btn btn-primary btn-login w-full">Iniciar Sesión</button>

              <div class="grid grid-cols-2 gap-1 social-auth-buttons">
                <x-google-button />
                <x-fb-button />
              </div>
              <div class="login-text-dont-have-account">
                ¿No tienes una cuenta? -
                <a href="{{ route('signup') }}"> Haz clic aquí para crear una</a>
              </div>

            </form>
            <div class="text-center mt-4">
              <a href="https://php.lospirineosit.com/privacy" target="_blank" rel="noopener" class="text-sm text-gray-600 hover:text-blue-600 underline mr-4">Política de Privacidad</a>
              <a href="https://php.lospirineosit.com/terms" target="_blank" rel="noopener" class="text-sm text-gray-600 hover:text-blue-600 underline">Términos de Servicio</a>
            </div>
          </div>
          <div class="auth-page-image">
            <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
          </div>
        </div>
      </div>
    </main>
</x-base-layout>