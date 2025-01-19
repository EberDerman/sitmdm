<?php
include("../includes/sesion.php");

$id_director = getIdUsuarioSeguridad();
checkAccess([3], $id_director);




include ('../sql/conexion.php');

// Crear conexión
$conn = new mysqli($servername, $username, $password, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar si se ha enviado el ID del registro
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Verificar si se ha confirmado la eliminación
    if (isset($_GET['confirm']) && $_GET['confirm'] == 'true') {
        // Preparar y ejecutar la consulta de eliminación
        $stmt = $conn->prepare("DELETE FROM tecnicaturas WHERE id_Tecnicatura = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "<script>alert('Registro eliminado exitosamente'); window.location.href = 'Doc_tecniNuevas.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Mostrar cuadro de confirmación de eliminación
        echo "<script>
            if (confirm('¿Estás seguro de que quieres eliminar este registro?')) {
                window.location.href = 'doc_tec_eliminar.php?id=" . $id . "&confirm=true';
            } else {
                window.location.href = 'Doc_tecniNuevas.php';
            }
        </script>";
    }
} else {
    echo "ID de registro no especificado.";
}

$conn->close();
?>
