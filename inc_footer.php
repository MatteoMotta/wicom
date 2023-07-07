
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
<script src='assets/js/jquery.sparkline.min.js'></script>
<script src='assets/js/bootstrap/modal.js'></script>
<script src='assets/js/bootstrap/tab.js'></script>
<script src='assets/js/bootstrap/dropdown.js'></script>
<script src='assets/js/bootstrap/collapse.js'></script>
<script src='assets/js/bootstrap/transition.js'></script>
<script src='assets/js/bootstrap/tooltip.js'></script>
<script src='assets/js/bootstrap/bootstrap-datepicker.js'></script>
<script src='assets/js/bootstrap/typeahead.js'></script>
<script src='assets/js/jquery.knob.js'></script>
<!-- <script src='assets/js/fullcalendar.min.js'></script> -->
<script src='assets/js/moment.min.js'></script>
<!-- <script src='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.1.1/fullcalendar.min.js'></script> -->

<script src='assets/js/datatables/datatables.min.js'></script>
<script src='assets/js/chosen.jquery.min.js'></script>
<script src='assets/js/datatables/bootstrap.datatables.js'></script>
<script src='assets/js/raphael-min.js'></script>
<script src='assets/js/morris-0.4.3.min.js'></script>
<script src='assets/js/for_pages/color_settings.js'></script>
<script src='assets/js/application.js'></script>
<script src='assets/js/nod.min.js'></script>
<script src='assets/js/tagmanager/tagmanager.js'></script>
<script src='assets/js/ekko-lightbox.min.js'></script>

<?
# JS per pagina
if ($pagename != "index.php" and file_exists("assets/js/for_pages/".basename($pagename,".php").".js"))
  echo "<script src='assets/js/for_pages/".basename($pagename,".php").".js' charset='UTF-8'></script>";
elseif ($pagename == "statistiche.php")
  echo "<script src='assets/js/for_pages/statistiche.php?da=$da&amp;a=$a&amp;gg=$gg&amp;".time()."' charset='UTF-8'></script>";
elseif (file_exists("assets/js/for_pages/$pagename"))
{
  if (isset($search) and $search)
    echo "<script src='assets/js/for_pages/$pagename?search=$search&amp;".time()."' charset='UTF-8'></script>";
  else
    echo "<script src='assets/js/for_pages/$pagename?".time()."' charset='UTF-8'></script>";
}
?>

<div style="text-align:center;font-size:10px">
  powered by <a href="http://www.mottasistemi.it/">Motta Sistemi Srl</a> - 2022<?=date("Y")>2016?"-".date("Y"):""?>
  <br /><br />
</div>
</body>
</html>