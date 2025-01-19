<?php

include("../includes/sesion.php");

$id_preceptor = getIdUsuarioSeguridad();
checkAccess([4], $id_preceptor);

include("../sql/EstudiantesRepository.php");

if (isset($_GET["id_estudiante"])) {
  $estudiantesRepository = new EstudiantesRepository();
  $estudiante = $estudiantesRepository->getEstudianteById($_GET["id_estudiante"]);
  $estudiante_tecnicatura = $estudiantesRepository->getEstudianteTecnicaturaById($_GET["id_estudiante"]);
}
?>







<!DOCTYPE html>
<html lang="es">

<head>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="formulario.css"> -->

  <style>
    .form-header {
      background-color: #007bff;
      color: white;
      padding: 20px;
      text-align: center;
      margin-bottom: 20px;
    }

    .form-header h3,
    .form-header h4 {
      margin: 0;
    }
  </style>
</head>

<body class="hidden-sn mdb-skin">
  <div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <form id="formulario" method="post" action="precepEstudiantesEditarDB.php">

          <div class="d-flex justify-content-between align-items-center">
            <div class="text-center p-33 rounded-1">
              <h4 class="font-weight-200"><i class="fas fa-user"></i> Editar a <?= $estudiante['nombre'] ?>
                <?= $estudiante['apellido'] ?><span id="fechaTitulo"></span></h4>
            </div>
            <a class="btn btn-secondary"
              href='precepEstudiantesVer.php?id_estudiante=<?= $_GET["id_estudiante"] ?>&id_Tecnicatura=<?= $_GET["id_Tecnicatura"] ?>&nombreTec=<?= $_GET["nombreTec"] ?>&Ciclo=<?= $_GET["Ciclo"] ?>'>
              VOLVER
            </a>
          </div>
          

          <section>
              <div class=" mb-3">
              <section>
                <h4 class="mb-3">DATOS ESTUDIANTE</h4>
                <div class="row">
                  <div class="col-md-6 mb-3">
                    <!-- Campo oculto para enviar el id del estudiante -->
                    <input type="hidden" name="id_estudiante" value="<?php echo $estudiante['id_estudiante']; ?>">
                    <input type="hidden" name="id_Tecnicatura" value="<?php echo $_GET['id_Tecnicatura']; ?>">
                    <input type="hidden" name="nombreTec" value="<?php echo $_GET['nombreTec']; ?>">
                    <input type="hidden" name="Ciclo" value="<?php echo $_GET['Ciclo']; ?>">
                    <label for="apellido" class="form-label">Apellido/s:</label>
                    <input type="text" class="form-control" id="apellido" placeholder="Apellido/s" name="apellido"
                      value="<?= htmlspecialchars($estudiante['apellido']) ?>" required pattern="[A-Za-z\s]+"
                      title="Solo letras y espacios">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="nombre" class="form-label">Nombre/s:</label>
                    <input type="text" class="form-control" id="nombre" placeholder="Nombre/s" name="nombre"
                      value="<?= htmlspecialchars($estudiante['nombre']) ?>" required pattern="[A-Za-z\s]+"
                      title="Solo letras y espacios">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="telefono" class="form-label">Teléfono:</label>
                    <input type="tel" class="form-control" id="telefono" placeholder="Teléfono" name="telefono"
                      value="<?= htmlspecialchars($estudiante['telefono']) ?>" required pattern="[0-9]{10}"
                      title="Debe contener exactamente 10 dígitos numéricos">
                  </div>
                  <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" placeholder="Email" name="email"
                      value="<?= htmlspecialchars($estudiante['email']) ?>" required>
                  </div>
                </div>
              </section>

              <section>
                <h4 class="mb-3">DNI</h4>
                <div class="mb-3">
                  <label for="dniSelect" class="form-label">¿Posee DNI Argentino?</label>
                  <select id="dniSelect" class="form-select" name="posee_dni" required>
                    <option value="" selected disabled>Seleccione una opción</option>
                    <option value="1" <?= ($estudiante['posee_dni'] == 1) ? 'selected' : ''; ?>>Sí, y tengo el DNI físico
                    </option>
                    <option value="2" <?= ($estudiante['posee_dni'] == 2) ? 'selected' : ''; ?>>Sí, pero NO tengo el DNI
                      físico
                      y se encuentra en trámite</option>
                    <option value="3" <?= ($estudiante['posee_dni'] == 3) ? 'selected' : ''; ?>>Sí, pero NO tengo el DNI
                      físico
                      y NO se encuentra en trámite</option>
                    <option value="4" <?= ($estudiante['posee_dni'] == 4) ? 'selected' : ''; ?>>NO posee DNI argentino
                    </option>
                  </select>

                </div>
                <div class="dni">
                  <div class="mb-3">
                    <label for="dniNumber" class="form-label">Indique número de DNI argentino:</label>
                    <input id="dniNumber" type="text" class="form-control" placeholder="********" name="dni_numero"
                      value="<?= htmlspecialchars($estudiante['dni_numero']) ?>" required pattern="[0-9]{8}">
                  </div>
                  <div class="mb-3">
                    <label for="cuilNumber" class="form-label">CUIL:</label>
                    <input id="cuilNumber" type="text" class="form-control" placeholder="***********" name="cuil"
                      value="<?= htmlspecialchars($estudiante['cuil']) ?>" required pattern="[0-9]{11}">
                  </div>
                </div>
                <div class="dniNo">
                  <h5>¿Posee certificado de preinscripción (CPI)?</h5>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" id="cpiSi" value="SI" name="tiene_cpi" required>
                    <label class="form-check-label" for="cpiSi">Sí</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" id="cpiNo" value="NO" name="tiene_cpi">
                    <label class="form-check-label" for="cpiNo">No</label>
                  </div>
                  <h5>¿Posee documento extranjero?</h5>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="docExtSi" value="SI" name="documento_extranjero"
                      required>
                    <label class="form-check-label" for="docExtSi">Sí</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="docExtNo" value="NO" name="documento_extranjero">
                    <label class="form-check-label" for="docExtNo">No</label>
                  </div>
                  <div class="mb-3">
                    <label for="tipo_documento_extranjero" class="form-label">Tipo de documento:</label>
                    <input type="text" class="form-control" id="tipo_documento_extranjero"
                      placeholder="Tipo de documento" name="tipo_documento_extranjero" required pattern="[A-Za-z\s]+">
                  </div>
                  <div class="mb-3">
                    <label for="numero_documento_extranjero" class="form-label">N°:</label>
                    <input type="number" class="form-control" id="numero_documento_extranjero" placeholder="N°"
                      name="numero_documento_extranjero" required>
                  </div>
                </div>
              </section>

              <section>
                <div class="mb-3">
                  <label for="identidadGenero" class="form-label">Identidad de género:</label>
                  <select id="identidadGenero" class="form-select" name="identidad_genero" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="1" <?= ($estudiante['identidad_genero'] == 1) ? 'selected' : ''; ?>>Mujer</option>
                    <option value="2" <?= ($estudiante['identidad_genero'] == 2) ? 'selected' : ''; ?>>Mujer trans /
                      travesti
                    </option>
                    <option value="3" <?= ($estudiante['identidad_genero'] == 3) ? 'selected' : ''; ?>>Varón</option>
                    <option value="4" <?= ($estudiante['identidad_genero'] == 4) ? 'selected' : ''; ?>>Varón trans /
                      masculinidad trans</option>
                    <option value="5" <?= ($estudiante['identidad_genero'] == 5) ? 'selected' : ''; ?>>No binario
                    </option>
                    <option value="6" <?= ($estudiante['identidad_genero'] == 6) ? 'selected' : ''; ?>>Otro</option>
                    <option value="7" <?= ($estudiante['identidad_genero'] == 7) ? 'selected' : ''; ?>>No desea responder
                    </option>
                  </select>

                </div>
              </section>

              <section>
                <div class="mb-3">
                  <label for="pais_select" class="form-label">Lugar de nacimiento:</label>
                  <select id="pais_select" class="form-select" name="lugar_nacimiento" required>
                    <option value="" disabled selected>Seleccione una opción</option>
                    <option value="1" <?= ($estudiante['lugar_nacimiento'] == 1) ? 'selected' : ''; ?>>Argentina</option>
                    <option value="2" <?= ($estudiante['lugar_nacimiento'] == 2) ? 'selected' : ''; ?>>En el extranjero
                    </option>
                  </select>

                </div>
                <div class="exterior">
                  <div class="mb-3">
                    <label for="especificar_pais" class="form-label">Especificar país:</label>
                    <input type="text" class="form-control" id="especificar_pais" placeholder="Especificar país"
                      name="especificar_pais" required pattern="[A-Za-z\s]+">
                  </div>
                </div>
                <div class="argentina">
                  <div class="mb-3">
                    <label for="provincia" class="form-label">Provincia</label>
                    <select class="form-select" id="provincia" name="provincia" required>
                      <option value="" disabled selected>Selecciona una provincia</option>
                      <option value="Buenos Aires" <?= ($estudiante['provincia'] == "Buenos Aires") ? 'selected' : ''; ?>>
                        Buenos Aires</option>
                      <option value="Catamarca" <?= ($estudiante['provincia'] == "Catamarca") ? 'selected' : ''; ?>>
                        Catamarca</option>
                      <option value="Chaco" <?= ($estudiante['provincia'] == "Chaco") ? 'selected' : ''; ?>>Chaco
                      </option>
                      <option value="Chubut" <?= ($estudiante['provincia'] == "Chubut") ? 'selected' : ''; ?>>Chubut
                      </option>
                      <option value="Córdoba" <?= ($estudiante['provincia'] == "Córdoba") ? 'selected' : ''; ?>>Córdoba
                      </option>
                      <option value="Corrientes" <?= ($estudiante['provincia'] == "Corrientes") ? 'selected' : ''; ?>>
                        Corrientes</option>
                      <option value="Entre Ríos" <?= ($estudiante['provincia'] == "Entre Ríos") ? 'selected' : ''; ?>>
                        Entre
                        Ríos</option>
                      <option value="Formosa" <?= ($estudiante['provincia'] == "Formosa") ? 'selected' : ''; ?>>Formosa
                      </option>
                      <option value="Jujuy" <?= ($estudiante['provincia'] == "Jujuy") ? 'selected' : ''; ?>>Jujuy
                      </option>
                      <option value="La Pampa" <?= ($estudiante['provincia'] == "La Pampa") ? 'selected' : ''; ?>>La
                        Pampa
                      </option>
                      <option value="La Rioja" <?= ($estudiante['provincia'] == "La Rioja") ? 'selected' : ''; ?>>La
                        Rioja
                      </option>
                      <option value="Mendoza" <?= ($estudiante['provincia'] == "Mendoza") ? 'selected' : ''; ?>>Mendoza
                      </option>
                      <option value="Misiones" <?= ($estudiante['provincia'] == "Misiones") ? 'selected' : ''; ?>>
                        Misiones
                      </option>
                      <option value="Neuquén" <?= ($estudiante['provincia'] == "Neuquén") ? 'selected' : ''; ?>>Neuquén
                      </option>
                      <option value="Río Negro" <?= ($estudiante['provincia'] == "Río Negro") ? 'selected' : ''; ?>>Río
                        Negro</option>
                      <option value="Salta" <?= ($estudiante['provincia'] == "Salta") ? 'selected' : ''; ?>>Salta
                      </option>
                      <option value="San Juan" <?= ($estudiante['provincia'] == "San Juan") ? 'selected' : ''; ?>>San
                        Juan
                      </option>
                      <option value="San Luis" <?= ($estudiante['provincia'] == "San Luis") ? 'selected' : ''; ?>>San
                        Luis
                      </option>
                      <option value="Santa Cruz" <?= ($estudiante['provincia'] == "Santa Cruz") ? 'selected' : ''; ?>>
                        Santa
                        Cruz</option>
                      <option value="Santa Fe" <?= ($estudiante['provincia'] == "Santa Fe") ? 'selected' : ''; ?>>Santa
                        Fe
                      </option>
                      <option value="Santiago del Estero" <?= ($estudiante['provincia'] == "Santiago del Estero") ? 'selected' : ''; ?>>Santiago del Estero</option>
                      <option value="Tierra del Fuego" <?= ($estudiante['provincia'] == "Tierra del Fuego") ? 'selected' : ''; ?>>
                        Tierra del Fuego</option>
                      <option value="Tucumán" <?= ($estudiante['provincia'] == "Tucumán") ? 'selected' : ''; ?>>Tucumán
                      </option>
                    </select>
                  </div>
                  <div class="mb-3">
                    <label for="ciudad" class="form-label">Ciudad:</label>
                    <input type="text" class="form-control" id="localidad" placeholder="Ciudad" name="ciudad"
                      value="<?= htmlspecialchars($estudiante['ciudad']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="localidad" class="form-label">Localidad:</label>
                    <input type="text" class="form-control" id="localidad" placeholder="Localidad" name="localidad"
                      value="<?= htmlspecialchars($estudiante['localidad']) ?>" required>
                  </div>
                  <div class="bsas">
                    <label for="distrito" class="form-label">Distrito:</label>
                    <input type="text" class="form-control" id="distrito" placeholder="Distrito" name="distrito"
                      value="<?= htmlspecialchars($estudiante['distrito']) ?>" required>
                  </div>
                  <div class="bsas">
                    <label for="codigo_postal" class="form-label">Codigo Postal:</label>
                    <input type="text" class="form-control" id="codigo_postal" placeholder="Codigo Postal"
                      name="codigo_postal" value="<?= htmlspecialchars($estudiante['codigo_postal']) ?>" required
                      pattern="[0-9]+">
                  </div>
                  <div class="mb-3">
                    <label for="calle" class="form-label">Calle:</label>
                    <input type="text" class="form-control" id="calle" placeholder="Calle" name="calle"
                      value="<?= htmlspecialchars($estudiante['calle']) ?>" required>
                  </div>
                  <div class="mb-3">
                    <label for="numero" class="form-label">Número:</label>
                    <input type="text" class="form-control" id="numero" placeholder="Número" name="numero"
                      value="<?= htmlspecialchars($estudiante['numero']) ?>" required pattern="[0-9]+"
                      title="Solo números">
                  </div>
                  <div class="mb-3">
                    <label for="piso" class="form-label">Piso:</label>
                    <input type="text" class="form-control" id="piso" placeholder="Piso" name="piso"
                      value="<?= htmlspecialchars($estudiante['piso']) ?>">
                  </div>
                  <div class="mb-3">
                    <label for="torre" class="form-label">Torre:</label>
                    <input type="text" class="form-control" id="torre" placeholder="Torre" name="torre"
                      value="<?= htmlspecialchars($estudiante['torre']) ?>">
                  </div>
                  <div class="mb-3">
                    <label for="departamento" class="form-label">Departamento:</label>
                    <input type="text" class="form-control" id="departamento" placeholder="Departamento"
                      value="<?= htmlspecialchars($estudiante['departamento']) ?>" name="departamento">
                  </div>
                </div>
              </section>

              <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
      </div>
    </div>
  </div>

  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRu0HQkmXNmHXud6VJUhgbgDUGb5gbdcfQ/ghvgn4"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-kQTf9pDbFLpr8xoT9WlEuQjTA3wT/4a5oDhz6kktLcbRHuoPBHVj12yow5j7R8u0"
    crossorigin="anonymous"></script>
  <!--<script src="formulario.js"></script>-->

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const dniSelect = document.getElementById("dniSelect");
      const paisSelect = document.getElementById("pais_select");
      const dniFields = document.querySelectorAll(".dni");
      const dniNoFields = document.querySelectorAll(".dniNo");
      const especificarPaisField = document.getElementById("especificar_pais");
      const argentinaFields = document.querySelector(".argentina");
      const exteriorFields = document.querySelector(".exterior");

      function toggleFields() {
        // Toggle DNI fields based on dniSelect value
        if (dniSelect.value === "1" || dniSelect.value === "2" || dniSelect.value === "3") {
          dniFields.forEach(field => {
            field.style.display = "block";
            field.querySelectorAll("input").forEach(input => input.required = true);
          });
          dniNoFields.forEach(field => {
            field.style.display = "none";
            field.querySelectorAll("input").forEach(input => input.required = false);
          });
        } else if (dniSelect.value === "4") {
          dniFields.forEach(field => {
            field.style.display = "none";
            field.querySelectorAll("input").forEach(input => input.required = false);
          });
          dniNoFields.forEach(field => {
            field.style.display = "block";
            field.querySelectorAll("input").forEach(input => input.required = true);
          });
        } else {
          dniFields.forEach(field => {
            field.style.display = "none";
            field.querySelectorAll("input").forEach(input => input.required = false);
          });
          dniNoFields.forEach(field => {
            field.style.display = "none";
            field.querySelectorAll("input").forEach(input => input.required = false);
          });
        }

        // Toggle country fields based on paisSelect value
        if (paisSelect.value === "1") { // Argentina
          argentinaFields.style.display = "block";
          exteriorFields.style.display = "none";
          especificarPaisField.required = false;
          argentinaFields.querySelectorAll("input, select").forEach(input => input.required = true);
        } else if (paisSelect.value === "2") { // Extranjero
          argentinaFields.style.display = "none";
          exteriorFields.style.display = "block";
          especificarPaisField.required = true;
          argentinaFields.querySelectorAll("input, select").forEach(input => input.required = false);
        } else { // Ninguna selección
          argentinaFields.style.display = "none";
          exteriorFields.style.display = "none";
          especificarPaisField.required = false;
          argentinaFields.querySelectorAll("input, select").forEach(input => input.required = false);
        }
      }

      // Event listeners
      dniSelect.addEventListener("change", toggleFields);
      paisSelect.addEventListener("change", toggleFields);

      // Initial toggle on load
      toggleFields();
    });
  </script>

</body>

</html>