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
    <form action="{{ route('storeDoctorSchedule') }}" method="POST" id="submitFormDoctorSchedule">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label>Pilih Dokter : </label>
                <select class="form-control" name="doctor_id" tabindex="-1" aria-hidden="true">
                    @foreach ($doctorData as $d)
                        <option value="{{ $d->id }}"
                            {{ $doctorSchedule->doctor_id == $d->id ? 'selected' : '' }}>
                            {{ $d->doctor_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Pilih Hari Partek :</label>
                <select class="multiple-day select2" name="day[]" multiple="multiple">
                    @foreach ($decodeDay as $d)
                        <option value="{{ $d }}" selected>{{ $d }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mt-2">
                <label class="form-label">Status :</label>
                <div class="selectgroup w-100 radio-btn">
                    <label class="selectgroup-item">
                        <input type="radio" name="status" value="Aktif" class="selectgroup-input"
                            {{ $doctorSchedule->status == 'Aktif' ? 'checked' : '' }}>
                        <span class="selectgroup-button">Aktif</span>
                    </label>
                    <label class="selectgroup-item">
                        <input type="radio" name="status" value="Tidak aktif" class="selectgroup-input"
                            {{ $doctorSchedule->status == 'Tidak aktif' ? 'checked' : '' }}>
                        <span class="selectgroup-button">Tidak Aktif</span>
                    </label>
                </div>
            </div>
            <div class="form-group mt-2">
                <label for="note">Informasi : </label>
                <div class="input-group">
                    <textarea cols="60" rows="5" style="border: none; border-radius: 5px" name="note">{{ $doctorSchedule->note }}</textarea>
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
    {{-- logic select 2 --}}
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });

        // $(document).ready(function() {
        //     var decodeTime = {!! json_encode($doctorSchedule->time) !!};
        //     decodeTime.forEach((values) => {
        //         console.log(values)
        //     })
        //     $('.select2').on('change', function() {
        //         var selectedData = $(this).val();
        //         var $parentDiv = $(this).closest('div.form-group');
        //         $parentDiv.find('.additional-input').remove();
        //         $parentDiv.find('.additional-label').remove();

        //         if (selectedData && selectedData.length > 0) {
        //             selectedData.forEach((value) => {
        //                 var newInput = $('<input>').attr({
        //                     type: 'text',
        //                     class: 'form-control additional-input',
        //                     name: 'additional_input[]',
        //                     value: value,
        //                 });
        //                 var newLabel = $('<label>').attr({
        //                     for: 'additional_input[]',
        //                     class: 'mt-2 additional-label',
        //                 }).text(value + ' :');
        //                 $parentDiv.append(newLabel).append(newInput);
        //             });
        //         }
        //     });
        // });



        $('.select2').on('change', function() {
            var decodeTime = {!! json_encode($doctorSchedule->time) !!};
            var selectedValues = $(this).val();
            var $parentDiv = $(this).closest('div.form-group');
            $parentDiv.find('.additional-input').remove();
            $parentDiv.find('.additional-label').remove();

            if (selectedValues && selectedValues.length > 0) {
                selectedValues.forEach(function(value) {
                    var newInput = $('<input>').attr({
                        type: 'text',
                        class: 'form-control additional-input',
                        name: 'additional_input[]',
                        placeholder: 'Jam praktek Hari ' + value
                    });
                    var newLabel = $('<label>').attr({
                        for: 'additional_input[]',
                        class: 'mt-2 additional-label',
                    }).text(value + ' :');
                    $parentDiv.append(newLabel).append(newInput);
                });
            }

            // Persiapkan data untuk dikirim dengan AJAX
            var formData = new FormData();
            formData.append('selected_values', selectedValues.join(
                ',')); // Gabungkan nilai-nilai yang dipilih menjadi string

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(res) {
                    console.log(res)
                    if (res.message === 'ok') {
                        Toastify({
                            text: res,
                            gravity: 'top',
                            position: 'right',
                            backgroundColor: '#4CAF50',
                            stopOnFocus: true,
                            className: 'toastify-with-icon-success',
                        }).showToast();
                        setTimeout(function() {
                            window.location.href =
                                '{{ route('managementDoctorSchedule') }}';
                        }, 1000);
                    }

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    </script>

</body>

</html>
