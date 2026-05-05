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
            <h1 class="auth-page-title">Verify Your Email</h1>

            @if (session('success') || session('status'))
              <div class="form-group" style="margin-bottom: 1rem;">
                <div style="color: #2e7d32; font-size: 0.95rem;">
                  {{ session('success') ?? session('status') }}
                </div>
              </div>
            @endif

            <p style="margin-bottom: 1rem; color: #666; line-height: 1.5;">
              Thanks for signing up. Before getting started, please verify your email address by clicking the link we just emailed to you.
              If you did not receive the email, we will gladly send you another.
            </p>

            <form action="{{ route('verification.send') }}" method="post" style="margin-bottom: 0.75rem;">
              @csrf
              <button class="btn btn-primary btn-login w-full">Resend verification email</button>
            </form>

            <form action="{{ route('logout') }}" method="post">
              @csrf
              <button class="btn btn-login w-full" type="submit">Log out</button>
            </form>
          </div>

          <div class="auth-page-image">
            <img src="/img/car-png-39071.png" alt="" class="img-responsive" />
          </div>
        </div>
      </div>
    </main>
</x-base-layout>
