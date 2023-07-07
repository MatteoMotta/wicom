<?
#### permessi
$req = 12; # admin

require "inc_config.php";
require "inc_sicurezza_bo.php";

	 unset($_SESSION['att_tecnico']);
	 unset($_SESSION['progressivi']);
	 unset($_SESSION['report']);
	 unset($_SESSION['articoli']);

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
if (isset($_REQUEST['id_report']))
  $id_report = mysqli_real_escape_string($link,$_REQUEST['id_report']);
else
  $id_report = "";



if (isset($_REQUEST['todo']))
  $todo = mysqli_real_escape_string($link,$_REQUEST['todo']);
else
  $todo = "";


$msg_ok = "";


$title = "Report";
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
            <h1><i class="icon-group"></i> Servizio di assistenza</h1>
          </div>
          <ol class="breadcrumb">
            <li><a href="home.php">Home</a></li>
            <li class="active">Servizio di assistenza</li>
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
              <h3 class="section-title first-title"><i class="icon-group"></i> Servizio di Assistenza
              </h3>
              <div class="widget-content-white glossed">
                <div class="padded">
                <table class="table table-striped table-bordered table-hover datatable">
                  <thead>
                    <tr>
                      <th><a href="reports.php?column=id&order=<?php echo $asc_or_desc; ?>">#</a></th>
                      <th>Bollettario</th>
					  <th>Ticket</th>
					  
                    </tr>
                  </thead>
                  <tbody>
<?
			$query = "
			SELECT R.id_report, R.progressivo, R.anno, R.id_ticket, B.bollettario
			FROM  report R 
			LEFT JOIN bollettario B on B.id_bollettario = R.id_bollettario
			";
			
			$up_or_down = str_replace(array('ASC','DESC'), array('up','down'), $sort_order); 
			$asc_or_desc = $sort_order == 'ASC' ? 'desc' : 'asc';
			$add_class = ' class="highlight"';


			$result = doQuery($query);
			while (list($id_report_t, $progressivo_t, $anno_t, $id_ticket_t, $bollettario_t)= mysqli_fetch_array($result))
			{


?>
                    <tr>
                      <td align="center"><a href="report.php?id_ticket=<?=$id_ticket_t?>&id_report=<?=$id_report_t?>"><?=$progressivo_t?>/<?=$anno_t?></a></td>
					  <td align="center"><?=$bollettario_t?></td>
					  <td align="center"><?=$id_ticket_t?></td>

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
<form id="fake" action="report.php" method="post">
  <input type="hidden" name="id_report" id="id_report_fake" />
</form>
<form id="fakeDel" action="reports.php" method="post">
  <input type="hidden" name="todo" id="todo" value="del" />
  <input type="hidden" name="id_report" id="id_report_fakeDel" />
</form>
<?require "inc_footer.php"?>