
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css') }}">
    <!-- Layout styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100 m-0">
          <div class="content-wrapper full-page-wrapper d-flex align-items-center auth login-bg">
            <div class="card col-lg-4 mx-auto">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-left mb-3">Login</h3>
                <form method="POST" action="{{ route('login') }}">
                  @csrf
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control p_input" value="{{ old('email') }}" required autocomplete="email" placeholder="Masukkan email anda">
                    @error('email')
                      <span class="text-danger" role="alert">
                        {{ $message }}
                      </span>
                    @enderror
                  </div>
                  <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" class="form-control p_input" required autocomplete="current-password" placeholder="Masukkan kata sandi">
                    @error('password')
                      <span class="text-danger" role="alert">
                        {{ $message }}
                      </span>
                    @enderror
                  </div>
                  <div class="form-group d-flex align-items-center justify-content-between">
                    <div class="form-check">
                      <label for="remember_me" class="form-check-label">
                        <input type="checkbox" id="remember_me" class="form-check-input"> Ingat saya </label>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary btn-block enter-btn">Login</button>
                  </div>
                  @if (Route::has('register'))
                    <p class="sign-up">Belum punya akun?<a href="{{ route('register') }}"> Daftar</a></p>
                  @endif
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
    <script src="{{ asset('assets/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/off-canvas.js') }}"></script>
    <script src="{{ asset('assets/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('assets/js/misc.js') }}"></script>
    <script src="{{ asset('assets/js/settings.js') }}"></script>
    <script src="{{ asset('assets/js/todolist.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
  </body>
</html>
