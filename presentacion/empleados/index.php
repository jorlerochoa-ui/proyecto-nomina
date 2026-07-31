<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Empleados</h3>
        <button
            type="button"
            class="btn btn-primary"
            id="btnNuevoEmpleado">
            Crear
        </button>

    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                     <th>Cedula</th>
                    <th>Apellido</th>
                    <th>Cargo</th>
                    <th>Fecha Creación</th>
                    <th>Acciones</th>
                </tr>

            </thead>
            <tbody id="tblEmpleados">
            </tbody>
        </table>
    </div>
</div>
 <?php include 'modal.php'; ?>
<script src="scripts/empleados.js"></script>
