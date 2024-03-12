<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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

</head>

<body>
    <form action="#" id="submitFormUser">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                    </div>
                    <input type="name" class="form-control" name="name" placeholder="nama" id="name">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <input type="email" class="form-control" name="email" placeholder="email@mail.com"
                        id="email">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </div>
                    </div>
                    <input type="password" class="form-control" name="password" placeholder="password" id="password">
                </div>
            </div>
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>
                    <input type="number" class="form-control" name="phone" placeholder="no telp" id="phone">
                </div>
            </div>
            <div class="form-group mt-2">
                <label class="form-label">Roles :</label>
                <div class="selectgroup w-100 radio-btn">
                    <label class="selectgroup-item">
                        <input type="radio" name="role_id" value="1" class="selectgroup-input" checked="">
                        <span class="selectgroup-button">Super Admin</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="role_id" value="2" class="selectgroup-input">
                        <span class="selectgroup-button">Doctor</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="role_id" value="3" class="selectgroup-input">
                        <span class="selectgroup-button">Staff</span>
                    </label>
                </div>
            </div>
        </div>
        <div style="display: flex; justify-content: flex-end; bottom: 0;">
            <button class="btn btn-primary" id="submitBtn">Simpan</button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function() {
            $('#submitBtn').on('click', function() {
                var originalText = $(this).text();
                $(this).html(
                    '<div class="d-flex justify-content-center align-items-center"><span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...</div>'
                );
                setTimeout(function() {
                    $('#submitBtn').html(originalText);
                }, 2000);
            });

            $('#submitFormUser').submit(function(e) {
                e.preventDefault();

                var name = $('#name').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var phone = $('#phone').val();
                var role_id = $('.selectgroup-item input:checked').val();
                $.ajax({
                    url: '{{ route('storeUser') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        name: name,
                        email: email,
                        password: password,
                        phone: phone,
                        role_id: role_id
                    },
                    success: function(res) {
                        Toastify({
                            text: 'Berhasil simpan data',
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: '#4CAF50',
                            stopOnFocus: true,
                            className: 'toastify-with-icon-success',
                        }).showToast();
                        setTimeout(function() {
                            window.location.href = '{{ route('managementUser') }}';
                        }, 1000);
                    },
                    error: function(error) {
                        if (error.responseJSON.errors.name) {
                            console.log('masuk error')
                            Toastify({
                                text: error.responseJSON.errors.name[0],
                                duration: 2000,
                                gravity: 'top',
                                position: 'center',
                                backgroundColor: '#ffc107',
                                stopOnFocus: true,
                                className: 'toastify-with-icon',
                            }).showToast();
                            return false;
                        }
                        if (error.responseJSON.errors.email) {
                            console.log('masuk error')
                            Toastify({
                                text: error.responseJSON.errors.email[0],
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
                            console.log('masuk error')
                            Toastify({
                                text: error.responseJSON.errors.password[0],
                                duration: 2000,
                                gravity: 'top',
                                position: 'center',
                                backgroundColor: '#ffc107',
                                stopOnFocus: true,
                                className: 'toastify-with-icon',
                            }).showToast();
                            return false;
                        }
                        if (error.responseJSON.errors.phone) {
                            console.log('masuk error')
                            Toastify({
                                text: error.responseJSON.errors.phone[0],
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

</body>

</html>
