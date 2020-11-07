@extends('adminlte::page')

@section('title', 'Prestamos')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Recibos</h1>
@stop
@section('content')
@include('receipt/partials/register')
@include('receipt/partials/detail')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive">
                        <table id="receiptTable" class="table table-striped">
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
        $('#receiptTable').DataTable( {
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
            "ajax":"{{route('receiptList')}}",
            "columns":[
                {data: 'Rid'},
                {data: 'code'},
                {data: 'Uname'},
                {data: 'responsable'},
                {data: 'Rcreated'},
                {data: 'action',orderable: false}
            ]

        } );
        $("div.crud-buttons").html(
        '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".bd-example-modal-lg" ><i class="fas fa-pen"></i>  Registrar entrega</button>');

        var table = $('#receiptTable').DataTable();
        // Tomar id y aplicar estilo a la fila
        var idRow
        $('#receiptTable tbody').on( 'click', 'tr', function () {
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
    // Añadir a la tabla
    $('#btnItemSelect').click(function () {
        var item =$('#txtItem').val();
        $.ajax({
            url:"/prestamo/select/"+item,
            success:function(data){
                console.log(data.itemCode);
                var fila='<tr class="selected align-items-center" id="fila'+data.id+'"><td><button type="button" class="btn btn-danger" onclick="eliminar('+data.id+');">X</button></td><td><input type="hidden" name="idItem[]" value="'+data.id+'">'+data.id+'</td><td>'+data.itemCode+'</td></tr>';
                cont++;
                $('#detail').append(fila);
                $("#divItemSelect").children().prop('disabled',false);
            }
        })
    });
    function eliminar(index) {
        $("#fila"+ index).remove();

    }

    $('#btnStoreDetail').click(function () {
        var _token =$("input[name=_token]").val();
        var responsable=$('#txtResponsable').val();
        var delivery=$('#txtDelivery').val();
        var returnDate=$('#txtReturn').val();
        var idDetailValue=[];
        var idDetail=document.getElementsByName('idItem[]')
        for (let i = 0; i < idDetail.length; i++) {
            var elementid = idDetail[i];
            idDetailValue[i]=elementid.value;
        }

        $.ajax({
            url:"{{route('receiptStore')}}",
            type:"POST",
            data:{
                responsable:responsable,
                delivery:delivery,
                return:returnDate,
                idDetailValue:idDetailValue,
                _token:_token
            },
            success:function(response){
                $('#receiptModal').modal('hide');
                $('#receiptForm')[0].reset();
                Swal.fire({
                        title: 'Completado',
                        text: 'Registrado con exito!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                })
                $('#receiptTable').DataTable().ajax.reload();
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
<script>
    function showItem(id){
        console.log(id);
        var tablaDatos= $("#detailinfo");
        $.ajax({
            url:"/prestamo/mostrar/"+id,
            success:function(data){
             console.log(data)
                document.getElementById("lblCodigo").innerHTML =data[0].Rcode;
                document.getElementById("lblresponsable").innerHTML =data[0].Uname;
                document.getElementById("lblEntrega").innerHTML =data[0].responsable;
                document.getElementById("lblEntregaFecha").innerHTML =data[0].delivery_date;
                if(data[0].return_date!=null && data[0].return_date!=""){
                    document.getElementById("fechadevolucion").style.display="";
                    document.getElementById("lblRetornoFecha").innerHTML =data[0].return_date;
                }
                $('#receiptModalInfo').modal('show');
                tablaDatos.empty();
                for(i in data)
                    tablaDatos.append("<tr><td>"+data[i].itemCode+"</td></tr>");

            }
        });
    }

    $('.cerrarinfo').click(function () {
        document.getElementById("lblEntregaFecha").value="";
        document.getElementById("fechadevolucion").style.display="none";
     })


</script>
@endsection
