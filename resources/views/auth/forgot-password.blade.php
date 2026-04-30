<x-base-layout title="Forgot Password" bodyClass="page-login">
    <main>
      <div class="container-small page-login">
        <div class="flex" style="gap: 5rem">
          <div class="auth-page-form">
            <div class="text-center">
              <a href="/">
                <img src="/img/logoipsum-265.svg" alt="" />
              </a>
            </div>
            <h1 class="auth-page-title">Request Password Reset</h1>

            <form action="{{ route('password.email') }}" method="post">
              @csrf

              @if (session('success') || session('status'))
                <div class="form-group" style="margin-bottom: 1rem;">
                  <div style="color: #2e7d32; font-size: 0.95rem;">
                    {{ session('success') ?? session('status') }}
                  </div>
                </div>
              @endif

              @if ($errors->any())
                <div class="form-group has-error" style="margin-bottom: 1rem;">
                  <div class="error-message" style="display: block;">
                    {{ $errors->first() }}
                  </div>
                </div>
              @endif

              <div class="form-group @error('email') has-error @enderror">
                <input type="email" name="email" placeholder="Your Email" value="{{ old('email') }}" />
                <div class="error-message">
                  {{ $errors->first('email') }}
                </div>
              </div>

              <button class="btn btn-primary btn-login w-full">
                Request password reset
              </button>

              <div class="login-text-dont-have-account">
                Already have an account? -
                <a href="{{ route('login') }}"> Click here to login </a>
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