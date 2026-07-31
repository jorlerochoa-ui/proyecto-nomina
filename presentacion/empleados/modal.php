<div class="modal fade" id="modalEmpleado" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Registrar Empleado
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>
            </div>
            <div class="modal-body">
                 <form action="" method="POST" id="frmEmpleado">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre del Empleado</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" placeholder="Ingrese el nombre del empleado" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido del Empleado</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" maxlength="100" placeholder="Ingrese el nombre del empleado" required>
                        </div>
                        <div class="mb-3">
                            <label for="cedula" class="form-label">Cédula</label>
                            <input type="number" class="form-control" id="cedula" name="cedula" placeholder="Ingrese la cédula" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="cargo" class="form-label">Cargo</label>
                            <select class="form-select" id="cargo" name="cargo" required>
                                <option value="">Seleccione un cargo</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Guardar</button>
                        </div>
                    </form>
            </div>
        </div>
    </div>
</div>