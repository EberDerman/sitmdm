document.addEventListener('DOMContentLoaded', function () {
    const formulario = document.getElementById('formulario');
    const dniSelect = document.getElementById('dniSelect');
    const dniFields = document.querySelector('.dni');
    const dniNoFields = document.querySelector('.dniNo');
    const lugarNacimientoSelect = document.getElementById('pais_select');
    const extranjeroFields = document.querySelector('.exterior');
    const argentinaFields = document.querySelector('.argentina');
    const inputEspecificarPais = document.querySelector('input[name="especificar_pais"]');
    const emailField = formulario.querySelector('input[type="email"]');

    // Inicializar campos ocultos
    dniFields.style.display = 'none';
    dniNoFields.style.display = 'none';
    extranjeroFields.style.display = 'none';
    argentinaFields.style.display = 'none';

    // Función para verificar si un campo contiene solo espacios en blanco
    function isFieldEmptyOrSpaces(field) {
        return field.value.trim() === ''; // Elimina los espacios en blanco y verifica si está vacío
    }

    // Función para validar email con una expresión regular
    function isValidEmail(email) {
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
        return emailRegex.test(email.value.trim());
    }

    // Evento change para el select dniSelect
    dniSelect.addEventListener('change', function () {
        const selectedOption = parseInt(dniSelect.value);

        // Mostrar u ocultar campos según la opción seleccionada
        dniFields.style.display = (selectedOption === 1 || selectedOption === 2 || selectedOption === 3) ? 'block' : 'none';
        dniNoFields.style.display = (selectedOption === 4) ? 'block' : 'none';

        // Establecer atributos required según la opción seleccionada
        const dniInputs = dniFields.querySelectorAll('input');
        const dniNoInputs = dniNoFields.querySelectorAll('input');

        if (selectedOption === 1 || selectedOption === 2 || selectedOption === 3) {
            dniInputs.forEach(input => input.setAttribute('required', true));
            dniNoInputs.forEach(input => input.removeAttribute('required'));
        } else if (selectedOption === 4) {
            dniInputs.forEach(input => input.removeAttribute('required'));
            dniNoInputs.forEach(input => input.setAttribute('required', true));
        } else {
            dniInputs.forEach(input => input.removeAttribute('required'));
            dniNoInputs.forEach(input => input.removeAttribute('required'));
        }

        // Limpiar campos cuando cambia la opción
        clearInputFields(dniFields);
        clearInputFields(dniNoFields);
    });

    // Evento change para el select lugarNacimientoSelect
    lugarNacimientoSelect.addEventListener('change', function () {
        const selectedOption = parseInt(lugarNacimientoSelect.value);

        // Mostrar u ocultar campos según la opción seleccionada
        if (selectedOption === 1) { // Argentina seleccionada
            extranjeroFields.style.display = 'none';
            argentinaFields.style.display = 'block';
            inputEspecificarPais.required = false;

            // Quitar atributos required para campos de Argentina
            const argentinaInputs = argentinaFields.querySelectorAll('input, select');
            argentinaInputs.forEach(input => {
                input.removeAttribute('required'); // Eliminar requerimiento para los campos de Argentina
            });

            // Quitar atributos required para campos de Extranjero
            const extranjeroInputs = extranjeroFields.querySelectorAll('input');
            extranjeroInputs.forEach(input => input.removeAttribute('required'));
        } else if (selectedOption === 2) { // En el extranjero seleccionado
            extranjeroFields.style.display = 'block';
            argentinaFields.style.display = 'none';
            inputEspecificarPais.required = true;

            // Establecer atributos required para campos de Extranjero
            const extranjeroInputs = extranjeroFields.querySelectorAll('input');
            extranjeroInputs.forEach(input => input.setAttribute('required', true));

            // Quitar atributos required para campos de Argentina
            const argentinaInputs = argentinaFields.querySelectorAll('input, select');
            argentinaInputs.forEach(input => input.removeAttribute('required'));
        } else { // Ninguna opción seleccionada
            extranjeroFields.style.display = 'none';
            argentinaFields.style.display = 'none';
            inputEspecificarPais.required = false;

            clearInputFields(extranjeroFields);
            clearInputFields(argentinaFields);
        }
    });

    // Función para limpiar los campos de un contenedor dado
    function clearInputFields(container) {
        const fields = container.querySelectorAll('input[type="text"], input[type="number"], input[type="radio"], input[type="tel"], input[type="email"]');
        fields.forEach(field => {
            if (field.type === 'radio' && field.checked) {
                field.checked = false;
            } else {
                field.value = '';
                field.classList.remove('is-invalid', 'is-valid');
                const feedback = field.parentNode.querySelector('.invalid-feedback');
                if (feedback) {
                    feedback.textContent = '';
                }
            }
        });
    }

    // Validar el formulario antes de enviar
    formulario.addEventListener('submit', function (event) {
        const invalidFields = formulario.querySelectorAll('input:invalid, select:invalid');
        const allFields = formulario.querySelectorAll('input[type="text"], input[type="email"], input[type="tel"], input[type="number"]');

        // Validar si los campos contienen solo espacios en blanco
        allFields.forEach(field => {
            if (isFieldEmptyOrSpaces(field)) {
                field.classList.add('is-invalid');
                invalidFields.push(field); // Añadir el campo a la lista de inválidos si contiene solo espacios
            }
        });

        // Validar el email
        if (!isValidEmail(emailField)) {
            emailField.classList.add('is-invalid');
            invalidFields.push(emailField); // Añadir a los campos inválidos si el email no es válido
        }

        invalidFields.forEach(field => {
            field.classList.add('is-invalid');
        });

        const validFields = formulario.querySelectorAll('input:valid, select:valid');
        validFields.forEach(field => {
            field.classList.remove('is-invalid');
            field.classList.add('is-valid');
        });

        if (invalidFields.length > 0) {
            event.preventDefault();
            event.stopPropagation();
        }
    });

    // Eliminar la clase is-invalid cuando el usuario cambia el valor del campo y verificar espacios
    formulario.addEventListener('input', function (event) {
        const target = event.target;

        if (target.type === 'email') {
            if (isValidEmail(target)) {
                target.classList.remove('is-invalid');
                target.classList.add('is-valid');
            } else {
                target.classList.remove('is-valid');
                target.classList.add('is-invalid');
            }
        } else if (!isFieldEmptyOrSpaces(target) && target.checkValidity()) {
            target.classList.remove('is-invalid');
            target.classList.add('is-valid');
        } else {
            target.classList.remove('is-valid');
            target.classList.add('is-invalid');
        }
    });
});
