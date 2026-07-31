<?php

require_once __DIR__ . '/../config/conexion.php';

class Liquidacion
{
    private PDO $conexion;
    public float $ultimoSalarioCalculado = 0.0;

    public function __construct()
    {
        $this->conexion = (new Conexion())->conectar();
    }

    public function guardar(int $idEmpleado, string $horaEntrada, string $horaSalida, int $semana, string $periodo): bool {

        list($ano, $mes) = explode('-', $periodo);
        if (!$this->validarPeriodoLiquidado($idEmpleado, $semana, $mes, $ano)) {
            throw new Exception('Ya existe una liquidación para este empleado en la semana seleccionada.');
        }
        $datos = $this->prepararLiquidacion($idEmpleado, $horaEntrada, $horaSalida);
        $sql = "INSERT INTO liquidacion_semanal (id_empleado, id_cargo, hora_entrada, 
                            hora_salida, horas_extras, semana, mes, ano, salario_total) 
                VALUES (:id_empleado, :id_cargo, :hora_entrada, :hora_salida, :horas_extras, :semana, :mes, :ano, :salario_total);";
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            ':id_empleado'   => $idEmpleado,
            ':id_cargo'      => $datos['cargo']['id_cargo'],
            ':hora_entrada'  => $horaEntrada,
            ':hora_salida'   => $horaSalida,
            ':horas_extras'  => $datos['horasExtras'],
            ':semana'        => $semana,
            ':mes'           => $mes,
            ':ano'           => $ano,
            ':salario_total' => $datos['salarioTotal']
        ]);

        return true;
    }

    public function actualizar(int $idLiquidacion, int $idEmpleado, string $horaEntrada, string $horaSalida, int $semana, string $periodo): bool {

        list($ano, $mes) = explode('-', $periodo);
        if (!$this->validarPeriodoLiquidado( $idEmpleado, $semana, $mes, $ano,$idLiquidacion)) {
            throw new Exception('Ya existe otra liquidación para este empleado en la semana seleccionada.');
        }
        $datos = $this->prepararLiquidacion($idEmpleado, $horaEntrada, $horaSalida);

        $sql = "UPDATE liquidacion_semanal
                SET id_empleado = :id_empleado,id_cargo = :id_cargo,hora_entrada = :hora_entrada,
                    hora_salida = :hora_salida,horas_extras = :horas_extras,semana = :semana,
                    mes = :mes,ano = :ano,salario_total = :salario_total
                WHERE id_liquidacion = :id_liquidacion";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            ':id_liquidacion' => $idLiquidacion,
            ':id_empleado'    => $idEmpleado,
            ':id_cargo'       => $datos['cargo']['id_cargo'],
            ':hora_entrada'   => $horaEntrada,
            ':hora_salida'    => $horaSalida,
            ':horas_extras'   => $datos['horasExtras'],
            ':semana'         => $semana,
            ':mes'            => $mes,
            ':ano'            => $ano,
            ':salario_total'  => $datos['salarioTotal']
        ]);
        return true;
    }

    public function eliminar(int $idLiquidacion): bool {
        $sql = "DELETE FROM liquidacion_semanal WHERE id_liquidacion = :id_liquidacion";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_liquidacion', $idLiquidacion, PDO::PARAM_INT);
        return $stmt->execute();
    }
       
    public function listar(): array {
        $sql = "SELECT
                    l.id_liquidacion,
                    l.id_empleado,
                    e.nombre_empleado,
                    e.apellido_empleado,
                    l.semana,
                    l.mes,
                    l.ano,
                    l.hora_entrada,
                    l.hora_salida,
                    l.horas_extras,
                    l.salario_total,
                    l.semana,
                    concat(l.ano,'-',l.mes) as periodo,
                    l.fecha_creacion
                FROM liquidacion_semanal l
                INNER JOIN cargos c ON l.id_cargo = c.id_cargo
                INNER JOIN empleados e ON l.id_empleado = e.id_empleado
                ORDER BY l.id_liquidacion DESC";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function obtenerInfoCargo(int $idEmpleado): ?array {
         $sql = "SELECT
                    c.id_cargo,
                    c.valor_hora,
                    c.valor_hora_extra,
                    c.horas_trabajo_diario
                FROM empleados e
                INNER JOIN cargos c
                    ON e.id_cargo = c.id_cargo
                WHERE e.id_empleado = :id_empleado";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id_empleado', $idEmpleado, PDO::PARAM_INT);
        $stmt->execute();

        $cargo = $stmt->fetch(PDO::FETCH_ASSOC);
        return $cargo ?: null;
    }

    public function calculoHorasTrabajadas(string $horaEntrada, string $horaSalida): float {
        $entrada = strtotime($horaEntrada);
        $salida = strtotime($horaSalida);
        if ($salida < $entrada) {
            $salida += 86400; // 24 horas en segundos
        }
        $horasTrabajadas = ($salida - $entrada) / 3600;
        
        return (float)$horasTrabajadas;
    }

    public function calcularSalario(float $horasTrabajadas, float $horasExtras, array $cargo): float {

    $horasNormales = min($horasTrabajadas,48);

    $salarioTotal =
        ($horasNormales *$cargo['valor_hora']) +
        ($horasExtras * $cargo['valor_hora_extra']);

    return (float)$salarioTotal;
}


    public function calculoHorasExtras(float $horasTrabajadas): float {
        return max(0, $horasTrabajadas - 48);
    }

    public function validarPeriodoLiquidado(int $idEmpleado, int $semana, int $mes, int $anio, ?int $idLiquidacion = null): bool {

        $sql = "SELECT COUNT(*)
                FROM liquidacion_semanal
                WHERE id_empleado = :id_empleado
                AND semana = :semana
                AND mes = :mes
                AND ano = :anio";
        if ($idLiquidacion !== null) {
            $sql .= " AND id_liquidacion != :id_liquidacion";
        }
        $stmt = $this->conexion->prepare($sql);
        $parametros = [
            ':id_empleado' => $idEmpleado,
            ':semana'      => $semana,
            ':mes'         => $mes,
            ':anio'        => $anio
        ];
        if ($idLiquidacion !== null) {
            $parametros[':id_liquidacion'] = $idLiquidacion;
        }
        $stmt->execute($parametros);
        return $stmt->fetchColumn() == 0;
    }

    private function prepararLiquidacion(int $idEmpleado,string $horaEntrada,string $horaSalida): array {

        $cargo = $this->obtenerInfoCargo($idEmpleado);
        if (!$cargo) {
            throw new Exception("No se encontró el cargo del empleado.");
        }
        $horasTrabajadas = $this->calculoHorasTrabajadas($horaEntrada,$horaSalida);
        $horasExtras = $this->calculoHorasExtras($horasTrabajadas,$cargo);
        $salarioTotal = $this->calcularSalario($horasTrabajadas,$horasExtras,$cargo);
        $this->ultimoSalarioCalculado = $salarioTotal;
        return [
            'cargo' => $cargo,
            'horasExtras' => $horasExtras,
            'salarioTotal' => $salarioTotal
        ];
    }

    public function obtenerNombreEmpleado(int $idEmpleado): string {

        $sql = "SELECT CONCAT(nombre_empleado, ' ', apellido_empleado) AS nombre
                FROM empleados
                WHERE id_empleado = :id_empleado";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute([
            ':id_empleado' => $idEmpleado
        ]);

        return $stmt->fetchColumn();
    }
}