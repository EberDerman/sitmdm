function habilitarUsuario(id_Persona, idUsuario, nombreDoc, apellidoDoc) {
    if (confirm(`¿Desea habilitar a ${nombreDoc} ${apellidoDoc}?`)) {
        $.post('direcDesactivadosDB.php', {
            id_Persona: id_Persona,
            idUsuario: idUsuario
        })
            .done(function (response) {
                alert(response);
                location.reload();
            })
            .fail(function () {
                alert('Error al habilitar un docente.');
            });
    }
    return;
}