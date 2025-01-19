function reiniciarPassword(id_Persona, idUsuario, nombre, apellido) {
    if (confirm(`¿Desea reiniciar la contraseña a ${nombre} ${apellido}?`)) {
        $.post('direcResetPasswordDB.php', {
            id_Persona: id_Persona,
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