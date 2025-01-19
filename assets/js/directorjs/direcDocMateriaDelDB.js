function quitarMateriaAsignada(iddocentesmaterias,idDoc, materia, tecnicatura, nombreDoc, apellidoDoc) {
    if (confirm(`¿Desea quitar la materia ${materia} de la carrera ${tecnicatura} al docente ${nombreDoc} ${apellidoDoc}?`)) {
        $.post('direcDocMateriaDelDB.php', {
            iddocentesmaterias: iddocentesmaterias
        })
            .done(function (response) {
                alert(response);
                window.location.href = `direcDocMateria.php?idDoc=${idDoc}&nombreDoc=${nombreDoc}&apellidoDoc=${apellidoDoc}`;
            })
            .fail(function () {
                alert('Error al quitar la materia.');
            });
    }
    return;
}