<?
require("phpsqlajax_dbinfo.php");

$con = mysqli_connect(localhost, $username, $password);
if(mysqli_connect_errno()) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
mysqli_select_db($con, "triposal");

$files = scandir('categories/');
$dir = 'categories/';
$arr = array();

foreach ($files as $fileName) {
  $actName = str_replace(".txt", "", $fileName);
	foreach (file($dir.$fileName, FILE_IGNORE_NEW_LINES) as $city) {
	  $text = explode(",", $city);
      $text[0] = trim($text[0]);
  
      $sql= "INSERT INTO city_activity
      (cityId, activityId)
      SELECT city.cityId, activity.activityId
      FROM city
      INNER JOIN activity ON city.cityName = '$text[0]'
      && activity.activityName = '$actName';";
      
      if (!mysqli_query($con, $sql)) {
        die('Error: ' . mysqli_error($con) . "\n");
      }
      echo "1 record added.\n";
  }
}

mysqli_close($con);
?>