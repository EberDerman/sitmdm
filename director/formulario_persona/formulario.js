
$(document).ready(function () {
    $('#fecha_nacimiento').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        autoclose: true
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('nacionalidad').addEventListener('change', function () {
        if (this.value == "Argentino/a") {
            document.getElementById('pais').disabled = true;
        } else {
            document.getElementById('pais').disabled = false;
        }
    });
});
