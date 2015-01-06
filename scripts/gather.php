<?
function getCities(){

$files = scandir('categories/');
$dir = 'categories/';
$arr = array();

foreach ($files as $fileName) {
	foreach (file($dir.$fileName, FILE_IGNORE_NEW_LINES) as $city) {
		array_push($arr, $city);
		//echo($city);
		}
	//echo "\n";
	}
$arr = array_unique($arr);
$arr = array_values($arr);
sort($arr);
//var_dump($arr);
return $arr;
}


function writeFile($aArray){

$filename = 'loc.txt';
$f = @fopen($filename,'w+');
if ($f) {
	$lines = implode("\n",$aArray);
	fwrite($f, $lines);
	fclose($f);
	}
}

writeFile(getCities());

?>