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
    <!-- <img src="<?=BASE_URL?>img/logo.png"> -->
    <span><?=SITE_NAME?></span>
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
      <li class="<?=($pagename=="cliente.php" or $pagename=="clienti.php")?"current":""?>">
        <a class='<?=($pagename=="cliente.php" or $pagename=="clienti.php")?"current":""?>' href="clienti.php">
          <i class="icon-group"></i> Clienti
          <span class="badge pull-right"><?=$cnt_clienti?></span>
        </a>
      </li>


    </ul>
  </div>

<?if (isAdmin()){?>
  <div class="relative-w">
    <ul class="side-menu <?=$side_menu_class?>">



    </ul>
  </div>
  <div class="relative-w">
    <ul class="side-menu <?=$side_menu_class?>">
      <li class='<?=(substr($pagename,0,5)=="stats")?"current":""?>'>
        <a class='<?=(substr($pagename,0,5)=="stats")?"current":""?> is-dropdown-menu' href="#" >
          <i class="icon-bar-chart"></i> Statistiche
        </a>
        <ul>

          <li class='<?=($pagename=="stats_attivita.php")?"current":""?>'>
            <a href="stats_attivita.php">
              Attività
            </a>
          </li>

        </ul>
      </li>
    </ul>

  </div>

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
<?}else{?>
  <div class="relative-w">
    <ul class="side-menu <?=$side_menu_class?>">
      <li class='<?=(substr($pagename,0,5)=="stats")?"current":""?>'>
        <a class='<?=(substr($pagename,0,5)=="stats")?"current":""?> is-dropdown-menu' href="#" >
          <i class="icon-bar-chart"></i> Statistiche
        </a>
        <ul>

          <li class='<?=($pagename=="stats_attivita_cina.php")?"current":""?>'>
            <a href="stats_attivita_cina.php">
              Attività
            </a>
          </li>
        </ul>
      </li>
    </ul>

  </div>
<?}?>


</div>