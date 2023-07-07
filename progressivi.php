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

$column = isset($_GET['column']) && in_array($_GET['column'], $columns) ? $_GET['column'] : $columns[0];
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) == 'asc' ? 'ASC' : 'DESC';
$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';

#ticket
if (isset($_REQUEST['id_bollettario']))
  $id_bollettario = mysqli_real_escape_string($link,$_REQUEST['id_bollettario']);
else
  $id_bollettario = "";




if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";


$msg_ok = "";


$title = "Progressivi";
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
            <h1><i class="icon-group"></i> Progressivi</h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li class="active">Servizio di assistenza - Progressivi</li>
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
              <h3 class="section-title first-title"><i class="icon-group"></i> Servizio di Assistenza - Progressivi
              </h3>
              <div class="widget-content-white glossed">
                <div class="padded">
                <table class="table table-striped table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th>Bollettario</th>
					  <th>Anno</th>
					  <th>Progressivo</th>
					  <th><a href="reports.php?column=id&order=<?php echo $asc_or_desc; ?>"></a></th>
                    </tr>
                  </thead>
                  <tbody>
<?
			$query = "
			SELECT P.id_progressivo, P.progressivo, max(P.anno), B.bollettario
			FROM  progressivi P 
			LEFT JOIN bollettario B on B.id_bollettario = P.id_bollettario
            group by P.id_progressivo,P.progressivo, B.bollettario;
			";
			
			$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
			$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
			$add_class = ' class="highlight"';


			$result = doQuery($query);
			while (list($id_progressivo_t, $progressivo_t, $anno_t, $bollettario_t)= mysqli_fetch_array($result))
			{


?>
                    <tr>					  
					  <td align="center"><?=$bollettario_t?></td>
					  <td align="center"><?=$anno_t?></td>
					  <td align="center"><?=$progressivo_t?></td>
					  <td align="center"><a class="btn btn-default btn-xs" href="progressivo.php?id_progressivo=<?=$id_progressivo_t?>"><i class="icon-pencil"></i></a></td>
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
<form id="fake" action="progressivo.php" method="post">
  <input type="hidden" name="id_progressivo" id="id_progressivo_fake" />
</form>
<form id="fakeDel" action="progressivi.php" method="post">
  <input type="hidden" name="todo" id="todo" value="del" />
  <input type="hidden" name="id_progressivo" id="id_progressivo_fakeDel" />
</form>
<?require "inc_footer.php"?>