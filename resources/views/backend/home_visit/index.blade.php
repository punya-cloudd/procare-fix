@extends('backend.app')

@section('title','Data Home Visit')

@section('content')

<div class="container">
<div class="page-inner">

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card">

    <div class="card-header">

        <div class="d-flex align-items-center">

            <div>

                <h4 class="card-title">
                    Home Visit
                </h4>

                <small class="text-muted">
                    Kunjungan rumah pasien Prolanis
                </small>

            </div>

            <a href="{{ route('home_visit.create') }}"
                class="btn btn-primary btn-round ms-auto">

                <i class="fa fa-plus"></i>

                Buat Agenda Home Visit

            </a>

        </div>

    </div>


    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-bordered table-hover" id="table">

                <thead class="table-light">

                    <tr>

                        <th>No</th>

                        <th>Pasien</th>

                        <th>Alasan</th>

                        <th>Jadwal HV</th>

                        <th>Petugas</th>

                        <th>Status</th>

                        <th width="230">
                            Aksi
                        </th>

                    </tr>

                </thead>

            </table>

        </div>

    </div>

</div>

</div>
</div>

@endsection



@section('script')

<script>

$(function(){

    $('#table').DataTable({

        processing:true,
        serverSide:true,

        ajax:{
            url:"{{ route('home_visit.index') }}"
        },

        order:[[3,'desc']],

        columns:[

            {

                data:'DT_RowIndex',
                name:'DT_RowIndex',

                searchable:false,
                orderable:false

            },

            {

                data:'nama',
                name:'nama'

            },

            {

                data:'alasan',
                name:'alasan',

                defaultContent:'-'

            },

            {

                data:'tanggal',
                name:'tanggal'

            },

            {

                data:'petugas',
                name:'petugas'

            },

            {

                data:'status',
                name:'status',

                render:function(data){

                    if(data=="Terjadwal"){

                        return '<span class="badge bg-warning">TERJADWAL</span>';

                    }

                    if(data=="Selesai"){

                        return '<span class="badge bg-success">SELESAI</span>';

                    }

                    return '<span class="badge bg-danger">BATAL</span>';

                }

            },

            {

                data:'action',
                name:'action',

                searchable:false,
                orderable:false,

                className:'text-center'

            }

        ]

    });



    $(document).on('click','.delete',function(){

        let id=$(this).data('id');

        Swal.fire({

            title:'Hapus Data?',

            text:'Data akan dihapus',

            icon:'warning',

            showCancelButton:true,

            confirmButtonText:'Ya'

        }).then((result)=>{

            if(result.isConfirmed){

                $.ajax({

                    url:"/home_visit/"+id,

                    type:"DELETE",

                    data:{

                        _token:"{{ csrf_token() }}"

                    },

                    success:function(){

                        $('#table').DataTable().ajax.reload();

                        Swal.fire(

                            'Berhasil',

                            'Data berhasil dihapus',

                            'success'

                        );

                    }

                });

            }

        });

    });

});

</script>

@endsection