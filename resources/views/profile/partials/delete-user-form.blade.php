<section class="stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">{{ __('Delete Account') }}</h4>
        <p class="card-description">
          {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>

        <button
          type="button"
          class="btn btn-danger btn-fw"
          data-toggle="modal"
          data-target="#confirm-user-deletion"
        >{{ __('Delete Account') }}</button>

        <div class="modal fade" id="confirm-user-deletion" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')

                <div class="modal-header">
                  <h5 class="modal-title" id="deleteAccountModalLabel">{{ __('Are you sure you want to delete your account?') }}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

                <div class="modal-body">
                  <p class="text-muted">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                  </p>

                  <div class="form-group">
                    <label for="password" class="sr-only">{{ __('Password') }}</label>
                    <input
                      type="password"
                      class="form-control @if($errors->userDeletion->get('password')) is-invalid @endif"
                      id="password"
                      name="password"
                      placeholder="{{ __('Password') }}"
                    >
                    @if($errors->userDeletion->get('password'))
                      <div class="invalid-feedback text-danger">
                        {{ $errors->userDeletion->first('password') }}
                      </div>
                    @endif
                  </div>
                </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                  <button type="submit" class="btn btn-danger">{{ __('Delete Account') }}</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
