
document.addEventListener("DOMContentLoaded", () => {
    cargarCargos();
    cargarEmpleados();
});
const formulario = document.getElementById("frmEmpleado");
if(formulario){
    formulario.addEventListener("submit", guardarEmpleado);
}
const btnNuevoEmpleado = document.getElementById("btnNuevoEmpleado");
if(btnNuevoEmpleado){
    btnNuevoEmpleado.addEventListener("click", function () {
    const modal = new bootstrap.Modal(
        document.getElementById("modalEmpleado")
    );
    modal.show();
});
}
async function guardarEmpleado(e) {
    e.preventDefault();
    const datos = new FormData(e.target);
    try {
        const respuesta = await fetch("rutas/routes.php?controller=empleado&accion=guardar", {
            method: "POST",
            body: datos
        });
        const resultado = await respuesta.json();
        if (resultado.estado) {
            alert(resultado.mensaje);
            e.target.reset();
        } else {
            alert(resultado.mensaje);
        }
        cargarEmpleados();
    } catch (error) {
        console.error(error);
        alert("Error al comunicarse con el servidor.");
    }
}

async function cargarCargos() {

    try {
        const respuesta = await fetch(
            "rutas/routes.php?controller=cargo&accion=listar"
        );
        const cargos = await respuesta.json();
        const select = document.getElementById("cargo");
        cargos.forEach(cargo => {
            const option = document.createElement("option");
            option.value = cargo.id_cargo;
            option.textContent = cargo.nombre_cargo;
            select.appendChild(option);
        });
    } catch (error) {

        console.error(error);
    }
}
async function cargarEmpleados() {
    try {
        const respuesta = await fetch(
            "rutas/routes.php?controller=empleado&accion=listar"
        );
        const empleados = await respuesta.json();
        const tbody = document.getElementById("tblEmpleados");
        tbody.innerHTML = "";
        empleados.forEach(empleado => {
            tbody.innerHTML += `
                <tr>
                    <td>${empleado.id_empleado}</td>
                    <td>${empleado.nombre_empleado}</td>
                    <td>${empleado.cedula_empleado}</td>
                    <td>${empleado.apellido_empleado}</td>
                    <td>${empleado.nombre_cargo}</td>
                    <td>${empleado.fecha_creacion}</td>
                    <td>
                        <button class="btn btn-danger btn-sm"
                         onclick="eliminarEmpleado(${empleado.id_empleado})">
                            Eliminar
                        </button>
                    </td>
                </tr>
            `;
        });
       
    } catch (error) {
        console.error(error);
    }
}

async function eliminarEmpleado(id) {
    if (!confirm("¿Está seguro de eliminar este empleado?")) return;
    const datos = new FormData();
    datos.append("id_empleado", id);
    try {
        const respuesta = await fetch(
            "rutas/routes.php?controller=empleado&accion=eliminar",
            {
                method: "POST",
                body: datos
            }
        );
        const resultado = await respuesta.json();
        alert(resultado.mensaje);
        if (resultado.estado) {
            cargarEmpleados();
        }
    } catch(error) {
        console.error(error);
        alert("Error al eliminar empleado.");
    }
}