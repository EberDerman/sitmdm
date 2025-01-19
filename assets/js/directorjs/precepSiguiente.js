        // Obtener el año actual
        const currentYear = new Date().getFullYear();

        // Obtener el elemento <select>
        const yearSelect = document.getElementById("year");

        // Llenar el <select> con los años desde 2000 hasta el año actual
        for (let year = currentYear - 1; year - 1 <= currentYear; year++) {
            let option = document.createElement("option");
            option.value = year;
            option.textContent = year;
            yearSelect.appendChild(option);
        }
        yearSelect.value = currentYear;

        // Función para hacer una solicitud AJAX al servidor para obtener las materias de un año específico
        function getMateriasPorAnio(anio) {
            fetch(`precepSiguienteAjax.php?anio=${anio}`)
                .then(response => response.json())
                .then(data => {
                    // Limpiar las filas de la tabla antes de llenarlas
                    const materiasList = document.getElementById('materias-list');
                    materiasList.innerHTML = '';

                    // Llenar la tabla con los datos recibidos
                    data.forEach(row => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td>${row.nombreTec}</td>
                            <td>${row.Ciclo}</td>
                            <td>${row.Materia}</td>
                            <td>${row.AnioCursada} (${row.AnioCursadaCiclo})</td>
                        `;
                        materiasList.appendChild(tr);
                    });
                })
                .catch(error => {
                    console.error("Error al cargar las materias: ", error);
                });
        }

        // Evento cuando el usuario selecciona un año
        yearSelect.addEventListener('change', (e) => {
            const selectedYear = e.target.value;
            getMateriasPorAnio(selectedYear);
        });

        // Llamada inicial para cargar las materias por defecto (si se desea cargar un valor inicial)
        getMateriasPorAnio(currentYear);

        // Activar los tooltips para todos los elementos con el atributo data-toggle="tooltip"
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
        document.getElementById("acceptBtn").addEventListener("click", function () {
            const selectedYear = document.getElementById("year").value;
            // Solicitud AJAX para asignar la regularidad
            fetch("precepSiguienteRegular.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded",
                },
                body: `anio=${selectedYear}`
            })
                .then(response => response.json()) // Se espera una respuesta JSON
                .then(data => {
                    if (data.success) {
                        alert(data.message);  // Mostrar mensaje de éxito
                        location.reload();  // Recargar la página para ver los cambios
                    } else {
                        alert(data.message);  // Mostrar mensaje de error
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    alert("Hubo un error al procesar la solicitud.");
                });
        });