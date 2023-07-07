<?
#### permessi
$req = 12; # admin

require "inc_config.php";
require "inc_sicurezza_bo.php";

	 unset($_SESSION['att_tecnico']);
	 unset($_SESSION['progressivi']);
	 unset($_SESSION['report']);
	 unset($_SESSION['articoli']);
	 unset($_SESSION['tipoIntervento']);
	 
if (0)
{
  echo "<pre>";
  print_r($_REQUEST);
  echo "</pre>";
}

$columns = array('id', 'data_chiamata');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

#ticket
if (isset($_REQUEST['ticket_id_ticket']))
  $ticket_id_ticket = mysqli_real_escape_string($link,$_REQUEST['ticket_id_ticket']);
else
  $ticket_id_ticket = "";

if (isset($_REQUEST['id_report']))
  $id_report = mysqli_real_escape_string($link,$_REQUEST['id_report']);
else
  $id_report = "";

if (isset($_REQUEST['id_bollettario']))
  $id_bollettario = mysqli_real_escape_string($link,$_REQUEST['id_bollettario']);
else
  $id_bollettario = "";

if (isset($_REQUEST['stato']))
  $stato = mysqli_real_escape_string($link,$_REQUEST['stato']);
else
  $stato = "";

if (isset($_REQUEST['data_chiamata']))
  $data_chiamata = mysqli_real_escape_string($link,$_REQUEST['data_chiamata']);
else
  $data_chiamata = "";

if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";


$msg_ok = "";



$title = "Export Quanto";
require "inc_header.php"
?>
<div class="all-wrapper">
  <div class="row">
    <div class="col-md-3">
<?require "inc_menu_sx.php"?>
    </div>
    <div class="col-md-9">

      <div class="content-wrapper">
        <div class="content-inner <?=$content_inner_class?>">
          <div class="page-header <?=$page_header_class?>">
            <?require "inc_menu_oriz.php"?>
            <h1><i class="icon-group"></i> Export Quanto</h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li class="active">Export Quanto</li>
          </ol>
          <div class="main-content">
<?if ($msg_ok){?>
<div class="widget">
 <div class="alert alert-success alert-dismissable">
    <i class="icon-check-sign"></i>
    <!--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> -->
    <strong>Perfetto!</strong> <?=$msg_ok?>.
  </div>
</div>
<?}?>
            <div class="widget">
              <h3 class="section-title first-title"><i class="icon-group"></i> Export Quanto</h3>
              <div class="widget-content-white glossed">
                <div class="padded">
				
				<div class="row">
						<div class="col-md-4">
							  <div class="form-group">
								<label># Report: </label>
								<input type="text" id="myInput" class="form-control"  onkeyup="searchTicket()" placeholder="Cerca per # report">
							  </div>
						</div>			

						<div class="col-md-4">
							  <div class="form-group">
								<label>Bollettario: </label>
								<input type="text" id="bollettario" class="form-control" onkeyup="searchBollettario()" placeholder="Cerca per bollettario">
							  </div>
						</div>	

						<div class="col-md-4">
							  <div class="form-group">
								<label>Stato: </label>
								<input type="text" id="stato" class="form-control" onkeyup="searchStato()" placeholder="Cerca per stato ticket">
							  </div>
						</div>							
				</div>
				
										
			<table class="table table-striped table-bordered table-hover datatable" id="myTable">
                  <thead>
                    <tr>
                      <th><a href="tickets.php?column=id&order=<?php echo $asc_or_desc; ?>">#</a></th>
					  <th>Bollettario</th>
					  <th><a href="tickets.php?column=data_chiamata&order=<?php echo $asc_or_desc; ?>">Data Inserimento<a></th>
                      <th>Cliente</th>
					  <th>Progressivo</th>
					  <th>Stato</th>
					  <th>Export Quanto</th>					  
                    </tr>
                  </thead>
                  <tbody>
<?


			$query = "
			SELECT T.id,R.id_report, T.data_chiamata, C.ragsoc1, C.ragsoc2, T.motivo,R.id_report, R.id_bollettario, R.anno, S.descrizione, B.bollettario, R.progressivo
			FROM report R
			LEFT join ticket T on R.id_ticket = T.id
			LEFT JOIN cliente C on C.id = T.id_cliente
			LEFT JOIN stato S on S.id = T.stato
			LEFT JOIN bollettario B on B.id_bollettario = R.id_bollettario
			WHERE T.stato != 1 and R.ExportQuanto = 0
			ORDER BY " .  $column . " " . $sort_order;
			
			$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
			$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
			$add_class = ' class="highlight"';


			$result = doQuery($query);
			while (list($id_ticket_t, $id_report_t, $data_chiamata_t, $ragsoc1_t, $ragsoc2_t, $motivo_t, $id_report_t, $id_bollettario_t, $anno_t, $stato_t, $bollettario_t, $progressivo_t)= mysqli_fetch_array($result))
			{


?>
                    
					<tr>
                      <td align="center"><a href="ticket.php?id_ticket=<?=$id_ticket_t?>&id_report=<?=$id_report_t?>"><?=$id_report_t?></a></td>
					  <td align="center"><?=trim($bollettario_t)?></td> 					  
					  <td align="center"><?=$data_chiamata_t?></td>
					  <td align="center">
                        <?=trim($ragsoc1_t)?> <?=trim($ragsoc2_t)?>
                      </td>
					  <td align="center"><?=trim($progressivo_t) . "/" . trim($anno_t) ?></td>
					  <td align="center"><?=trim($stato_t)?></td> 
					  <td align="center"><a href="http://webapp.enneeffe.com/doXML.php?id_report=<?php echo $id_report_t?>" >Export XML in Quanto</a></td> 
                    </tr>
					


<?
}
		  
?>

                  </tbody>
                </table>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<script>
function searchTicket() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}


function searchBollettario() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("bollettario");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[1];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function searchStato() {
  // Declare variables
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("stato");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[5];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}
</script>
<?require "inc_footer.php"?>