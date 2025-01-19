<!--Footer-->
<footer class="page-footer pt-0 mt-5 sticky-bottom">
  <!--Copyright-->
  <div class="footer-copyright py-3 text-center">
    <div class="container-fluid d-flex justify-content-center">
      <p class="m-0 pr-2">Tecnicatura Superior en Desarrollo de Software <span class="font-weight-bold"
          style="font-size: 20px;">•</span></p>
      <p class="m-0 pr-2">3° Año - 2024 <span class="font-weight-bold" style="font-size: 20px;">•</span></p>
      <p class="m-0 pr-2">ISFT 135 <span class="font-weight-bold" style="font-size: 20px;">•</span></p>
    </div>
  </div>

  <!--/.Copyright-->
</footer>
<!--/.Footer-->
<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="../assets/js/jquery-3.4.1.min.js"></script>
<!--script src="js/jquery-3.4.1.min.js"></script-->
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="../assets/js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="../assets/js/bootstrap.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="../assets/js/mdb.min.js"></script>
<!-- MDBootstrap Datatables  -->
<script type="text/javascript" src="../assets/js/addons/datatables.min.js"></script>

<!-- DataTables Select  -->
<script type="text/javascript" src="../assets/js/addons/datatables-select.min.js"></script>

<script type="text/javascript">
  $(document).ready(function () {
    $('.AllDataTables').DataTable({
      language: {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
          "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        }
      }
    });
    $('.dataTables_length').addClass('bs-select');
  });

  $(document).ready(function () {
    $('.mdb-select').materialSelect({ selectId: 'mono' });
    // SideNav Button Initialization
    $(".button-collapse").sideNav();
    // SideNav Scrollbar Initialization
    var sideNavScrollbar = document.querySelector('.custom-scrollbar');
    var ps = new PerfectScrollbar(sideNavScrollbar);
  })
</script>