@extends('index')

@section('content')
<div class="container-xl">
    <div class="row g-2 align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
                Overview
            </div>
            <h2 class="page-title">
                Menu Dashboard
                <!-- Page title actions -->
        </div>
    </div>

    <div class="container mt-5">
        <div class="row g-3">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('Data Pendaftaran') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="laravel_datatable" class="table table-striped table-bordered display nowrap"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>No. Pendaftaran</th>
                                            <th>No. Rekam Medis</th>
                                            <th>Nama Pasien</th>
                                            <th>Dokter</th>
                                            <th>Poli</th>
                                            <th>Tanggal Daftar</th>
                                            <th>Keluhan</th>
                                            <th>Status</th>
                                            {{-- <th>Action</th> --}}
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Data Dokter') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table id="data_dokter" class="table table-striped table-bordered display nowrap"
                                            style="width: 100%">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Kode Dokter</th>
                                                    <th>Nama Dokter</th>
                                                    <th>Alamat</th>
                                                    <th>Email</th>
                                                    <th>Spesialisasi</th>
                                                    <th>No. HP</th>
                                                    <th>Tanggal Lahir</th>
                                                    <th>Jenis Kelamin</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">{{ __('Data Pasien') }}</h3>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <table id="data_pasien" class="table table-striped table-bordered display nowrap"
                                            style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>No. Rekam Medis</th>
                                                <th>NIK</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Agama</th>
                                                <th>Pekerjaan</th>
                                                <th>Alamat</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <script type="text/javascript">
                $(document).ready(function () {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $('#data_pasien').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('pasiens.index') }}",
                    columns: [{
                            data: 'id',
                            name: 'id'
                        },
                        {
                            data: 'no_rm',
                            name: 'no_rm'
                        },
                        {
                            data: 'nik',
                            name: 'nik'
                        },
                        {
                            data: 'tanggal_lahir',
                            name: 'tanggal_lahir'
                        },
                        {
                            data: 'jk',
                            name: 'jk'
                        },
                        {
                            data: 'agama',
                            name: 'agama'
                        },
                        {
                            data: 'pekerjaan',
                            name: 'pekerjaan'
                        },
                        {
                            data: 'alamat',
                            name: 'alamat'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    responsive: true,
                    scrollX: true,
                });

                    $('#data_dokter').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dokters.index') }}",
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'kd_dokter',
                    name: 'kd_dokter'
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    data: 'alamat',
                    name: 'alamat'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'spesialisasi',
                    name: 'spesialisasi'
                },
                {
                    data: 'no_hp',
                    name: 'no_hp'
                },
                {
                    data: 'tanggal_lahir',
                    name: 'tanggal_lahir'
                },
                {
                    data: 'jk',
                    name: 'jk'
                },
                {
                    data: 'status',
                    name: 'status',
                    render: function (data, type, row) {
                        if (data == 'aktif') {
                            return '<span class="badge bg-success text-white">' +
                                'Aktif' + '</span>';
                        } else if (data == 'tidak') {
                            return '<span class="badge bg-danger text-white">' +
                                'Tidak Aktif' + '</span>';
                        } else {
                            return '<span class="badge bg-warning">' + 'Belum diatur' +
                                '</span>';
                        }
                    }
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            responsive: true,
            scrollX: true,

        });


                    $('#laravel_datatable').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ route('pendaftarans.listpendaftarans') }}",
                        columns: [{
                                data: 'id',
                                name: 'id'
                            },
                            {
                                data: 'no_pendaftaran',
                                name: 'no_pendaftaran'
                            },
                            {
                                data: 'pasien_id',
                                name: 'pasien_id'
                            },
                            {
                                data: 'nama_pasien',
                                name: 'nama_pasien'
                            },
                            {
                                data: 'dokter_id',
                                name: 'dokter_id'
                            },
                            {
                                data: 'poli_id',
                                name: 'poli_id'
                            },

                            {
                                data: 'tanggal_daftar',
                                name: 'tanggal_daftar'
                            },
                            {
                                data: 'keluhan',
                                name: 'keluhan'
                            },
                            {
                                data: 'status',
                                name: 'status',
                                render: function (data, type, row) {
                                    if (data == 'Terdaftar') {
                                        return '<span class="badge bg-primary text-white">' +
                                            'Terdaftar' + '</span>';
                                    } else if (data == 'Dalam Antrian') {
                                        return '<span class="badge bg-warning text-white">' +
                                            'Menunggu' + '</span>';
                                    } else if (data == 'Selesai') {
                                        return '<span class="badge bg-success text-white">' +
                                            'Menunggu' + '</span>';
                                    } else {
                                        return '<span class="badge bg-warning">' +
                                            'Belum diatur' +
                                            '</span>';
                                    }
                                }
                            },
                            // {
                            //     data: 'action',
                            //     name: 'action',
                            //     orderable: false,
                            //     searchable: false
                            // },
                        ],
                        responsive: true,
                        scrollX: true,

                    });
                });

            </script>

            @endsection
