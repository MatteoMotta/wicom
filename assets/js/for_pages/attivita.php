(function() {
  $(function() {
    return $('.chosen').chosen();
  });


///////////// referenti
  var metrics = [
    ['#attivita_allegato', 'presence', 'obbligatorio'],
  ];
  $( "#frmCtrl" ).nod( metrics );

  $(".del_ctrl").click(function() {
    if (confirm("Confermi rimozione definitiva di questo referente?"))
    {
      ar = this.id.split("_");
      id = ar[1];

      $.post("ajax/doAllegato.php", { id_allegato:id, todo:"del"},
          function(risposta)
          {
            b = risposta.split("|");
            if (b[0] == "KO")
              alert(risposta);
            else
            {
             $("#tr_ctrl_"+id).hide();
            }
          }
      );
      return false;
    }
  

}).call(this);
