<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../sql/conexion.php");

// Verificar que el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir los datos del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Obtener los parámetros desde la URL
    $id_estudiante = $_GET['id_estudiante']; // Obtener ID del estudiante desde la URL
    $id_tecnicatura = $_GET['id_Tecnicatura']; // Obtener ID de la tecnicatura desde la URL

    // Validar que las contraseñas coinciden
    if ($password !== $confirmPassword) {
        echo "Las contraseñas no coinciden.";
        exit;
    }

    // Establecer el rol del usuario
    $codRol = 6; // Cambiar según el rol que desees

    // Verificar si el usuario ya existe
    $checkUserSql = "SELECT idUsuario FROM usuarios WHERE usuario = ?";
    if ($checkUserStmt = $conexion->prepare($checkUserSql)) {
        $checkUserStmt->bind_param("s", $usuario);
        $checkUserStmt->execute();
        $checkUserStmt->store_result();

        if ($checkUserStmt->num_rows > 0) {
            // Si el usuario existe, obtener el ID del usuario
            $checkUserStmt->bind_result($id_usuario);
            $checkUserStmt->fetch();
        } else {
            // Si el usuario no existe, insertar uno nuevo con contraseña hasheada
            /*$hashedPassword = password_hash($password, PASSWORD_DEFAULT);*/
            $sql = "INSERT INTO usuarios (codRol, usuario, contrasenia) VALUES (?, ?, ?)";
            if ($stmt = $conexion->prepare($sql)) {
                $stmt->bind_param("iss", $codRol, $usuario, $password);
                if ($stmt->execute()) {
                    // Obtener el ID del usuario recién insertado
                    $id_usuario = $conexion->insert_id;
                } else {
                    echo "Error al crear el usuario: " . $stmt->error;
                    exit;
                }
                $stmt->close();
            } else {
                echo "Error al preparar la consulta para insertar el usuario: " . $conexion->error;
                exit;
            }
        }
        $checkUserStmt->close();
    } else {
        echo "Error al preparar la consulta para verificar el usuario: " . $conexion->error;
        exit;
    }

    // Insertar o actualizar el ID del usuario en la tabla estudiantes
    $insertEstudianteSql = "UPDATE estudiantes SET idUsuario = ? WHERE id_estudiante = ?";
    if ($insertEstudianteStmt = $conexion->prepare($insertEstudianteSql)) {
        $insertEstudianteStmt->bind_param("ii", $id_usuario, $id_estudiante);
        if (!$insertEstudianteStmt->execute()) {
            echo "Error al actualizar el ID del usuario en la tabla estudiantes: " . $insertEstudianteStmt->error;
            exit;
        }
        $insertEstudianteStmt->close();
    } else {
        echo "Error al preparar la consulta para actualizar el ID del estudiante: " . $conexion->error;
        exit;
    }

    // Obtener las materias del primer año de esa tecnicatura
    $getMateriasSql = "SELECT id_Materia, AnioCursada FROM materias WHERE IdTec = ?";

    if ($getMateriasStmt = $conexion->prepare($getMateriasSql)) {
        $getMateriasStmt->bind_param("i", $id_tecnicatura);
        $getMateriasStmt->execute();
        $getMateriasStmt->store_result();

        // Comprobar si hay resultados
        if ($getMateriasStmt->num_rows > 0) {
            $getMateriasStmt->bind_result($id_materia, $anio_cursada);

            // Recorrer las materias y asignarlas una por una
            while ($getMateriasStmt->fetch()) {
                // Verificar si la materia es del primer año
                if ($anio_cursada == 'Primero') {
                    // Asignar tipo de cursada Regular con id_Tipocursada 3
                    $id_tipocursada = 3;
                    $observaciones = 'Regular';
                } else {
                    // Para las demás, asignar tipo de cursada No asignado con id_Tipocursada 1
                    $id_tipocursada = 1;
                    $observaciones = 'No asignado';
                }

                // Insertar la materia en la tabla estudiante_materia con el tipo de cursada adecuado
                $insertMateriaSql = "INSERT INTO estudiante_materia (id_estudiante, id_Materia, id_Tipocursada, observaciones) VALUES (?, ?, ?, ?)";

                if ($insertMateriaStmt = $conexion->prepare($insertMateriaSql)) {
                    $insertMateriaStmt->bind_param("iiis", $id_estudiante, $id_materia, $id_tipocursada, $observaciones);
                    if (!$insertMateriaStmt->execute()) {
                        echo "Error al asignar la materia (ID: $id_materia): " . $insertMateriaStmt->error;
                        exit;
                    }
                    $insertMateriaStmt->close();
                } else {
                    echo "Error al preparar la consulta para insertar materia: " . $conexion->error;
                    exit;
                }
            }
        } else {
            echo "No se encontraron materias para la tecnicatura.";
            exit;
        }

        $getMateriasStmt->close();
    } else {
        echo "Error al preparar la consulta para obtener las materias: " . $conexion->error;
        exit;
    }
}

// Redirigir a la página de éxito
echo "<script>
            window.location.href = 'usuarioCreado.php?id_estudiante=" . $id_estudiante . "';
        </script>";
exit;
