<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>E-commerce {{ !empty($meta_title) ? ' - ' . ucwords($meta_title) : '' }}</title>
    @if (!empty($meta_description))
        <meta name="description" content="{{ $meta_description }}">
    @endif
    @if (!empty($meta_keywords))
        <meta name="keywords" content="{{ $meta_keywords }}">
    @endif




    <link rel="shortcut icon" href="{{ url('assets/front/images/icons/favicon.ico') }}">


    <link rel="stylesheet"
        href="{{ url('assets/front/vendor/line-awesome/line-awesome/line-awesome/css/line-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ url('assets/front/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/front/css/plugins/owl-carousel/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ url('assets/front/css/plugins/magnific-popup/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ url('assets/front/css/plugins/jquery.countdown.css') }}">

    <link rel="stylesheet" href="{{ url('assets/front/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/front/css/skins/skin-demo-4.css') }}">
    <link rel="stylesheet" href="{{ url('assets/front/css/demos/demo-4.css') }}">
    <style>
        body {
            background-color: #f5f6f9;
        }

        .border-bottom-none {
            border-bottom: none !important;
        }

        .border-radius {
            border-radius: 6px;
            border: 1px solid #F2F2F2;
        }

        .header-4 .header-bottom {
            /* background-color: #fff; */
            color: #fff;
            background-color: #333;
        }

        .menu>li>a {
            color: #fff;
        }

        .header-intro-clearance .header-bottom .header-right i {
            color: #39f;
        }

        .header-14 .header-bottom .header-right i {
            font-size: 1.6rem;
            margin-right: 1.5rem;
            color: #fcb941;
        }

        .header-intro-clearance .header-bottom .header-right p {
            font-size: 1.4rem;
            letter-spacing: -.01em;
            font-weight: 300;
            color: #fff;
        }

        .header-4 .dropdown.category-dropdown {
            background-color: #39f;
        }
    </style>
    @yield('style')
</head>

<body>
    <div class="page-wrapper">
        @include('layouts._header')


        @yield('content')



        @include('layouts._footer')

    </div>
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <div class="mobile-menu-overlay"></div>

    @include('layouts._mobile_menu')

    <div class="modal fade" id="signin-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true"><i class="icon-close"></i></span>
                    </button>

                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill nav-border-anim" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab" data-toggle="tab" href="#signin"
                                        role="tab" aria-controls="signin" aria-selected="true">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="register-tab" data-toggle="tab" href="#register"
                                        role="tab" aria-controls="register" aria-selected="false">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="tab-content-5">
                                <div class="tab-pane fade show active" id="signin" role="tabpanel"
                                    aria-labelledby="signin-tab">
                                    <form action="" method="POST" id="loginCustomer">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="singin-email">Email address *</label>
                                            <input type="text" class="form-control" id="singin-email" name="email"
                                                required>
                                        </div>

                                        <div class="form-group">
                                            <label for="singin-password">Password *</label>
                                            <input type="password" class="form-control" id="singin-password"
                                                name="password" required>
                                        </div>

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="is_remember" class="custom-control-input"
                                                    id="signin-remember">
                                                <label class="custom-control-label" for="signin-remember">Remember
                                                    Me</label>
                                            </div>

                                            <a href="{{ url('forgot-password') }}" class="forgot-link">Forgot Your
                                                Password?</a>
                                        </div>
                                    </form>

                                </div>
                                <div class="tab-pane fade" id="register" role="tabpanel"
                                    aria-labelledby="register-tab">
                                    <form action="" method="POST" id="registerCustomer">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <label for="register-name">Name <span
                                                    class="text text-danger">*</span></label>
                                            <input type="text" class="form-control" id="register-name"
                                                name="name" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="register-email">Email address <span
                                                    class="text text-danger">*</span></label>
                                            <input type="email" class="form-control" id="register-email"
                                                name="email" required>
                                        </div>

                                        <div class="form-group">
                                            <label for="register-password">Password <span
                                                    class="text text-danger">*</span></label>
                                            <input type="password" class="form-control" id="register-password"
                                                name="password" required>
                                        </div>

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>

                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input"
                                                    id="register-policy" required>
                                                <label class="custom-control-label" for="register-policy">I agree to
                                                    the <a href="#">privacy policy</a> *</label>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="container newsletter-popup-container mfp-hide" id="newsletter-popup-form">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="row no-gutters bg-white newsletter-popup-content">
                    <div class="col-xl-3-5col col-lg-7 banner-content-wrap">
                        <div class="banner-content text-center">
                            <img src="{{ url('assets/front/images/popup/newsletter/logo.png') }}" class="logo" alt="logo"
    width="60" height="15">
    <h2 class="banner-title">get <span>25<light>%</light></span> off</h2>
    <p>Subscribe to the Molla eCommerce newsletter to receive timely updates from your favorite
        products.</p>
    <form action="#">
        <div class="input-group input-group-round">
            <input type="email" class="form-control form-control-white" placeholder="Your Email Address" aria-label="Email Adress" required>
            <div class="input-group-append">
                <button class="btn" type="submit"><span>go</span></button>
            </div>
        </div>
    </form>
    <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input" id="register-policy-2" required>
        <label class="custom-control-label" for="register-policy-2">Do not show this popup
            again</label>
    </div>
    </div>
    </div>
    <div class="col-xl-2-5col col-lg-5 ">
        <img src="{{ url('assets/front/images/popup/newsletter/img-1.jpg') }}" class="newsletter-img" alt="newsletter">
    </div>
    </div>
    </div>
    </div>
    </div> --}}

    <script src="{{ url('assets/front/js/jquery.min.js') }}"></script>
    <script src="{{ url('assets/front/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('assets/front/js/jquery.hoverIntent.min.js') }}"></script>
    <script src="{{ url('assets/front/js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ url('assets/front/js/superfish.min.js') }}"></script>
    <script src="{{ url('assets/front/js/owl.carousel.min.js') }}"></script>
    <script src="{{ url('assets/front/js/bootstrap-input-spinner.js') }}"></script>
    <script src="{{ url('assets/front/js/jquery.plugin.min.js') }}"></script>
    <script src="{{ url('assets/front/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ url('assets/front/js/jquery.countdown.min.js') }}"></script>

    @yield('script')

    <script src="{{ url('assets/front/js/main.js') }}"></script>
    <script src="{{ url('assets/front/js/demos/demo-4.js') }}"></script>

    <script type="text/javascript">
        $('body').delegate('#loginCustomer', 'submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ url('login-customer') }}",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.status == true) {
                        // location.reload();
                        window.location.href = data.redirect;
                    } else {
                        alert(data.message);
                    }
                },
                error: function(data) {

                }
            });
        });
        $('body').delegate('#registerCustomer', 'submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "{{ url('register-customer') }}",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    alert(data.message);
                    if (data.status == true) {
                        location.reload();
                    }
                },
                error: function(data) {

                }
            });
        });
    </script>


</body>


</html>
