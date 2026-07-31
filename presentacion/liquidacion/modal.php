<div class="modal fade" id="modalLiquidacion" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitulo">
                    Registrar Liquidación
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                <form id="frmLiquidacion">
                    <!-- Campo oculto para el ID de liquidación -->
                    <input type="hidden" id="id_liquidacion" name="id_liquidacion" value="">
                    
                    <div class="mb-3">
                        <label for="id_empleado" class="form-label">Empleado</label>
                        <select class="form-select" id="id_empleado" name="id_empleado" required>
                            <option value="" selected disabled>Seleccione un empleado</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="hora_entrada" class="form-label">Hora de Inicio</label>
                        <input type="time" class="form-control" id="hora_entrada" name="hora_entrada" required>
                    </div>
                    <div class="mb-3">
                        <label for="hora_salida" class="form-label">Hora de Fin</label>
                        <input type="time" class="form-control" id="hora_salida" name="hora_salida" required>
                    </div>
                    <div class="mb-3">
                        <label for="semana" class="form-label">Semana</label>
                        <select class="form-select" id="semana" name="semana" required>
                            <option value="">Seleccione una semana</option>
                            <option value="1">Semana 1</option>
                            <option value="2">Semana 2</option>
                            <option value="3">Semana 3</option>
                            <option value="4">Semana 4</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="periodo" class="form-label">Período</label>
                        <input
                            type="month"
                            class="form-control"
                            id="periodo"
                            name="periodo"
                            required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success" id="btnSubmitForm">Liquidar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>