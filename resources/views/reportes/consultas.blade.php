@extends('adminlte::page')

@section('title', 'Consultas')


@section('content_header')
    <h1 class="m-0 text-dark">Consultas</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('pdf') }}" target="_blank" id="formconsultas">
                        @csrf
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="tipo">De:</label>
                            <select id="tipo" name="tipo" class="form-control" onchange="ShowSelected();">
                              <option value="0" selected>Seleccionar</option>
                              <option value="1">Almacen</option>
                              <option value="2">Deposito</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fechainicio">Desde:</label>
                                <input type="date" class="form-control" id="fechainicio" name="fechainicio">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="fechafin">Hasta:</label>
                              <input type="date" class="form-control" id="fechafin" name="fechafin">
                            </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="item">Item:</label>
                            <input type="text" class="form-control" id="item" name="item">
                          </div>
                          <div class="form-group col-md-6">
                                <label for="marca">Marca:</label>
                                <select id="marca" class="form-control" name="marca">
                                    <option value="" selected>Seleccion una marca</option>
                                    @foreach ($brands as $branditem)
                                        <option value="{{$branditem->id}}">{{$branditem->name}}</option>
                                    @endforeach
                                  </select>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="estado">Estado:</label>
                                <select id="estado" name="estado" class="form-control" disabled>
                                  <option value="" selected>Seleccionar</option>
                                  <option value="Disponible">Disponible</option>
                                  <option value="No disponible">No disponible</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cantidad">Cantidad:</label>
                                <input type="text" class="form-control" id="cantidad" name="cantidad" disabled>
                              </div>
                          </div>

                          <button type="button" class="btn btn-success float-right m-2" id="consultar" name="consultar" disabled>
                            <i class="fas fa-search"></i></button>
                          <button  class="btn btn-dark float-right m-2 bgVerde" id="imprimir" disabled>
                            <i class="fa fa-print"></i>  </button>
                            <button type="button" class="btn btn-warning float-right m-2" id="limpiar" disabled>
                                <i class="fas fa-broom"></i></button>
                      </form>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="deposito" style="display: none;">
                        <table id="DepositTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Item</th>
                                    <th>Marca</th>
                                    <th>Codigo</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                    <div class="table-responsive" id="almacen" style="display: none;">
                    <table id="consultasTable" class="table table-striped">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Item</th>
                                <th>Marca</th>
                                <th>Código</th>
                                <th>Cantidad</th>
                                <th>Fecha</th>
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
<script>
        $(document).ready(function() {
            consulta_datatable();
            deposito_datatable();
            function consulta_datatable(item='', brand='',fromdate='', todate='', quantity=''){

                var datatable=$('#consultasTable').DataTable({
                    dom:
                    "<'row'<'col-md-8 crud-buttons'B><'col-md-4'f>>" +
                    "<'row'<'col-sm-12 col-12'<'#tableScroll.scrollable-table table-responsive't><'p-5'r>>>" +
                    "<'row custom-pagination'<'col-sm-12 col-md-4 mt-3'l><'col-sm-12 col-md-4 text-center align-self-center'i><'col-sm-12 col-md-4 mt-3'p>>",
                    "language":
                    {
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
                    processing: true,
                    serverSide:true,
                    ajax:{
                        url: "{{route('consultasgral')}}",
                        data:
                            {
                                item:item,
                                brand:brand,
                                fromdate:fromdate,
                                todate:todate,
                                quantity:quantity
                            }
                    },
                    columns:[
                            {data: 'Wid'},
                            {data: 'item'},
                            {data: 'Bname'},
                            {data: 'code'},
                            {data: 'quantity'},
                            {data: 'Wcreated'}
                        ]
                });
            }
            function deposito_datatable(item='', brand='',fromdate='', todate='', state=''){

                var datatable=$('#DepositTable').DataTable({
                    dom:
                    "<'row'<'col-md-8 crud-buttons'B><'col-md-4'f>>" +
                    "<'row'<'col-sm-12 col-12'<'#tableScroll.scrollable-table table-responsive't><'p-5'r>>>" +
                    "<'row custom-pagination'<'col-sm-12 col-md-4 mt-3'l><'col-sm-12 col-md-4 text-center align-self-center'i><'col-sm-12 col-md-4 mt-3'p>>",
                    "language":
                    {
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
                    processing: true,
                    serverSide:true,
                    ajax:{
                        url: "{{route('consultadeposit')}}",
                        data:
                        {
                            item:item,
                            brand:brand,
                            fromdate:fromdate,
                            todate:todate,
                            state:state
                        }
                    },
                    columns:[
                            {data: 'Did'},
                            {data: 'item'},
                            {data: 'Bname'},
                            {data: 'code'},
                            {data: 'state'},
                            {data: 'Dcreated'},
                        ]
                });
            }
            $('#consultar').click(function(){

                var tipo= $('#tipo').val();
                var item=$('#item').val();
                var brand = $('#marca').val();
                var fromdate= $('#fechainicio').val()
                var todate = $('#fechafin').val();
                var quantity = $('#cantidad').val();
                var state = $('#estado').val();
                var tabla1 = document.getElementById('deposito');
                var tabla = document.getElementById('almacen');
                if(tipo==1)
                 {
                     $('#consultasTable').DataTable().destroy();
                     consulta_datatable(item,brand,fromdate,todate,quantity);
                     tabla.style.display = '';
                     tabla1.style.display = 'none';
                 }
                 else if(tipo==2)
                 {
                    $('#DepositTable').DataTable().destroy();
                     deposito_datatable(item,brand,fromdate,todate,state);
                     tabla1.style.display = '';
                     tabla.style.display = 'none';
                 }
                 else{
                    tabla.style.display = 'none';
                    tabla1.style.display = 'none';
                 }
            });

        });
        $('#limpiar').click(function(){
            $('#formconsultas')[0].reset();
            document.getElementById("consultar").disabled = true;
          document.getElementById("imprimir").disabled = true;
          document.getElementById("limpiar").disabled = true;
          var tabla1 = document.getElementById('deposito').style.display='none';
          var tabla = document.getElementById('almacen').style.display='none';

        })
      function ShowSelected()
      {
        var tipo = document.getElementById("tipo").value;
        var cantidad= document.getElementById('cantidad');
        var estado= document.getElementById('estado');
        if(tipo==1)
        {
          cantidad.disabled = false;
          estado.disabled = true;
          document.getElementById("consultar").disabled = false;
          document.getElementById("imprimir").disabled = false;
          document.getElementById("limpiar").disabled = false;

        }
        else  if(tipo==2)
        {
          estado.disabled = false;
          cantidad.disabled = true;
          document.getElementById("consultar").disabled = false;
          document.getElementById("imprimir").disabled = false;
          document.getElementById("limpiar").disabled = false;

        }
        else{
          estado.disabled = true;
          cantidad.disabled = true;
          document.getElementById("consultar").disabled = true;
          document.getElementById("imprimir").disabled = true;
          document.getElementById("limpiar").disabled = true;
        }
      }

    </script>
@endsection
