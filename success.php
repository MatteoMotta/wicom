<?php

require "inc_config.php";

if (isset($_REQUEST['id_allegato']))
 $id_allegato = mysqli_real_escape_string($link,$_REQUEST['id_allegato']);
else
 $id_allegato = "";

$query = "
			SELECT A.id, AC.id_acc, CE.id_ctrl, M.id_motivo, IP.id_prec, SC.id_scheda
			FROM allegati AL
			inner join attivita A on A.id = AL.id_att
			LEFT OUTER JOIN accettazione AC on AC.id_att = A.id
			LEFT OUTER JOIN controllo_estetico CE on CE.id_att = A.id
			LEFT OUTER JOIN motivo M on M.id_att = A.id
			LEFT OUTER JOIN intervento_precedente IP on IP.id_att = A.id
			LEFT OUTER JOIN scheda_lavorazione SC on SC.id_att = A.id
			where AL.id = '$id_allegato'

			";
			$result = doQuery($query);
			list($attivita_id_attivita_t, $id_acc_t, $id_ctrl_t, $id_motivo_t, $id_prec_t, $id_scheda_t)= mysqli_fetch_array($result);
?>

<html><head><title>redirect</title></head>
<body><!--i give you header to know this is will give error header or not-->
<?php
echo "<p>Your upload is success</p>";   
echo "<p>You will redirect back</p>";
echo "<p><a href=\"attivita.php?attivita_id_attivita=".$attivita_id_attivita_t."&id_acc=".$id_acc_t."&id_ctrl=".$id_ctrl_t."&id_motivo".$id_motivo_t."&id_prec=".$id_prec_t."&id_scheda=".$id_scheda_t\">or press this to redirect directly</a></p>";
?>
<script>
setTimeout(function () {
       window.location.href = "attivita.php?attivita_id_attivita=".$attivita_id_attivita_t."&id_acc=".$id_acc_t."&id_ctrl=".$id_ctrl_t."&id_motivo".$id_motivo_t."&id_prec=".$id_prec_t."&id_scheda=".$id_scheda_t"; 
    }, 3000);

</script>
</body></html>
