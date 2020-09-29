@extends('adminlte::page')

@section('title', 'Home')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Almacen</h1>
@stop

@section('content')
@include('warehouse/partials/modal')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="userTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                            </tr>
                        </thead>

                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
<script src="https://cdn.datatables.net/responsive/2.2.6/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.6/js/responsive.bootstrap4.min.js"></script>
<script>
    $(document).ready(function() {
    $('#userTable').DataTable( {
        dom:    
                    "<'row'<'col-md-8 crud-buttons'B><'col-md-4'f>>" +
                    "<'row'<'col-sm-12 col-12'<'#tableScroll.scrollable-table table-responsive't><'p-5'r>>>" +
                    "<'row custom-pagination'<'col-sm-12 col-md-4 mt-3'l><'col-sm-12 col-md-4 text-center align-self-center'i><'col-sm-12 col-md-4 mt-3'p>>",
        "language": {
            "lengthMenu": "Mostrar _MENU_ registros por pagina",
            "zeroRecords": "Nada encontrado - disculpa",
            "info": "Mostrando pagina _PAGE_ de _PAGES_",
            "infoEmpty": "No existe informacion disponible",
            "infoFiltered": "(filtrado de _MAX_ registros totales)",
            "search": "Buscar:",
            "paginate":{
                "next":"Siguiente",
                "previous":"Anterior"
            }
        },
        "ajax":"{{route('almacenList')}}",
        "columns":[
            {data: 'id'},
            {data: 'name'},
            {data: 'email'},
        ]

    } );
    $("div.crud-buttons").html(
    '<button type="button" class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#warehouseModal"><i class="fas fa-pen"></i>  Registrar</button>'+
    '&nbsp;&nbsp;<button type="button" class="btn btn-outline-warning btn-sm"><i class="fas fa-edit"></i> Editar</button>'+
    '&nbsp;&nbsp;<button type="button" class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i> Eliminar</button>');
} );
</script>
@endsection