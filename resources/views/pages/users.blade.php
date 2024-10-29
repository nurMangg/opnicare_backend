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
            Menu {{ $title ?? env('APP_NAME') }}
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <a href="javascript:void(0)" class="btn btn-primary d-none d-sm-inline-block" id="createNewUser">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Create {{ $title ?? env('APP_NAME') }}
                </a>
            
            </div>
        </div>
    </div>
</div>

{{-- Alert --}}
<div id="alertPlaceholder"></div>

<div class="container-xl mt-5">
    <div class="row row-card">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $title ?? env('APP_NAME') }}</h3>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <table class="table" id="laravel_datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                </div>
            </div>
    </div>
</div>

{{-- Ajax Modal --}}
<x-form :form="$form" :title="$title ?? env('APP_NAME')"/>

{{-- Modal loading --}}
<x-popup.loading/>

{{-- Modal konfirmasi --}}
<x-popup.modal_delete_confirmation/>


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
          ajax: "{{ route('users.index') }}",
          columns: [
              {data: 'id', name: 'id'},
              {data: 'name', name: 'name'},
              {data: 'email', name: 'email'},
              {data: 'action', name: 'action', orderable: false, searchable: false},
          ]
      });

      $('#createNewUser').click(function () {
            $('#saveBtn').val("create-user");
            $('#user_id').val('');
            $('#userForm').trigger("reset");
            $('#modelHeading').html("Add New User");
            $('#ajaxModel').modal('show');
        });

    $('body').on('click', '.editProduct', function () {
        var user_id = $(this).data('id');
        $.get("{{ route('users.index') }}" + '/' + user_id + '/edit', function (data) {
            $('#modelHeading').html("Edit {{ $title ?? env('APP_NAME') }}");
            $('#saveBtn').val("edit-user");
            $('#ajaxModel').modal('show');
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#email').val(data.email);
        })
    });

    $('#saveBtn').click(function (e) {
        e.preventDefault();
        $('#saveBtn').html('Sending..');

        // Reset error messages
        $('#nameError').text('');
        $('#emailError').text('');
        $('#passwordError').text('');

        var actionType = $(this).val();
            var url = actionType === "create-user" ? "{{ route('users.store') }}" : "{{ route('users.index') }}/" + $('#user_id').val();

            // Tentukan jenis permintaan (POST atau PUT)
            var requestType = actionType === "create-user" ? "POST" : "PUT";

            $.ajax({
                data: $('#userForm').serialize(),
                url: url,
                type: requestType,
                dataType: 'json',
                success: function (data) {
                    $('#userForm').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    $('#laravel_datatable').DataTable().ajax.reload();
                    $('#saveBtn').html('Save Changes');

                    // Tampilkan alert sukses
                    if (actionType === "create-user") {
                        $('#alertPlaceholder').html(`
                            @component('components.popup.alert', ['type' => 'success', 'message' => 'User baru ditambahkan!'])
                            @endcomponent
                        `);
                    } else {
                        $('#alertPlaceholder').html(`
                            @component('components.popup.alert', ['type' => 'success', 'message' => 'User diperbarui!'])
                            @endcomponent
                        `);
                    }
                },
                error: function (xhr) {
                    $('#saveBtn').html('Save Changes');

                    // Tampilkan pesan error
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#nameError').text(errors.name[0]);
                        }
                        if (errors.email) {
                            $('#emailError').text(errors.email[0]);
                        }
                    } else {
                        $('#alertPlaceholder').html(`
                            @component('components.popup.alert', ['type' => 'danger', 'message' => 'User gagal ditambahkan!'])
                            @endcomponent
                        `);
                    }
                }
            });
        });
    });

    $('body').on('click', '.deleteProduct', function () {
            var user_id = $(this).data('id');
            $('#confirmDeleteModal').modal('show');

            // Handle konfirmasi hapus
            $('#confirmDeleteBtn').off('click').on('click', function () {
                $.ajax({
                    type: 'DELETE',
                    url: "{{ route('users.index') }}/" + user_id,
                    success: function (data) {
                        $('#laravel_datatable').DataTable().ajax.reload();
                        $('#confirmDeleteModal').modal('hide');
                        
                        // Tampilkan alert sukses
                        $('#alertPlaceholder').html(`
                            @component('components.popup.alert', ['type' => 'success', 'message' => 'User berhasil dihapus!'])
                            @endcomponent
                        `);
                    },
                    error: function (xhr) {
                        $('#confirmDeleteModal').modal('hide');
                        
                        // Tampilkan alert error
                        $('#alertPlaceholder').html(`
                            @component('components.popup.alert', ['type' => 'danger', 'message' => 'User gagal dihapus!'])
                            @endcomponent
                        `);
                    }
                });
            });
        });

    
    
    
</script>
@endsection
