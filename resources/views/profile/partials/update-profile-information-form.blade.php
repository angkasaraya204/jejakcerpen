<section class="stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">{{ __('Profile Information') }}</h4>
        <p class="card-description">
          {{ __("Update your account's profile information and email address.") }}
        </p>

        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
          @csrf
        </form>

        <form method="post" action="{{ route('profile.update') }}" class="forms-sample">
          @csrf
          @method('patch')

          <div class="form-group">
            <label for="name">{{ __('Name') }}</label>
            <input
              type="text"
              class="form-control @if($errors->get('name')) is-invalid @endif"
              id="name"
              name="name"
              value="{{ old('name', $user->name) }}"
              required
              autofocus
              autocomplete="name"
            >
            @if($errors->get('name'))
              <div class="text-danger mt-1">
                {{ $errors->first('name') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            <label for="email">{{ __('Email') }}</label>
            <input
              type="email"
              class="form-control @if($errors->get('email')) is-invalid @endif"
              id="email"
              name="email"
              value="{{ old('email', $user->email) }}"
              required
              autocomplete="username"
            >
            @if($errors->get('email'))
              <div class="text-danger mt-1">
                {{ $errors->first('email') }}
              </div>
            @endif

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
              <div class="mt-2">
                <p class="text-muted">
                  {{ __('Your email address is unverified.') }}
                  <button form="send-verification" class="btn btn-link p-0 m-0 align-baseline text-primary">
                    {{ __('Click here to re-send the verification email.') }}
                  </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                  <p class="text-success mt-2">
                    {{ __('A new verification link has been sent to your email address.') }}
                  </p>
                @endif
              </div>
            @endif
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
              <span class="text-success" id="profile-updated-message">
                {{ __('Saved.') }}
              </span>
              <script>
                setTimeout(() => {
                  document.getElementById('profile-updated-message').style.display = 'none';
                }, 2000);
              </script>
            @endif
          </div>
        </form>
      </div>
    </div>
  </section>
