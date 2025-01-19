<?php
include("./utils/constantes.php");
?>

<div class="container mt-5">
    <div class="card text-center">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3 mb-4" style="border-radius: 8px;">
            <h4 class="mb-0"><i class="fas fa-user"></i> Datos Personales</h4>
            <div>
                <button class="btn btn-primary" onclick="window.history.back()">VOLVER</button>
            </div>
        </div>

        <!-- Card Body with the form, keeping the original structure -->
        <div class="card-body">
            <form id="formulario" method="post" action="direcFormPersonaGuardar.php">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="apellido" class="form-label">* Apellido/s:</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo $apellido; ?>" disabled required pattern="[A-Za-z\s]+" title="Solo letras y espacios">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="nombre" class="form-label">* Nombre/s:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $nombre; ?>" disabled required pattern="[A-Za-z\s]+" title="Solo letras y espacios">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="Rol" class="form-label">* Rol:</label>
                            <input type="tel" class="form-control" id="Rol" name="Rol" value="<?php echo constantes::obtenerNombreRol($codRol); ?>" disabled required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="celular" class="form-label">* Celular:</label>
                            <input type="tel" class="form-control" id="celular" name="celular" value="<?php echo $telefono_1; ?>" disabled required title="Debe contener exactamente 10 dígitos numéricos">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="telefono" class="form-label">Teléfono fijo:</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" value="<?php echo $telefono_2; ?>" disabled title="Debe contener exactamente 10 dígitos numéricos">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="fecha_nacimiento" class="form-label">* Fecha de nacimiento:</label>
                            <input type="text" id="fecha_nacimiento" class="form-control" name="fecha_nacimiento" value="<?php echo $fecha_nacimiento; ?>" disabled required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="dni" class="form-label">* Número de DNI:</label>
                            <input id="dni" type="text" class="form-control" name="dni" value="<?php echo $dni; ?>" disabled required pattern="[0-9]{8}">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="cuil" class="form-label">CUIT/CUIL:</label>
                            <input id="cuil" type="tel" class="form-control" name="cuil" value="<?php echo $cuil; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="Estado_civil" class="form-label">Estado Civil:</label>
                            <input id="Estado_civil" type="text" class="form-control" name="Estado_civil" value="<?php echo $estado_civil; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="email" class="form-label">* Email:</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" disabled required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="nacionalidad" class="form-label">* Nacionalidad:</label>
                            <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" value="<?php echo $nacionalidad; ?>" disabled required>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="domicilio" class="form-label">* Domicilio / Localidad:</label>
                            <input type="text" class="form-control" id="domicilio" name="domicilio" value="<?php echo $domicilio; ?>" disabled required title="Solo letras y espacios">
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="pais" class="form-label">Extranjeros, especificar país:</label>
                            <input type="text" class="form-control" id="pais" name="pais" value="<?php echo $nacionalidad; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="md-form">
                            <label for="titulo" class="form-label">* Título:</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" value="<?php echo $titulo; ?>" disabled required>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
