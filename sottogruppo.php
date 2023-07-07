<?
require "inc_config.php";
require "inc_sicurezza_bo.php";

// Get the user id 
$sottogruppo = $_REQUEST['sottogruppo'];
  
if ($sottogruppo !== "") {
      
    // Get corresponding first name and 
    // last name for that user id    
    $query = mysqli_query($con, "SELECT codice_articolo, 
    descrizione FROM articoli WHERE sottogruppo='$sottogruppo'");
  
    $row = mysqli_fetch_array($query);
  
    // Get the first name
    $codice_articolo = $row["codice_articolo"];
  
    // Get the first name
    $descrizione = $row["descrizione"];
}
  
// Store it in a array
$result = array("$codice_articolo", "$descrizione");
  
// Send in JSON encoded form
$myJSON = json_encode($result);
echo $myJSON;
?>