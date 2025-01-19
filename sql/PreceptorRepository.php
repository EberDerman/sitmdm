<?php
class PreceptorRepository
{
    private $conexiones;

    public function __construct()
    {
        include 'conexion.php';
        $this->conexiones = $conexiones;
    }

    public function getAllPreceptores()
    {
        try {
            $query = $this->conexiones->prepare("SELECT id_Persona, idUsuario, Nombre, Apellido, codRol FROM personas WHERE codRol = 4 AND Estado = 1;");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener preceptores.';
        }
    }

    public function getDisabledPreceptores()
    {
        try {
            $query = $this->conexiones->prepare("SELECT id_Persona, idUsuario, Nombre, Apellido, codRol FROM personas WHERE codRol = 4 AND Estado = 0;");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener preceptores desactivados.';
        }
    }
}