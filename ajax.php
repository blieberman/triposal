<?php  

require("scripts/phpsqlajax_dbinfo.php"); 

// Start XML file, create parent node
$dom = new DOMDocument("1.0");
$node = $dom->createElement("items");
$parnode = $dom->appendChild($node); 

// Opens a connection to a MySQL server
$connection=mysql_connect('localhost', $username, $password);
if (!$connection) {  die('Not connected : ' . mysql_error());} 

// Set the active MySQL database
$db_selected = mysql_select_db($database, $connection);
if (!$db_selected) {
  die ('Can\'t use db : ' . mysql_error());
}

/////////////////////////////////////////////////////////////////////

$initDate = (!empty($_GET["initDate"]) ? $_GET["initDate"] : null);
$finalDate = (!empty($_GET["finalDate"]) ? $_GET["finalDate"] : null);
$activities = (!empty($_GET["activitiesDoor"]) ? $_GET["activitiesDoor"] : null);
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
		//$initDate = strtotime($initDate);
		//$month = date("n", $initDate);
		$weatherQ = weatherToSQL($weather);
		$query .= "JOIN forecast f ON f.cityId = c.cityId WHERE month = $month AND $weatherQ;";
		//print_r($activities);
		//print $_SERVER['QUERY_STRING'];
	} // No activities filled out
	else if(isset($activities) && isset($initDate) && isset($finalDate) && isset($weather)) {
		$month = datePrep($initDate);
	 //$initDate = strtotime($initDate);
	 //$month = date("n", $initDate);
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
	  //print_r($activities);
	  //print $_SERVER['QUERY_STRING'];
	} // All options filled out
	else {
		throw new Exception('Error. Invalid use of parameters.');
	}
//print "\n" . $query;
//}
//catch (Exception $e) {
//	print $e->getMessage();
//}

/////////////////////////////////////////////////////////////////////
	$result = mysql_query($query);
	if (!$result) {  
		die('Invalid query: ' . mysql_error());
	}

	header("Content-type: text/xml"); 

	// Iterate through the rows, adding XML nodes for each
	while ($row = @mysql_fetch_assoc($result)){  
		// ADD TO XML DOCUMENT NODE  
		$node = $dom->createElement("item");  
		$newnode = $parnode->appendChild($node);   
		$newnode->setAttribute("id",$row['cityId']);
		$newnode->setAttribute("name",$row['cityName']);
		$newnode->setAttribute("lat", $row['lat']);  
		$newnode->setAttribute("lon", $row['lon']);
	}

	echo $dom->saveXML();
}
catch (Exception $e) {
	print $e->getMessage();
}
?>
