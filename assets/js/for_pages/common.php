<?
require "../../../inc_config.php";

?>

(function() {
  $('.datepicker').datepicker({
    format: 'dd-mm-yyyy',
    weekStart: 1,
    autoclose: true
  }).on('changeDate', function(ev){
    $('.datepicker').datepicker('hide');
  });

  $(".chosen-select").chosen();

}).call(this);
