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

        #imagePreview {
            max-width: 100%;
            max-height: 400px;
            border-radius: 10px;
            overflow: hidden;
        }

        #imagePreview img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
    </style>

</head>

<body>
    <form action="#" id="submitFormDoctor" enctype="multipart/form-data">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa-solid fa-id-card"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="doctor_name" placeholder="nama" id="doctor_name">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-envelope"></i>
                        </div>
                    </div>
                    <input type="email" class="form-control" name="doctor_email" placeholder="email@mail.com"
                        id="doctor_email">
                </div>
            </div>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa-solid fa-suitcase-medical"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="doctor_specialist" placeholder="Dokter Spesialis"
                        id="doctor_specialist">
                </div>
            </div>
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fas fa-phone"></i>
                        </div>
                    </div>
                    <input type="number" class="form-control" name="doctor_phone" placeholder="no telp"
                        id="doctor_phone">
                </div>
            </div>
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="doctor_address" placeholder="Alamat"
                        id="doctor_address">
                </div>
            </div>
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa-solid fa-id-card-clip"></i>
                        </div>
                    </div>
                    <input type="text" class="form-control" name="doctor_sip" placeholder="Surat izin praktek"
                        id="doctor_sip">
                </div>
            </div>
            <div class="form-group mt-2">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <i class="fa-solid fa-image"></i>
                        </div>
                    </div>
                    <input type="file" class="form-control" id="doctor_photo" name="doctor_photo" accept="image/*">
                    <div id="imagePreview" class="mt-2"></div>
                </div>
            </div>

        </div>
        <div style="display: flex; justify-content: flex-end; bottom: 0;">
            <button class="btn btn-primary" id="submitBtnDoctor">Simpan</button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        $(document).ready(function() {
            $('#submitBtnDoctor').on('click', function() {
                var originalText = $(this).text();
                $(this).html(
                    '<div class="d-flex justify-content-center align-items-center"><span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...</div>'
                );
                setTimeout(function() {
                    $('#submitBtnDoctor').html(originalText);
                }, 2000);
            });

            $('#submitFormDoctor').submit(function(e) {
                e.preventDefault();

                var doctor_name = $('#doctor_name').val();
                var doctor_email = $('#doctor_email').val();
                var doctor_specialist = $('#doctor_specialist').val();
                var doctor_phone = $('#doctor_phone').val();
                var doctor_address = $('#doctor_address').val();
                var doctor_sip = $('#doctor_sip').val();
                if (doctor_name === '') {
                    Toastify({
                        text: 'Nama harus diisi',
                        duration: 2000,
                        gravity: 'top',
                        position: 'center',
                        backgroundColor: '#ffc107',
                        stopOnFocus: true,
                        className: 'toastify-with-icon',
                    }).showToast();
                    return;
                }
                if (doctor_email === '') {
                    Toastify({
                        text: 'email harus diisi',
                        duration: 2000,
                        gravity: 'top',
                        position: 'center',
                        backgroundColor: '#ffc107',
                        stopOnFocus: true,
                        className: 'toastify-with-icon',
                    }).showToast();
                    return;
                }
                if (doctor_specialist === '') {
                    Toastify({
                        text: 'spesialis dokter harus diisi',
                        duration: 2000,
                        gravity: 'top',
                        position: 'center',
                        backgroundColor: '#ffc107',
                        stopOnFocus: true,
                        className: 'toastify-with-icon',
                    }).showToast();
                    return;
                }
                if (doctor_phone === '') {
                    Toastify({
                        text: 'no telp harus diisi',
                        duration: 2000,
                        gravity: 'top',
                        position: 'center',
                        backgroundColor: '#ffc107',
                        stopOnFocus: true,
                        className: 'toastify-with-icon',
                    }).showToast();
                    return;
                }
                if (doctor_address === '') {
                    Toastify({
                        text: 'alamat harus diisi',
                        duration: 2000,
                        gravity: 'top',
                        position: 'center',
                        backgroundColor: '#ffc107',
                        stopOnFocus: true,
                        className: 'toastify-with-icon',
                    }).showToast();
                    return;
                }
                if (doctor_sip === '') {
                    Toastify({
                        text: 'SIP harus diisi',
                        duration: 2000,
                        gravity: 'top',
                        position: 'center',
                        backgroundColor: '#ffc107',
                        stopOnFocus: true,
                        className: 'toastify-with-icon',
                    }).showToast();
                    return;
                }

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
    <script>
        document.getElementById('doctor_photo').addEventListener('change', function(event) {
            var input = event.target;

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    var preview = document.getElementById('imagePreview');
                    preview.innerHTML = '<img src="' + e.target.result +
                        '" alt="Preview">';
                };

                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>

</body>

</html>
