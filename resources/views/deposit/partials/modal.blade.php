
<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" data-backdrop="static" aria-hidden="true">
    <form id="depositForm"  novalidate autocomplete="off">
        @csrf
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                {{-- header --}}
                <h5 class="modal-title" id="modalTitle">Registrar</h5>
                {{-- Boton cerrar --}}
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                {{-- input para editar id --}}
                <input type="hidden" id="txtId" >
                {{-- Contenido --}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="txtItem"><span style="color: red">*</span>Item</label>
                        <input type="text" class="form-control" id="txtItem" placeholder="Introduzca el item">
                        <div class="invalid-feedback" id="errorItem"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="txtBrand"><span style="color: red">*</span>Marca</label>
                            <div class="input-group">
                                <select id="txtBrand" class="custom-select" required>
                                    <option selected>Seleccion una marca</option>
                                    @foreach ($brands as $branditem)
                                        <option value="{{$branditem->id}}">{{$branditem->name}}</option>
                                    @endforeach
                                  </select>
                                <div class="input-group-append">
                                  <button class="btn btn-success" type="button" id="add-brand"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                                <div class="invalid-feedback" id="errorBrandS"></div>
                              </div>
                        </div>
                        <div class="form-group col">
                            <label for="txtCode"><span style="color: red">*</span>Código</label>
                            <input type="text" class="form-control" id="txtCode" placeholder="Introduzca el codigo">
                            <div class="invalid-feedback" id="errorCode"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-6" style="display: none" id="marcadiv">
                            <input type="text" class="form-control" id="brand" placeholder="Introduzca una nueva marca">
                            <div class="invalid-feedback" id="errorBrand"></div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="txtSize">Tamaño</label>
                            <input type="text" class="form-control" id="txtSize" placeholder="Introduzca el tamaño">
                        </div>
                        <div class="form-group col">
                            <label for="txtProcessor">Procesador</label>
                            <input type="text" class="form-control" id="txtProcessor" placeholder="Introduzca el tipo de procesador">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="txtCondition"><span style="color: red">*</span>Condición</label>
                            <input type="text" class="form-control" id="txtCondition" placeholder="Introduzca la condicion del item">
                            <div class="invalid-feedback" id="errorCondition"></div>
                        </div>
                        <div class="form-group col">
                            <label for="txtState"><span style="color: red">*</span>Estado</label>
                            <select id="txtState" class="custom-select">
                                <option value="Disponible">Disponible</option>
                                <option value="No disponible">No disponible</option>
                            </select>
                            <div class="invalid-feedback" id="errorState"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txtDescription">Descripción</label>
                        <textarea class="form-control" id="txtDescription" rows="3" placeholder="Introduzca una descripcion"></textarea>
                      </div>
                </div>
                {{-- Botones footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            </div>
        </div>
    </form>
  </div>
