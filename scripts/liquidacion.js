// Variable global para almacenar las liquidaciones cargadas y usarlas en la edición
let listaLiquidaciones = [];

document.addEventListener("DOMContentLoaded", () => {
    cargarLiquidaciones();
    cargarEmpleados();
});

const btnNuevaLiquidacion = document.getElementById("btnNuevaLiquidacion");
if (btnNuevaLiquidacion) {
    btnNuevaLiquidacion.addEventListener("click", () => {
        abrirModal('crear');
    });
}

const formulario = document.getElementById("frmLiquidacion");
if (formulario) {
    formulario.addEventListener("submit", guardarLiquidacion);
}

// Función para abrir la modal en modo Crear o Editar
function abrirModal(modo, id = null) {
    const modalEl = document.getElementById("modalLiquidacion");
    const modalInstancia = bootstrap.Modal.getOrCreateInstance(modalEl);
    const form = document.getElementById("frmLiquidacion");
    if (modo === 'crear') {
        form.reset();
        document.getElementById("id_liquidacion").value = "";
        document.getElementById("modalTitulo").textContent = "Registrar Liquidación";
        document.getElementById("btnSubmitForm").textContent = "Liquidar";
        modalInstancia.show();
    } 
    else if (modo === 'editar') {
        const liq = listaLiquidaciones.find(item => item.id_liquidacion == id);
        if (liq) {
            document.getElementById("id_liquidacion").value = liq.id_liquidacion;
            document.getElementById("id_empleado").value = liq.id_empleado;
            document.getElementById("hora_entrada").value = liq.hora_entrada.substring(0, 5);
            document.getElementById("hora_salida").value = liq.hora_salida.substring(0, 5);
            document.getElementById("semana").value = liq.semana;
            const periodoFormateado = `${liq.ano}-${String(liq.mes).padStart(2, '0')}`;
            document.getElementById("periodo").value = periodoFormateado;
            document.getElementById("modalTitulo").textContent = "Editar Liquidación";
            document.getElementById("btnSubmitForm").textContent = "Guardar Cambios";
            modalInstancia.show();
        } else {
            alert("No se encontró la liquidación seleccionada.");
        }
    }
}

async function guardarLiquidacion(e) {
    e.preventDefault();
    const datos = new FormData(e.target);
    try {
        const respuesta = await fetch("rutas/routes.php?controller=liquidacion&accion=guardar", {
            method: "POST",
            body: datos
        });
        const resultado = await respuesta.json();
       alert(`${resultado.mensaje}
        Empleado: ${resultado.nombre_empleado}
        Salario calculado: $${parseFloat(resultado.salario_total).toLocaleString('es-CO')}`);    
        if (resultado.estado) {
            e.target.reset();
            // Cerramos la modal de manera segura
            const modalEl = document.getElementById("modalLiquidacion");
            const modalInstancia = bootstrap.Modal.getOrCreateInstance(modalEl);
            modalInstancia.hide();
            cargarLiquidaciones();
        }
    } catch (error) {
        console.error(error);
        alert("Error al comunicarse con el servidor.");
    }
}

async function eliminarLiquidacion(id) {
    if (confirm("¿Está seguro de que desea eliminar esta liquidación?")) {
        const datos = new FormData();
        datos.append("accion", "eliminar");
        datos.append("id_liquidacion", id);
        try {
            const respuesta = await fetch("rutas/routes.php?controller=liquidacion&accion=eliminar", {
                method: "POST",
                body: datos
            });
            const resultado = await respuesta.json();
            alert(resultado.mensaje);
            if (resultado.estado) {
                cargarLiquidaciones();
            }
        } catch (error) {
            console.error(error);
            alert("Error al comunicarse con el servidor.");
        }
    }
}

// Carga del select de empleados
async function cargarEmpleados() {
    try {
        const respuesta = await fetch("rutas/routes.php?controller=empleado&accion=listar");
        const empleados = await respuesta.json();
        const select = document.getElementById("id_empleado");
        
        // Limpiar opciones previas excepto la primera descriptiva
        select.innerHTML = '<option value="" selected disabled>Seleccione un empleado</option>';
        
        empleados.forEach(empleado => {
            const option = document.createElement("option");
            option.value = empleado.id_empleado;
            option.textContent = empleado.nombre_empleado + " " + empleado.apellido_empleado;
            select.appendChild(option);
        });
    } catch (error) {
        console.error("Error al cargar empleados:", error);
    }
}

// Carga de la tabla de liquidaciones
async function cargarLiquidaciones() {
    try {
        const respuesta = await fetch(
            "rutas/routes.php?controller=liquidacion&accion=listar"
        );
        const liquidaciones = await respuesta.json();
        listaLiquidaciones = liquidaciones;
        const tbody = document.getElementById("tblLiquidaciones");
        tbody.innerHTML = "";
        if (liquidaciones.length === 0) {
            tbody.innerHTML = `<tr><td colspan="8" class="text-center">No hay liquidaciones registradas.</td></tr>`;
            return;
        }
        liquidaciones.forEach(liquidacion => {
            tbody.innerHTML += `
                <tr>
                    <td>${liquidacion.id_liquidacion}</td>
                    <td>${liquidacion.nombre_empleado} ${liquidacion.apellido_empleado}</td>
                    <td>${liquidacion.hora_entrada}</td>
                    <td>${liquidacion.hora_salida}</td>
                    <td>${liquidacion.horas_extras}</td>
                    <td>${liquidacion.semana}</td>
                    <td>${liquidacion.periodo}</td>
                    <td>$${parseFloat(liquidacion.salario_total).toLocaleString('es-ES', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    <td>${liquidacion.fecha_creacion}</td>
                    <td>
                        <button
                            class="btn btn-warning btn-sm me-1" 
                            onclick="abrirModal('editar', ${liquidacion.id_liquidacion})">
                            Editar
                        </button>
                        <button
                            class="btn btn-danger btn-sm"
                            onclick="eliminarLiquidacion(${liquidacion.id_liquidacion})">
                            Eliminar
                        </button>
                    </td>
                </tr>
            `;
        });
    } catch (error) {
        console.error("Error al cargar liquidaciones:", error);
    }
}