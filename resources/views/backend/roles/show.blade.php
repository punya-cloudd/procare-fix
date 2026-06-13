@extends('backend.app')
@section('title', 'Detail Role & Permission')

@section('content')
<div class="container">
    <div class="page-inner">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">Detail Role</h4>
                            <a href="{{ route('roles.index') }}" class="btn btn-info ms-auto btn-sm">
                                <i class="fa fa-arrow-left"></i> Kembali
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table pl-10 table-bordered">
                                <tbody>
                                    <tr>
                                        <th>Nama Role</th>
                                        <td>{{ $role->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Permission</th>
                                        <td>
                                            @if(!empty($rolePermissions))
                                                @foreach($rolePermissions as $v)
                                                    <button class="btn btn-secondary btn-border btn-round btn-sm mr-1 mb-1 mt-2">
                                                        {{ $v->name }}
                                                    </button>
                                                @endforeach
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Dibuat Pada</th>
                                        <td>{{ $role->created_at }}</td>
                                    </tr>
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
