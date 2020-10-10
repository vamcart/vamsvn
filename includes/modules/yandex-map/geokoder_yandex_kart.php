<?php
 
set_time_limit(30);

######## Геокодирование #########
 

/* if ($_SESSION['pvz'] != '') {

$query = "SELECT id, city, address, lat, lng FROM markers_geocod";
$result = vam_db_query($query);
if (!$result) {
  die("ошибка запроса: " . mysql_error());
}
 

$delay = 0;
$base_url = "https://geocode-maps.yandex.ru/1.x/?geocode=";


while ($row = vam_db_fetch_array($result)) {

if ($row['lat'] == '') {
$adress = 'город ' . $row["city"] . ', ' . $row["address"];
$exp_str1 = explode(",", $adress);
$address = implode($exp_str1, ", ");

$id = $row["id"];
$request_url = $base_url . urlencode($address);

$ch = curl_init($request_url);
$fp = fopen("includes/modules/yandex-map/geokoder_yandex_address.txt", "w+");

curl_setopt($ch, CURLOPT_FILE, $fp);
curl_setopt($ch, CURLOPT_HEADER, 0);
 
curl_exec($ch);
curl_close($ch);
fclose($fp);
 
	$lines = file("includes/modules/yandex-map/geokoder_yandex_address.txt");
 
	if($lines[5] == '<ygeo:request>несуществующая улица</ygeo:request>'){
//	echo 'адрес: ', $row["address"], ' ', 'не найден', '<br><br>';
	}
	else
	{
	foreach ($lines as $line_num => $line)
	{
 
if(strpos($line, "<pos>")!= FALSE) {
//  echo "Строка #<b>{$line_num}</b> : " . htmlspecialchars($line) . "<br>";
 
	$line = trim ($line);
 
	$coord = substr($line, 5, -6);
 
//	echo $coord;
 
	$newcoord = explode(" ", $coord);
 
	$lat1 = $newcoord[1];
	$lng1 = $newcoord[0];
//	echo '<br><br>';
 
	$query = "UPDATE markers_geocod " .
             " SET lat = '".$lat1."', lng = '".$lng1."' " .
             " WHERE id = '".$id."' LIMIT 1";
			 
      $update_result = vam_db_query($query);
      if (!$update_result) {
        die("Ошибка подключения к базе: " . mysql_error());
		}
 
	}	
} 
}
}
}
} */




######## Запись координатов в json файл #########

if ($_SESSION['pvz'] != '') {
$result0 = vam_db_query("SELECT city, company, lat, lng FROM markers_geocod where name = '" . $_SESSION['pvz'] . "' ORDER BY lat DESC limit 1");
$row0 = vam_db_fetch_array($result0);

$_SESSION['centr'] = '[' . $row0['lat'] . ', ' . $row0['lng'] . ']';

} else {
unset($_SESSION['centr']);
}

//echo $_SESSION['pvz'];

$result = vam_db_query("SELECT * FROM markers_geocod where city = '" . $row0['city'] . "' and company = '" . $row0['company'] . "'");

// здесь пошла запись json в файл (вначале создание дерева массива)
while ($row = vam_db_fetch_array($result)) {
$id = $row["id"];
$lat1 = $row["lat"];
$lng1 = $row["lng"];
$metka = '[' . $lat1 . ', ' . $lng1 . ']';

$row["address"] = preg_replace('#"(.*?)"#', '«$1»', $row["address"]); // преобразуем кавычки в елочки, чтобы json был валидный (ругается на кавычки)

$t = array(
      "type" => "Feature",
      "id" => $id,
      "geometry" => array(
      "type" => "Point",
      "coordinates" => $metka
    ),
      "properties" => array(
      "balloonContent" => addslashes($row["address"]),
	  "balloonContentBody" => $row["company"] . '. ' . addslashes($row["address"]) . ', ' . $row["telephon"] . ', ' . $row["worktime"],
      "clusterCaption" => "Еще одна метка",
      "hintContent" => $row["company"] . ' - ' . $row["address"] . ', ' . $row["telephon"]
    ));
$tall[] = $t;  
}


$json_adress = json_encode( $tall, JSON_UNESCAPED_UNICODE );
$json_adress = stripcslashes($json_adress);

// убираем кавычки от квадратных скобок (вроде как ошибкой считается - так сказали в поддержке Яндекс.Карт)
$json_adress = htmlspecialchars($json_adress);
$json_adress = str_replace("&quot;[", "[", $json_adress);
$json_adress = str_replace("]&quot;", "]", $json_adress);
$json_adress = htmlspecialchars_decode($json_adress);
$json_adress = '{ "type": "FeatureCollection", "features": ' . $json_adress . '}';

// и сама запись файл (предварительно очистка)

file_put_contents('includes/modules/yandex-map/data.json', '');
$file = fopen ("includes/modules/yandex-map/data.json","r+");
  $str = $json_adress;
  if ( !$file )
  {
    echo("Ошибка открытия файла");
  }
  else
  {
    fputs ( $file, $str);
  }
  fclose ($file);
  
//}

?>