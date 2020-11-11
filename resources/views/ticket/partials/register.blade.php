
<div class="modal fade bd-example-modal-lg" id="ticketModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <form id="ticketForm" novalidate autocomplete="off">
        @csrf
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                {{-- header --}}
                <h5 class="modal-title" id="modalTitle">Registrar</h5>
                {{-- Boton cerrar --}}
                <button type="button" class="close" id="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                {{-- Contenido --}}
                <div class="modal-body">
                    <div class="form-group">
                        <label for="txtResponsable"><span style="color: red">*</span>Entregado a</label>
                        <input type="text" class="form-control" id="txtResponsable" placeholder="Introduzca el responsable">
                        <div class="invalid-feedback" id="errorResponsable"></div>
                    </div>
                    <div class="form-group">
                        <label for="txtDescription">Buscar Item</label>
                        <div class="input-group mb-3">
                            {{-- <input type="text" class="form-control" id="txtItem" placeholder="Introduzca el item"> --}}

                            <select id="txtItem" class="custom-select">
                                <option selected>Seleccione un item</option>
                                @foreach ($items as $item)
                                    <option value="{{$item->id}}">{{$item->itemCode}}</option>
                                @endforeach
                              </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-primary btn-sm" id="btnItemSelect" ><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                        <div class="p-2 mb-2 bg-light text-white d-flex align-items-center" id="divItemSelect">
                            <input type="hidden" id="itemId">
                            <p class="text-secondary d-inline m-0 mr-0" id="lblItem">Item encontrado</p>
                            <sub class="text-secondary d-inline m-0 mr-auto" id="subItem"></sub>
                            <input type="number" class="form-control d-inline col-2" min="1" id="quantityInput" value="1" disabled>
                            <button type="button" class="btn btn-success  ml-2" id="btnAddDetail" disabled>Agregar</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tableDetail">Items</label>
                        <table class="table" id="detail">
                            <thead>
                                <tr>
                                    <th width="10%"> Opciones</th>
                                    <th width="10%">Id</th>
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
                    <button type="button" class="btn btn-primary btn-sm" id="btnStoreDetail">Guardar</button>
                </div>
            </div>
        </div>
    </form>
  </div>
