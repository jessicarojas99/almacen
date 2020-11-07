@extends('adminlte::page')

@section('title', 'Deposito')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.6/css/responsive.bootstrap4.min.css">
@endsection

@section('content_header')
    <h1 class="m-0 text-dark">Depósito</h1>
@stop

@section('content')
@include('deposit/partials/modal')
@include('deposit/partials/infomodal')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="depositTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Item</th>
                                <th>Marca</th>
                                <th>Código</th>
                                <th>Estado</th>
                                <th>Fecha de creación</th>
                                <th></th>
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
        $('#depositTable').DataTable( {
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
            "ajax":"{{route('depositoList')}}",
            "columns":[
                {data: 'Did'},
                {data: 'item'},
                {data: 'Bname'},
                {data: 'code'},
                {data: 'state'},
                {data: 'Dcreated'},
                {data: 'action',orderable: false}
            ]

        } );
        $("div.crud-buttons").html(
        '<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#depositModal"><i class="fas fa-pen"></i>  Registrar</button>'+
        '&nbsp;&nbsp;<button type="button" class="btn btn-warning btn-sm" id="btnEdit" name="edit" disabled><i class="fas fa-edit"></i> Editar</button>'+
        '&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-sm" id="btnDelete" name="delete" disabled><i class="fas fa-trash"></i> Eliminar</button>');

        var table = $('#depositTable').DataTable();
        // Tomar id y aplicar estilo a la fila
        var idRow
        $('#depositTable tbody').on( 'click', 'tr', function () {
            table.$('tr.bg-primary').removeClass('bg-primary');
            $(this).addClass("bg-primary");
            idRow =table.row( this ).data().Did;
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

                                    // maybe also reject() on some condition
                                });
                            }
                        }).then((data) => {
                            // your input data object will be usable from here
                            console.log(data.value.Motivo);
                            $.ajax({
                                url:"/deposito/eliminar/"+idRow,
                                data:
                                {
                                    motivo:data.value.Motivo
                                },
                                success:function(data){
                                    Swal.fire({
                                        title:'Eliminado!',
                                        text:'El item fue eliminado con exito',
                                        icon:'success',
                                        showConfirmButton: false,
                                        timer: 1500
                                        }
                                    )
                                    $('#depositTable').DataTable().ajax.reload();
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
                    url:"/deposito/editar/"+idRow,
                    success:function(data){
                        document.getElementById("txtId").value =data[0].id;
                        document.getElementById("txtItem").value =data[0].item;
                        document.getElementById("txtBrand").value =data[0].brand_id;
                        document.getElementById("txtCode").value =data[0].code;
                        document.getElementById("txtDescription").value =data[0].description;
                        document.getElementById("txtSize").value =data[0].size;
                        document.getElementById("txtProcessor").value =data[0].processor;
                        document.getElementById("txtCondition").value =data[0].condition;
                        document.getElementById("txtState").value =data[0].state;
                        document.getElementById("modalTitle").innerHTML ='Editar';
                        document.getElementById("txtItem").disabled =true;
                        document.getElementById("txtBrand").disabled =true;
                        document.getElementById("txtCode").disabled =true;
                        document.getElementById("txtSize").disabled=true;
                        document.getElementById("add-brand").disabled =true;
                        document.getElementById("txtProcessor").disabled=true;
                        $('#depositModal').modal('show');

                    }
                });
            }
        });

        $('#close').click(function () {
            $('#depositForm')[0].reset();
            document.getElementById("txtItem").disabled =false;
            document.getElementById("txtBrand").disabled =false;
            document.getElementById("txtCode").disabled =false;
            document.getElementById("txtSize").disabled=false;
            document.getElementById("txtProcessor").disabled=false;
            document.getElementById("modalTitle").innerHTML ='Registrar';
            document.getElementById('marcadiv').style.display="none";
        })


    });

</script>
{{-- Registrar y Editar--}}
<script>
    form=$('#depositForm');
    form.submit(function(e){
        e.preventDefault();
        var id=$('#txtId').val();
        var item=$('#txtItem').val();
        var brand = $("#txtBrand").val(); // Capturamos el valor del select
        var name=$("#brand").val();
        var code=$('#txtCode').val();
        var size=$('#txtSize').val();
        var processor=$('#txtProcessor').val();
        var condition=$('#txtCondition').val();
        var state=$('#txtState').val();
        var description=$('#txtDescription').val();
        var _token =$("input[name=_token]").val();

        if(id !=""){
            $.ajax({
                url:"{{route('depositoUpdate')}}",
                type: "POST",
                data:{
                    id:id,
                    item:item,
                    brand:brand,
                    code:code,
                    size:size,
                    processor:processor,
                    condition:condition,
                    state:state,
                    description:description,
                    _token:_token
                },
                success:function (response) {
                    $('#depositModal').modal('hide');
                    $('#depositForm')[0].reset();
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
                    document.getElementById("txtSize").disabled=false;
                    document.getElementById("txtProcessor").disabled=false;
                    $('#depositTable').DataTable().ajax.reload();
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
                url:"{{route('depositoStore')}}",
                type: "POST",
                data:{
                    item:item,
                    brand:brand,
                    code:code,
                    size:size,
                    name:name,
                    processor:processor,
                    condition:condition,
                    state:state,
                    description:description,
                    _token:_token
                },
                success:function (response) {
                    $('#depositModal').modal('hide');
                    $('#depositForm')[0].reset();
                    Swal.fire({
                        title: 'Completado',
                        text: 'Registrado con éxito!',
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    if(name!=""){
                        location.reload(true);
                    }
                    else
                    {
                        $('#depositTable').DataTable().ajax.reload();
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

        $.ajax({
            url:"/deposito/mostrar/"+id,
            success:function(data){
                console.log(data)

                var procesador=document.getElementById("lblprocessor");
                var tamanio=document.getElementById("lblsize");
                var description=document.getElementById("lblDescription");
                document.getElementById("lblItem").innerHTML =data[0].item;
                document.getElementById("lblBrand").innerHTML =data[0].Bname;
                document.getElementById("lblCode").innerHTML =data[0].code;
                document.getElementById("lblEstado").innerHTML =data[0].state;

                if(data[0].size!=null && data[0].size!=""){
                    document.getElementById("size").style.display="";
                    tamanio.innerHTML =data[0].size+" pulg.";
                }
                if(data[0].processor!=null && data[0].processor!=""){
                    document.getElementById("processor").style.display="";
                    procesador.innerHTML =data[0].processor;
                }
                if(data[0].description !=null && data[0].description !=""){
                    document.getElementById("description").style.display="";
                    description.innerHTML =data[0].description;
                }
                $('#depositInfoModal').modal('show');

            }
        });
    }

    $('.closeinfo').click(function () {
       document.getElementById("lblprocessor").value="";
       document.getElementById("processor").style.display="none";
       document.getElementById("size").style.display="none";
       document.getElementById("description").style.display="none";
       document.getElementById("lblsize").value="";
       document.getElementById("lblDescription").value="";
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
