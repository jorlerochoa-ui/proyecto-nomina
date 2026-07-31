document.addEventListener("DOMContentLoaded", () => {
    const formulario = document.getElementById("frmCargo");
    formulario.addEventListener("submit", guardarCargo);
    cargarCargos();
});

const btnNuevoCargo = document.getElementById("btnNuevoCargo");
if(btnNuevoCargo){
    btnNuevoCargo.addEventListener("click", function () {
    const modal = new bootstrap.Modal(
        document.getElementById("modalCargo")
    );
    modal.show();
});
}

async function guardarCargo(e) {
    e.preventDefault();
    const datos = new FormData(e.target);
    try {
        const respuesta = await fetch("rutas/routes.php?controller=cargo&accion=guardar", {
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
        cargarCargos();
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
        const tbody = document.getElementById("tblCargos");
        tbody.innerHTML = "";
        cargos.forEach(cargo => {
            tbody.innerHTML += `
                <tr>
                    <td>${cargo.id_cargo}</td>
                    <td>${cargo.nombre_cargo}</td>
                    <td>${cargo.valor_hora}</td>
                    <td>${cargo.valor_hora_extra}</td>
                    <td>${cargo.horas_trabajo_diario}</td>
                    <td>${cargo.fecha_creacion}</td>
                    <td>
                        <button
                            class="btn btn-danger btn-sm"
                            onclick="eliminarCargo(${cargo.id_cargo})">
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

async function eliminarCargo(id){

    if(!confirm("¿Está seguro de eliminar este cargo?")){
        return;
    }
    const datos = new FormData();
    datos.append("id_cargo", id);
    const respuesta = await fetch(
        "rutas/routes.php?controller=cargo&accion=eliminar",
        {
            method:"POST",
            body:datos
        }
    );
    const resultado = await respuesta.json();
    console.log(resultado);
    
    alert(resultado.mensaje);
    if(resultado.estado){
        cargarCargos();
    }
}