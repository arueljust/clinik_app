@extends('layouts.app')

@section('title', 'Patients')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('library/selectric/public/selectric.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Patient</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Master Data</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('managementPatient') }}">Management Patient</a></div>
                    <div class="breadcrumb-item">All Patients</div>
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
                                    <a href="#" class="btn btn-primary" id="add-btn">
                                        <i class="fa fa-add"></i> Tambah
                                    </a>
                                </div>
                                <div class="float-right">
                                    <form method="GET" action="{{ route('managementPatient') }}">
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
                                            <th>Email</th>
                                            <th>NO Telp</th>
                                            <th>Registrasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                        @foreach ($patient as $u)
                                            <tr>

                                                <td>{{ $u->name }}
                                                </td>
                                                <td>
                                                    {{ $u->email }}
                                                </td>
                                                <td>
                                                    {{ $u->phone }}
                                                </td>
                                                <td>{{ $u->created_at }}</td>
                                                @if (Auth::user()->id == $u->id)
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <span class="badge badge-success mr-2">Online</span>
                                                        </div>
                                                    </td>
                                                @else
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <a class="btn btn-sm btn-info btn-icon btn-edit"
                                                                id-users="{{ $u->id }}">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form class="ml-2">
                                                                <button
                                                                    class="btn btn-sm btn-danger btn-icon confirm-delete"
                                                                    value="{{ $u->id }}">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $patient->withQueryString()->links() }}
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
            $('#add-btn').on('click', function() {
                $('#modalTitle').text('Tambah User');
                $.ajax({
                    url: '{{ route('addUser') }}',
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
            $('.btn-edit').on('click', function() {
                var userId = $(this).attr('id-users');
                $('#modalTitle').text('Edit User');
                $.ajax({
                    url: `{{ route('editUser', ['id' => ':userId']) }}`.replace(':userId', userId),
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

            $('.confirm-delete').on('click', function() {
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
                            url: '{{ route('deleteUser') }}',
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
                                        '{{ route('managementUser') }}';
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
