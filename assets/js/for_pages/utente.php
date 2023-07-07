(function() {
  $(function() {
    return $('.chosen').chosen();
  });

  // validazione
  var metrics = [
    ['#email', 'presence', 'obbligatorio'],
    ['#email', 'email', 'non valida'],
    //['#password', 'presence', 'obbligatorio'],
    ['#password', 'min-length:6', 'almeno 6 caratteri'],
    ['#name', 'presence', 'obbligatorio'],
    //['#cognome', 'presence', 'obbligatorio'],
    //['#cellulare', 'presence', 'obbligatorio'],
    //['#codice_fiscale', /^[A-Za-z]{6}[0-9]{2}[A-Za-z]{1}[0-9]{2}[A-Za-z]{1}[0-9]{3}[A-Za-z]{1}$/, 'verifica'],
    //['#data_nascita', /^\d{2}\-\d{2}\-\d{4}$/, 'verifica gg-mm-aaaa'],
  ];
  $( "#frm" ).nod( metrics );

}).call(this);
