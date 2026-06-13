@extends('backend.app')
@section('title', 'Edit Role & Permission')

@section('content')
<!-- ============================================================== -->
<!-- Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
@include('backend.roles.breadcrumb')
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">
    <!-- Notifikasi Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-12">
            <!-- Tombol Kembali -->
            <div class="mb-3 d-flex justify-content-end">
                <a href="{{ route('roles.index') }}" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i> Kembali
                </a>
            </div>

            <div class="card">
                @if (count($errors) > 0)
                    <div class="alert alert-danger custom-error">
                        <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-body">
                    <form action="{{ route('roles.update', $role) }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="mb-3">
                                    <label class="mb-2" for="name">Nama Role <strong style="color: red;">*</strong></label>
                                    <input type="text" name="name" placeholder="Nama Role" value="{{ old('name', $role->name) }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label class="mb-2" for="permission">Permission <strong style="color: red;">*</strong></label>
                                    <div class="selectgroup selectgroup-pills">
                                        @foreach($permission as $value)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" 
                                                    {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }} 
                                                    id="checkbox{{ $value->id }}" 
                                                    name="permission[]" 
                                                    value="{{ $value->id }}" 
                                                    type="checkbox">
                                                <label class="form-check-label" for="flexCheckDefault{{ $value->id }}">
                                                    {{ $value->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 30px">
                                <button type="button" class="btn btn-secondary mr-3" id="select-all-button">
                                    <input type="checkbox" class="mr-2" id="select-all"> Pilih Semua
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Simpan
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Fungsi untuk memilih semua checkbox
        $('#select-all').click(function() {
            var checked = this.checked;
            $('input[type="checkbox"]').each(function() {
                this.checked = checked;
            });
        });
    });
</script>
@endsection
