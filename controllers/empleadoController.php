<?php

require_once __DIR__ . '/../models/empleadoModel.php';

class EmpleadoController
{
    private Empleado $empleado;

    public function __construct()
    {
        header('Content-Type: application/json');
        $this->empleado = new Empleado();
    }

    public function listar()
    {
        echo json_encode($this->empleado->listar());
    }


    public function guardar(array $datos)
    {
        $cedula = trim($datos['cedula'] ?? '');
        $nombre = trim($datos['nombre'] ?? '');
        $apellido = trim($datos['apellido'] ?? '');
        $cargo = intval($datos['cargo'] ?? 0);
        if ($nombre === '' || $cedula === '' || $cargo <= 0) {
            echo json_encode([
                'estado' => false,
                'mensaje' => 'Todos los campos son obligatorios.'
            ]);
            return;
        }

        if ($empleado->existeCedula($cedula)) {
            echo json_encode([
                'estado' => false,
                'mensaje' => 'La cédula ya se encuentra registrada.'
            ]);
            exit;
        }
        $registro=$this->empleado->guardar($cedula, $nombre, $apellido, $cargo);
        if ($registro) {
            echo json_encode([
                'estado' => true,
                'mensaje' => 'Empleado registrado correctamente.'
            ]);

        } else {
            echo json_encode([
                'estado' => false,
                'mensaje' => 'No fue posible registrar el empleado.'
            ]);
        }
    }

    public function eliminar(array $datos)
    {   
        $response=array('estado'=>false,'mensaje'=>'No fue posible eliminar el empleado.');
        $id_empleado = intval($datos['id_empleado'] ?? 0);
        if($id_empleado <= 0){
            $response['mensaje'] = 'ID de empleado inválido.';
            echo json_encode($response);
             return;
        }
        if($this->empleado->eliminar($id_empleado)){
            $response['estado'] = true;
            $response['mensaje'] = 'Empleado eliminado correctamente.';
        }else{
              $response['mensaje'] = 'Error al eliminar empleado tiene liquidacion.';
        }
        echo json_encode($response);
    }
}