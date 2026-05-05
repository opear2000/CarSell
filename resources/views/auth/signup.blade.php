<x-base-layout title="Signup" bodyClass="page-signup">
    <main>
      <div class="container-small page-login">
        <div class="flex" style="gap: 5rem">
          <div class="auth-page-form">
            <div class="text-center">
              <a href="/">
                <img src="/img/CarSell.logo.png" alt="" />
              </a>
            </div>
            <h1 class="auth-page-title">Signup</h1>

            <form action="{{ route('signup.store') }}" method="post">
              @csrf

              @if ($errors->any())
                <div class="form-group has-error" style="margin-bottom: 1rem;">
                  <div class="error-message" style="display: block;">
                    {{ $errors->first() }}
                  </div>
                </div>
              @endif

              <div class="form-group @error('name') has-error @enderror">
                <input type="text" placeholder="Name" name="name" value="{{ old('name') }}" />
                <div class="error-message">
                    {{ $errors->first('name') }}
                  </div>
              </div>
              <div class="form-group @error('email') has-error @enderror">
                <input type="email" placeholder="Your Email" name="email" value="{{ old('email') }}" />
                <div class="error-message">
                    {{ $errors->first('email') }}
                  </div>
              </div>
              <div class="form-group @error('phone') has-error @enderror">
                <input type="text" placeholder="Phone" name="phone" value="{{ old('phone') }}" />
                <div class="error-message">
                    {{ $errors->first('phone') }}
                </div>
              </div>
              <div class="form-group @error('password') has-error @enderror" style="position:relative;">
                <input type="password" placeholder="Your Password" name="password" id="signupPassword" />
                <button type="button" class="password-toggle-btn" data-password-toggle data-target="signupPassword" aria-label="Show password" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);padding:0 8px;background:none;border:none;cursor:pointer;">
                  Show
                </button>
                <div class="error-message">
                    {{ $errors->first('password') }}
                </div>
              </div>
              <div class="form-group @error('password_confirmation') has-error @enderror" style="position:relative;">
                <input type="password" placeholder="Repeat Password" name="password_confirmation" id="signupPasswordConfirmation" />
                <button type="button" class="password-toggle-btn" data-password-toggle data-target="signupPasswordConfirmation" aria-label="Show password" style="position:absolute;right:10px;top:50%;transform:translateY(-50%);padding:0 8px;background:none;border:none;cursor:pointer;">
                  Show
                </button>
                <div class="error-message">
                    {{ $errors->first('password_confirmation') }}
                </div>
              </div>
              <button class="btn btn-primary btn-login w-full">Register</button>

              <div class="grid grid-cols-2 gap-1 social-auth-buttons">
                <x-google-button />
                <x-fb-button />
              </div>
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