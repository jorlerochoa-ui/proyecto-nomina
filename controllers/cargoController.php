<?php

require_once __DIR__ . '/../models/cargoModel.php';

class CargoController
{
    private Cargo $cargo;

    public function __construct()
    {
        header('Content-Type: application/json');
        $this->cargo = new Cargo();
    }

    public function listar()
    {
        echo json_encode($this->cargo->listar());
    }

    public function guardar(array $datos)
    {   
        $response=array('estado'=>false,'mensaje'=>'No fue posible registrar el cargo.');
        $nombreCargo = trim($datos['nombre_cargo'] ?? '');
        $valorHora = floatval($datos['valor_hora'] ?? 0);
        $valorHoraExtra = floatval($datos['valor_hora_extra'] ?? 0);
        $horasTrabajoDiario = intval($datos['horas_trabajo_diario'] ?? 0);

        if ($nombreCargo === '' || $valorHora <= 0 || $valorHoraExtra <= 0 || $horasTrabajoDiario <= 0) {
            $response['mensaje'] = 'Todos los campos son obligatorios.';
            return $response;
        }
        try {
            $resultado = $this->cargo->guardar(
                $nombreCargo,
                $valorHora,
                $valorHoraExtra,
                $horasTrabajoDiario
            );
            if ($resultado) {
                 $response['estado'] = true;
                 $response['mensaje'] = 'cargo eliminado correctamente.';
            } else {
                 $response['mensaje'] = 'No fue posible registrar el cargo.';
            }

        } catch (PDOException $e) {
            $response['mensaje'] = 'El cargo esta asociado a un empleado';

        } catch (Exception $e) {
           echo json_encode($response);
        }
        echo json_encode($response);
    }

    public function eliminar(array $datos)
    {   
        $response=array('estado'=>false,'mensaje'=>'No fue posible eliminar el cargo.');
        $idCargo = intval($datos['id_cargo'] ?? 0);
        if($idCargo <= 0){
            $response['mensaje'] = 'ID de cargo inválido.';
            echo json_encode($response);
             return;
        }
        if($this->cargo->eliminar($idCargo)){
            $response['estado'] = true;
            $response['mensaje'] = 'Cargo eliminado correctamente.';
        }else{
             $response['mensaje'] = 'El cargo esta asociado a un vendedor.';
        }
         echo json_encode($response);
    }
}