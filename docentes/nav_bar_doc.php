<style>
    .navbar {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        background-color: #003366; /* Azul oscuro */
        padding: 10px;
    }
    .navbar button {
        background-color: #00aaff; /* Celeste */
        color: white;
        border: none;
        padding: 8px 16px;
        margin-right: 10px;
        cursor: pointer;
        font-size: 16px;
        border-radius: 4px;
    }
    .navbar button:hover {
        background-color: #0088cc; /* Celeste más oscuro en hover */
    }
</style>

<div class="navbar">
    <button onclick="goBackToTop()">Volver</button>
    <button onclick="window.location.href='MisCursos.php'">Mis Cursos</button>
</div>

<script>
    function goBackToTop() {
        window.history.back();
        window.scrollTo(0, 0); // Mueve la vista al principio de la página
    }
</script>
