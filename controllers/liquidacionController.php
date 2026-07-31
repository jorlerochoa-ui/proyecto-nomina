<?php

require_once __DIR__ . '/../models/liquidacionModel.php';

class LiquidacionController
{
    private Liquidacion $liquidacion;

    public function __construct()
    {
        header('Content-Type: application/json');
        $this->liquidacion = new Liquidacion();
    }

    public function listar()
    {
        echo json_encode($this->liquidacion->listar());
    }

    public function guardar(array $datos)
    {
        $idLiquidacion = intval($datos['id_liquidacion'] ?? 0);
        $idEmpleado = intval($datos['id_empleado'] ?? 0);
        $horaEntrada = trim($datos['hora_entrada'] ?? '');
        $horaSalida = trim($datos['hora_salida'] ?? '');
        $semana = intval($datos['semana'] ?? 0);
        $periodo = trim($datos['periodo'] ?? '');
        $response = [
            'estado'=>false,
            'mensaje'=>'No fue posible guardar la liquidacion.'
        ];

        if ($idEmpleado <= 0 || $horaEntrada === '' || $horaSalida === '' || $semana <= 0 || $periodo === '') {
            $response['mensaje'] = 'Todos los campos son obligatorios.';
            echo json_encode($response);
            return;
        }
        try {
            if ($idLiquidacion > 0) {
                $resultado = $this->liquidacion->actualizar($idLiquidacion,$idEmpleado,$horaEntrada,$horaSalida,$semana,$periodo);
                $mensaje = 'Liquidación actualizada correctamente.';
            } else {
                $resultado = $this->liquidacion->guardar($idEmpleado,$horaEntrada,$horaSalida,$semana,$periodo);
                $mensaje = 'Liquidación registrada correctamente.';
            }
            if (!$resultado) {
                $response['mensaje'] = 'No fue posible guardar la liquidación.';
                echo json_encode($response);
                return;
            }
            $response['estado'] = true;
            $response['mensaje'] = $mensaje;
            $response['nombre_empleado'] = $this->liquidacion->obtenerNombreEmpleado($idEmpleado);
            $response['salario_total'] = $this->liquidacion->ultimoSalarioCalculado;

        } catch (PDOException $e) {
            $response['mensaje'] = 'Error de Base de Datos: '.$e->getMessage();
        } catch (Exception $e) {
            $response['mensaje'] = $e->getMessage();
        }

        echo json_encode($response);
    }

    public function eliminar(array $datos)
    {
        $idLiquidacion = intval($datos['id_liquidacion'] ?? 0);
        $response=array('estado'=>false,'mensaje'=>'No fue posible eliminar la liquidacion.');
        if ($idLiquidacion <= 0) {
            $response['mensaje'] = 'ID inválido.';
            echo json_encode($response);
             return;
        }
        try {
            if ($this->liquidacion->eliminar($idLiquidacion)) {
                 $response['estado'] = true;
                 $response['mensaje'] = 'liquidación eliminada correctamente.';
            } else {
               $response['mensaje'] = 'No fue posible eliminar liquidación.';
            }
             echo json_encode($response); 

        } catch (PDOException $e) {
             $response['mensaje'] = 'Error de Base de Datos: '.$e->getMessage();
            echo json_encode($response);

        } 
    }
}