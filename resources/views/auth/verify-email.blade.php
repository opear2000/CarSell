<x-base-layout title="Verify Email" bodyClass="page-login">
    <main>
      <div class="container-small page-login">
        <div class="flex" style="gap: 5rem">
          <div class="auth-page-form">
            <div class="text-center">
              <a href="/">
                <img src="/img/CarSell.logo.png" alt="" />
              </a>
            </div>
            <h1 class="auth-page-title">Verifica tu correo electrónico</h1>

            @if (session('success') || session('status'))
              <div class="form-group" style="margin-bottom: 1rem;">
                <div style="color: #2e7d32; font-size: 0.95rem;">
                  {{ session('success') ?? session('status') }}
                </div>
              </div>
            @endif

            <p style="margin-bottom: 1rem; color: #666; line-height: 1.5;">
              Gracias por registrarte. Antes de comenzar, verifica tu dirección de correo electrónico haciendo clic en el enlace que te enviamos.
              Si no recibiste el correo, con gusto te enviaremos otro.
            </p>

            <form action="{{ route('verification.send') }}" method="post" style="margin-bottom: 0.75rem;">
              @csrf
              <button class="btn btn-primary btn-login w-full">Reenviar correo de verificación</button>
            </form>

            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button class="btn btn-login w-full" type="submit">Cerrar sesión</button>
            </form>
          </div>

          <div class="auth-page-image">
            <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
          </div>
        </div>
      </div>
    </main>
</x-base-layout>
