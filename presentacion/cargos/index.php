<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Listado de Cargos</h3>
        <button
            type="button"
            class="btn btn-primary"
            id="btnNuevoCargo">
            Crear
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre Cargo</th>
                    <th>Valor Hora</th>
                    <th>Valor Hora Extra</th>
                    <th>Horas Trabajo Diario</th>
                    <th>Fecha Creación</th>
                    <th>Acciones</th>
                </tr>

            </thead>
            <tbody id="tblCargos">
            </tbody>

        </table>
    </div>
<?php include 'modal.php'; ?>
<script src="scripts/cargos.js"></script>