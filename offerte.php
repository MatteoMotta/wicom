<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>


<?
#### permessi
$req = 12; # admin

require "inc_config.php";
require "inc_sicurezza_bo.php";

	 unset($_SESSION['articoli']);	 
	 unset($_SESSION['offerta']);

if (0)
{
  echo "<pre>";
  print_r($_REQUEST);
  echo "</pre>";
}

	 
$columns = array('num_doc', 'data_doc');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

#ticket
if (isset($_REQUEST['id_offerta']))
  $id_offerta = mysqli_real_escape_string($link,$_REQUEST['id_offerta']);
else
  $id_offerta = "";



if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";








$msg_ok = "";

	

if (isAdmin() and $id_offerta and $todo=="del")
{
  $query = "
  DELETE FROM offerta
  WHERE 1
    AND id = '$id_offerta'
  ";
  doQuery($query);

  $msg_ok = "Offerta rimossa definitivamente";
}

if (isAdmin() and $id_offerta and $todo=="upd")
{
  $query = "
  DELETE FROM offerta
  WHERE 1
    AND id = '$id_offerta'
  ";
  doQuery($query);

  $msg_ok = "Offerta rimossa definitivamente";
}

$title = "Offerte";
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
            <h1><i class="icon-group"></i> Offerte</h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li class="active">Offerte</li>
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
              <h3 class="section-title first-title"><i class="icon-group"></i> Offerte
              <a href="offerta.php" type="button" class="btn" style="float:right"><i class="icon-plus"></i>Aggiungi</a>
              </h3>
              <div class="widget-content-white glossed">
                <div class="padded" style="overflow-x: auto;">

		<table class="table table-striped table-bordered table-hover datatable sortable" id="custom-table">
				<thead>			     
					
                    <tr>
                      <th style="width: 5%;"><a href="offerte.php?column=id&order=<?php echo $asc_or_desc; ?>">Offerta</a></th>
					  <th style="width: 15%;"><a href="offerte.php?column=data_chiamata&order=<?php echo $asc_or_desc; ?>">Data Documento<a></th>
                      <th style="width: 25%;">Cliente</th>
					  <th style="width: 15%;">Totale</th>
					  <th style="width: 10%;">Stato</th>
					  <th style="width: 10%;">Allarme</th>

					  
                    </tr>
					
					<tr>
                      <th><input type="text" id="numero-search" onchange="search()" placeholder="" class="form-control" style="width: 100%;"></th>
					  <th><input type="date" id="data-search" onchange="search()" placeholder="" class="form-control" style="width: 100%;"></th>
                      <th><input type="text" id="cliente-search" onkeyup="search()" placeholder="" class="form-control" style="width: 100%;"></th>
					  <th><input type="text" id="note-search" onkeyup="search()" placeholder="" class="form-control" style="width: 100%;"></th>
					  <th><select class="form-control" id="stato-search" onchange="search()" placeholder="" style="width: 100%;">		
							<option value="In corso">In corso</option>
							<option value="OK">Stato OK</option>
							<option value="KO">Stato KO</option>
						</select>
										</th>
					  
					  <th><input type="date" id="allarme-search" onchange="search()" placeholder="" class="form-control" style="width: 100%;"></th>

					  
                    </tr>
                  </thead>
    <tbody>
				  

					

<?			
			$query = "
			SELECT O.id, O.id_cliente, O.data_doc, O.num_doc, O.anno, O.note, O.stato, O.allarme, C.ragsoc1, C.nome, C.cognome, AO.qta, AO.prezzo, AO.sconto, FORMAT(SUM((AO.qta * AO.prezzo) - (((AO.qta * AO.prezzo)/100) * AO.sconto)), 2, 'de_DE')
			FROM offerta O
			LEFT JOIN cliente C on C.id = O.id_cliente
			LEFT JOIN articoli_offerta AO on AO.id_offerta = O.id
			GROUP BY O.num_doc
			ORDER BY " .  $column . " " . $sort_order;
			
			$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
			$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
			$add_class = ' class="highlight"';


			$result = doQuery($query);
			while (list($id_offerta_t, $id_cliente_t, $data_doc_t, $num_doc_t, $anno_t, $note_t, $stato_t, $allarme_t, $ragsoc1_t, $nome_t, $cognome_t, $qta_t, $prezzo_t, $sconto_t, $totale_t)= mysqli_fetch_array($result))
			{


?>
                    <tr>
					
                      <td align="center"><a href="offerta.php?id_offerta=<?=$id_offerta_t?>"><?=$num_doc_t?></a></td>
					  <? $date=date_create($data_doc_t);?>
					  <td align="center"><?=date_format($date,"d/m/Y");?></td>
					  <td align="center"><?=$ragsoc1_t?> <br> <?=$nome_t?> <?=$cognome_t?></td>
					  <td align="center"><?=$totale_t . ' €'?></td>
					  <td align="center"><?=$stato_t?></td>
					  <? if(empty($allarme_t)){?>
						<td align="center"></td>
					  <?}else{?>
						<? $dateAllarme=date_create($allarme_t);?>
						<td align="center"><?=date_format($dateAllarme,"d/m/Y");?></td>
					  <? }?>
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

</html>




<script>

$(document).ready(function(){
  $("select").trigger('change');
});

var input_cliente = document.getElementById("cliente-search");
var input_numero = document.getElementById("numero-search");
var input_note = document.getElementById("note-search");
var input_stato = document.getElementById("stato-search");
var input_data = document.getElementById("data-search");
var input_allarme = document.getElementById("allarme-search");
var table = document.getElementById("custom-table");

function search() {
  let filter_cliente = input_cliente.value.toUpperCase();
  let filter_numero = input_numero.value.toUpperCase();
  let filter_note = input_note.value.toUpperCase();
  let filter_stato = input_stato.value.toUpperCase();
  var data = new Date(input_data.value.toUpperCase());
  let filter_data = data.getDate()  + "/" + ("0"+(data.getMonth()+1)).slice(-2) + "/" + data.getFullYear()
  var allarme = new Date(input_allarme.value.toUpperCase());
  let filter_allarme = allarme.getDate()  + "/" + ("0"+(allarme.getMonth()+1)).slice(-2) + "/" + allarme.getFullYear()
  

  let tr = table.rows;
 
  
  for (let i =2; i < tr.length; i++) {
	td = tr[i].cells;
		td_numero = td[0].innerText;	
		td_data = td[1].innerText;		
		td_allarme = td[5].innerText;				
		td_cliente = td[2].innerText;
		td_note = td[3].innerText;
		td_stato = td[4].innerText;
		if (td_numero.toUpperCase().indexOf(filter_numero) > -1 && td_cliente.toUpperCase().indexOf(filter_cliente) > -1 && td_note.toUpperCase().indexOf(filter_note) > -1  && td_stato.toUpperCase().indexOf(filter_stato) > -1  && (td_data.toUpperCase() == filter_data || input_data.value.toUpperCase() == "") && (td_allarme.toUpperCase() == filter_allarme || input_allarme.value.toUpperCase() == "") ) {
		  tr[i].style.display = "";
		} else
		  tr[i].style.display = "none";
		
  }
}
</script>



