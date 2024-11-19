@extends('index')

@section('content')
<div class="page-header d-print-none">

    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                    Overview
                </div>
                <h2 class="page-title">
                    Menu {{ $title ?? env('APP_NAME') }}
                    <!-- Page title actions -->
            </div>
        </div>
    </div>
</div>
{{-- Alert --}}
<div id="alertPlaceholder" class="alert-position-top-right"></div>

<div class="container mt-5">

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? env('APP_NAME') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="laravel_datatable" class="table table-striped table-bordered display nowrap"
                        style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>No. Antrian</th>
                                <th>No. Pendaftaran</th>
                                <th>No. Rekam Medis</th>
                                <th>Nama Pasien</th>
                                <th>Dokter</th>
                                <th>Poli</th>
                                <th>Tanggal Daftar</th>
                                <th>Keluhan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>

{{-- Modal loading --}}
<x-popup.loading />

{{-- Modal konfirmasi --}}
<x-popup.modal_delete_confirmation />


<script type="text/javascript">
    $(document).ready(function () {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


        $('#laravel_datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('pendaftarans.listpendaftarans') }}",
            order: [[0, 'desc']],
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'no_antrian',
                    name: 'no_antrian'
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
                                'Dalam Antrian' + '</span>';
                        } else if (data == 'Selesai') {
                            return '<span class="badge bg-success text-white">' +
                                'Selesai' + '</span>';
                        } else {
                            return '<span class="badge bg-danger text-white">' + 'Gagal' +
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
