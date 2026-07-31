<?php

require_once __DIR__ . '/../config/conexion.php';

class Cargo
{
    private PDO $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->conectar();
    }

    public function guardar(
        string $nombreCargo,
        float $valorHora,
        float $valorHoraExtra,
        int $horasTrabajoDiario
    ): bool {

        $sql = "INSERT INTO cargos
                (
                    nombre_cargo,
                    valor_hora,
                    valor_hora_extra,
                    horas_trabajo_diario
                )
                VALUES
                (
                    :nombre_cargo,
                    :valor_hora,
                    :valor_hora_extra,
                    :horas_trabajo_diario
                )";

        $stmt = $this->conexion->prepare($sql);

        $stmt->bindParam(':nombre_cargo', $nombreCargo, PDO::PARAM_STR);
        $stmt->bindParam(':valor_hora', $valorHora);
        $stmt->bindParam(':valor_hora_extra', $valorHoraExtra);
        $stmt->bindParam(':horas_trabajo_diario', $horasTrabajoDiario, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function listar(): array
    {
        $stmt = $this->conexion->query(
            "SELECT * FROM cargos ORDER BY nombre_cargo"
        );
        return $stmt->fetchAll();
    }

     public function eliminar(int $idCargo): bool {
        try {
            $sql = "DELETE FROM cargos WHERE id_cargo = :id_cargo";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_cargo', $idCargo, PDO::PARAM_INT);
            return $stmt->execute();
        } catch(PDOException $e) {

            return false;
        }
    }
}