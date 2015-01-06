<?
function actIntersect($aArray) {
	if(!empty($aArray)) {
		$i = 0;
		foreach($aArray as $chkval) {
		$actArray[$i] = file("categories/" . $chkval . ".txt");
		$i++;
		}
		$result = call_user_func_array('array_intersect',$actArray);
		print_r($result);
		//return $result;
	}
	else {
		throw new Exception('Error. No Options Filled Out');
	}
}
?>