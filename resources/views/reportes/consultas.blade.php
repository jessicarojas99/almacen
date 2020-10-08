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
                    <form>
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
                                <input type="text" class="form-control" id="marca" name="marca">
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="estado">Estado:</label>
                                <select id="estado" name="estado" class="form-control" disabled>
                                  <option selected>Disponible</option>
                                  <option>No Disponible</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cantidad">Cantidad:</label>
                                <input type="text" class="form-control" id="cantidad" name="cantidad" disabled>
                              </div>
                          </div>
                          <button type="button" class="btn btn-danger float-right" id="consultar" name="consultar">
                              Consultar</button>
                          <a href="{{ route('consultasuser') }}" type="submit" target="blank" class="btn btn-info float-right">
                               Imprimir reporte</a>
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
                                    <th>Tamaño</th>
                                    <th>Estado</th>
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
                                <th>Codigo</th>
                                <th>Cantidad</th>
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
            function consulta_datatable(item='', brand=''){

                var datatable=$('#consultasTable').DataTable({
                    processing: true,
                    serverSide:true,
                    ajax:{
                        url: "{{route('consultasgral')}}",
                        data:
                            {

                            item:item,
                            brand:brand
                            }
                    },
                    columns:[
                            {data: 'id'},
                            {data: 'item'},
                            {data: 'brand'},
                            {data: 'code'},
                            {data: 'quantity'}
                        ]
                });
            }
            function deposito_datatable(){
                var datatable=$('#DepositTable').DataTable({
                    processing: true,
                    ajax:{
                        url: "{{route('consultadeposit')}}",
                        data: function(d)
                        {
                            if($('#item').val()){
                                d.item=('#item').value;
                            }
                            if($('#brand').val()){
                                d.item=('#brand').value;
                            }
                        }
                    },
                    columns:[
                            {data: 'id', name: 'id'},
                            {data: 'item', name: 'item'},
                            {data: 'brand', name: 'brand'},
                            {data: 'code', name: 'code'},
                            {data: 'size', name: 'size'},
                            {data: 'state', name: 'state'}
                        ]
                });
            }
            $('#consultar').click(function(){
                var tipo= $('#tipo').val();
                var item=$('#item').val();
                var brand = $('#marca').val();
                var tabla1 = document.getElementById('deposito');
                var tabla = document.getElementById('almacen');
                if(tipo==1)
                 {
                     $('#consultasTable').DataTable().destroy();
                     consulta_datatable(item,brand);
                     tabla.style.display = '';
                     tabla1.style.display = 'none';
                 }
                 else if(tipo==2)
                 {
                    $('#DepositTable').DataTable().destroy();
                     deposito_datatable();
                     tabla1.style.display = '';
                     tabla.style.display = 'none';
                 }
                 else{
                    tabla.style.display = 'none';
                    tabla1.style.display = 'none';
                 }

            });

        });

      function ShowSelected()
      {
        var cod = document.getElementById("tipo").value;
        var cantidad= document.getElementById('cantidad');
        var estado= document.getElementById('estado');

        if(cod==1)
        {
          cantidad.disabled = false;
        }
        else{
          cantidad.disabled = true;
        }
        if(cod==2)
        {
          estado.disabled = false;
        }
        else{
          estado.disabled = true;
        }
      }
    </script>
@endsection
