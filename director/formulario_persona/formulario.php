<div class="container mt-5">
  <div class="container card text-center">
    <div class="card-body">
      <form id="formulario" method="post" action="direcFormPersonaGuardar.php">
        <div class="form-header bg-primary text-white text-center py-3 mb-4">
          <h3 class="font-weight-200"><i class="fas fa-user"></i> Crear nuevo usuario <span id="fechaTitulo"></span>
          </h3>
        </div>
        <div class="row">
          <div class="col-md-4 mb-3">
            <div class="md-form">
              <label for="apellido" class="form-label">* Apellido/s:</label>
              <input type="text" class="form-control" id="apellido" name="apellido" required 
                title="Solo letras, espacios, y caracteres especiales" pattern="[A-Za-zÀ-ÿ\s'-]+">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="md-form">
              <label for="nombre" class="form-label">* Nombre/s:</label>
              <input type="text" class="form-control" id="nombre" name="nombre" required 
                title="Solo letras, espacios, y caracteres especiales" pattern="[A-Za-zÀ-ÿ\s'-]+">
            </div>
          </div>
          <div class="col-md-4">
            <div class="md-form">
              <select id="rol" class="mdb-select md-form" name="rol" required>
                <option value="" disabled selected>* Seleccionar Rol a cargar</option>
                <option value="Docente">Docente</option>
                <option value="Preceptor">Preceptor</option>
              </select>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="md-form">
              <label for="celular" class="form-label">* Celular:</label>
              <input type="tel" class="form-control" id="celular" name="celular" required 
                title="Introduzca un número de celular válido">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="md-form">
              <label for="telefono" class="form-label">Teléfono fijo:</label>
              <input type="tel" class="form-control" id="telefono" name="telefono" 
                title="Introduzca un número de teléfono válido">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="md-form">
              <label for="fecha_nacimiento" class="form-label">* Fecha de nacimiento:</label>
              <input type="text" id="fecha_nacimiento" class="form-control" name="fecha_nacimiento" required>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="md-form">
              <label for="dni" class="form-label">* Número de DNI:</label>
              <input id="dni" type="text" class="form-control" name="dni" required 
       title="El DNI debe ser numérico y tener entre 7 y 10 dígitos" 
       pattern="\d{7,10}" maxlength="10" oninput="this.value = this.value.replace(/\D/g, '')">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="md-form">
              <label for="cuil" class="form-label">CUIT/CUIL:</label>
              <input id="cuil" type="text" class="form-control" name="cuil" maxlength="13" pattern="\d*" title="Ingrese solo números" oninput="this.value = this.value.replace(/\D/g, '')">
              </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="md-form">
              <select id="estado_civil" class="mdb-select md-form" name="estado_civil">
                <option value="" disabled selected>Seleccionar Estado Civil</option>
                <option value="Soltero">Soltero</option>
                <option value="Casado">Casado</option>
                <option value="Viudo">Viudo</option>
                <option value="Divorciado">Divorciado</option>
              </select>
            </div>
          </div>
          <div class="col-md-8 mb-3">
            <div class="md-form">
              <label for="email" class="form-label">* Email:</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="md-form">
              <select id="nacionalidad" class="mdb-select md-form" name="nacionalidad" required>
                <option value="" disabled selected>* Seleccionar nacionalidad</option>
                <option value="Argentino/a">Argentino/a</option>
                <option value="Extranjero">Extranjero</option>
              </select>
            </div>
          </div>
          <div class="col-md-8 mb-3">
            <div class="md-form">
              <label for="domicilio" class="form-label">* Domicilio Y Localidad:</label>
              <input type="text" class="form-control" id="domicilio" name="domicilio" required
                title="Introduce el domicilio completo">
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="md-form">
              <label for="pais" class="form-label">Extranjeros, especificar país:</label>
              <input type="text" class="form-control" id="pais" name="pais" disabled>
            </div>
          </div>
          <div class="col-md-12 mb-3">
            <div class="md-form">
              <label for="titulo" class="form-label">* Título:</label>
              <input type="text" class="form-control" id="titulo" name="titulo" maxlength="150" required>
              </div>
          </div>
        </div>
        <button class="btn btn-primary-outlined" onclick="window.location.href='inicioDirec.php'">VOLVER</button>
        <button type="submit" class="btn btn-primary">ENVIAR</button>
      </form>
    </div>
  </div>
</div>