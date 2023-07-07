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
      "bStateSave": true,
      "bStateSave": true,
      <?if ($search){?>
        "oSearch": {"sSearch": "<?=str_replace('"','',$search)?>"}
      <?}?>
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
    ar = this.id.split("_");
    id = ar[1];

    $("#id_cliente_fake").val(id);
    $("#fake").submit();
    return false;
  });

  $(".del").click(function() {
    if (confirm("Confermi rimozione definitiva di questo cliente?"))
    {
      ar = this.id.split("_");
      id = ar[1];

      $("#id_cliente_fakeDel").val(id);
      $("#fakeDel").submit();
      return false;
    }
  });

  $(".status").click(function() {
    ar = this.id.split("_");
    id_cliente = ar[1];

    $.post("ajax/doCliente.php", { id_cliente:id_cliente},
    function(risposta) {
      b = risposta.split("|");
      if (b[0] == "KO")
        alert(risposta);
      else
      {
        btn = $("#status_"+id_cliente);
        if (b[1] == 0)
        {
          btn.removeClass("label-success").addClass("label-danger");
          btn.html("Non Attiva");
        }
        else
        {
          btn.removeClass("label-danger").addClass("label-success");
          btn.html("Attiva");
        }
      }
    });

    return false;
  });

}).call(this);
