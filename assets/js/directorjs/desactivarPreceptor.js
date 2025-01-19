function desactivarDocente(id_Persona, idUsuario, nombrePrecep, apellidoPrecep) {
    if (confirm(`¿Desea desactivar al preceptor ${nombrePrecep} ${apellidoPrecep}?`)) {
        $.post('direcPrecepDelDB.php', {
            id_Persona: id_Persona,
            idUsuario: idUsuario
        })
            .done(function (response) {
                alert(response);
                window.location.href = `direcPrecep.php`;
            })
            .fail(function () {
                alert('Error al quitar un preceptor.');
            });
    }
    return;
}