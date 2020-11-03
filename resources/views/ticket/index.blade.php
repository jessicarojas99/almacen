@extends('adminlte::page')

@section('title', 'Almacen')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Almacen</h1>
@stop
@section('content')
@include('ticket/partials/register')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table id="ticketTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Codigo</th>
                                    <th>Responsable</th>
                                    <th>Entregado a</th>
                                    <th>Fecha de creación</th>
                                    <th></th>
                                </tr>
                            </thead>        
                        </table>
                    </div>
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
        $('#ticketTable').DataTable( {
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
            "ajax":"{{route('ticketList')}}",
            "columns":[
                {data: 'Tid'},
                {data: 'code'},
                {data: 'Uname'},
                {data: 'responsable'},
                {data: 'Tcreated'},
                {data: 'action',orderable: false}
            ]

        } );
        $("div.crud-buttons").html(
        '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg" ><i class="fas fa-pen"></i>  Registrar entrega</button>');

        var table = $('#ticketTable').DataTable();
        // Tomar id y aplicar estilo a la fila
        var idRow
        $('#ticketTable tbody').on( 'click', 'tr', function () {
            table.$('tr.bg-primary').removeClass('bg-primary');
            $(this).addClass("bg-primary");
            idRow =table.row( this ).data().id;
            if (idRow!=undefined) {

            }
        });

    });

</script>
<script>
    var cont=0;
    // Abrir modal
    $('#btnItemSelect').click(function () {
        var item =$('#txtItem').val();
        $.ajax({
            url:"/comprobante/select/"+item,
            success:function(data){
                console.log(data.itemCode);
                document.getElementById('lblItem').innerHTML=data.itemCode;
                document.getElementById('subItem').innerHTML="cantidad "+data.quantity;
                document.getElementById('itemId').value=data.id;
                document.getElementById('quantityInput').max=data.quantity;
                $("#divItemSelect").children().prop('disabled',false);
            }
        })
    });
    // Añadir a tabla
    $('#btnAddDetail').click(function(){
        var id= $('#itemId').val();
        var item= $('#lblItem').text();
        var quantity= $('#quantityInput').val();

        var fila='<tr class="selected align-items-center" id="fila'+cont+'"><td><button type="button" class="btn btn-danger" onclick="eliminar('+cont+');">X</button></td><td><input type="hidden" name="idItem[]" value="'+id+'">'+id+'</td><td>'+item+'</td><td><input type="number" name="quantityItem[]" value="'+quantity+'"></td></tr>';
        cont++;
        $('#detail').append(fila);
        $("#divItemSelect").children().prop('disabled',true);
    });

    function eliminar(index) {
        $("#fila"+ index).remove();

    }

    $('#btnStoreDetail').click(function () {
        var _token =$("input[name=_token]").val();
        var responsable=$('#txtResponsable').val();
        var quantityDetailValue=[];
        var idDetailValue=[];
        var quantityDetail=document.getElementsByName('quantityItem[]');
        var idDetail=document.getElementsByName('idItem[]')
        for (let i = 0; i < quantityDetail.length; i++) {
            var elementquantity = quantityDetail[i];
            var elementid = idDetail[i];
            quantityDetailValue[i]=elementquantity.value;
            idDetailValue[i]=elementid.value;
        }
        console.log(quantityDetailValue);
        console.log(idDetailValue);

        $.ajax({
            url:"{{route('ticketStore')}}",
            type:"POST",
            data:{
                responsable:responsable,
                quantityDetailValue:quantityDetailValue,
                idDetailValue:idDetailValue,
                _token:_token
            },
            success:function(response){
                $('#ticketModal').modal('hide');
                $('#ticketForm')[0].reset();
                Swal.fire({
                        title: 'Completado',
                        text: 'Registrado con exito!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                })
                $('#ticketTable').DataTable().ajax.reload();
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

    })
</script>

@endsection
