<?
#### permessi
$req = 11; # admin

header("Location: tickets.php");
exit();


require "inc_config.php";
require "inc_sicurezza_bo.php";

if (1)
{
  echo "<pre>";
  print_r($_REQUEST);

  print_r($_FILES);
  echo "</pre>";
}

if (isset($_REQUEST['anno']))
  $anno = mysqli_real_escape_string($link,$_REQUEST['anno']);
else
  $anno = date("Y");


$title = "Home Page";
require "inc_header.php";


$menu_int = "
<h4>
  <a href=\"#evasioni\">Evasioni</a>
  |
  <a href=\"#ordini\">Ordini</a>
  |
  <a href=\"#preventivi\">Preventivi</a>
  |
  <a href=\"#attivitaa\">Attività</a>
</h4>
";

?>
<div class="all-wrapper">
  <div class="row">
    <div class="col-md-2">
<?require "inc_menu_sx.php"?>
    </div>
    <div class="col-md-10">

      <div class="content-wrapper">
        <div class="content-inner <?=$content_inner_class?>">
          <div class="page-header <?=$page_header_class?>">
            <?require "inc_menu_oriz.php"?>
            <h1><i class="icon-group"></i> </h1>
          </div>
          <ol class="breadcrumb">
            <li class="active">Home</li>
          </ol>
          <div class="main-content">

            <div class="row text-center">
<?
for($i=2016;$i<=date("Y");$i++)
{
?>
            <button onclick="document.location.href='home.php?anno=<?=$i?>';return false" class="btn btn-<?=$i==$anno?"success":"default"?>"><?=$i?></button>
<?
}
?>
            </div>

            <div class="widget">
              <a name="evasioni"></a>
              <?=$menu_int?>

              <div class="widget-content-white glossed">
                <div class="padded">

                  <h3 class="form-title form-title-first">Evasioni</h3>

                <div class="row">
                  <div class="padded">
                  <a name="tbl_evasioni"></a>
                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Ordine</th>
                        <th>Evaso</th>
                        <th>Rimanenza</th>
                        <th>Note</th>
                        <th>Inserito da</th>
                      </tr>
                    </thead>
                    <tbody>
<?
$importo_tot = 0;
$importo_rimanenza_tot = 0;
$importo_evaso_tot = 0;

$query = "
SELECT E.id, E.data_emissione, E.importo, E.note,
       E.data_inserimento, E.id_inserimento,
       O.codice, O.importo,
       C.id, C.ragione_sociale
FROM evasione E
  INNER JOIN ordine_evasione OE ON OE.id_evasione = E.id
  INNER JOIN ordine O ON O.id = OE.id_ordine
  INNER JOIN cliente C ON C.id = O.id_cliente
WHERE 1
  AND YEAR(E.data_emissione) = '$anno'
ORDER BY E.id DESC
";
$result = doQuery($query);
while (list($id_evasione_t,
            $data_emissione_t, $importo_t, $note_t,
            $data_inserimento_t, $id_inserimento_t,
            $ordine_codice_t, $ordine_importo_t,
            $id_cliente_t, $ragione_sociale_t) = mysqli_fetch_array($result))
{
  $importo_rimanenza_t = $ordine_importo_t-$importo_t;
?>
                      <tr id="tr_eva_<?=$id_evasione_t?>">
                        <td class="text-center" nowrap>
                          <a href="cliente.php?id_cliente=<?=$id_cliente_t?>#evasioni"><?=$ragione_sociale_t?></a>
                        </td>
                        <td>
                          <?=giraData($data_emissione_t, "out")?>
                        </td>
                        <td>
                          <?=$ordine_codice_t?>
                        </td>
                        <td align="right">
                          <?=soldi($importo_t)?>
                        </td>
                        <td align="right">
                          <?=soldi($importo_rimanenza_t)?>
                        </td>
                        <td style="font-size:10px">
                          <?=nl2br($note_t)?>
                        </td>
                        <td style="font-size:10px">
                          <?=$data_inserimento_t?>
                          <br />
                          <?=getUtente($id_inserimento_t)?>
                        </td>
                      </tr>
<?
  $importo_tot += $importo_t;
  $importo_rimanenza_tot += $importo_rimanenza_t;
}
?>
                      <tr>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                         </td>
                        <td align="right" style="font-size:16px">
                          <strong><?=soldi($importo_tot)?></strong>
                        </td>
                        <td align="right" style="font-size:16px">
                          <strong><?=soldi($importo_rimanenza_tot)?></strong>
                        </td>
                        <td>

                        </td>
                        <td>

                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                </div>
             </div>
           </div>
         </div>


            <div class="widget">
              <a name="ordini"></a>
              <?=$menu_int?>

              <div class="widget-content-white glossed">
                <div class="padded">

                  <h3 class="form-title form-title-first">Ordini</h3>

                <div class="row">
                  <div class="padded">
                  <a name="tbl_ordini"></a>
                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>Cliente</th>
                        <th>Forn/Codice</th>
                        <th>Data</th>
                        <th>Importo</th>
                        <th>Rimanenza</th>
                        <th>Preventivo</th>
                        <th>Evasioni</th>
                        <th>Descrizione</th>
                        <th>Note</th>
                        <th>Inserito da</th>
                      </tr>
                    </thead>
                    <tbody>
<?
$importo_tot = 0;
$importo_rimanenza_tot = 0;
$importo_evaso_tot = 0;

$query = "
SELECT O.id, O.id_fornitore,
       O.codice, O.data_emissione, O.importo, O.allegato, O.descrizione, O.note,
       O.data_inserimento, O.id_inserimento,
       C.id, C.ragione_sociale
FROM ordine O
  INNER JOIN cliente C ON C.id = O.id_cliente
WHERE 1
  AND YEAR(O.data_emissione) = '$anno'
ORDER BY O.id DESC
";
$result = doQuery($query);
while (list($id_ordine_t, $id_fornitore_t,
            $codice_t, $data_emissione_t, $importo_t, $allegato_t, $descrizione_t, $note_t,
            $data_inserimento_t, $id_inserimento_t,
            $id_cliente_t, $ragione_sociale_t) = mysqli_fetch_array($result))
{
  if ($allegato_t)
  {
    $allegato_t = "
    <i class=\"icon-cloud-download\"></i>
    <a href=\"".BASE_URL."upload/$id_cliente/ordini/$allegato_t\" onclick=\"window.open(this.href);return false;\">scarica</a>
    <br />
    [".getDim(BASE_PATH."upload/$id_cliente/ordini/$allegato_t")."]
    ";
  }

  # preventivi collegate
  $importo_preventivo_t = 0;
  $html_preventivi_t = "";
  $query = "
  SELECT P.id, P.codice, P.importo
  FROM preventivo P
    INNER JOIN preventivo_ordine PO ON PO.id_preventivo = P.id
  WHERE 1
    AND PO.id_ordine = '$id_ordine_t'
  -- GROUP BY P.id
  ";
  $result_p = doQuery($query);
  while (list($id_preventivo_t, $codice_preventivo_t, $importo_preventivo_t) = mysqli_fetch_array($result_p))
  {
    $importo_preventivo_t += $importo_t;
    $html_preventivi_t .= "$codice_preventivo_t: <strong>$importo_preventivo_t</strong><br />";
  }

  # evasioni collegate
  $importo_evaso_t = 0;
  $html_evasioni_t = "";
  $query = "
  SELECT E.id, E.importo, E.data_emissione
  FROM evasione E
    INNER JOIN ordine_evasione OE ON OE.id_evasione = E.id
  WHERE 1
    AND OE.id_ordine = '$id_ordine_t'
  ";
  $result_p = doQuery($query);
  while (list($id_evasione_t, $importo_evasione_t, $data_emissione_evasione_t) = mysqli_fetch_array($result_p))
  {
    $importo_evaso_t += $importo_evasione_t;
    $html_evasioni_t .= giraData($data_emissione_evasione_t, "out").": <strong>$importo_evasione_t</strong><br />";
  }
  $importo_rimanenza_t = $importo_t-$importo_evaso_t;
?>
                      <tr id="tr_ord_<?=$id_ordine_t?>">
                        <td class="text-center" nowrap>
                          <a href="cliente.php?id_cliente=<?=$id_cliente_t?>#ordini"><?=$ragione_sociale_t?></a>
                        </td>
                        <td nowrap>
                          <strong><?=$id_fornitore_t==1?"Mobili d'Arte":"Atelier"?></strong>
                          <br />
                          <?=$codice_t?>
                          <br />
                          <?=$allegato_t?>
                        </td>
                        <td>
                          <?=giraData($data_emissione_t, "out")?>
                        </td>
                        <td align="right">
                          <?=soldi($importo_t)?>
                        </td>
                        <td align="right">
                          <?=soldi($importo_rimanenza_t)?>
                        </td>
                        <td align="right" nowrap  style="font-size:10px">
                          <?=$html_preventivi_t?>
                        </td>
                        <td align="right" nowrap  style="font-size:10px">
                          <?=$html_evasioni_t?>
                        </td>
                        <td style="font-size:10px">
                          <?=nl2br($descrizione_t)?>
                        </td>
                        <td style="font-size:10px">
                          <?=nl2br($note_t)?>
                        </td>
                        <td style="font-size:10px">
                          <?=$data_inserimento_t?>
                          <br />
                          <?=getUtente($id_inserimento_t)?>
                        </td>
                      </tr>
<?
  $importo_tot += $importo_t;
  $importo_rimanenza_tot += $importo_rimanenza_t;
  $importo_evaso_tot += $importo_evaso_t;
}
?>
                      <tr>
                        <td class="text-center" nowrap>

                        </td>
                        <td>

                        </td>
                        <td>

                         </td>
                        <td align="right" style="font-size:16px">
                          <strong><?=soldi($importo_tot)?></strong>
                        </td>
                        <td align="right" style="font-size:16px">
                          <strong><?=soldi($importo_rimanenza_tot)?></strong>
                        </td>
                        <td>

                        </td>
                        <td align="right" style="font-size:16px">
                          <strong><?=soldi($importo_evaso_tot)?></strong>
                        </td>
                        <td>

                        </td>
                        <td style="font-size:10px">

                        </td>
                        <td style="font-size:10px">

                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                </div>

             </div>
           </div>
         </div>

<hr />

            <div class="widget">
              <a name="preventivi"></a>
              <?=$menu_int?>

              <div class="widget-content-white glossed">
                <div class="padded">

                  <h3 class="form-title form-title-first">Preventivi</h3>

                <div class="row">
                  <div class="padded">
                  <a name="tbl_preventivi"></a>
                  <table class="table table-striped table-bordered table-hover datatable">
                    <thead>
                      <tr>
                        <th>Cliente</th>
                        <th>Codice</th>
                        <th>Data</th>
                        <th>Importo</th>
                        <th>Rimanenza</th>
                        <th>Ordini</th>
                        <th>Allegato</th>
                        <th>Note</th>
                        <th>Inserito da</th>
                      </tr>
                    </thead>
                    <tbody>
<?
$importo_tot = 0;
$importo_rimanenza_tot = 0;
$importo_evaso_tot = 0;

$query = "
SELECT P.id,
       P.codice, P.data_emissione, P.importo, P.allegato, P.note,
       P.data_inserimento, P.id_inserimento,
       C.id, C.ragione_sociale
FROM preventivo P
  INNER JOIN cliente C ON C.id = P.id_cliente
WHERE 1
  AND YEAR(P.data_emissione) = '$anno'
ORDER BY P.id DESC
";
$result = doQuery($query);
while (list($id_preventivo_t,
            $codice_t, $data_emissione_t, $importo_t, $allegato_t, $note_t,
            $data_inserimento_t, $id_inserimento_t,
            $id_cliente_t, $ragione_sociale_t) = mysqli_fetch_array($result))
{
  if ($allegato_t)
  {
    $allegato_t = "
    <i class=\"icon-cloud-download\"></i>
    <a href=\"".BASE_URL."upload/$id_cliente/preventivi/$allegato_t\" onclick=\"window.open(this.href);return false;\">scarica</a>
    <br />
    [".getDim(BASE_PATH."upload/$id_cliente/preventivi/$allegato_t")."]
    ";
  }

  # ordini collegati
  $importo_evaso_t = 0;
  $html_ordini_t = "";
  $query = "
  SELECT O.id, O.codice, O.importo
  FROM ordine O
    INNER JOIN preventivo_ordine PO ON PO.id_ordine = O.id
  WHERE 1
    AND PO.id_preventivo = '$id_preventivo_t'
  ";
  $result_p = doQuery($query);
  while (list($id_ordine_t, $codice_ordine_t, $importo_ordine_t) = mysqli_fetch_array($result_p))
  {
    $importo_evaso_t += $importo_ordine_t;
    $html_ordini_t .= "$codice_ordine_t: <strong>$importo_ordine_t</strong><br />";
  }
  $importo_rimanenza_t = $importo_t-$importo_evaso_t;
?>
                      <tr id="tr_prev_<?=$id_preventivo_t?>">
                        <td class="text-center" nowrap>
                          <a href="cliente.php?id_cliente=<?=$id_cliente_t?>#preventivi"><?=$ragione_sociale_t?></a>
                        </td>
                        <td>
                          <?=$codice_t?>
                        </td>
                        <td>
                          <?=giraData($data_emissione_t, "out")?>
                        </td>
                        <td align="right">
                          <?=soldi($importo_t)?>
                        </td>
                        <td align="right">
                          <?=soldi($importo_rimanenza_t)?>
                        </td>
                        <td align="right" nowrap  style="font-size:10px">
                          <?=$html_ordini_t?>
                        </td>
                        <td>
                          <?=$allegato_t?>
                        </td>
                        <td style="font-size:10px">
                          <?=nl2br($note_t)?>
                        </td>
                        <td style="font-size:10px">
                          <?=$data_inserimento_t?>
                          <br />
                          <?=getUtente($id_inserimento_t)?>
                        </td>
                      </tr>
<?
  $importo_tot += $importo_t;
  $importo_rimanenza_tot += $importo_rimanenza_t;
  $importo_evaso_tot += $importo_evaso_t;
}
?>
                      <tr>
                        <td>

                        </td>
                        <td>

                        </td>
                        <td>

                         </td>
                        <td align="right" style="font-size:16px">
                          <strong><?=soldi($importo_tot)?></strong>
                        </td>
                        <td align="right" style="font-size:16px">
                          <strong><?=soldi($importo_rimanenza_tot)?></strong>
                        </td>
                        <td align="right" style="font-size:16px">
                          <strong><?=soldi($importo_evaso_tot)?></strong>
                        </td>
                        <td>

                        </td>
                        <td style="font-size:10px">

                        </td>
                        <td style="font-size:10px">

                        </td>
                      </tr>
                    </tbody>
                  </table>
                  </div>
                </div>

             </div>
           </div>
         </div>

<hr />



            <div class="widget">
              <a name="attivitaa"></a>
              <?=$menu_int?>

              <div class="widget-content-white glossed">
                <div class="padded">
                  <h3 class="form-title form-title-first">Attività</h3>
                <div class="row">
                  <div class="padded">
                  <a name="tbl_attivita"></a>
                  </div>
                </div>

             </div>
           </div>
         </div>



      </div>
    </div>
  </div>
</div>

<?require "inc_footer.php"?>
