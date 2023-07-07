(function() {
  $(function() {
    return $('.chosen').chosen();
  });

  // validazione
  var metrics = [
    // ['#email', 'presence', 'obbligatorio'],
    ['#ragione_sociale', 'presence', 'obbligatorio'],
    ['#attivita', 'presence', 'obbligatorio'],
    ['#id_nazione', 'presence', 'obbligatorio'],
    ['#email', 'email', 'non valida'],
  ];
  $( "#frmAnag" ).nod( metrics );

///////////// agenti

  $(".upd_age").click(function() {
    ar = this.id.split("_");
    id = ar[1];
    id_cliente = $('#id_cliente').val();
    document.location.href='agente.php?id_cliente='+id_cliente+'&id_agente='+id+'#agenti';
    return false;
  });

  $(".del_age").click(function() {
    if (confirm("Confermi rimozione di questo agente da questo cliente?"))
    {
      ar = this.id.split("_");
      id = ar[1];

      $.post("ajax/doAgente.php", { id_agente:id, id_cliente:$("#id_cliente").val(), todo:"del"},
          function(risposta)
          {
            b = risposta.split("|");
            if (b[0] == "KO")
              alert(risposta);
            else
            {
             $("#tr_age_"+id).hide();
            }
          }
      );
      return false;
    }
  });


///////////// referenti
  var metrics = [
    ['#referente', 'presence', 'obbligatorio'],
    ['#referente_email', 'email', 'non valida'],
  ];
  $( "#frmRef" ).nod( metrics );

  $(".upd_ref").click(function() {
    ar = this.id.split("_");
    id = ar[1];
    id_cliente = $('#id_cliente').val();
    document.location.href='cliente.php?id_cliente='+id_cliente+'&id_referente='+id+'#referenti';
    return false;
  });

  $(".del_ref").click(function() {
    if (confirm("Confermi rimozione definitiva di questo referente?"))
    {
      ar = this.id.split("_");
      id = ar[1];

      $.post("ajax/doReferente.php", { id_referente:id, todo:"del"},
          function(risposta)
          {
            b = risposta.split("|");
            if (b[0] == "KO")
              alert(risposta);
            else
            {
             $("#tr_ref_"+id).hide();
            }
          }
      );
      return false;
    }
  });

///////////// sconti
  var metrics = [
    
  ];
  $( "#frmRef" ).nod( metrics );

  $(".upd_sc").click(function() {
    ar = this.id.split("_");
    id = ar[1];
    id_cliente = $('#id_cliente').val();
    document.location.href='cliente.php?id_cliente='+id_cliente+'&id_sconto='+id+'#sconti';
    return false;
  });

  $(".del_sc").click(function() {
    if (confirm("Confermi rimozione definitiva di questo referente?"))
    {
      ar = this.id.split("_");
      id = ar[1];

      $.post("ajax/doSconto.php", { id_sconto:id, todo:"del"},
          function(risposta)
          {
            b = risposta.split("|");
            if (b[0] == "KO")
              alert(risposta);
            else
            {
             $("#tr_ref_"+id).hide();
            }
          }
      );
      return false;
    }
  });

///////////// attivita
  var metrics = [
   // ['#attivita_data', 'presence', 'obbligatorio'],
    // DATEPICKER ['#attivita_data', /^\d{2}\-\d{2}\-\d{4}$/, 'in formato gg-mm-aaaa'],
	
    ['#attivita_id_attivitamotivo', 'presence', 'obbligatorio'],
	['#attivita_luogo', 'presence', 'obbligatorio'],
	['#referente_jp', 'presence', 'obbligatorio'],

  ];
  $( "#frmAtt" ).nod( metrics );

  $(".del_att").click(function() {
    if (confirm("Confermi rimozione definitiva di questa attivita?"))
    {
      ar = this.id.split("_");
      id = ar[1];

      $.post("ajax/doAttivita.php", { id_attivita:id, todo:"del"},
          function(risposta)
          {
            b = risposta.split("|");
            if (b[0] == "KO")
              alert(risposta);
            else
            {
             $("#tr_att_"+id).hide();
            }
          }
      );
      return false;
    }
  });

  $(".upd_att").click(function() {
    ar = this.id.split("_");
    id = ar[1];
    id_cliente = $('#id_cliente').val();
    document.location.href='cliente.php?id_cliente='+id_cliente+'&attivita_id_attivita='+id+'#attivitaa';
    return false;
  });


  $("#attivita_id_catalogo").change(function() {
    id = this.value;
    if (!id)
      $("#row_attivita_catalogo").hide();
    else
    {
      $("#row_attivita_catalogo").show();
      $.post("ajax/selAttivitaCatalogo.php", { id_catalogo:id},
          function(risposta)
          {
            if (risposta == "KO")
              alert(risposta);
            else
            {
              // $box|$cd|$dvd|$pdf|$tes|$vol
              b = risposta.split("|");
              box = b[0];
              if (box==0)
                $('#attivita_box').prop('disabled', true);
              else
                $('#attivita_box').prop('disabled', false);
              cd = b[1];
              if (cd==0)
                $('#attivita_cd').prop('disabled', true);
              else
                $('#attivita_cd').prop('disabled', false);
              dvd = b[2];
              if (dvd==0)
                $('#attivita_dvd').prop('disabled', true);
              else
                $('#attivita_dvd').prop('disabled', false);
              pdf = b[3];
              if (pdf==0)
                $('#attivita_pdf').prop('disabled', true);
              else
                $('#attivita_pdf').prop('disabled', false);
              tes = b[4];
              if (tes==0)
                $('#attivita_tes').prop('disabled', true);
              else
                $('#attivita_tes').prop('disabled', false);
              vol = b[5];
              if (vol==0)
                $('#attivita_vol').prop('disabled', true);
              else
                $('#attivita_vol').prop('disabled', false);
            }
          }
      );
    }
  });

///////////// preventivi
  var metrics = [
    ['#preventivo_codice', 'presence', 'obbligatorio'],
    //['#preventivo_data_emissione', 'presence', 'obbligatorio'],
    // DATEPICKER ['#preventivo_data_emissione', /^\d{2}\-\d{2}\-\d{4}$/, 'in formato gg-mm-aaaa'],
    ['#importo', 'presence', 'obbligatorio'],
    ['#importo', 'float', 'in formato xxx.yy'],
  ];
  $( "#frmPrev" ).nod( metrics );

  $(".del_prev").click(function() {
    if (confirm("Confermi rimozione definitiva di questo preventivo?"))
    {
      ar = this.id.split("_");
      id = ar[1];

      $.post("ajax/doPreventivo.php", { id_preventivo:id, todo:"del"},
          function(risposta)
          {
            b = risposta.split("|");
            if (b[0] == "KO")
              alert(risposta);
            else
            {
             $("#tr_prev_"+id).hide();
            }
          }
      );
      return false;
    }
  });

  $(".upd_prev").click(function() {
    ar = this.id.split("_");
    id = ar[1];
    id_cliente = $('#id_cliente').val();
    document.location.href='cliente.php?id_cliente='+id_cliente+'&preventivo_id_preventivo='+id+'#preventivi';
    return false;
  });

  $(".ann_prev").click(function() {
    if (confirm('Confermi annullamento di questo Preventivo?'))
    {
      ar = this.id.split("_");
      id = ar[1];
      id_cliente = $('#id_cliente').val();
      document.location.href='cliente.php?todo=annPrev&id_cliente='+id_cliente+'&preventivo_id_preventivo='+id+'#preventivi';
    }
    return false;
  });

///////////// ordini
  var metrics = [
    ['#ordine_codice', 'presence', 'obbligatorio'],
    ['#ordine_id_preventivo', 'presence', 'obbligatorio'],
    //['#ordine_data_emissione', 'presence', 'obbligatorio'],
    // DATEPICKER ['#ordine_data_emissione', /^\d{2}\-\d{2}\-\d{4}$/, 'in formato gg-mm-aaaa'],
    //['#ordine_data_consegna', 'presence', 'obbligatorio'],
    // DATEPICKER ['#ordine_data_consegna', /^\d{2}\-\d{2}\-\d{4}$/, 'in formato gg-mm-aaaa'],
    ['#importo', 'presence', 'obbligatorio'],
    ['#importo', 'float', 'in formato xxx.yy'],
  ];
  $( "#frmOrd" ).nod( metrics );
  
    $(".upd_ord").click(function() {
    ar = this.id.split("_");
    id = ar[1];
    id_cliente = $('#id_cliente').val();
    document.location.href='cliente.php?id_cliente='+id_cliente+'&ordine_id_ordine='+id+'#ordini';
    return false;
  });

  $(".del_ord").click(function() {
    if (confirm("Confermi rimozione definitiva di questo ordine?"))
    {
      ar = this.id.split("_");
      id = ar[1];

      $.post("ajax/doOrdine.php", { id_ordine:id, todo:"del"},
          function(risposta)
          {
            b = risposta.split("|");
            if (b[0] == "KO")
              alert(risposta);
            else
            {
             $("#tr_ord_"+id).hide();
            }
          }
      );
      return false;
    }
  });


  $("#ordine_id_fornitore").change(function() {
    id_fornitore = $(this).val();
    id_cliente = $("#id_cliente").val();

    $.post("ajax/selPreventivo.php", { id_fornitore:id_fornitore, id_cliente:id_cliente},
        function(risposta)
        {
          var output = [];
          output.push('<option value="">seleziona</option>');
          $.each(JSON.parse(risposta), function(idx, obj) {
          	output.push('<option value="'+ obj.id +'">'+ obj.codice +'</option>');
          });
          $('#ordine_id_preventivo').html(output.join(''));
        }
    );
  });


  $("#ordine_id_preventivo").change(function() {
    id_preventivo = $(this).val();

    $.post("ajax/selPreventivoImporto.php", { id_preventivo:id_preventivo},
        function(risposta)
        {
          $('#ordine_importo').val(risposta);
        }
    );
  });


///////////// evasioni
  var metrics = [
    ['#evasione_id_ordine', 'presence', 'obbligatorio'],
    //['#evasione_data_emissione', 'presence', 'obbligatorio'],
    // DATEPICKER ['#evasione_data_emissione', /^\d{2}\-\d{2}\-\d{4}$/, 'in formato gg-mm-aaaa'],
    ['#evasione_numero', 'presence', 'obbligatorio'],
    ['#importo', 'presence', 'obbligatorio'],
    ['#importo', 'float', 'in formato xxx.yy'],
  ];
  $( "#frmEva" ).nod( metrics );

  
  $(".upd_eva").click(function() {
    ar = this.id.split("_");
    id = ar[1];
    id_cliente = $('#id_cliente').val();
    document.location.href='cliente.php?id_cliente='+id_cliente+'&evasione_id_evasione='+id+'#evasioni';
    return false;
  });
  
  $(".del_eva").click(function() {
    if (confirm("Confermi rimozione definitiva di questo evasione?"))
    {
      ar = this.id.split("_");
      id = ar[1];

      $.post("ajax/doEvasione.php", { id_evasione:id, todo:"del"},
          function(risposta)
          {
            b = risposta.split("|");
            if (b[0] == "KO")
              alert(risposta);
            else
            {
             $("#tr_eva_"+id).hide();
            }
          }
      );
      return false;
    }
  });

  $("#evasione_id_fornitore").change(function() {
    id_fornitore = $(this).val();
    id_cliente = $("#id_cliente").val();

    $.post("ajax/selOrdine.php", { id_fornitore:id_fornitore, id_cliente:id_cliente},
        function(risposta)
        {
          var output = [];
          output.push('<option value="">seleziona</option>');
          $.each(JSON.parse(risposta), function(idx, obj) {
          	output.push('<option value="'+ obj.id +'">'+ obj.codice +'</option>');
          });
          $('#evasione_id_ordine').html(output.join(''));
        }
    );
  });
  $("#evasione_id_ordine").change(function() {
    id_ordine = $(this).val();

    $.post("ajax/selOrdineImporto.php", { id_ordine:id_ordine},
        function(risposta)
        {
          $('#evasione_importo').val(risposta);
        }
    );
  });

  $(".del_all").click(function() {
    if (confirm("Confermi rimozione definitiva di questa attivita?"))
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
             $("#tr_att_"+id).hide();
            }
          }
      );
      return false;
    }
  });


}).call(this);
