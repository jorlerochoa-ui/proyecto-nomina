<?php

require_once __DIR__ . '/../config/conexion.php';

class Empleado
{
    private PDO $conexion;

    public function __construct()
    {
        $this->conexion = (new Conexion())->conectar();
    }

    public function guardar(
        int $cedula,
        string $nombre,
        string $apellido,
        int $idCargo
    ): bool {

        $sql = "INSERT INTO empleados
                (
                    cedula_empleado,
                    nombre_empleado,
                    apellido_empleado,
                    id_cargo
                )
                VALUES
                (   
                    :cedula,
                    :nombre,
                    :apellido,
                    :id_cargo
                )";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_INT);
        $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
        $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
        $stmt->bindParam(':id_cargo', $idCargo, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function listar(): array
    {
        $sql = "SELECT
                    e.id_empleado,
                    e.nombre_empleado,
                    e.apellido_empleado,
                    c.nombre_cargo,
                    e.fecha_creacion,
                    e.cedula_empleado
                FROM empleados e
                INNER JOIN cargos c
                    ON e.id_cargo = c.id_cargo
                ORDER BY e.nombre_empleado";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function eliminar(int $idEmpleado): bool {
        try {
            $sql = "DELETE FROM empleados WHERE id_empleado = :id_empleado";
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':id_empleado', $idEmpleado, PDO::PARAM_INT);

            return $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function existeCedula(string $cedula): bool
    {
        $sql = "SELECT COUNT(*) FROM empleados WHERE cedula = :cedula";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':cedula', $cedula, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }
}