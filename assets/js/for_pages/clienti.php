<?
require "../../../inc_config.php";

if (isset($_REQUEST['search']))
  $search = mysqli_real_escape_string($link,$_REQUEST['search']);
else
  $search = "";
?>(function() {
  $(function() {
    $('.datatable').dataTable({
      aoColumnDefs: [
        {
          bSortable: false,
          aTargets: []
        }
      ],
      aaSorting: [],
     // "bStateSave": true,
    });
    return $(".datatable").each(function() {
      var datatable, length_sel, search_input;
      datatable = $(this);
      search_input = datatable.closest(".dataTables_wrapper").find("div[id$=_filter] input");
      search_input.attr("placeholder", "Filtra");
      search_input.addClass("form-control input-sm");
      length_sel = datatable.closest(".dataTables_wrapper").find("div[id$=_length] select");
      length_sel.addClass("form-control input-sm");
      length_sel = datatable.closest(".dataTables_wrapper").find("div[id$=_info]");
      return length_sel.css("margin-top", "18px");
    });
  });

  $(".upd").click(function() {
    id = this.id.substr(4);
    $("#id_cliente_fake").val(id);
    $("#fake").submit();
    return false;
  });

  $(".del").click(function() {
    if (confirm("Confermi rimozione definitiva di questo cliente?"))
    {
      id = this.id.substr(4);
      $("#id_cliente_fakeDel").val(id);
      $("#fakeDel").submit();
      return false;
    }
  });

}).call(this);
