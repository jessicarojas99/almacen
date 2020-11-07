<div class="modal fade bd-example-modal-lg" id="receiptModalInfo" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static">
    <form id="receiptFormdetail">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                {{-- header --}}
                <h5 class="modal-title" id="modalTitle">Información</h5>
                {{-- Boton cerrar --}}
                <button type="button" class="close cerrarinfo" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                {{-- Contenido --}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="lblCodigo"><u>Código</u></label>
                        <label type="text" class="form-control border-0 font-weight-normal" id="lblCodigo"></label>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="lblEntregaFecha"><u>Fecha de entrega: </u></label>
                            <label type="text" class="form-control border-0 font-weight-normal" id="lblEntregaFecha"></label>
                        </div>
                        <div class="col" style="display: none" id="fechadevolucion">
                            <label for="lblRetornoFecha"><u>Fecha de devolucion: </u></label>
                            <label type="text" class="form-control border-0 font-weight-normal" id="lblRetornoFecha"></label>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col">
                            <label for="lblresponsable"><u>Responsable</u></label>
                            <label type="text" class="form-control border-0 font-weight-normal" id="lblresponsable"></label>
                        </div>
                        <div class="col">
                            <label for="lblEntrega"><u>Entregado a</u></label>
                            <label type="text" class="form-control border-0 font-weight-normal" id="lblEntrega"></label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tableDetail"><u>Items</u></label>
                        <table class="table" id="detailinfo">
                            <thead>
                                <tr>
                                    <th width="70%">Item</th>
                                    <th width="10%">Cantidad</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- Botones footer --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-sm cerrarinfo" data-dismiss="modal" >Cerrar</button>
                </div>
            </div>
        </div>
    </form>
  </div>
