<div class="modal modal-blur fade" id="ajaxScanner" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            {{-- <div class="modal-header">
                <h5 class="modal-title" id="modelHeading">New {{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
            </div> --}}
            <div id="qr-reader" style="width: 100%;"></div>
            <div id="qr-reader-results"></div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode"></script>

<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Tampilkan hasil yang dipindai
        // console.log(`Code matched = ${decodedText}`, decodedResult);
        $.ajax({
                        url: "{{ route('pendaftarans.cekpendaftaran.getinfopendaftaran') }}",
                        type: "POST",
                        dataType: 'json',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_pendaftaran: decodedText
                        },
                        success: function (data) {
                            $('#cekPendaftaran').trigger("reset");
                            $('#ajaxModel').modal('hide');
                            $('#ajaxScanner').modal('hide');
                            $('#cariPendaftaran').html('Save Changes');

                            @foreach ($form1 as $item)
                                $('#{{ $item['field'] }}').val(data.{{ $item['field'] }});
                            @endforeach

                            @foreach ($form2 as $item)
                                $('#{{ $item['field'] }}').val(data.{{ $item['field'] }});
                            @endforeach

                            @foreach ($form3 as $item)
                                $('#{{ $item['field'] }}').val(data.{{ $item['field'] }});
                            @endforeach

                            // Tampilkan alert sukses
                            
                                $('#alertPlaceholder').html(`
                            @component('components.popup.alert', ['type' => 'success', 'message' => 'Pencarian berhasil!'])
                            @endcomponent`)
            
                        },
                        error: function (xhr) {
                            $('#cariPendaftaran').html('Save Changes');

                            // Tampilkan pesan error
                            if (xhr.status === 422) {
                                $('#alertPlaceholder').html(`
                            @component('components.popup.alert', ['type' => 'danger', 'message' => 'Kode QR Tidak Valid!'])
                            @endcomponent
                                `);
                            } else {
                                $('#alertPlaceholder').html(`
                            @component('components.popup.alert', ['type' => 'danger', 'message' => 'Pencarian gagal! Cek kembali Nomor Pendaftarannya'])
                            @endcomponent
                                `);
                            }
                        }
                    });

        // Anda dapat mengirim hasil ini ke Laravel dengan AJAX
        // alert(`Hasil QR Code: ${decodedText}`);
    }

    function onScanFailure(error) {
        // Handle scan failure
        console.warn(`QR Code scan failed. Error: ${error}`);
    }

    // Inisialisasi pemindai QR Code
    let html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 300 });
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>

