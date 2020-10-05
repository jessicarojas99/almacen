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
                            <select id="tipo" class="form-control" onchange="ShowSelected();">
                              <option value="1" selected>Almacen</option>
                              <option value="2">Deposito</option>
                              <option value="3">Ambos</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="fechainicio">Fecha Inicio:</label>
                                <input type="date" class="form-control" id="fechainicio">
                            </div>
                            <div class="form-group col-md-6">
                              <label for="fechafin">Ficha Final:</label>
                              <input type="date" class="form-control" id="fechafin">
                            </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="Item">Item:</label>
                            <input type="text" class="form-control" id="Item">
                          </div>
                          <div class="form-group col-md-6">
                                <label for="Marca">Marca:</label>
                                <input type="text" class="form-control" id="Marca">
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="estado">Estado:</label>
                                <select id="estado" class="form-control" disabled>
                                  <option selected>Disponible</option>
                                  <option>No Disponible</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="cantidad">Cantidad:</label>
                                <input type="text" class="form-control" id="cantidad" disabled>
                              </div>
                          </div>
                          <a href="{{ route('consultasuser') }}" type="submit" target="blank" class="btn btn-danger float-right">
                              Consultar</a>
                          <a href="{{ route('consultasuser') }}" type="submit" target="blank" class="btn btn-danger float-right">
                               Imprimir reporte</a>
                      </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>

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
        if(cod==3)
        {
          cantidad.disabled = false;
          estado.disabled = false;
        }
      }
    </script>
@endsection
