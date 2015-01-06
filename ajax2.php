<?php  

require("scripts/phpsqlajax_dbinfo.php"); 

// Opens a connection to a MySQL server
$connection = mysqli_connect ('localhost', $username, $password, $database) or die("Error " . mysqli_error($connection));

/////////////////////////////////////////////////////////////////////
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);

print_r($postdata);
$activities = $request->activitiesDoor;

$initDate = (!empty($_GET["initDate"]) ? $_GET["initDate"] : null);
$finalDate = (!empty($_GET["finalDate"]) ? $_GET["finalDate"] : null);
$weather = (!empty($_GET["weatherRad"]) ? $_GET["weatherRad"] : null);

function weatherToSQL($weather) {
  if($weather == 1) {
    $weatherQ = "(temp < 0)";
    return $weatherQ;
  }
  elseif($weather == 2) {
    $weatherQ = "(temp >= 0 and temp <= 24)";
    return $weatherQ;
  }
  elseif($weather == 3) {
    $weatherQ = "(temp >= 25 and temp <= 49)";
    return $weatherQ;
  }
  elseif($weather == 4) {
    $weatherQ = "(temp >= 50 and temp <= 74)";
    return $weatherQ;
  }
  elseif($weather == 5) {
    $weatherQ = "(temp >= 75 and temp <= 95)";
    return $weatherQ;
  }  
  elseif($weather == 6) {
    $weatherQ = "(temp >= 96)";
    return $weatherQ;
  }
  else {
    throw new Exception('Error. Weather scope out of bounds.');
  }
}

function datePrep($date) { //Converts HTML Form Date to just month numeral.
  $date = strtotime($date);
  $month = date("n", $date);
  if($month % 2 == 0) { //Needed for prep for compatible data month date (only have odd months)
    $month = --$month;
  }
  return $month;
}
  
/////////////////////////////////////////////////////////////////////
$c = 1;
$query = "SELECT c.* FROM city c ";  // Select all the rows in the city table

try {
  if(!isset($activities) && !isset($initDate) && !isset($finalDate) && !isset($weather)) {
    throw new Exception('Error. No options are filled out.');
  } // No options filled out
  
  else if(isset($activities) && !isset($initDate) && !isset($finalDate) && !isset($weather)) {   
    foreach($activities as $activity) {
      $queryPrep =
      "JOIN city_activity ca# ON ca#.cityId = c.cityId 
      JOIN activity a# ON ca#.activityId = a#.activityId AND a#.activityName = " . "'" . $activity . "' ";
      $queryAcc = str_replace("#", $c, $queryPrep);
      $query .= $queryAcc;
      $c++;
    } // Just activites filled out
    $query .= ";";
  }
  else if(!isset($activities) && isset($initDate) && isset($finalDate) && isset($weather)) {
    $month = datePrep($initDate);
    $weatherQ = weatherToSQL($weather);
    $query .= "JOIN forecast f ON f.cityId = c.cityId WHERE month = $month AND $weatherQ;";
  } // No activities filled out
  else if(isset($activities) && isset($initDate) && isset($finalDate) && isset($weather)) {
    $month = datePrep($initDate);
    $weatherQ = weatherToSQL($weather);
    foreach($activities as $activity) {
      $queryPrep =
        "JOIN city_activity ca# ON ca#.cityId = c.cityId
        JOIN activity a# ON ca#.activityId = a#.activityId AND a#.activityName = " . "'" . $activity . "' ";
      $queryAcc = str_replace("#", $c, $queryPrep);
      $query .= $queryAcc;
      $c++;
    }
    $query .= "JOIN forecast f ON f.cityId = c.cityId WHERE month = $month AND $weatherQ;";

  } // All options filled out
  else {
    throw new Exception('Error. Invalid use of parameters.');
  }

/////////////////////////////////////////////////////////////////////
  $query .= mysqli_error($connection);
  $fetch = $connection->query($query);
  $data = array(); // return array

  $cityId = array(); $cityName = array(); $lat = array(); $lon = array();

  while ($row = mysqli_fetch_array($fetch)) {
    $row_array["cityId"] = $row["cityId"];
    $row_array["cityName"] = $row["cityName"];
    $row_array["lat"] = $row["lat"];
    $row_array["lon"] = $row["lon"];

    array_push ($data, $row_array);
  }

  echo json_encode($data);

}
catch (Exception $e) {
  print $e->getMessage();
}

?>