<?
require("phpsqlajax_dbinfo.php");

$con = mysqli_connect(localhost, $username, $password);
if(!$con) {
    die("Could not connect: " . mysql_error());
    }

mysql_select_db("triposal", $con);

$cities = file('loc.txt', FILE_IGNORE_NEW_LINES);

foreach($cities as $city) {
	$text = explode(",", $city);
	$text[0] = trim($text[0]);
	$text[1] = trim($text[1]);
	$text[2] = trim($text[2]);

        else {
         $text[2] = 2;
        }
	//mysql_query("INSERT INTO temp (city, state, country)
	//	VALUES ('$text[0]','$text[1]','$text[2]')");
	mysql_query("INSERT INTO state (stateName, countryId)
		VALUES ('$text[1]', '$text[2]')");
}

mysql_close($con);

?>