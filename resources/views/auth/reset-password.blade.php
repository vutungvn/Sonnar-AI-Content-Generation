<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Reset Password Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="{{ asset('backend/assets/images/favicon.ico') }}">
    <link href="{{ asset('backend/assets/css/app.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('backend/assets/css/icons.min.css') }}" rel="stylesheet" />
</head>

<body class="bg-white">

    <div class="account-page">
        <div class="container-fluid p-0">
            <div class="row align-items-center g-0">

                {{-- LEFT --}}
                <div class="col-xl-5">
                    <div class="row">
                        <div class="col-md-7 mx-auto">
                            <div class="mb-0 border-0 p-md-5 p-lg-0 p-4">

                                {{-- Logo --}}
                                <div class="mb-4 p-0">
                                    <a href="#" class="auth-logo">
                                        <img src="{{ asset('backend/assets/images/logo-dark.png') }}" class="mx-auto"
                                            height="28">
                                    </a>
                                </div>

                                <div class="pt-0">
                                    <form method="POST" action="{{ route('password.store') }}" class="my-4">
                                        @csrf

                                        {{-- Token --}}
                                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                        {{-- Email --}}
                                        <div class="form-group mb-3">
                                            <label class="form-label">Email address</label>
                                            <input type="email" name="email" value="{{ old('email', $request->email) }}"
                                                class="form-control @error('email') is-invalid @enderror" required
                                                autofocus>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Password --}}
                                        <div class="form-group mb-3">
                                            <label class="form-label">New Password</label>
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror" required
                                                autocomplete="new-password">
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Confirm Password --}}
                                        <div class="form-group mb-3">
                                            <label class="form-label">Confirm Password</label>
                                            <input type="password" name="password_confirmation"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                required autocomplete="new-password">
                                            @error('password_confirmation')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Submit --}}
                                        <div class="form-group mb-0 row">
                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary">
                                                        Reset Password
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="text-center text-muted">
                                        <p class="mb-0">Change the mind ?<a class='text-primary ms-2 fw-medium'
                                                href='{{ route('login') }}'>Back to Login</a></p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT --}}
                <div class="col-xl-7">
                    <div class="account-page-bg p-md-5 p-4">
                        <div class="text-center">
                            <h3 class="text-dark mb-3 pera-title">
                                Quick, Effective, and Productive With Tapeli Admin Dashboard
                            </h3>
                            <div class="auth-image">
                                <img src="{{ asset('backend/assets/images/authentication.svg') }}"
                                    class="mx-auto img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="{{ asset('backend/assets/js/app.js') }}"></script>
</body>

</html>