// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
    responsive: true,
    "language": {
      sEmptyTable: "No existen datos en esta tabla",
      sInfo: "Mostrando _START_ de _END_ de _TOTAL_ Entradas",
      sInfoEmpty: "0 de 0 de 0 Entradas",
      sInfoFiltered: "(Filtrado de un total de _MAX_ resultados)",
      sInfoPostFix: "",
      sInfoThousands: ".",
      sLengthMenu: "Mostrar _MENU_ Resultados",
      sLoadingRecords: "Cargando resultados...",
      sProcessing: "Espere por favor..",
      sSearch: "Buscar:",
      sZeroRecords: "No se han encontrado resultados.",
      oPaginate: {
        sFirst: "Primero",
        sPrevious: "Anterior",
        sNext: "Siguiente",
        sLast: "Último"
      },
      oAria: {
        sSortAscending: ":Habilitar para ordenar de forma ascendente",
        sSortDescending: ":Habilitar para ordenar de forma descendente"
      }
    }
  });
  $('#dataTable').DataTable();

  $('#dataTable1').DataTable({
    responsive: true,
    "language": {
      sEmptyTable: "No existen datos en esta tabla",
      sInfo: "Mostrando _START_ de _END_ de _TOTAL_ Entradas",
      sInfoEmpty: "0 de 0 de 0 Entradas",
      sInfoFiltered: "(Filtrado de un total de _MAX_ resultados)",
      sInfoPostFix: "",
      sInfoThousands: ".",
      sLengthMenu: "Mostrar _MENU_ Resultados",
      sLoadingRecords: "Cargando resultados...",
      sProcessing: "Espere por favor..",
      sSearch: "Buscar:",
      sZeroRecords: "No se han encontrado resultados.",
      oPaginate: {
        sFirst: "Primero",
        sPrevious: "Anterior",
        sNext: "Siguiente",
        sLast: "Último"
      },
      oAria: {
        sSortAscending: ":Habilitar para ordenar de forma ascendente",
        sSortDescending: ":Habilitar para ordenar de forma descendente"
      }
    }
  });
  $('#dataTable1').DataTable();
  $('#dataTable2').DataTable({
    responsive: true,
    "language": {
      sEmptyTable: "No existen datos en esta tabla",
      sInfo: "Mostrando _START_ de _END_ de _TOTAL_ Entradas",
      sInfoEmpty: "0 de 0 de 0 Entradas",
      sInfoFiltered: "(Filtrado de un total de _MAX_ resultados)",
      sInfoPostFix: "",
      sInfoThousands: ".",
      sLengthMenu: "Mostrar _MENU_ Resultados",
      sLoadingRecords: "Cargando resultados...",
      sProcessing: "Espere por favor..",
      sSearch: "Buscar:",
      sZeroRecords: "No se han encontrado resultados.",
      oPaginate: {
        sFirst: "Primero",
        sPrevious: "Anterior",
        sNext: "Siguiente",
        sLast: "Último"
      },
      oAria: {
        sSortAscending: ":Habilitar para ordenar de forma ascendente",
        sSortDescending: ":Habilitar para ordenar de forma descendente"
      }
    }
  });
  $('#dataTable2').DataTable();
});
