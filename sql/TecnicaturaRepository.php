<?php
class TecnicaturaRepository
{
    private $conexiones;

    public function __construct()
    {
        include 'conexion.php';
        $this->conexiones = $conexiones;
    }

    public function getTecnicaturasInscripcion()
    {
        try {
            $query = $this->conexiones->prepare(
                "SELECT t.id_Tecnicatura, t.nombreTec, t.Ciclo
                FROM tecnicaturas t
                WHERE t.Ciclo = (
                SELECT MAX(Ciclo) FROM tecnicaturas)
                AND t.EstadoTec = 1;"
            );
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getMessage());
            echo 'Error al obtener las tecnicaturas.';
        }
    }

    public function getTecnicaturas()
    {
        try {
            $query = $this->conexiones->prepare(
                "SELECT id_Tecnicatura, nombreTec, Resolucion, Ciclo, FechaModificacion FROM tecnicaturas;"
            );
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getMessage());
            echo 'Error al obtener las tecnicaturas.';
        }
    }

}
