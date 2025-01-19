<?php
include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

// Incluir el archivo de conexión
include ('../sql/conexion.php');

// Verificar si la conexión se ha realizado correctamente
if (!$conexiones) {
    /* echo "Conexión exitosa a la base de datos";
} else { */
    die("Fallo la conexion a la base de datos");
}

// Obtener ID de estudiante y Tecnicatura desde la URL
$id_estudiante = $_GET['id_estudiante'] ?? '';  
$id_Tecnicatura = $_GET['id_Tecnicatura'] ?? ''; 

// Obtener los datos del formulario

$apellido = $_POST['apellido'] ?? NULL;
$nombre = $_POST['nombre'] ?? NULL;
$telefono = $_POST['telefono'] ?? NULL;
$email = $_POST['email'] ?? NULL;
$poseeDni = $_POST['posee_dni'] ?? NULL;
$dniNumero = $_POST['dni_numero'] ?? NULL;
$cuil = $_POST['cuil'] ?? NULL;
$tieneCpi = $_POST['tiene_cpi'] ?? 'SI';
$documentoExtranjero = $_POST['documento_extranjero'] ?? 'NO';
$tipoDocumentoExtranjero = $_POST['tipo_documento_extranjero'] ?? NULL;
$numeroDocumentoExtranjero = $_POST['numero_documento_extranjero'] ?? NULL;
$identidadGenero = $_POST['identidad_genero'] ?? NULL;
$lugarNacimiento = $_POST['lugar_nacimiento'] ?? NULL;
$especificarPais = $_POST['especificar_pais'] ?? NULL;
$provincia = $_POST['provincia'] ?? NULL;
$ciudad = $_POST['ciudad'] ?? NULL;
$distrito = $_POST['distrito'] ?? NULL;
$localidad = $_POST['localidad'] ?? NULL;
$codigoPostal = $_POST['codigo_postal'] ?? NULL;
$calle = $_POST['calle'] ?? NULL;
$numero = $_POST['numero'] ?? NULL;
$piso = $_POST['piso'] ?? NULL;
$torre = $_POST['torre'] ?? NULL;
$departamento = $_POST['departamento'] ?? NULL;

$estado = $_POST['Estado'] ?? 1;

// Construir la consulta SQL
$query = "UPDATE estudiantes SET
    
    apellido = :apellido,
    nombre = :nombre,
    telefono = :telefono,
    email = :email,
    posee_dni = :poseeDni,
    dni_numero = :dniNumero,
    cuil = :cuil,
    tiene_cpi = :tieneCpi,
    documento_extranjero = :documentoExtranjero,
    tipo_documento_extranjero = :tipoDocumentoExtranjero,
    numero_documento_extranjero = :numeroDocumentoExtranjero,
    identidad_genero = :identidadGenero,
    lugar_nacimiento = :lugarNacimiento,
    especificar_pais = :especificarPais,
    provincia = :provincia,
    ciudad = :ciudad,
    localidad = :localidad,
    distrito = :distrito,
    codigo_postal = :codigoPostal,
    calle = :calle,
    numero = :numero,
    piso = :piso,
    torre = :torre,
    departamento = :departamento,
   
    Estado = :estado
WHERE id_estudiante = :id_estudiante";

// Preparar la declaración
$stmt = $conexiones->prepare($query);

// Vincular los parámetros

$stmt->bindParam(':apellido', $apellido);
$stmt->bindParam(':nombre', $nombre);
$stmt->bindParam(':telefono', $telefono);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':poseeDni', $poseeDni);
$stmt->bindParam(':dniNumero', $dniNumero);
$stmt->bindParam(':cuil', $cuil);
$stmt->bindParam(':tieneCpi', $tieneCpi);
$stmt->bindParam(':documentoExtranjero', $documentoExtranjero);
$stmt->bindParam(':tipoDocumentoExtranjero', $tipoDocumentoExtranjero);
$stmt->bindParam(':numeroDocumentoExtranjero', $numeroDocumentoExtranjero);
$stmt->bindParam(':identidadGenero', $identidadGenero);
$stmt->bindParam(':lugarNacimiento', $lugarNacimiento);
$stmt->bindParam(':especificarPais', $especificarPais);
$stmt->bindParam(':provincia', $provincia);
$stmt->bindParam(':ciudad', $ciudad);
$stmt->bindParam(':localidad', $localidad);
$stmt->bindParam(':distrito', $distrito);
$stmt->bindParam(':codigoPostal', $codigoPostal);
$stmt->bindParam(':codigoPostal', $codigoPostal);
$stmt->bindParam(':calle', $calle);
$stmt->bindParam(':numero', $numero);
$stmt->bindParam(':piso', $piso);
$stmt->bindParam(':torre', $torre);
$stmt->bindParam(':departamento', $departamento);

$stmt->bindParam(':estado', $estado, PDO::PARAM_INT);
$stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);

// Ejecutar la consulta
if ($stmt->execute()) {
    $urlRedirigir = "precepEntregaPlanilla.php?id_estudiante=" . urlencode($id_estudiante) . "&id_Tecnicatura=" . urlencode($id_Tecnicatura);
    header("Location: " . $urlRedirigir);
    exit();
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Error al actualizar los datos: " . $errorInfo[2];
}

?>
