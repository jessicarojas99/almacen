
<div class="modal fade" id="warehouseInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                {{-- header --}}
                <h5 class="modal-title" id="modalTitle">Historico</h5>
                {{-- Boton cerrar --}}
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                {{-- Contenido --}}
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col">
                        <label for="lblItem">Item</label>
                        <label type="text" class="form-control border-0 font-weight-normal" id="lblItem" placeholder="Introduzca el item"></label>
                        </div>
                        <div class="form-group col">
                            <label for="lblBrand">Marca</label>
                            <label id="lblBrand" class="form-control border-0 font-weight-normal"></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="lblCode">Codigo</label>
                            <label type="text" class="form-control border-0 font-weight-normal" id="lblCode" placeholder="Introduzca el codigo"></label>
                        </div>
                        <div class="form-group col">
                            <label for="lblQuantity">Cantidad</label>
                            <label type="number" class="form-control border-0 font-weight-normal" id="lblQuantity"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="txtDescription">Descripción</label>
                        <textarea class="form-control" id="lblDescription" rows="3" placeholder="Introduzca una descripcion"></textarea>
                    </div>
                </div>
                {{-- Botones footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                </div>
            </div>
        </div>
  </div>
