<?
require "../../../inc_config.php";

# mappa
$i = 0;
$arr_map = array();
$query = "
SELECT P.id, P.id_type, P.id_user_fe,
       P.address, P.id_country,
       P.latitude, P.longitude
FROM property P
WHERE 1
  AND C.latitude <> 0
  AND C.longitude <> 0
  -- loggati
  -- AND C.last_login IS NOT NULL
  -- attivi
  AND C.approvato = 1
-- LIMIT 1900, 100
GROUP BY C.id
";
$result = doQuery($query);
while (list($id_t, $ragione_sociale_t, $indirizzo_t,
            $nazione_t, $provincia_t, $comune_t,
            $latitude_t, $longitude_t) = mysqli_fetch_array($result))
{
  $ragione_sociale_t = str_replace("&", " e ", $ragione_sociale_t);
  #$ragione_sociale_t = iconv("UTF-8","UTF-8//IGNORE", trim($ragione_sociale_t));
  #mb_convert_encoding($ragione_sociale_t, 'UTF-8', 'UTF-8');
  #$ragione_sociale_t = html_entity_decode($ragione_sociale_t);
  $ragione_sociale_t = str_replace("/", " ", $ragione_sociale_t);
  $ragione_sociale_t = str_replace("\t", " ", $ragione_sociale_t);

  $nazione_t = iconv("UTF-8","UTF-8//IGNORE", trim($nazione_t));
  #mb_convert_encoding($nazione_t, 'UTF-8', 'UTF-8');
  #$nazione_t = html_entity_decode($nazione_t);
  $nazione_t = str_replace("/", " ", $nazione_t);

  $provincia_t = iconv("UTF-8","UTF-8//IGNORE", trim($provincia_t));
  #mb_convert_encoding($provincia_t, 'UTF-8', 'UTF-8');
  #$provincia_t = html_entity_decode($provincia_t);
  $provincia_t = str_replace("/", " ", $provincia_t);

  $indirizzo_t = iconv("UTF-8","UTF-8//IGNORE", trim($indirizzo_t));
  #mb_convert_encoding($indirizzo_t, 'UTF-8', 'UTF-8');
  #$indirizzo_t = html_entity_decode($indirizzo_t);
  $indirizzo_t = str_replace("/", " ", $indirizzo_t);

  $comune_t = iconv("UTF-8","UTF-8//IGNORE", trim($comune_t));
  #mb_convert_encoding($comune_t, 'UTF-8', 'UTF-8');
  #$comune_t = html_entity_decode($comune_t);
  $comune_t = str_replace("/", " ", $comune_t);

  $arr_map[$i]["id"] = "$id_t";
  $arr_map[$i]["ragione_sociale"] =  str_replace("'"," ",$ragione_sociale_t);
  $arr_map[$i]["nazione"] = str_replace("'"," ",$nazione_t);
  $arr_map[$i]["provincia"] = str_replace("'"," ",$provincia_t);
  $arr_map[$i]["indirizzo"] = str_replace("'"," ",$indirizzo_t);
  $arr_map[$i]["comune"] = str_replace("'"," ",$comune_t);
  $arr_map[$i]["latitude"] = $latitude_t;
  $arr_map[$i]["longitude"] = $longitude_t;

  #single
  if (0)
  {
    $json_t = json_encode(array($arr_map[$i]));
    $json_count_t = 1;
?>
json_<?=$id_t?> = '<?=$json_t?>';
data_<?=$id_t?> = {
  "count": <?=$json_count_t?>,
  "point": JSON.parse(json_<?=$id_t?>),
};
<?
  }
  $i++;
}

$rand_key = array_rand($arr_map);

#print_r($arr_map);


$json = json_encode($arr_map);
$json_count = count($arr_map);

//$json = preg_replace_callback('/[\x{80}-\x{10FFFF}]/u', function ($match) {
//    list($utf8) = $match;
//    $binary = iconv('UTF-8', 'UTF-32BE', $utf8);
//    $entity = vsprintf('&#x%X;', unpack('N', $binary));
//    return $entity;
//}, $json);

#iconv("UTF-8", "CP1252", $json);
#$json = str_replace("\u", "", $json);
?>

json = '<?=$json?>';
data = {
  "count": <?=$json_count?>,
  "point": JSON.parse(json),
};

initialize(data);

function initialize(data) {
  var center = new google.maps.LatLng(<?=$arr_map[$rand_key]["latitude"]?>, <?=$arr_map[$rand_key]["longitude"]?>);

  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 12,
    center: center,
    //mapTypeId: google.maps.MapTypeId.TERRAIN
  });

  google.maps.event.trigger(map, 'resize');

  var bounds = new google.maps.LatLngBounds();

  var markers = [];

  for (var i = 0; i < data.point.length; i++) {
    var dataPoint = data.point[i];
    var latLng = new google.maps.LatLng(dataPoint.latitude, dataPoint.longitude);
    var contentString = '<div style="overflow-y:auto;overflow-x:hidden;width:400px;height:150px">' +
        '<h4>'+data.point[i].ragione_sociale+ '</h4>' +
        ''+data.point[i].indirizzo+''+
        '<br />' +
        ''+data.point[i].comune+' ('+data.point[i].provincia+')'+
        '<br />' +
        '<b>'+data.point[i].nazione+'</b>'+
        '<br /><br />' +
        '<a href="cliente.php?id_cliente='+data.point[i].id+'"><i class="icon-eye-open"></i> vedi</a>' +
        '</div>';

    var marker = new google.maps.Marker({
      position: latLng,
      title: data.point[i].ragione_sociale,
      //icon: icon
    });

    attachInfo(marker,contentString);

    // Extending the bounds object with each LatLng
    bounds.extend(latLng);

    // Adjusting the map to new bounding box
    if (data.count > 1) {
      map.fitBounds(bounds);
    }
    else if (data.count == 1) {
      map.setCenter(bounds.getCenter());
      map.setZoom(10);
    }

    markers.push(marker);
  }

  var markerCluster = new MarkerClusterer(map, markers, {
      maxZoom: 10,
      zoomOnClick: true,
      averageCenter: true
  });

  function addMarker( latitude, longitude, label ){
    var marker = new google.maps.Marker({
    map: map,
    position: new google.maps.LatLng(
    latitude,
    longitude
    ),
    title: (label || "")
    });

    // Return the new marker reference.
    return( marker );
  }


  function attachInfo(marker, contentString)
  {
    var infowindow = new google.maps.InfoWindow({
      content: contentString
      });
    google.maps.event.addListener(marker, 'click', function() {
      infowindow.open(map,marker);
    });
  } // end attachInfo
}