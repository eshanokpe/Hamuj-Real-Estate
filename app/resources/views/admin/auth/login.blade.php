 <!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Igrcfp Admin</title>
  <link rel="icon" type="image/png" href="{{ asset('assets/admin/images/favicon.png')}}" sizes="16x16">
  <!-- remix icon font css  -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/remixicon.css')}}">
  <!-- BootStrap css -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/bootstrap.min.css')}}">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/apexcharts.css')}}">
  <!-- Data Table css -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/dataTables.min.css')}}">
  <!-- Text Editor css -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/editor-katex.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/editor.atom-one-dark.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/editor.quill.snow.css')}}">
  <!-- Date picker css -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/flatpickr.min.css')}}">
  <!-- Calendar css -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/full-calendar.css')}}">
  <!-- Vector Map css -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/jquery-jvectormap-2.0.5.css')}}">
  <!-- Popup css -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/magnific-popup.css')}}">
  <!-- Slick Slider css -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/lib/slick.css')}}">
  <!-- main css -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css')}}">
</head>
  <body>

    <section class="auth bg-base d-flex flex-wrap">  
        <div class="auth-left d-lg-block d-none">
            <div class="d-flex align-items-center flex-column h-100 justify-content-center">
                <img src="{{ asset('assets/admin/images/auth/auth-img.png')}}" alt="">
            </div>
        </div>
        <div class="auth-right py-32 px-24 d-flex flex-column justify-content-center">
            <div class="max-w-464-px mx-auto w-100">
                <div>
                    <div class="text-center mb-40">
                        <a href="#" class="d-inline-block max-w-290-px">
                            <img src="{{ asset('assets/images/home-three/logo/logo-main.png')}}" style="width:60px" alt="">
                        </a>
                    </div>

                    <h4 class="mb-12">Admin Sign In</h4>
                    <p class="mb-32 text-secondary-light text-lg">Welcome back! please enter your detail</p>
                </div> 
                @if($errors->any())
                    <div class="alert alert-danger mt-3">
                        {{ $errors->first() }}
                    </div>
                @endif
            <form action="{{ route('admin.authenticate') }}" method="POST">
                    @csrf
                    <div class="icon-field mb-16">
                        <span class="icon top-50 translate-middle-y">
                            <iconify-icon icon="mage:email"></iconify-icon>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" class="form-control h-56-px bg-neutral-50 radius-12" placeholder="Email" required>
                    </div>
                    <div class="position-relative mb-20">
                        <div class="icon-field">
                            <span class="icon top-50 translate-middle-y">
                                <iconify-icon icon="solar:lock-password-outline"></iconify-icon>
                            </span> 
                            <input type="password" name="password" class="form-control h-56-px bg-neutral-50 radius-12" id="your-password" placeholder="Password" required>
                        </div>
                        <span class="toggle-password ri-eye-line cursor-pointer position-absolute end-0 top-50 translate-middle-y me-16 text-secondary-light" data-toggle="#your-password"></span>
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-16">
                        <label class="checkbox-label">
                            <input type="checkbox" name="remember">
                            <span class="checkmark"></span>
                            Remember Me
                        </label>
                    </div>

                    <!-- Error Messages -->
                    @if($errors->any())
                        <div class="alert alert-danger mb-16">
                            @foreach($errors->all() as $error)
                                <p class="mb-0">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger mb-16">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success mb-16">
                            {{ session('success') }}
                        </div>
                    @endif

                    <button type="submit" class="btn btn-primary text-sm btn-sm px-12 py-16 w-100 radius-12 mt-32">Sign In</button>

                
                </form>
            </div>
        </div>
    </section>

  <!-- jQuery library js -->
  <script src="{{ asset('assets/admin/js/lib/jquery-3.7.1.min.js')}}"></script>
  <!-- Bootstrap js -->
  <script src="{{ asset('assets/admin/js/lib/bootstrap.bundle.min.js')}}"></script>
  <!-- Apex Chart js -->
  <script src="{{ asset('assets/admin/js/lib/apexcharts.min.js')}}"></script>
  <!-- Data Table js -->
  <script src="{{ asset('assets/admin/js/lib/dataTables.min.js')}}"></script>
  <!-- Iconify Font js -->
  <script src="{{ asset('assets/admin/js/lib/iconify-icon.min.js')}}"></script>
  <!-- jQuery UI js -->
  <script src="{{ asset('assets/admin/js/lib/jquery-ui.min.js')}}"></script>
  <!-- Vector Map js -->
  <script src="{{ asset('assets/admin/js/lib/jquery-jvectormap-2.0.5.min.js')}}"></script>
  <script src="{{ asset('assets/admin/js/lib/jquery-jvectormap-world-mill-en.js')}}"></script>
  <!-- Popup js -->
  <script src="{{ asset('assets/admin/js/lib/magnifc-popup.min.js')}}"></script>
  <!-- Slick Slider js -->
  <script src="{{ asset('assets/admin/js/lib/slick.min.js')}}"></script>
  <!-- main js -->
  <script src="{{ asset('assets/admin/js/app.js')}}"></script>

<script>
      // ================== Password Show Hide Js Start ==========
      function initializePasswordToggle(toggleSelector) {
        $(toggleSelector).on('click', function() {
            $(this).toggleClass("ri-eye-off-line");
            var input = $($(this).attr("data-toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    }
    // Call the function
    initializePasswordToggle('.toggle-password');
  // ========================= Password Show Hide Js End ===========================
</script>

</body>
</html>
