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

<div class="container mt-5" style="margin-bottom: 10vh">
    <div class="row g-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between" data-bs-toggle="collapse"
                    data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <h3 class="card-title">{{ $title ?? env('APP_NAME') }}</h3>
                    <p class="card-subtitle text-muted" id="tanggal_jam"></p>
                    <script>
                        function updateDateTime() {
                            var d = new Date();
                            var options = {
                                year: 'numeric',
                                month: 'long',
                                day: 'numeric'
                            };
                            var date = d.toLocaleDateString('id-ID', options);
                            var time = d.toLocaleTimeString();
                            document.getElementById("tanggal_jam").innerHTML = date + ' ' + time;
                        }
                        updateDateTime();
                        setInterval(updateDateTime, 1000);

                    </script>

                </div>
                <div class="card-body" id="collapseExample">
                    <div class="row">
                        <div class="col-md-12">
                            <table id="tagihanDetailsTable" class="table table-hover">
                                <colgroup>
                                    <col style="width: 30%;">
                                    <col style="width: 70%;">
                                </colgroup>
                                <tr>
                                    <td>No. Pendaftaran</td>
                                    <td>&emsp;&emsp;: <span
                                            id="no_pendaftarans">{{ $pendaftaran->no_pendaftaran ?? ' -'}}</span></td>
                                </tr>
                                <tr>
                                    <td>No. Rekam Medis</td>
                                    <td>&emsp;&emsp;: <span id="no_rm">{{ $pendaftaran->no_rm ?? ' -'}}</span></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td>&emsp;&emsp;: <span id="nik">{{ $pendaftaran->nik ?? ' -' }}</span></td>
                                </tr>
                                <tr>
                                    <td>Nama Pasien</td>
                                    <td>&emsp;&emsp;: <span
                                            id="nama_pasien">{{ $pendaftaran->nama_pasien ?? ' -'}}</span></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td>&emsp;&emsp;: <span id="alamat">{{ $pendaftaran->alamat ?? ' -'}}</span></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Lahir</td>
                                    <td>&emsp;&emsp;: <span
                                            id="tanggal_lahir">{{ $pendaftaran->tanggal_lahir ?? ' -'}}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td>&emsp;&emsp;: <span id="jk">{{ $pendaftaran->jk ?? ' -'}}</span></td>
                                </tr>
                                <tr>
                                    <td>Poli</td>
                                    <td>&emsp;&emsp;: <span id="poli">{{ $pendaftaran->nama_poli ?? ' -'}}</span></td>
                                </tr>
                                <tr>
                                    <td>Dokter</td>
                                    <td>&emsp;&emsp;: <span id="dokter">{{ $pendaftaran->nama ?? ' -'}}</span></td>
                                </tr>
                                <tr>
                                    <td>Spesialis</td>
                                    <td>&emsp;&emsp;: <span
                                            id="spesialis">{{ $pendaftaran->spesialisasi ?? ' -'}}</span></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Daftar</td>
                                    <td>&emsp;&emsp;: <span
                                            id="tanggal_daftar">{{ $pendaftaran->tanggal_daftar ?? ' -'}}</span></td>
                                </tr>
                                <tr>
                                    <td>Keluhan</td>
                                    <td>&emsp;&emsp;: <span id="keluhan">{{ $pendaftaran->keluhan ?? ' -'}}</span></td>
                                </tr>

                            </table>
                            <div class="mt-5 mb-5">
                                <table id="tagihanDetailsTable" class="table table-hover">
                                    <colgroup>
                                        <col style="width: 30%;">
                                        <col style="width: 70%;">
                                    </colgroup>
                                    <tr>
                                        <td>Tinggi Badan</td>
                                        <td>&emsp;&emsp;: <span id="sda">-</span></td>
                                    </tr>
                                    <tr>
                                        <td>Berat Badan</td>
                                        <td>&emsp;&emsp;: <span id="no_rm">-</span></td>
                                    </tr>
                                    <tr>
                                        <td>Tekanan Darah</td>
                                        <td>&emsp;&emsp;: <span id="nik">-</span></td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal Daftar</td>
                                        <td>&emsp;&emsp;: <span
                                                id="tanggal_daftar">{{ $pendaftaran->tanggal_daftar ?? ' -'}}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Keluhan</td>
                                        <td>&emsp;&emsp;: <span id="keluhan">{{ $pendaftaran->keluhan ?? ' -'}}</span>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h3 class="card-title">{{ __('Input Diagnosa Pasien') }}</h3>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                                        <li class="nav-item">
                                            <a href="#tabs-home-7" class="nav-link active" data-bs-toggle="tab">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/stethoscope -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-file-plus">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                    <path
                                                        d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                                    <path d="M12 11l0 6" />
                                                    <path d="M9 14l6 0" /></svg>
                                                Input Diagnosa</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="#tabs-riwayat-pemeriksaan" class="nav-link" data-bs-toggle="tab">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24"
                                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                                    stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M3 12h4l3 8l4 -16l3 8h4" /></svg>

                                                Riwayat Pemeriksaan</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane active show" id="tabs-home-7">
                                            <x-form_nomodal :form="$form_daftar" :title="$title ?? env('APP_NAME')" />

                                        </div>
                                        <div class="tab-pane" id="tabs-riwayat-pemeriksaan">
                                            <table id="laravel_datatable"
                                                class="table table-striped table-bordered display nowrap"
                                                style="width: 100%">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Kode Diagnosa</th>
                                                        <th>No. Pendaftaran</th>
                                                        <th>Tanggal Diagnosa</th>
                                                        <th>Tinggi Badan</th>
                                                        <th>Berat Badan</th>
                                                        <th>Tekanan Darah</th>
                                                        <th>Hasil Pemeriksaan</th>
                                                        <th>Diagnosa</th>
                                                        <th>Tindakan</th>
                                                        <th>Resep Obat</th>
                                                        <th>Pemeriksaan Lanjutan</th>
                                                        <th>Catatan</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>

                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>




        {{-- Modal loading --}}
        <x-popup.loading />

        {{-- Modal konfirmasi --}}
        <x-popup.modal_delete_confirmation />




        <script type="text/javascript">
            $(document).ready(function () {
                $('#no_pendaftaran').val('{{ $pendaftaran->no_pendaftaran }}');

                $('#pasien_id').val('{{ $pendaftaran->pasien_id }}');



                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });


                var pasienId = '{{$pendaftaran->pasien_id}}';
                $('#laravel_datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ url('layanans/pemeriksaan-pasien/getDataDiagnosis') }}/" + pasienId,
                    columns: [{
                            data: 'id',
                            name: 'id',
                            render: function (data, type, row, meta) {
                                return meta.row + 1;
                            }
                        },
                        {
                            data: 'kd_diagnosa',
                            name: 'kd_diagnosa'
                        },
                        {
                            data: 'kd_pendaftaran',
                            name: 'kd_pendaftaran'
                        },
                        {
                            data: 'tanggal_diagnosa',
                            name: 'tanggal_diagnosa'
                        },
                        {
                            data: 'tinggi_badan',
                            name: 'tinggi_badan'
                        },
                        {
                            data: 'berat_badan',
                            name: 'berat_badan'
                        },
                        {
                            data: 'tekanan_darah',
                            name: 'tekanan_darah'
                        },
                        {
                            data: 'hasil_pemeriksaan',
                            name: 'hasil_pemeriksaan'
                        },
                        {
                            data: 'diagnosa',
                            name: 'diagnosa'
                        },
                        {
                            data: 'tindakan',
                            name: 'tindakan'
                        },
                        {
                            data: 'resep_obat',
                            name: 'resep_obat'
                        },
                        {
                            data: 'pemeriksaan_lanjutan',
                            name: 'pemeriksaan_lanjutan'
                        },
                        {
                            data: 'catatan',
                            name: 'catatan'
                        },

                    ],
                    responsive: true,
                    scrollX: true,

                });


                $('#saveBtn').click(function (e) {
                    e.preventDefault();
                    $('#saveBtn').html('Sending..');

                    // memasang user_id



                    // Reset error messages
                    $('#hasil_pemeriksaanError').text('');
                    $('#diagnosaError').text('');
                    $('#tindakanError').text('');


                    var actionType = $(this).val();
                    var formData = new FormData($('#userForm')[0]);
                    
                


                    $.ajax({
                        data: formData,
                        url: "{{ route('pemeriksaan-pasien.store') }}",
                        type: "POST",
                        dataType: 'json',
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#userForm').trigger("reset");
                            $('#laravel_datatable').DataTable().ajax.reload();
                            $('#saveBtn').html('Save Changes');

                            // Tampilkan alert sukses

                                $('#alertPlaceholder').html(`
                            @component('components.popup.alert', ['type' => 'success', 'message' => 'Dokter baru ditambahkan!'])
                            @endcomponent
                        `);
                            
                        },
                        error: function (xhr) {
                            $('#saveBtn').html('Save Changes');

                            // Tampilkan pesan error
                            if (xhr.status === 422) {
                                let errors = xhr.responseJSON.errors;
                                if (errors.hasil_pemeriksaan) {
                                    $('#hasil_pemeriksaanError').text(errors.hasil_pemeriksaan[0]);
                                }
                                if (errors.diagnosa) {
                                    $('#diagnosaError').text(errors.diagnosa[0]);
                                }
                                if (errors.tindakan) {
                                    $('#tindakanError').text(errors.tindakan[0]);
                                }
                            } else {
                                $('#alertPlaceholder').html(`
                            @component('components.popup.alert', ['type' => 'danger', 'message' => 'Diagnosis gagal ditambahkan!'])
                            @endcomponent
                        `);
                            }
                        }
                    });
                });


            });

        </script>
        @endsection
