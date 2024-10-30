@extends('index')

@section('styles')
<style>
    form[disabled] {
            opacity: 0.5;
            pointer-events: none;
        }
</style>
    
@endsection

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

<div class="container-xl mt-3">
    <div class="card mt-3">
        <div class="card-header d-flex align-items-center justify-content-between">
            <h3 class="card-title">Data Pasien</h3>
            <div class="col-auto ms-auto d-print-none">
                <button type="button" class="btn btn-outline-gr cariPasien" id="cari_pasien" value="search">Cari Pasien</button>
            </div>
        </div>
        <div class="card-body">
            <div class="mb-3">
                <form id="FormPasien" name="userForm" class="form-horizontal">
                    <div class="row">
                    <input type="hidden" name="user_id" id="user_id">
                    @foreach ($form as $field)
                        <div class="form-group mb-3 col-md-{{ $field['width'] ?? 12 }}">
                            <label for="{{ $field['field'] }}" class="control-label">
                                {{ $field['label'] }}
                                @if ($field['required'] ?? false)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            @if ($field['type'] === 'textarea')
                                <textarea class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }}{{ $field['disabled'] ?? false ? 'disabled readonly' : '' }} ></textarea>
                            @elseif ($field['type'] === 'file')
                                <input type="file" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" {{ $field['required'] ?? false ? 'required' : '' }}{{ $field['disabled'] ?? false ? 'disabled' : '' }}>
                            @elseif ($field['type'] === 'password')
                                <input type="password" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }}{{ $field['disabled'] ?? false ? 'disabled' : '' }}>
                            @elseif ($field['type'] === 'email')
                                <input type="email" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }} {{ $field['disabled'] ?? false ? 'disabled' : '' }}>
                            @elseif ($field['type'] === 'number')
                                <input type="number" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }} {{ $field['disabled'] ?? false ? 'disabled' : '' }}>
                            @elseif ($field['type'] === 'date')
                                <input type="date" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }} {{ $field['disabled'] ?? false ? 'disabled' : '' }}>
                            @elseif ($field['type'] === 'select')
                                <select class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" {{ $field['required'] ?? false ? 'required' : '' }}>
                                    <option value="" disabled selected>{{ $field['placeholder'] }}</option>
                                    @foreach ($field['options'] as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" class="form-control" id="{{ $field['field'] }}" name="{{ $field['field'] }}" placeholder="{{ $field['placeholder'] }}" {{ $field['required'] ?? false ? 'required' : '' }} {{ $field['disabled'] ?? false ? 'disabled' : '' }}>
                            @endif
                            <span class="text-danger" id="{{ $field['field'] }}Error"></span>
                        </div>
                    @endforeach
                </div>
                    
                </form>
            </div>
        </div>
    </div>

    <div class="card disabled mt-4">
        <div class="card-header">
            <h3 class="card-title">{{ $title ?? env('APP_NAME') }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-3">
                {{-- Component form no modal --}}
                <x-form_nomodal :form="$form_daftar" :title="$title ?? env('APP_NAME')" />
            </div>
        </div>

{{-- Modal loading --}}
<x-popup.loading />

{{-- Modal konfirmasi --}}
<x-popup.modal_delete_confirmation />


<script>
$(document).ready(function () { 
    $('#userForm').find('input, select, textarea, button').prop('disabled', true);

    $('body').on('click', '.cariPasien', function () {
        var no_rm = $('#no_rm').val();

        if (!no_rm) {
            var alertHtml = `
                @component('components.popup.alert', ['type' => 'danger', 'message' => 'No. Rekam Medis harus diisi!'])
                @endcomponent
            `;
            
            // Tambahkan alert baru ke dalam placeholder
            $('#alertPlaceholder').append(alertHtml);

            return false;
        }

        // Tampilkan loading
        $('#loadingModal').modal('show');

        $.get("{{ route('pendaftarans.show', '') }}" + '/' + no_rm, function (data) {

            if (data) {
                var suksesHtml = `
                    @component('components.popup.alert', ['type' => 'success', 'message' => 'Pasien ditemukan!'])
                    @endcomponent
                `;
                
                // Tambahkan alert baru ke dalam placeholder
                $('#alertPlaceholder').append(suksesHtml);

                $('#nik').val(data.nik);
                $('#nama_pasien').val(data.nama_pasien);
                $('#tanggal_lahir').val(data.tanggal_lahir);
                $('#jk').val(data.jk);
                $('#agama').val(data.agama);
                $('#pekerjaan').val(data.pekerjaan);
                $('#kewarganegaraan').val(data.kewarganegaraan);
                $('#alamat').val(data.alamat);
                $('#no_hp').val(data.no_hp);
                $('#email').val(data.email);

                $('#userForm').find('input, select, textarea, button').prop('disabled', false);
            } else {
                var pasienHtml = `
                    @component('components.popup.alert', ['type' => 'danger', 'message' => 'Pasien tidak ditemukan!'])
                    @endcomponent
                `;
                
                // Tambahkan alert baru ke dalam placeholder
                $('#alertPlaceholder').append(pasienHtml);

                $('#userForm').find('input, select, textarea, button').prop('disabled', true);
            }

            // Tutup modal loading setelah data berhasil diambil atau tidak ditemukan
            $('#loadingModal').modal('hide');

        }).fail(function() {
            var errorHtml = `
                @component('components.popup.alert', ['type' => 'danger', 'message' => 'Terjadi kesalahan saat mengambil data!'])
                @endcomponent
            `;
                
            // Tambahkan alert baru ke dalam placeholder
            $('#alertPlaceholder').append(errorHtml);

            $('#userForm').find('input, select, textarea, button').prop('disabled', true);

            // Tutup modal loading jika terjadi kesalahan
            $('#loadingModal').modal('hide');

        }).always(function() {
            // Pastikan modal loading tertutup setelah selesai proses (sukses atau gagal)
            $('#loadingModal').modal('hide');
            setTimeout(function() {
                $('#loadingModal').modal('hide');
            }, 500);
        });
    });

    $('#poli_id').on('change', function() {
        var poliId = $(this).val();
        $.ajax({
            type: 'GET',
            url: "/data/datapolis/getDokterByPoliId/" + poliId,
            success: function(data) {
                $('#dokter_id').empty();
                if (data.length > 0) {
                    $('#dokter_id').append('<option value="" selected>Pilih Dokter</option>');
                    $.each(data, function(index, value) {
                        $('#dokter_id').append('<option value="' + value.id + '">' + value.nama + '</option>');
                    });
                } else {
                    $('#dokter_id').append('<option value="" selected>Tidak ada dokter</option>');
                }
            }
        });
    });
});

</script>
@endsection
