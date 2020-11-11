
<div class="modal fade" id="warehouseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static">
    <form id="warehouseForm" novalidate autocomplete="off">
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
                    <div class="form-group has-feedback">
                        <label for="txtItem"><span style="color: red">*</span>Item</label>
                        <input type="text" class="form-control" id="txtItem" placeholder="Introduzca el item" required>
                        <div class="invalid-feedback" id="errorItem"></div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="txtBrand"><span style="color: red">*</span>Marca</label>
                            <div class="input-group">
                                <select id="txtBrand" class="custom-select" required name="brands">
                                        <option selected>Seleccion una marca</option>
                                    @foreach ($brands as $branditem)
                                        <option value="{{$branditem->id}}">{{$branditem->name}}</option>
                                    @endforeach
                                  </select>
                                  <div class="input-group-append">
                                      <button class="btn btn-success" type="button" id="add-brand"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                    </div>
                                   <div class="invalid-feedback" id="errorMarcaS">
                                   </div>
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
                                <input type="text" class="form-control" id="brand" placeholder="Introduzca una nueva marca" required>
                                <div class="invalid-feedback" id="errorMarca">
                                </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="txtColor">Color</label>
                            <input type="text" class="form-control" id="txtColor" placeholder="Introduzca el color">
                        </div>
                        <div class="form-group col">
                            <label for="txtQuantity"><span style="color: red">*</span>Cantidad</label>
                            <input type="number" class="form-control" id="txtQuantity" min="1" value="1" required>
                            <div class="invalid-feedback" id="errorCantidad">

                            </div>
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
