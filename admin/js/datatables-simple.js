$(document).ready(function () {
  const datatablesSimple = document.getElementById("datatablesSimple");
  if (datatablesSimple) {
    new DataTable(datatablesSimple, {
      searchable: true,
      sortable: true,
      lengthMenu: [15, 25, 50, 75, 100],
      pageLength: 15,
      orderCellsTop: true,
      fixedHeader: true,
      colReorder: true,
      language: {
        paginate: {
          previous: "Anterior",
          next: "Próximo",
        },
        search: "",
        searchPlaceholder: "Pesquisar...",
        lengthMenu: "Mostrar _MENU_ registos por página",
        zeroRecords: "Nenhum registo encontrado",
        emptyTable: "Tabela vazia",
        info: "A exibir _START_ até _END_ de _TOTAL_ registos",
        infoEmpty: "Nenhum registo encontrado",
        infoFiltered: "(filtrado de _MAX_ registos)",
        searchBuilder: {
          button: {
            0: "Pesquisa Avançada",
            _: "Pesquisa Avançada (%d)",
          },
          title: {
            _: "Pesquisa Avançada",
            1: "Pesquisa Avançada (1 filtro)",
          },
          value: "Valor",
          valueJoiner: "e",
          titleAttr: "Construtor de Pesquisa",
          buttonAttr: "Construtor de Pesquisa",
          logicAnd: "E",
          logicOr: "Ou",
          add: "Adicionar Filtro",
          clearAll: "Limpar Tudo",
          condition: "Condição",
          conditions: {
            no: "Não",
            yes: "Sim",
            "=": "Igual",
            "!=": "Diferente",
            "<": "Menor que",
            "<=": "Menor ou igual a",
            ">": "Maior que",
            ">=": "Maior ou igual a",
            string: {
              equals: "Igual",
              not: "Diferente",
              startsWith: "Começa com",
              notStartsWith: "Não começa com",
              contains: "Contém",
              notContains: "Não contém",
              endsWith: "Termina com",
              notEndsWith: "Não termina com",
              empty: "Vazio",
              notEmpty: "Não vazio",
            },
          },
          data: "Coluna",
          deleteTitle: "Apagar filtro",
          leftTitle: "Condição Externa",
          rightTitle: "Condição Interna",
          valueTitle: "Valor",
          buttonTitle: "Filtro",
          selected: "selecionado",
          selectedAll: "Todos selecionados",
          selectedNone: "Nenhum selecionado",
          titleButton: "Filtros",
        },
        buttons: {
          copyTitle: "Copiado para a área de transferência",
          copyKeys:
            "Pressiona <i>ctrl</i> ou <i>\u2318</i> + <i>C</i> para copiar os dados da tabela para a área de transferência. <br><br>Para cancelar, clica nesta mensagem ou pressiona ESC.",
          copySuccess: {
            1: "1 linha copiada para a área de transferência",
            _: "%d linhas copiadas para a área de transferência",
          },
        },
      },
      columnDefs: [
        {
          targets: 1,
          className: "noVis",
        },
      ],
      layout: {
        topEnd: {
          buttons: [
            {
              extend: "print",
              text: "<i class='bi bi-printer'></i>",
              className: "btn btn-primary",
              titleAttr: "Imprimir",
              exportOptions: {
                columns: ":visible",
              },
            },
            {
              extend: "csv",
              text: "<i class='bi bi-file-earmark-spreadsheet'></i>",
              className: "btn btn-warning",
              titleAttr: "CSV",
              exportOptions: {
                columns: ":visible",
              },
            },
            {
              extend: "excel",
              text: "<i class='bi bi-file-earmark-excel'></i>",
              className: "btn btn-success",
              titleAttr: "Excel",
              exportOptions: {
                columns: ":visible",
              },
            },
            {
              extend: "pdf",
              text: "<i class='bi bi-file-earmark-pdf'></i>",
              className: "btn btn-danger",
              titleAttr: "PDF",
              exportOptions: {
                columns: ":visible",
              },
            },
            {
              extend: "copy",
              text: "<i class='bi bi-clipboard'></i>",
              className: "btn btn-secondary",
              titleAttr: "Copiar",
              exportOptions: {
                columns: ":visible",
              },
            },
            {
              extend: "searchBuilder",
              text: "<i class='bi bi-funnel'></i> Pesquisa Avançada",
              className: "btn btn-info",
              titleAttr: "Construtor de Pesquisa",
              config: {
                depthLimit: 2,
              },
            },
            {
              extend: "colvis",
              text: "<i class='bi bi-eye'></i> Colunas",
              className: "btn btn-light",
              title: "Colunas",
              popoverTitle: "Escolher colunas",
            },
          ],
        },
      },
    });
  }
});
