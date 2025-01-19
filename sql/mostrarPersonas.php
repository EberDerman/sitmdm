<?php
// Verificar si el ID de la persona está presente en la URL
if (isset($_GET["id_Persona"])) {
  $id_Persona = $_GET['id_Persona'];
} else {
  echo "<script>alert('No se encontró el ID de la persona.');</script>";
  exit;
}

try {
  $stmt = $conexiones->prepare("SELECT * FROM personas p WHERE p.id_Persona = :id_Persona");
  $stmt->bindParam(':id_Persona', $id_Persona, PDO::PARAM_INT);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);

  if ($row) {
      $nombre = $row['nombre'] ?? null;
      $apellido = $row['apellido'] ?? null;
      $email = $row['email'] ?? null;
      $codRol = $row['codRol'] ?? null;
      $dni = $row['dni'] ?? null;
      $cuil = $row['cuil'] ?? null;
      $fecha_nacimiento = $row['fecha_nacimiento'] ?? null;
      $nacionalidad = $row['nacionalidad'] ?? null;
      $estado_civil = $row['estado_civil'] ?? null;
      $domicilio = $row['domicilio'] ?? null;
      $pais = $row['pais'] ?? null;
      $telefono_1 = $row['telefono_1'] ?? null;
      $telefono_2 = $row['telefono_2'] ?? null;
      $titulo = $row['titulo'] ?? null;
      $estado = $row['estado'] ?? null;
  } else {
      // Si no se encuentra la persona
      echo "<script>alert('Persona no encontrada.');</script>";
      exit; // Salir si no se encuentra el ID
  }

} catch (PDOException $e) {
  // Manejo de error de la base de datos
  echo 'Error de conexión: ' . $e->getMessage();
  exit;
}
