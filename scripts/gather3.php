<?
require("phpsqlajax_dbinfo.php");

$con = mysqli_connect(localhost, $username, $password);
if(mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

mysqli_select_db($con, "triposal");

$result = mysqli_query($con,"SELECT temp.city, temp.state FROM temp;");

$i = 0;

while($row = mysqli_fetch_array($result)) {
  $temp = $row['city'] . ",+" . $row['state']; //prepping syntax for api call
  $sqlNameAcc[$i] = $row['city']; //stored for later sql insert function
  
  $tempName = str_replace(" ", "+", $temp); // prepping syntax for api call
  $nameAcc[$i] = $tempName;
  
  $i++;
  }

$c = 0;
$i = 0;
foreach($nameAcc as $locName) {
  $fullurl = "http://maps.googleapis.com/maps/api/geocode/json?address=";
  $fullurl = $fullurl . $locName . "&sensor=true";
  $string = file_get_contents($fullurl); // get json content
  $json_a = json_decode($string, true); //json decoder

  $lat = $json_a['results'][0]['geometry']['location']['lat']; // get lat for json
  $lon = $json_a['results'][0]['geometry']['location']['lng']; // get ing for json
  //print $lat . ", " . $lon . "\n";
  //print $sqlNameAcc[$i];
  $sql= "UPDATE city
  SET lat = '$lat', lon='$lon'
  WHERE city.cityName = '$sqlNameAcc[$i]';";
  if (!mysqli_query($con, $sql)) {
    die('Error: ' . mysqli_error($con) . "\n");
  }
  echo "1 record added.\n";
  
  $c++;
  $i++;
  if($c == 9) { // GoogleMap API timeout on 10 or more requests in 1-2 seconds
    sleep(5); // because of this limitation, sleep for 5 seconds after every 9 calls
    $c = 0; // set counter back to 0
  }
}
mysqli_close($con);
?>