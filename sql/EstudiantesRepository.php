<?php
class EstudiantesRepository
{
    private $conexiones;

    public function __construct()
    {
        include 'conexion.php';
        $this->conexiones = $conexiones;
    }

    public function getAllEstudiantes()
    {
        try {
            $query = $this->conexiones->prepare("SELECT id_Persona,idUsuario, nombre, apellido, dni
            FROM estudiantes
            WHERE Estado = 1;");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener estudiantes.';
        }
    }

    public function getAllPreinscriptos($id_Tecnicatura)
    {
        try {
            $query = $this->conexiones->prepare("SELECT e.id_estudiante, e.nombre, e.apellido, e.dni_numero
            FROM estudiantes e
            INNER JOIN estudiante_tecnicatura et
            ON e.id_estudiante = et.id_estudiante
            WHERE et.inscripto = 0
            AND et.id_tecnicatura = :id_Tecnicatura
            AND e.estado = 1;");
            $query->bindParam(':id_Tecnicatura', $id_Tecnicatura, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener estudiantes preinscriptos.';
        }

    }

    public function getAllInscriptos($id_Tecnicatura)
    {
        try {
            $query = $this->conexiones->prepare("SELECT e.id_estudiante, e.nombre, e.apellido, e.dni_numero, e.idUsuario
            FROM estudiantes e
            INNER JOIN estudiante_tecnicatura et
            ON e.id_estudiante = et.id_estudiante
            WHERE et.inscripto = 1
            AND et.id_tecnicatura = :id_Tecnicatura
            AND e.estado = 1;");
            $query->bindParam(':id_Tecnicatura', $id_Tecnicatura, PDO::PARAM_INT);
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener estudiantes inscriptos.';
        }
    }

    public function getEstudianteById($id_estudiante)
    {
        try {
            // Preparar la consulta SQL
            $query = $this->conexiones->prepare("SELECT * FROM estudiantes WHERE id_estudiante = :id_estudiante;");
            $query->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
            $query->execute();

            $estudiante = $query->fetch(PDO::FETCH_ASSOC);

            if ($estudiante === false) {
                return false;
            }

            return $estudiante;

        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getMessage());
            echo 'Error al obtener el estudiante.';
            return false;
        }
    }

    public function getEstudianteTecnicaturaById($id_estudiante)
    {
        try {
            // Preparar la consulta SQL
            $query = $this->conexiones->prepare("SELECT * FROM estudiante_tecnicatura WHERE id_estudiante = :id_estudiante;");
            $query->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
            $query->execute();

            $estudiante = $query->fetch(PDO::FETCH_ASSOC);

            if ($estudiante === false) {
                return false;
            }

            return $estudiante;

        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getMessage());
            echo 'Error al obtener el estudiante.';
            return false;
        }
    }


    public function getEstudianteByDni($dni)
    {
        try {
            $query = $this->conexiones->prepare("SELECT * FROM estudiantes WHERE dni_numero = :dni;");
            $query->bindParam(':dni', $dni, PDO::PARAM_INT);
            $query->execute();
            $result = $query->rowCount() > 0;
            return $result;
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener un estudiante por su dni.';
            return false;
        }
    }

    public function getEstudianteByEmail($email)
    {
        try {
            $query = $this->conexiones->prepare("SELECT * FROM estudiantes WHERE email = :email;");
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $result = $query->rowCount() > 0;
            return $result;
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener un estudiante por su email.';
            return false;
        }
    }

    public function getDniByIdEstudiante($id_estudiante)
    {
        try {
            $query = $this->conexiones->prepare("SELECT dni_numero FROM estudiantes WHERE id_estudiante = :id_estudiante;");
            $query->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['dni_numero'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener un estudiante por su id.';
            return false;
        }
    }

    public function updateInscriptoByEstudiante($id_estudiante)
    {
        try {
            $query = $this->conexiones->prepare(
                "UPDATE estudiante_tecnicatura
                SET inscripto = 1
                WHERE id_estudiante = :id_estudiante;"
            );
            $query->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
            $result = $query->execute();
            if ($result) {
                return array('success' => true, 'mensaje' => 'Estudiante inscripto correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al inscribir al estudiante');
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al intentar inscribir al estudiante.');
        }
    }

    public function getEstudiantesMateriasNoAsignadas($anio_seleccionado)
    {
        $anio_actual = date("Y");
        $anio_seleccionado < $anio_actual ? $anio_actual = $anio_seleccionado : $anio_actual;

        try {
            $query = $this->conexiones->prepare(
                "SELECT m.id_Materia, m.Materia, m.AnioCursada, t.Ciclo, t.nombreTec, 
                est.nombre AS nombre_alumno, est.apellido AS apellido_alumno, 
                tc.tipocursada
                FROM materias m
                JOIN tecnicaturas t ON m.IdTec = t.id_Tecnicatura
                JOIN estudiante_materia em ON m.id_Materia = em.id_Materia AND em.id_Tipocursada = 1
                JOIN estudiantes est ON em.id_estudiante = est.id_estudiante
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

    public function estudiantesMateriasToRegular($anio_seleccionado)
    {
        $anio_actual = date("Y");
        $anio_seleccionado < $anio_actual ? $anio_actual = $anio_seleccionado : $anio_actual;

        try {
            $query = $this->conexiones->prepare(
                "UPDATE estudiante_materia
                SET id_Tipocursada = 3
                WHERE id_Tipocursada = 1
                AND id_Materia IN (
                    SELECT m.id_Materia
                    FROM materias m
                    JOIN tecnicaturas t ON m.IdTec = t.id_Tecnicatura
                    JOIN estudiante_materia em ON m.id_Materia = em.id_Materia AND em.id_Tipocursada = 1
                    JOIN estudiantes est ON em.id_estudiante = est.id_estudiante
                    JOIN tipocursada tc ON em.id_Tipocursada = tc.id_Tipocursada
                    WHERE (t.Ciclo + CASE m.AnioCursada 
                                        WHEN 'Primero' THEN 1 
                                        WHEN 'Segundo' THEN 2 
                                        WHEN 'Tercero' THEN 3 
                                        WHEN 'Cuarto' THEN 4 
                                        WHEN 'Quinto' THEN 5
                                        ELSE 0 
                                    END) = (:anio_seleccionado + 1)
                    AND (t.Ciclo + 4) >= (:anio_seleccionado + 1));"
            );

            $query->bindParam(':anio_seleccionado', $anio_seleccionado, PDO::PARAM_INT);
            $query->execute();
            return $query->rowCount();
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener materias por docente.';
        }
    }

    public function logicDeleteEstudiante($id_estudiante)
    {
        try {
            $query = $this->conexiones->prepare(
                "UPDATE estudiantes
                SET Estado = 0
                WHERE id_estudiante = :id_estudiante;"
            );
            $query->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
            $result = $query->execute();
            if ($result) {
                return array('success' => true, 'mensaje' => 'Estudiante desactivado correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al quitar una persona');
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al desactivar un estudiante.');
        }
    }

    public function logicEnableEstudiante($id_estudiante)
    {
        try {
            $query = $this->conexiones->prepare(
                "UPDATE estudiantes
                SET Estado = 1
                WHERE id_estudiante = :id_estudiante;"
            );
            $query->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
            $result = $query->execute();
            if ($result) {
                return array('success' => true, 'mensaje' => 'Estudiante habilitada correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al quitar un estudiante');
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al desactivar un estudiante.');
        }
    }

    public function resetPasswordEstudiante($idUsuario, $dni)
    {
        try {
            $query = $this->conexiones->prepare(
                "UPDATE usuarios
                SET contrasenia = :dni
                WHERE idUsuario = :idUsuario;"
            );
            $query->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $query->bindParam(':dni', $dni, PDO::PARAM_STR);
            $result = $query->execute();
            if ($result) {
                return array('success' => true, 'mensaje' => 'Contraseña reiniciada correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al reiniciar la contraseña');
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al reiniciar la contraseña.');
        }
    }

    public function getDisabledEstudiantes()
    {
        try {
            $query = $this->conexiones->prepare("SELECT id_estudiante, idUsuario, nombre, apellido FROM estudiantes WHERE Estado = 0;");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener estudiantes desactivados.';
        }
    }

}