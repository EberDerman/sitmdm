function desactivarEstudiante(id_estudiante, idUsuario, nombre, apellido) {
    if (confirm(`¿Desea desactivar al estudiante ${nombre} ${apellido}?`)) {
        $.post('precepEstudiantesDelDB.php', {
            id_estudiante: id_estudiante,
            idUsuario: idUsuario
        })
            .done(function (response) {
                alert(response);
                location.reload();
            })
            .fail(function () {
                alert('Error al quitar un estudiante.');
            });
    }
    return;
}