@extends('backend.app')
@section('title', 'Tambah Role & Permission')
@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Data Role</h4>
                            <a href="{{ route('roles.index') }}" class="btn btn-info ms-auto btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('roles.store') }}" method="post">
                            @csrf
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12">
                                        <div class="mb-3">
                                            <label class="mb-2" for="name">Nama Role <strong style="color: red;">*</strong></label>
                                            <input type="text" name="name" placeholder="Nama Role" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">

                                            @error('name')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                        <div class="mb-3">
                                            <label class="mb-2" for="permission">Permission <strong style="color: red;">*</strong></label>
                                            <div class="selectgroup selectgroup-pills">
                                                @foreach($permission as $value)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input @error('permission') is-invalid @enderror" id="checkbox{{$value->id}}" name="permission[]" value="{{$value->id}}" type="checkbox">
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $value->name }}
                                                    </label>
                                                </div>
                                                <label class="selectgroup-item">
                                                </label>
                                                @endforeach
                                            </div>

                                            @error('permission')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-12 col-md-12" style="margin-top: 20px">
                                        <button type="button" class="btn btn-secondary btn-sm mr-3">
                                            <input type="checkbox" class="mr-3" id="select-all"> Pilih Semua
                                        </button>
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fa fa-save"></i> Simpan
                                        </button>
                                    </div>
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
        $('#select-all').click(function() {
            var checked = this.checked;
            $('input[type="checkbox"]').each(function() {
            this.checked = checked;
        });
        })
    });
</script>
@endsection
