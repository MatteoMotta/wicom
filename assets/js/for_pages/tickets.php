<?
require "../../../inc_config.php";

if (isset($_REQUEST['search']))
  $search = mysqli_real_escape_string($link,$_REQUEST['search']);
else
  $search = "";
?>(function() {



  $(".delTicket").click(function() {
    if (confirm("Confermi rimozione definitiva di questa attivita?"))
    {
      id = this.id.substr(4);
      $("#id_ticket_fakeDel").val(id);
      $("#fakeDel").submit();
      return false;
    }
  });



}).call(this);

