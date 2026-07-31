<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Liquidaciones</h3>
        <button
            type="button"
            class="btn btn-primary"
            id="btnNuevaLiquidacion">
            Crear
        </button>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>Empleado</th>
                    <th>Hora Entrada</th>
                    <th>Hora Salida</th>
                    <th>Horas Extras</th>
                    <th>Semana</th>
                    <th>Periodo</th>
                    <th>Salario Total</th>
                    <th>Fecha Creación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody id="tblLiquidaciones">
            </tbody>
        </table>
    </div>
 <?php include 'modal.php'; ?>
<script src="scripts/liquidacion.js"></script>