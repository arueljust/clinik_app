@extends('layouts.auth')

@section('title', 'Login')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/bootstrap-social/bootstrap-social.css') }}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <style>
        .toastify {
            border-radius: 5px;
            padding: 3px 10px 5px 10px;
        }

        .toastify-with-icon .toastify-content {
            display: flex;
            align-items: center;
        }

        .toastify-with-icon-success .toastify-content {
            display: flex;
            align-items: center;
        }

        .toastify-with-icon::before {
            content: '\f071';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            font-size: 1.5em;
            margin-right: 8px;
            color: inherit;
        }

        .toastify-with-icon-success::before {
            content: '\f00c';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            font-size: 1.5em;
            margin-right: 8px;
            color: inherit;
        }
    </style>
@endpush

@section('main')
    <div class="card card-primary">
        <div class="card-header">
            <h4>Login</h4>
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate=""
                id="submit-login-form">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" name="email" tabindex="1" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <div class="d-block">
                        <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" tabindex="2" required value="{{ old('password') }}">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <button type="submit" id="login-button" class="btn btn-primary btn-lg btn-block" tabindex="4"
                        id="test">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>Login</span>
                            <i class="fas fa-arrow-right"></i>
                        </div>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function() {
            $('#login-button').on('click', function() {
                var originalText = $('#login-button').html();
                $(this).html(
                    '<div class="d-flex justify-content-center align-items-center"><span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...</div>'
                );
                setTimeout(function() {
                    $('#login-button').html(originalText);
                }, 2000);
            });

            $('#submit-login-form').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        var userData = response;
                        console.log(userData)
                        window.location.href = '{{ route('home') }}';
                    },
                    error: function(error) {
                        if (error.responseJSON.errors.email) {
                            var errorMsg = error.responseJSON.errors.email[0];
                            Toastify({
                                text: errorMsg,
                                duration: 2000,
                                gravity: 'top',
                                position: 'center',
                                backgroundColor: '#ffc107',
                                stopOnFocus: true,
                                className: 'toastify-with-icon',
                            }).showToast();
                            return false;
                        }
                        if (error.responseJSON.errors.password) {
                            var errorMsg = error.responseJSON.errors.password[0];
                            Toastify({
                                text: errorMsg,
                                duration: 2000,
                                gravity: 'top',
                                position: 'center',
                                backgroundColor: '#ffc107',
                                stopOnFocus: true,
                                className: 'toastify-with-icon',
                            }).showToast();
                            return false;
                        }
                    }
                });
            });
        });
    </script>
@endpush
