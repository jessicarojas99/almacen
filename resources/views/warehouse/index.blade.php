@extends('adminlte::page')

@section('title', 'Almacen')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Almacén</h1>
@stop

@section('content')
@include('warehouse/partials/modal')
@include('warehouse/partials/infomodal')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="warehouseTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Item</th>
                                    <th>Marca</th>
                                    <th>Código</th>
                                    <th>Cantidad</th>
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
                {data: 'Wid'},
                {data: 'item'},
                {data: 'Bname'},
                {data: 'code'},
                {data: 'quantity'},
                {data: 'Wcreated'},
                {data: 'action',orderable: false}
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
            idRow =table.row( this ).data().Wid;
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
                    if (result.isConfirmed){
                        Swal.fire({
                            title: "Ingrese el motivo de la eliminación",
                            icon: 'info',
                            html: `
                            <textarea class="form-control" id="txtMotivo"></textarea>
                            `,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Guardar',
                            cancelButtonText: 'Cancelar',
                            showCancelButton: true,
                            preConfirm: function() {
                                return new Promise((resolve, reject) => {
                                    // get your inputs using their placeholder or maybe add IDs to them
                                    resolve({
                                        Motivo: $('#txtMotivo').val()

                                    });
                                });
                            }
                        }).then((data) => {
                            // your input data object will be usable from here
                            console.log(data.value.Motivo);
                            $.ajax({
                                url:"/almacen/eliminar/"+idRow,
                                data:
                                {
                                    motivo:data.value.Motivo
                                },
                                success:function(data){
                                    Swal.fire({
                                        title:'Eliminado!',
                                        text:'El item fue eliminado con éxito',
                                        icon:'success',
                                        showConfirmButton: false,
                                        timer: 1500
                                        }
                                    )
                                    $('#warehouseTable').DataTable().ajax.reload();
                                }
                            });
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
                        document.getElementById("txtBrand").value =data[0].brand_id;
                        document.getElementById("txtCode").value =data[0].code;
                        document.getElementById("txtDescription").value =data[0].description;
                        document.getElementById("txtColor").value =data[0].color;
                        document.getElementById("txtQuantity").value =data[0].quantity;
                        document.getElementById("txtQuantity").min =data[0].quantity;
                        document.getElementById("modalTitle").innerHTML ='Editar';
                        document.getElementById("txtItem").disabled =true;
                        document.getElementById("txtBrand").disabled =true;
                        document.getElementById("add-brand").disabled =true;
                        document.getElementById("txtCode").disabled =true;
                        $('#warehouseModal').modal('show');

                    }
                });
            }
        });

        $('#close').click(function () {
            $('#warehouseForm')[0].reset();
            document.getElementById("txtId").value="";
            document.getElementById("modalTitle").innerHTML ='Registrar';
            document.getElementById("txtItem").disabled =false;
            document.getElementById("txtBrand").disabled =false;
            document.getElementById("txtCode").disabled =false;
            document.getElementById("txtQuantity").min =1;
            document.getElementById('marcadiv').style.display="none";
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
        var brand = $("#txtBrand").val(); // Capturamos el valor del select
        var name=$("#brand").val();
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
                        icon: 'success',
                        text: 'Actualizado con exito!',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    document.getElementById("txtId").value="";
                    document.getElementById("modalTitle").innerHTML ='Registrar';
                    document.getElementById("txtItem").disabled =false;
                    document.getElementById("txtBrand").disabled =false;
                    document.getElementById("txtCode").disabled =false;
                    document.getElementById("txtQuantity").min =1;
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
                    code:code,
                    color:color,
                    quantity:quantity,
                    name:name,
                    description:description,
                    brand:brand,
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
                    if(name!=""){
                        location.reload(true);
                    }
                    else
                    {
                        $('#warehouseTable').DataTable().ajax.reload();
                    }

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
<script>
    function showItem(id){
        console.log(id);
        var tablaDatos= $("#tableinfo");
        $.ajax({
            url:"/almacen/mostrar/"+id,
            success:function(data){
                console.log(data)
                var description= document.getElementById("lblDescription");
                var color= document.getElementById("lblColor");
                document.getElementById("lblItem").innerHTML =data[0].item;
                document.getElementById("lblBrand").innerHTML =data[0].Bname;
                document.getElementById("lblCode").innerHTML =data[0].code;
                document.getElementById("lblQuantity").innerHTML =data[0].quantity;
                if(data[0].description !=null && data[0].description !=""){
                    document.getElementById("description").style.display="";
                    description.innerHTML =data[0].description;
                }
                if(data[0].color !=null && data[0].color!=""){
                    document.getElementById("color").style.display="";
                    color.innerHTML =data[0].color;
                }
                $('#warehouseInfoModal').modal('show');

                tablaDatos.empty();
                for(i in data)
                tablaDatos.append("<tr><td>"+data[i].Rdate+"</td><td>"+data[i].Rquantity+"</td></tr>");
            }
        });
    }

    $('.closeinfo').click(function () {
        document.getElementById("description").style.display="none";
        document.getElementById("lblDescription").value="";
        document.getElementById("color").style.display="none";
        document.getElementById("lblColor").value="";
     })

</script>

<script>
        $('#add-brand').click(function () {
            var marca = document.getElementById('marcadiv');
            var marcaselect = document.getElementById('txtBrand').disabled = true;
            marca.style.display = '';
    });
</script>

@endsection
