<?php
class MateriasRepository
{
    private $conexiones;

    public function __construct()
    {
        include 'conexion.php';
        $this->conexiones = $conexiones;
    }

    public function getMateriasByCarrera()
    {
        try {
            $query = $this->conexiones->prepare(
                "SELECT t.id_Tecnicatura, t.nombreTec, m.id_Materia, m.Materia, m.AnioCursada
                FROM tecnicaturas t
                INNER JOIN materias m ON t.id_Tecnicatura = m.IdTec
                WHERE t.EstadoTec = 1 AND m.Estado = 1
                ORDER BY t.id_Tecnicatura;"
            );
            $query->execute();
            $resultados = $query->fetchAll(PDO::FETCH_ASSOC);
            $materiasByCarrera = array();
            foreach ($resultados as $fila) {
                $idTecnicatura = $fila['id_Tecnicatura'];
                $nombreTec = $fila['nombreTec'];
                unset($fila['id_Tecnicatura']);
                unset($fila['nombreTec']);
                $materiasByCarrera[$idTecnicatura][$nombreTec][] = $fila;
            }
            //La sintaxis [] es un shortcut para agregar un nuevo elemento al final del array.
            return $materiasByCarrera;
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener las materias.';
        }
    }

    public function getMateriasNoAsignadas($anio_seleccionado)
    {
        $anio_actual = date("Y");
        $anio_seleccionado < $anio_actual ? $anio_actual = $anio_seleccionado : $anio_actual;

        try {
            $query = $this->conexiones->prepare(
                "SELECT DISTINCT m.id_Materia, m.Materia, m.AnioCursada, t.Ciclo, t.nombreTec, tc.tipocursada
                FROM materias m
                JOIN tecnicaturas t ON m.IdTec = t.id_Tecnicatura
                JOIN estudiante_materia em ON m.id_Materia = em.id_Materia AND em.id_Tipocursada = 1
                JOIN tipocursada tc ON em.id_Tipocursada = tc.id_Tipocursada
                WHERE (t.Ciclo + CASE m.AnioCursada 
                                    WHEN 'Primero' THEN 1 
                                    WHEN 'Segundo' THEN 2 
                                    WHEN 'Tercero' THEN 3 
                                    WHEN 'Cuarto' THEN 4 
                                    WHEN 'Quinto' THEN 5
                                    ELSE 0 
                                END) = (:anio_seleccionado + 1)
                AND (t.Ciclo + 4) >= (:anio_seleccionado + 1);"
            );

            $query->bindParam(':anio_seleccionado', $anio_seleccionado, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener materias por docente.';
        }
    }

}