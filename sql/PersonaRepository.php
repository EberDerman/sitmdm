<?php

class PersonaRepository
{

    private $conexiones;

    public function __construct()
    {
        include 'conexion.php';
        $this->conexiones = $conexiones;
    }

    public function getPersonaByDni($dni)
    {
        try {
            $query = $this->conexiones->prepare("SELECT 1 FROM personas WHERE dni = :dni;");
            $query->bindParam(':dni', $dni, PDO::PARAM_INT);
            $query->execute();
            $result = $query->rowCount() > 0;
            return $result;
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener una persona por su dni.';
            return false;
        }
    }

    public function getPersonaById($id_Persona)
    {
        $query = $this->conexiones->prepare("SELECT * FROM personas WHERE id_Persona = :id_Persona");
        $query->bindParam(':id_Persona', $id_Persona, PDO::PARAM_INT);
        $query->execute();

        // Retorna los resultados como un array asociativo
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function getPersonaByEmail($email)
    {
        try {
            $query = $this->conexiones->prepare("SELECT 1 FROM personas WHERE email = :email;");
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->execute();
            $result = $query->rowCount() > 0;
            return $result;
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener una persona por su email.';
            return false;
        }
    }

    public function getDniByIdPersona($id_Persona)
    {
        try {
            $query = $this->conexiones->prepare("SELECT dni FROM personas WHERE id_Persona = :id_Persona;");
            $query->bindParam(':id_Persona', $id_Persona, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['dni'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener una persona por su id.';
            return false;
        }
    }

    public function saveUsuario($usuario, $contrasenia, $codRol)
    {
        try {
            $query = $this->conexiones->prepare("INSERT INTO usuarios (codRol, usuario, contrasenia) VALUES (:codRol, :usuario, :contrasenia)");
            $query->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $query->bindParam(':contrasenia', $contrasenia, PDO::PARAM_STR);
            $query->bindParam(':codRol', $codRol, PDO::PARAM_INT);
            $query->execute();
            $id = $this->conexiones->lastInsertId();
            return $id;
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al insertar un usuario.' . $e->getMessage() . $e->getTrace();
            return false;
        }
    }

    public function savePersona(
        $idUsuarioInsertado,
        $apellido,
        $nombre,
        $codRol,
        $telefono_1,
        $telefono_2,
        $fecha_nacimiento,
        $dni,
        $cuil,
        $estado_civil,
        $email,
        $nacionalidad,
        $domicilio,
        $pais,
        $titulo
    ) {
        try {
            $query = $this->conexiones->prepare("INSERT INTO personas (idUsuario, apellido, nombre, codRol, telefono_1, telefono_2, fecha_nacimiento, dni, cuil, estado_civil, email, nacionalidad, domicilio, pais, titulo) VALUES (:idUsuario, :apellido, :nombre, :codRol, :telefono_1, :telefono_2, :fecha_nacimiento, :dni, :cuil, :estado_civil, :email, :nacionalidad, :domicilio, :pais, :titulo)");
            $query->bindParam(':idUsuario', $idUsuarioInsertado, PDO::PARAM_INT);
            $query->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $query->bindParam(':codRol', $codRol, PDO::PARAM_INT);
            $query->bindParam(':telefono_1', $telefono_1, PDO::PARAM_STR);
            $query->bindParam(':telefono_2', $telefono_2, PDO::PARAM_STR);
            $query->bindParam(':fecha_nacimiento', $fecha_nacimiento, PDO::PARAM_STR);
            $query->bindParam(':dni', $dni, PDO::PARAM_INT);
            $query->bindParam(':cuil', $cuil, PDO::PARAM_INT);
            $query->bindParam(':estado_civil', $estado_civil, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':nacionalidad', $nacionalidad, PDO::PARAM_STR);
            $query->bindParam(':domicilio', $domicilio, PDO::PARAM_STR);
            $query->bindParam(':pais', $pais, PDO::PARAM_STR);
            $query->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $query->execute();
            $id = $this->conexiones->lastInsertId();
            return $id;
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al insertar una persona.' . $e->getMessage() . $e->getTrace();
            return false;
        }
    }

    public function logicDeletePersona($id_Persona)
    {
        try {
            $query = $this->conexiones->prepare(
                "UPDATE personas
                SET Estado = 0
                WHERE id_Persona = :id_Persona;"
            );
            $query->bindParam(':id_Persona', $id_Persona, PDO::PARAM_INT);
            $result = $query->execute();
            if ($result) {
                return array('success' => true, 'mensaje' => 'Persona desactivada correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al quitar una persona');
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al desactivar una persona.');
        }
    }

    public function logicDeleteUsuario($idUsuario)
    {
        try {
            $query = $this->conexiones->prepare(
                "UPDATE usuarios
                SET Estado = 0
                WHERE idUsuario = :idUsuario;"
            );
            $query->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $result = $query->execute();
            if ($result) {
                return array('success' => true, 'mensaje' => 'Usuario desactivado correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al quitar un usuario');
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al desactivar un usuario.');
        }
    }

    public function logicEnablePersona($id_Persona)
    {
        try {
            $query = $this->conexiones->prepare(
                "UPDATE personas
                SET Estado = 1
                WHERE id_Persona = :id_Persona;"
            );
            $query->bindParam(':id_Persona', $id_Persona, PDO::PARAM_INT);
            $result = $query->execute();
            if ($result) {
                return array('success' => true, 'mensaje' => 'Persona habilitada correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al quitar una persona');
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al desactivar una persona.');
        }
    }

    public function logicEnableUsuario($idUsuario)
    {
        try {
            $query = $this->conexiones->prepare(
                "UPDATE usuarios
                SET Estado = 1
                WHERE idUsuario = :idUsuario;"
            );
            $query->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $result = $query->execute();
            if ($result) {
                return array('success' => true, 'mensaje' => 'Usuario habilitado correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al quitar un usuario');
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al desactivar un usuario.');
        }
    }

    public function resetPassword($idUsuario, $dni)
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

    public function updateEmail($idUsuario, $email)
    {
        try {
            $query = $this->conexiones->prepare(
                "UPDATE usuarios
                SET usuario = :email
                WHERE idUsuario = :idUsuario;"
            );
            $query->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $result = $query->execute();
            if ($result) {
                return array('success' => true, 'mensaje' => 'Email actualizado correctamente.');
            } else {
                return array('success' => false, 'mensaje' => 'Error al actualizar el email');
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            return array('success' => false, 'mensaje' => 'Error al actualizar el email.');
        }
    }

    public function updatePersona($nombre, $apellido, $email, $estado_civil, $domicilio, $telefono_1, $telefono_2, $titulo, $id_Persona)
    {
        try {
            // Primero, obtenemos la persona actual de la base de datos para comparar los datos
            $persona = $this->getPersonaById($id_Persona);

            // Verificamos si los datos ya son los mismos
            if (
                $persona['nombre'] === $nombre &&
                $persona['apellido'] === $apellido &&
                $persona['email'] === $email &&
                $persona['estado_civil'] === $estado_civil &&
                $persona['domicilio'] === $domicilio &&
                $persona['telefono_1'] === $telefono_1 &&
                $persona['telefono_2'] === $telefono_2 &&
                $persona['titulo'] === $titulo
            ) {
                // Si no hay cambios, no ejecutamos la consulta
                return array('success' => false, 'mensaje' => 'No se realizaron cambios.');
            }

            // Si los datos son diferentes, procedemos con la actualización
            $query = $this->conexiones->prepare(
                "UPDATE personas SET 
                nombre = :nombre,
                apellido = :apellido,
                email = :email,
                estado_civil = :estado_civil, 
                domicilio = :domicilio, 
                telefono_1 = :telefono_1, 
                telefono_2 = :telefono_2, 
                titulo = :titulo 
            WHERE id_Persona = :id_Persona"
            );

            // Vinculamos los parámetros
            $query->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $query->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $query->bindParam(':email', $email, PDO::PARAM_STR);
            $query->bindParam(':estado_civil', $estado_civil, PDO::PARAM_STR);
            $query->bindParam(':domicilio', $domicilio, PDO::PARAM_STR);
            $query->bindParam(':telefono_1', $telefono_1, PDO::PARAM_STR);
            $query->bindParam(':telefono_2', $telefono_2, PDO::PARAM_STR);
            $query->bindParam(':titulo', $titulo, PDO::PARAM_STR);
            $query->bindParam(':id_Persona', $id_Persona, PDO::PARAM_INT);

            // Ejecutamos la consulta
            $result = $query->execute();

            // Verificamos si alguna fila fue afectada
            $rowCount = $query->rowCount();

            if ($result && $rowCount > 0) {
                return array('success' => true, 'mensaje' => 'Persona actualizada correctamente.');
            } else {
                // Si no se afectaron filas, puede ser que los datos ya sean los mismos
                return array('success' => false, 'mensaje' => 'No se encontraron cambios o no se actualizó ninguna fila.');
            }
        } catch (PDOException $e) {
            // Capturamos cualquier error de la consulta y lo registramos
            error_log('Error al ejecutar la consulta: ' . $e->getMessage());
            return array('success' => false, 'mensaje' => 'Error al actualizar una persona.');
        }
    }

    public function getRolById($id_Persona)
    {
        try {
            $query = $this->conexiones->prepare("SELECT codRol FROM personas WHERE id_Persona = :id_Persona;");
            $query->bindParam(':id_Persona', $id_Persona, PDO::PARAM_STR);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                return $result['codRol'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            error_log('Error al ejecutar la consulta: ' . $e->getCode());
            echo 'Error al obtener el rol de una persona.';
            return false;
        }
    }

}