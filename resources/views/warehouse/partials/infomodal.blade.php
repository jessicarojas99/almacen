
<div class="modal fade" id="warehouseInfoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static"
data-keyboard="false">

        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                {{-- header --}}
                <h5 class="modal-title" id="modalTitle">Información</h5>
                {{-- Boton cerrar --}}
                <button type="button" class="close closeinfo" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>

                {{-- Contenido --}}
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="lblItem"><u> Item</u></label>
                            <label type="text" class="form-control border-0 font-weight-normal" id="lblItem" placeholder="Introduzca el item"></label>
                        </div>
                        <div class="form-group col">
                            <label for="lblBrand"><u>Marca</u></label>
                            <label id="lblBrand" class="form-control border-0 font-weight-normal"></label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col">
                            <label for="lblCode"><u>Código</u></label>
                            <label type="text" class="form-control border-0 font-weight-normal" id="lblCode" placeholder="Introduzca el codigo"></label>
                        </div>
                        <div class="form-group col">
                            <label for="lblQuantity"><u>Cantidad</u></label>
                            <label class="form-control border-0 font-weight-normal" id="lblQuantity"></label>
                        </div>
                    </div>
                    <div class="form-group" style="display: none" id="color">
                        <label for="txtDescription"><u>Color</u></label>
                        <label class="form-control border-0 font-weight-normal" id="lblColor"></label>
                    </div>
                    <div class="form-group" style="display: none" id="description">
                        <label for="txtDescription"><u>Descripción</u></label>
                        <label class="form-control border-0 font-weight-normal" id="lblDescription"></label>
                    </div>

                    <label style="text-align: center"><u>Historial</u></label>
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th scope="col">Fecha</th>
                            <th scope="col">Cantidad</th>
                          </tr>
                        </thead>
                        <tbody id="tableinfo">

                        </tbody>
                    </table>

                </div>
                {{-- Botones footer --}}
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm closeinfo" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
  </div>

