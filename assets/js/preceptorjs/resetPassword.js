function reiniciarPassword(id_estudiante, idUsuario, nombre, apellido) {
    console.log("", id_estudiante, idUsuario)
    if (confirm(`¿Desea reiniciar la contraseña a ${nombre} ${apellido}?`)) {
        $.post('precepResetPasswordDB.php', {
            id_estudiante: id_estudiante,
            idUsuario: idUsuario
        })
            .done(function (response) {
                alert(response);
                location.reload();
            })
            .fail(function () {
                alert('Error al reiniciar la contraseña.');
            });
    }
    return;
}