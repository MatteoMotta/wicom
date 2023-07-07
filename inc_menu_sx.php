<?
$working = "onclick=\"alert('working');return false\" style=\"color:red\"";

$query = "
SELECT COUNT(id)
FROM utente
WHERE 1
  AND id > 1
";
$result = doQuery($query);
list($cnt_utenti)= mysqli_fetch_array($result);





$w_nazione = (isCopywriter() and $_SESSION["sess_nazioni_str"])?" AND id_nazione IN (".$_SESSION["sess_nazioni_str"].") ":"";
$query = "
SELECT COUNT(codice_articolo)
FROM articoli
WHERE 1
";
$result = doQuery($query);
list($cnt_articoli)= mysqli_fetch_array($result);

$query = "
SELECT COUNT(id)
FROM ticket
WHERE 1
AND id_utente = '".$_SESSION["sess_id_utente"]."'
";
$result = doQuery($query);
list($cnt_ticket)= mysqli_fetch_array($result);


$query = "
SELECT COUNT(codice_articolo)
FROM articoli
WHERE 1
";
$result = doQuery($query);
list($cnt_articoli)= mysqli_fetch_array($result);

$query = "
SELECT COUNT(id)
FROM offerta
WHERE 1
";
$result = doQuery($query);
list($cnt_offerte)= mysqli_fetch_array($result);

$query = "
SELECT COUNT(id)
FROM cliente
WHERE 1
";
$result = doQuery($query);
list($cnt_clienti)= mysqli_fetch_array($result);




$query = "
SELECT COUNT(id)
FROM cliente
WHERE 1
";
$result = doQuery($query);
list($cnt_cliente)= mysqli_fetch_array($result);

?>


<div class="text-center">
  <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
  </button>
</div>
<div class="side-bar-wrapper collapse navbar-collapse navbar-ex1-collapse">
  <a href="home.php" class="logo hidden-sm hidden-xs">
    <img src="<?=BASE_URL?>img/logo-wicom.png"> 
    <p>
      <?=$_SESSION["sess_utente"]?>
      <!--
      <br />
      <?=$arr_livello[$_SESSION["sess_livello"]]?>
      -->
     </p>
  </a>

  <ul class="side-menu <?=$side_menu_class?>">
    <li>
      <a href="home.php">
        <i class="icon-home"></i> Home
      </a>
    </li>
  </ul>



  <div class="relative-w">
    <ul class="side-menu <?=$side_menu_class?>">

	  
	

	  
	  <li class="<?=($pagename=="ticket.php" or $pagename=="tickets.php")?"current":""?>">
        <a class='<?=($pagename=="ticket.php" or $pagename=="tickets.php")?"current":""?>' href="tickets.php">
          <i class="icon-file"></i> Attività
          <span class="badge pull-right"><?=$cnt_ticket?></span>
        </a>
      </li>
	  
      <li class="<?=($pagename=="articolo.php" or $pagename=="articoli.php")?"current":""?>">	
	    <a class='<?=($pagename=="articoli.php" or $pagename=="articoli.php")?"current":""?>' href="articoli.php?valido=1">
          <i class="icon-briefcase"></i> Articoli
          <span class="badge pull-right"><?=$cnt_articoli?></span>
        </a>	
      </li>	
	  
	  <li class="<?=($pagename=="offerta.php" or $pagename=="offerte.php")?"current":""?>">	
	    <a class='<?=($pagename=="offerte.php" or $pagename=="offerte.php")?"current":""?>' href="offerte.php">
          <i class="icon-folder-close"></i> Offerte
          <span class="badge pull-right"><?=$cnt_offerte?></span>
        </a>	
      </li>	
	  
	  <li class="<?=($pagename=="cliente.php" or $pagename=="clienti.php")?"current":""?>">	
	    <a class='<?=($pagename=="clienti.php" or $pagename=="clienti.php")?"current":""?>' href="clienti.php?valido=1">
          <i class="icon-group"></i> Clienti
          <span class="badge pull-right"><?=$cnt_clienti?></span>
        </a>	
      </li>	

  


	  

		
    </ul>
  </div>

<?if (isAdmin()){?>
  
  <div class="relative-w">
    <ul class="side-menu <?=$side_menu_class?>">
      <li class="<?=($pagename=="utente.php" or $pagename=="utenti.php" )?"current":""?>">
        <a href="utenti.php">
          <i class="icon-user"></i> Utenti
          <span class="badge pull-right"><?=$cnt_utenti?></span>
        </a>
      </li>
    </ul>
  </div>
<?}?>



</div>