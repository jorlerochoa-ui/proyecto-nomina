<div class="modal fade" id="modalCargo" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    Registrar Cargo
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                 <form id="frmCargo">
                        <div class="mb-3">
                            <label for="nombre_cargo" class="form-label">Nombre del Cargo</label>
                            <input type="text" class="form-control" id="nombre_cargo" name="nombre_cargo" maxlength="100" placeholder="Ingrese el nombre del cargo" required>
                        </div>
                        <div class="mb-3">
                            <label for="valor_hora" class="form-label">Valor Hora</label>
                            <input type="number" class="form-control" id="valor_hora" name="valor_hora" min="1" placeholder="Ingrese el valor de la hora" required>
                        </div>
                        <div class="mb-3">
                            <label for="valor_hora_extra" class="form-label">Valor Hora Extra</label>
                            <input type="number" class="form-control" id="valor_hora_extra" name="valor_hora_extra" min="1" placeholder="Ingrese el valor de la hora extra" required>
                        </div>
                        <div class="mb-3">
                            <label for="horas_trabajo_diario" class="form-label">Horas de Trabajo Diario</label>
                            <input type="number" class="form-control" id="horas_trabajo_diario" name="horas_trabajo_diario" min="1" max="24" placeholder="Ingrese las horas de trabajo diario" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>