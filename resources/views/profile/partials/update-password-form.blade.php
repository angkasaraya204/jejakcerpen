<section class="stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">{{ __('Update Password') }}</h4>
        <p class="card-description">
          {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>

        <form method="post" action="{{ route('password.update') }}" class="forms-sample">
          @csrf
          @method('put')

          <div class="form-group">
            <label for="update_password_current_password">{{ __('Current Password') }}</label>
            <input
              type="password"
              class="form-control @if($errors->updatePassword->get('current_password')) is-invalid @endif"
              id="update_password_current_password"
              name="current_password"
              autocomplete="current-password"
            >
            @if($errors->updatePassword->get('current_password'))
              <div class="text-danger mt-1">
                {{ $errors->updatePassword->first('current_password') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            <label for="update_password_password">{{ __('New Password') }}</label>
            <input
              type="password"
              class="form-control @if($errors->updatePassword->get('password')) is-invalid @endif"
              id="update_password_password"
              name="password"
              autocomplete="new-password"
            >
            @if($errors->updatePassword->get('password'))
              <div class="text-danger mt-1">
                {{ $errors->updatePassword->first('password') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
            <input
              type="password"
              class="form-control @if($errors->updatePassword->get('password_confirmation')) is-invalid @endif"
              id="update_password_password_confirmation"
              name="password_confirmation"
              autocomplete="new-password"
            >
            @if($errors->updatePassword->get('password_confirmation'))
              <div class="text-danger mt-1">
                {{ $errors->updatePassword->first('password_confirmation') }}
              </div>
            @endif
          </div>

          <div class="form-group">
            <button type="submit" class="btn btn-primary mr-2">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
              <span class="text-success" id="password-updated-message">
                {{ __('Saved.') }}
              </span>
              <script>
                setTimeout(() => {
                  document.getElementById('password-updated-message').style.display = 'none';
                }, 2000);
              </script>
            @endif
          </div>
        </form>
      </div>
    </div>
  </section>
