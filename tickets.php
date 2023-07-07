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

	 
$columns = array('id', 'data_assistenza');
$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

#ticket
if (isset($_REQUEST['id_ticket']))
  $id_ticket = mysqli_real_escape_string($link,$_REQUEST['id_ticket']);
else
  $id_ticket = "";



if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";


$msg_ok = "";

	

if ($id_ticket and $todo=="del")
{
  $query = "
  DELETE FROM ticket
  WHERE 1
    AND id = '$id_ticket'
  ";
  doQuery($query);

  $msg_ok = "Ticket rimosso definitivamente";
}


$title = "Attività";
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
            <h1><i class="icon-group"></i> Attività</h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li class="active">Attività</li>
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
              <h3 class="section-title first-title"><i class="icon-group"></i> Attività
              <a href="ticket.php" type="button" class="btn" style="float:right"><i class="icon-plus"></i>Aggiungi</a>
              </h3>
              <div class="widget-content-white glossed">
                <div class="padded" style="overflow-x: auto;">

		<table class="table table-striped table-bordered table-hover datatable sortable" id="custom-table">
				<thead>			     
					
                    <tr>
                      <th><a href="tickets.php?column=id&order=<?php echo $asc_or_desc; ?>">Attività</a></th>
					  <th><a href="tickets.php?column=data_chiamata&order=<?php echo $asc_or_desc; ?>">Data Start<a></th>
                      <th >Cliente</th>
					  <th>Progetto</th>
					  <th>Descrizione</th>
					  <th>Successo</th>
					  <th>Potenziale</th>
					  <th>Allarme</th>
					  <th></th>

					  
                    </tr>
					
					<tr>
                      <th><a href="tickets.php?column=id&order=<?php echo $asc_or_desc; ?>"></a></th>
					  <th><input type="date" id="data-search" onchange="search()" placeholder="" class="form-control" style="width: 100%;"></th>
                      <th><input type="text" id="cliente-search" onkeyup="search()" placeholder="" class="form-control" style="width: 100%;"></th>
					  <th><input type="text" id="progetto-search" onkeyup="search()" placeholder="" class="form-control" style="width: 100%;"></th>
					  <th><input type="text" id="descrizione-search" onkeyup="search()" placeholder="" class="form-control" style="width: 100%;"></th>
					  <th><input type="text" id="successo-search" onkeyup="search()" placeholder="" class="form-control" style="width: 100%;"></th>
					  <th><input type="text" id="potenziale-search" onkeyup="search()" placeholder="" class="form-control" style="width: 100%;"></th>
					  <th><input type="date" id="allarme-search" onchange="search()" placeholder="" class="form-control" style="width: 100%;"></th>
					  <th></th>
					  
                    </tr>
                  </thead>
    <tbody>
				  

					

<?			
			$query = "
			SELECT T.id, T.id_cliente, T.data_assistenza, T.progetto, T.descrizione, T.val_offerto, T.val_ordinato, T.val_potenziale, T.successo, T.note, T.commento, T.allarme, C.ragsoc1, C.nome, C.cognome
			FROM ticket T
			LEFT JOIN cliente C on C.id = T.id_cliente	
			WHERE id_utente = '".$_SESSION["sess_id_utente"]."'
			ORDER BY " .  $column . " " . $sort_order;
			
			$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
			$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
			$add_class = ' class="highlight"';


			$result = doQuery($query);
			while (list($id_ticket_t, $id_cliente_t, $data_assistenza_t, $progetto_t, $descrizione_t, $val_offerto_t, $val_ordinato_t, $val_potenziale_t, $successo_t, $note_t, $commento_t, $allarme_t, $ragsoc1_t, $nome_t, $cognome_t)= mysqli_fetch_array($result))
			{


?>
                    <tr>
					
					  <td align="center"><a href="ticket.php?id_ticket=<?=$id_ticket_t?>"><?=$id_ticket_t?></a></td>
					  <? $date=date_create($data_assistenza_t);?>
					  <td align="center"><?=date_format($date,"d/m/Y");?></td>
					  <td align="center"><?=$ragsoc1_t?> </br> <?=$nome_t?> <?=$cognome_t?></td>
					  <td align="center"><?=$progetto_t?></td>
					  <td align="center"><?=$descrizione_t?></td>
					  <td align="center"><?=$successo_t?></td>
					  <td align="center"><?=$val_potenziale_t?></td>
					  <? if($allarme_t == '0000-00-00'){?>
						<td align="center"></td>
					  <?}else{?>
						<? $dateAllarme=date_create($allarme_t);?>
						<td align="center"><?=date_format($dateAllarme,"d/m/Y");?></td>
					  <? }?>
					  
					  <td class="text-center" nowrap>
						  <button id="del_<?=$id_ticket_t?>" class="delTicket btn btn-danger btn-xs"><i class="icon-remove"></i></button>
					  </td>

                     
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

<form id="fake" action="ticket.php" method="post">
  <input type="hidden" name="id_ticket" id="id_ticket_fake" />
</form>
<form id="fakeDel" action="tickets.php" method="post">
  <input type="hidden" name="todo" id="todo" value="del" />
  <input type="hidden" name="id_ticket" id="id_ticket_fakeDel" />
</form>
<?require "inc_footer.php"?>

</html>




<script>

var input_cliente = document.getElementById("cliente-search");
var input_progetto = document.getElementById("progetto-search");
var input_descrizione = document.getElementById("descrizione-search");
var input_successo = document.getElementById("successo-search");
var input_potenziale = document.getElementById("potenziale-search");
var input_data = document.getElementById("data-search");
var input_allarme = document.getElementById("allarme-search");
var table = document.getElementById("custom-table");

function search() {
  let filter_cliente = input_cliente.value.toUpperCase();
  let filter_progetto = input_progetto.value.toUpperCase();
  let filter_descrizione = input_descrizione.value.toUpperCase(); 
  let filter_successo = input_successo.value.toUpperCase(); 
  let filter_potenziale = input_potenziale.value.toUpperCase(); 
  var data = new Date(input_data.value.toUpperCase());
  let filter_data = data.getDate()  + "/" + ("0"+(data.getMonth()+1)).slice(-2) + "/" + data.getFullYear()
  var allarme = new Date(input_allarme.value.toUpperCase());
  let filter_allarme = allarme.getDate()  + "/" + ("0"+(allarme.getMonth()+1)).slice(-2) + "/" + allarme.getFullYear()
    

  let tr = table.rows;
 
  
  for (let i =2; i < tr.length; i++) {
	td = tr[i].cells;
		td_data = td[1].innerText;
		td_allarme = td[7].innerText;
				
		td_cliente = td[2].innerText;
		td_progetto = td[3].innerText;
		td_descrizione = td[4].innerText;
		td_successo = td[5].innerText;
		td_potenziale = td[6].innerText;
		if (td_cliente.toUpperCase().indexOf(filter_cliente) > -1 && td_progetto.toUpperCase().indexOf(filter_progetto) > -1 && td_successo.toUpperCase().indexOf(filter_successo) > -1 && td_potenziale.toUpperCase().indexOf(filter_potenziale) > -1 && td_descrizione.toUpperCase().indexOf(filter_descrizione) > -1 && (td_data.toUpperCase() == filter_data || input_data.value.toUpperCase() == "") && (td_allarme.toUpperCase() == filter_allarme || input_allarme.value.toUpperCase() == "") ) {
		  tr[i].style.display = "";
		} else
		  tr[i].style.display = "none";
		
  }
}
</script>



