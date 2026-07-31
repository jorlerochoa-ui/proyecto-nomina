<?php

class Conexion
{
    private PDO $conexion;

    public function __construct() 
    {
        $config = require __DIR__ . '/database.php';

        try {

            $this->conexion = new PDO(
                "mysql:host={$config['HOST']};dbname={$config['DB']};charset={$config['CHARSET']}",
                $config['USER'],
                $config['PASSWORD']/* , [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_SSL_CA =>
                    "C:/xampp/htdocs/proyecto_nomina/DigiCertGlobalRootG2.crt.pem",
                PDO::MYSQL_ATTR_SSL_VERIFY_SERVER_CERT => false
        ] */
            );

            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        } catch (PDOException $e) {

            die("Error de conexión: " . $e->getMessage());

        }
    }

    public function conectar(): PDO
    {
        return $this->conexion;
    }
}