function desactivarDocente(id_Persona, idUsuario, nombreDoc, apellidoDoc) {
    if (confirm(`¿Desea desactivar al docente ${nombreDoc} ${apellidoDoc}?`)) {
        $.post('direcDocDelDB.php', {
            id_Persona: id_Persona,
            idUsuario: idUsuario
        })
            .done(function (response) {
                alert(response);
                window.location.href = `direcDoc.php`;
            })
            .fail(function () {
                alert('Error al quitar un docente.');
            });
    }
    return;
}