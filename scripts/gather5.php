<?php
require("phpsqlajax_dbinfo.php");

$con = mysqli_connect('localhost', $username, $password);
if(mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

mysqli_select_db($con, "triposal");

$result = mysqli_query($con,"SELECT city.cityName, state.stateName
FROM city INNER JOIN state
ON state.stateId = city.stateId
WHERE state.countryId = 1;");

$i = 0;

while($row = mysqli_fetch_array($result)) {
  $temp = $row['stateName'] . '/' . $row['cityName'] . '.json'; //prepping syntax for api call
  $sqlNameAcc[$i] = $row['cityName']; //stored for later sql insert function

  $tempName = str_replace(" ", "_", $temp); // prepping syntax for api call
  $nameAcc[$i] = $tempName;
  $i++;
  }
////////////////////////////////
$c = 0;
$monArray = array(8,10,12);
////////////////////////////////
foreach($monArray as $month) {
  $i = 0;
	foreach($nameAcc as $locName) {
	  $fullurl = "http://api.wunderground.com/api/50cb641dd2418c4d/planner_0".$month."010".$month."30/q/";
	  $fullurl = $fullurl . $locName;
	  $string = file_get_contents($fullurl); // get json content
	  $json_a = json_decode($string, true); //json decoder

	  $temp = $json_a['trip']['temp_high']['avg']['F']; // get temp from json
	  //print $temp."\n";
	  //print $sqlNameAcc[$i];

	  $sql= "INSERT INTO forecast
		  (cityId, temp, month)
		  SELECT city.cityId, '$temp', '$month'
		  FROM city
		  WHERE city.cityName = '$sqlNameAcc[$i]';";
  
	  if (!mysqli_query($con, $sql)) {
		die('Error: ' . mysqli_error($con) . "\n");
	  }
	  
	  $count = 231 - $c;
	  echo $count ." record(s) to be added.\n";
	  $c++;
	  $i++;
  }
}
	
mysqli_close($con);
?>
