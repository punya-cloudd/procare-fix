@extends('backend.app')
@section('title')
    Data Role
@stop

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex align-items-center">
                                <h4 class="card-title">Data Role</h4>
                                <a href="{{ route('roles.create') }}" class="btn btn-secondary ms-auto btn-sm">
                                    <i class="fa fa-plus"></i> Tambah Role
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="role-table" class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th class="select-filter">Nama Role</th>
                                            <th class="select-filter">Dibuat Pada</th>
                                            <th width="130px">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1; ?>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $no }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>{{ $role->created_at }}</td>
                                                <td>
                                                    <a class="btn btn-info btn-round btn-sm"
                                                        href="{{ route('roles.show', $role->id) }}">
                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                    </a>
                                                    @can('role-edit')
                                                        <a class="btn btn-primary btn-round btn-sm"
                                                            href="{{ route('roles.edit', $role->id) }}">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    @endcan
                                                    @can('role-delete')
                                                        <button class="btn btn-danger btn-round btn-sm"
                                                            onclick="deleteRole({{ $role->id }})">
                                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                                        </button>
                                                    @endcan
                                                </td>
                                            </tr>
                                            <?php $no++; ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#role-table').DataTable();

        function deleteRole(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var token = $("meta[name='csrf-token']").attr("content");

                    $.ajax({
                        url: '/backend/roles/' + id,
                        type: 'DELETE',
                        data: {
                            _token: token,
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                Swal.fire({
                                    position: 'top-center',
                                    icon: 'success',
                                    title: 'Role Deleted Successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.reload();
                                });
                            } else {
                                Swal.fire('Error', 'Failed to delete role!', 'error');
                            }
                        },
                        error: function(xhr) {

                            console.log(xhr.responseText);

                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: xhr.responseJSON?.message ?? 'Failed to delete role!'
                            });

                        }
                    });
                }
            });
        }
    </script>
@endsection
