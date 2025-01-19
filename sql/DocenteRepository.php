<?php
class DocenteRepository
{
    private $conexiones;

    public function __construct()
    {
        include 'conexion.php';
        $this->conexiones = $conexiones;
    }

    public function getAllDocentes()
    {
        try {
            $query = $this->conexiones->prepare("SELECT id_Persona,idUsuario, nombre, apellido
            FROM personas
            WHERE codRol = 5
            AND Estado = 1;");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener docentes.';
        }
    }

    public function getMateriaByDocente($id_Persona)
    {
        try {
            $query = $this->conexiones->prepare(
                "SELECT dm.iddocentesmaterias, dm.id_Persona, dm.id_Materia, m.Materia, m.AnioCursada, t.nombreTec
                FROM docentesmaterias dm
                INNER JOIN materias m ON dm.id_Materia = m.id_Materia
                INNER JOIN tecnicaturas t ON t.id_Tecnicatura = m.IdTec
                WHERE dm.id_Persona = :id_Persona
                AND dm.Estado = 1
                ORDER BY t.id_Tecnicatura;"
            );

            $query->bindParam(':id_Persona', $id_Persona, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener materias por docente.';
        }
    }

    public function getNotAgisnedMaterias()
    {
        try {
            $query = $this->conexiones->prepare(
                "SELECT t.id_Tecnicatura, t.nombreTec, m.id_Materia, m.Materia, m.AnioCursada
                FROM tecnicaturas t
                INNER JOIN materias m ON t.id_Tecnicatura = m.IdTec
                WHERE t.EstadoTec = 1
                AND m.Estado = 1
                AND (m.id_Materia
                    NOT IN (
                    SELECT dm.id_Materia
                    FROM docentesmaterias dm
                    WHERE dm.Estado = 1)
                )
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

    public function asignMateria($id_Persona, $id_Materia)
    {
        try {
            $query = $this->conexiones->prepare(
                "INSERT INTO docentesmaterias(id_Persona,id_Materia)
            VALUES (:id_Persona,:id_Materia);"
            );
            $query->bindParam(':id_Persona', $id_Persona, PDO::PARAM_INT);
            $query->bindParam(':id_Materia', $id_Materia, PDO::PARAM_INT);
            $result = $query->execute();

            if ($result) {
                return array('success' => true, 'mensaje' => 'Materia asignada correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al insertar el registro');
            }

        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al asignar una materia.');
        }
    }

    public function deleteAssignedMateria($iddocentesmaterias)
    {
        try {
            $query = $this->conexiones->prepare(
                "UPDATE docentesmaterias
                SET Estado = 0
                WHERE iddocentesmaterias = :iddocentesmaterias;"
            );
            $query->bindParam(':iddocentesmaterias', $iddocentesmaterias, PDO::PARAM_INT);
            $result = $query->execute();
            if ($result) {
                return array('success' => true, 'mensaje' => 'Materia quitada correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al quitar la materia');
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al desactivar una materia.');
        }
    }

    public function getDisabledDocentes()
    {
        try {
            $query = $this->conexiones->prepare("SELECT id_Persona,idUsuario, nombre, apellido FROM personas WHERE codRol = 5 AND Estado = 0;");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener docentes desactivados.';
        }
    }

}