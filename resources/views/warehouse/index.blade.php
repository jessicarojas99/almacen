@extends('adminlte::page')

@section('title', 'Almacen')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
    <style>
        table.dataTable tbody tr.selected {
            color: white;
            background-color: #eeeeee;  /* Not working */
        }
    </style>
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
                    <table id="warehouseTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Item</th>
                                <th>Marca</th>
                                <th>Codigo</th>
                                <th>Cantidad</th>
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
        $('#warehouseTable').DataTable( {
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
                {data: 'item'},
                {data: 'brand'},
                {data: 'code'},
                {data: 'quantity'}
            ]

        } );
        $("div.crud-buttons").html(
        '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#warehouseModal"><i class="fas fa-pen"></i>  Registrar</button>'+
        '&nbsp;&nbsp;<button type="button" class="btn btn-warning btn-sm" id="btnEdit" name="edit" disabled><i class="fas fa-edit"></i> Editar</button>'+
        '&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm" id="btnDelete" name="delete" disabled><i class="fas fa-trash"></i> Eliminar</button>');
        
        var table = $('#warehouseTable').DataTable();
        // Tomar id y aplicar estilo a la fila
        var idRow
        $('#warehouseTable tbody').on( 'click', 'tr', function () {
            table.$('tr.bg-primary').removeClass('bg-primary');
            $(this).addClass("bg-primary");
            idRow =table.row( this ).data().id;
            if (idRow!=undefined) {
                document.getElementById("btnEdit").disabled = false;
                document.getElementById("btnDelete").disabled = false;
            }
        });

        // Eliminar
        $('#btnDelete').click(function () {
            if(idRow!=undefined){
            Swal.fire({
                title: 'Estas seguro de eliminar el item?',
                text: "No podras revertir tu desición!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminar!',
                cancelButtonText: 'Cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"/almacen/eliminar/"+idRow,
                            success:function(data){
                                Swal.fire({
                                    title:'Eliminado!',
                                    text:'El item fue eliminado con exito',
                                    icon:'success',
                                    showConfirmButton: false,
                                    timer: 1500
                                }
                                )
                                $('#warehouseTable').DataTable().ajax.reload();
                            }
                        });
                    }
                });
            }
            
        });

        // Editar
        $('#btnEdit').click(function () {
            if (idRow !=undefined) {
                $.ajax({
                    url:"/almacen/editar/"+idRow,
                    success:function(data){
                        document.getElementById("txtId").value =data[0].id;
                        document.getElementById("txtItem").value =data[0].item;
                        document.getElementById("txtBrand").value =data[0].brand;
                        document.getElementById("txtCode").value =data[0].code;
                        document.getElementById("txtDescription").value =data[0].description;
                        document.getElementById("txtColor").value =data[0].color;
                        document.getElementById("txtQuantity").value =data[0].quantity;
                        document.getElementById("modalTitle").innerHTML ='Editar';
                        $('#warehouseModal').modal('show');

                    }
                });
            }
        })
    });

</script>
{{-- Registrar y Editar--}}
<script>
    form=$('#warehouseForm');
    form.submit(function(e){
        e.preventDefault();
        var id=$('#txtId').val();
        var item=$('#txtItem').val();
        var brand=$('#txtBrand').val();
        var code=$('#txtCode').val();
        var color=$('#txtColor').val();
        var quantity=$('#txtQuantity').val();
        var description=$('#txtDescription').val();
        var _token =$("input[name=_token]").val();

        if(id !=""){
            $.ajax({
                url:"{{route('almacenUpdate')}}",
                type: "POST",
                data:{
                    id:id,
                    item:item,
                    brand:brand,
                    code:code,
                    color:color,
                    quantity:quantity,
                    description:description,
                    _token:_token
                },
                success:function (response) {
                    $('#warehouseModal').modal('hide');
                    $('#warehouseForm')[0].reset();
                    Swal.fire({
                        title: 'Completado',
                        icon: 'info',
                        text: 'Actualizado con exito!',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#warehouseTable').DataTable().ajax.reload();
                },
                error: data =>  {
                    Swal.fire({
                        title: 'Error',
                        icon: 'warning',
                        text: 'No se completo la actualización',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        }
        else{
            $.ajax({
                url:"{{route('almacenStore')}}",
                type: "POST",
                data:{
                    item:item,
                    brand:brand,
                    code:code,
                    color:color,
                    quantity:quantity,
                    description:description,
                    _token:_token
                },
                success:function (response) {
                    $('#warehouseModal').modal('hide');
                    $('#warehouseForm')[0].reset();
                    Swal.fire({
                        title: 'Completado',
                        text: 'Registrado con exito!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                    $('#warehouseTable').DataTable().ajax.reload();
                },
                error: data =>  {
                    Swal.fire({
                        title: 'Error',
                        icon: 'warning',
                        text: 'No se completo el registro',
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        }
    })
</script>

@endsection