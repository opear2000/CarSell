<x-base-layout title="Reset Password" bodyClass="page-login">
    <main>
      <div class="container-small page-login">
        <div class="flex" style="gap: 5rem">
          <div class="auth-page-form">
            <div class="text-center">
              <a href="/">
                <img src="/img/CarSell.logo.png" alt="" />
              </a>
            </div>
            <h1 class="auth-page-title">Restablecer Contraseña</h1>

            <form action="{{ route('password.update') }}" method="post">
              @csrf

              @if ($errors->any())
                <div class="form-group has-error" style="margin-bottom: 1rem;">
                  <div class="error-message" style="display: block;">
                    {{ $errors->first() }}
                  </div>
                </div>
              @endif

              <input type="hidden" name="token" value="{{ $token }}" />

              <div class="form-group @error('email') has-error @enderror">
                <input type="email" name="email" placeholder="Your Email" value="{{ old('email', $email) }}" />
                <div class="error-message">
                  {{ $errors->first('email') }}
                </div>
              </div>

              <div class="form-group @error('password') has-error @enderror">
                <input type="password" name="password" placeholder="Nueva Contraseña" />
                <div class="error-message">
                  {{ $errors->first('password') }}
                </div>
              </div>

              <div class="form-group @error('password_confirmation') has-error @enderror">
                <input type="password" name="password_confirmation" placeholder="Confirmar Nueva Contraseña" />
                <div class="error-message">
                  {{ $errors->first('password_confirmation') }}
                </div>
              </div>

              <button class="btn btn-primary btn-login w-full">Restablecer Contraseña</button>

              <div class="login-text-dont-have-account">
                Volver al inicio de sesión -
                <a href="{{ route('login') }}"> Haz clic aquí para iniciar sesión </a>
              </div>
            </form>
          </div>
          <div class="auth-page-image">
            <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
          </div>
        </div>
      </div>
    </main>
</x-base-layout>
