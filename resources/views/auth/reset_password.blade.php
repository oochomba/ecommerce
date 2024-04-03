@extends('layouts.app')
@section('style')
    <style>
        .forgot-pass-title {
            text-transform: capitalize;
            font-weight: 400;
            font-size: 2rem;
            letter-spacing: -.025em;
            color: inherit;
            border-bottom-width: .2rem;
            padding: .9rem 1rem;
        }
    </style>
@endsection

@section('content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Pages</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol>
            </div>
        </nav>

        <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
            style="background-image: url('{{ url('assets/front/images/backgrounds/login-bg.jpg') }}')">
            <div class="container">
                <div class="form-box">
                    <div class="form-tab">
                        <ul class="nav nav-pills nav-fill" role="tablist">
                            <li class="nav-item mb-2 text-uppercase forgot-pass-title">
                                Reset Password
                            </li>
                        </ul>
                        <div class="tab-content">
                            @include('layouts._message')
                            <div class="mt-3" id="signin-2" role="tabpanel" aria-labelledby="signin-tab-2">
                                <form action="" method="POST">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="password">New Password <span class="text text-danger">*</span></label>
                                        <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" required>
                                        @if ($errors->has('password'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('password') }}.
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirm Password <span
                                                class="text text-danger">*</span></label>
                                        <input type="password" class="form-control {{ $errors->has('password_confirmation') ? ' is-invalid' : '' }}" id="password_confirm"
                                            name="password_confirmation" required>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="invalid feedback text text-danger" role="alert">
                                                {{ $errors->first('password_confirmation') }}.
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-outline-primary-2">
                                            <span>RESET</span>
                                            <i class="icon-long-arrow-right"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
@endsection
