function habilitarUsuario(id_estudiante, idUsuario, nombre, apellido) {
    if (confirm(`¿Desea habilitar a ${nombre} ${apellido}?`)) {
        $.post('precepEstudiantesHabilitar.php', {
            id_estudiante: id_estudiante,
            idUsuario: idUsuario
        })
            .done(function (response) {
                alert(response);
                location.reload();
            })
            .fail(function () {
                alert('Error al habilitar un estudiante.');
            });
    }
    return;
}