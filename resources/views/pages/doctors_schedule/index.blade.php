@extends('layouts.app')

@section('title', 'Doctors Schedule')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Doctors Schedule</h1>
                <div class="section-header-breadcrumb">
                    {{-- <div class="breadcrumb-item active"><a href="#">Master Data</a></div> --}}
                    <div class="breadcrumb-item"><a href="{{ route('managementDoctorSchedule') }}">Dokter Schedule</a></div>
                    <div class="breadcrumb-item">All Users</div>
                </div>
            </div>
            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        @include('layouts.alert')
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="float-left">
                                    <a href="#" class="btn btn-primary" id="add-btn-doctor-schedule">
                                        <i class="fa fa-add"></i> Tambah
                                    </a>
                                </div>
                                <div class="float-right">
                                    <form method="GET" action="{{ route('managementDoctorSchedule') }}">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Cari..." name="name">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary"><i class="fas fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="clearfix mb-3"></div>

                                <div class="table-responsive">
                                    <table class="table-striped table">
                                        <tr>

                                            <th>Nama</th>
                                            <th>Hari</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                            <th>Note</th>
                                            <th>Registrasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                        @foreach ($doctorsSchedule as $doctor)
                                            <tr>

                                                <td>
                                                    {{ $doctor->doctor_name }}
                                                </td>
                                                <td>
                                                    {{ $doctor->day }}
                                                </td>
                                                <td>
                                                    {{ $doctor->time }}
                                                </td>
                                                <td>
                                                    {{ $doctor->status }}
                                                </td>
                                                <td>
                                                    {{ $doctor->note }}
                                                </td>
                                                <td>
                                                    {{ $doctor->created_at }}
                                                </td>
                                                <td>
                                                    <div class="d-flex justify-content-center">
                                                        <a class="btn btn-sm btn-info btn-icon btn-edit-doctor"
                                                            id-doctor="{{ $doctor->id }}">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form class="ml-2">
                                                            <button
                                                                class="btn btn-sm btn-danger btn-icon confirm-delete-doctor"
                                                                value="{{ $doctor->id }}">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $doctorsSchedule->withQueryString()->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    @include('components.modal');
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <script src="{{ asset('library/selectric/public/jquery.selectric.min.js') }}"></script>
    <!-- Page Specific JS File -->
    <script src="{{ asset('js/page/features-posts.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#add-btn-doctor-schedule').on('click', function() {
                $('#modalTitle').text('Tambah Schedule Dokter');
                $.ajax({
                    url: '{{ route('addDoctorSchedule') }}',
                    type: 'GET',
                    success: function(res) {
                        $('#myModal').modal('show');
                        $('#modalContent').html(res);
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            });
            $('.btn-edit-doctor').on('click', function() {
                var doctorId = $(this).attr('id-doctor');
                $('#modalTitle').text('Edit Doctor');
                $.ajax({
                    url: `{{ route('editDoctor', ['id' => ':doctorId']) }}`.replace(':doctorId',
                        doctorId),
                    type: 'GET',
                    success: function(res) {
                        $('#myModal').modal('show');
                        $('#modalContent').html(res);
                    },
                    error: function(error) {
                        console.log('Error:', error);
                    }
                });
            });

            $('.confirm-delete-doctor').on('click', function() {
                var id = $(this).val();
                Swal.fire({
                    title: 'Yakin hapus data ?',
                    text: 'Data akan terhapus secara permanent. ',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hapus'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('deleteDoctor') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id: id
                            },
                            success: function(res) {
                                Swal.fire({
                                    title: "Berhasil.",
                                    text: res,
                                    icon: "success",
                                    showConfirmButton: false
                                });

                                setTimeout(() => {
                                    window.location.href =
                                        '{{ route('managementDoctor') }}';
                                }, 1000);
                            },
                            error: function(err) {
                                alert('Error: ' + err.responseText);
                            }
                        });
                    }
                });
                return false;
            })
        });
    </script>
@endpush
