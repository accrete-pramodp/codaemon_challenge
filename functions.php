<?php 
include("config.php"); 

/*
 * To generate 4 characters as a tiny url
 */
function generate_chars()
{
 $num_chars = 4; //max length of random chars
 $intCounter = 0;
 $my_keys = "123456789abcdefghijklmnopqrstuvwxyz"; //keys to be choose from
 $keys_length = strlen($my_keys);
 $strUrl  = "";
 while($intCounter<$num_chars)
 {
  $rand_num = mt_rand(1, $keys_length-1);
  $strUrl .= $my_keys[$rand_num];
  $intCounter++;
 }
 return $strUrl;
}

/*
 * check the uniqueness of the chars
 */
function isUnique($strChars)
{
	global $link;
	$query = "SELECT * FROM `urls` WHERE `unique_chars`='".$strChars."'";
	$row = mysqli_query($link, $query);
	if( mysqli_num_rows($row)>0 ){
		return false;
	} else {
		return true;
	}
}

/*
 * To check url is already present in DB or not
 */
function isThere($url)
{
	global $link;
	$query = "SELECT * FROM `urls` WHERE `url`='".$url."'";
	$row = mysqli_query($link, $query);
	if(mysqli_num_rows($row)>0){
		return true;
	} else {
		return false;
	}
}

/*
 * To get the count of visited url
 */
function visit_count($strUrl) {
	global $link;
	$query = "SELECT visit_count FROM `urls` WHERE `url`='".$strUrl."'";
	$row = mysqli_query($link, $query);
	$result = mysqli_fetch_row($row);
	return $result[0];
}

/*
 * Using unique_chars, incrementing visit_count in DB
 */
function redirect($strUrl) {
	global $link;
	$query = "SELECT url FROM `urls` WHERE `unique_chars`='".$strUrl."'";
	$row = mysqli_query($link, $query);
	if(mysqli_num_rows($row)>0){
		$result = mysqli_fetch_row($row);
		
		$count = visit_count($result[0]) + 1;		
		$query = "UPDATE `urls` set visit_count='".$count."' where `unique_chars`='".$strUrl."'";
		mysqli_query($link, $query);		
	} else {
		$result = 'Sorry! Record not matched';
	}
	return $result[0];
}

/*
 * Main function, which is responsible for generate tinyurl
 */
function create($strReceivedUrl)
{	
	global $link; //make the link variable in the config.php, global
	$strChars = generate_chars(); //generate random characters
	
	/*
	 * We check the uniqueness of the characters.
	 * The following loop continues until it generates unique characters 
	 */
	while( !isUnique($strChars) )
	{
		$strChars = generate_chars();
	}
	
	/*
	 * Append http:// string to received url, if this is missing
	 * 
	 */
	if(strpos($strReceivedUrl,'http://')===false){
		$strReceivedUrl='http://'.$strReceivedUrl;
	}
	
	$strUrl = $strReceivedUrl;			//get the url
	$strUrl = trim($strUrl);			//trim it to remove whitespace
	$strUrl = mysqli_real_escape_string($link, $strUrl);	//sanitize data
	

	/* Now we check whether the url is already there in the database. */
	if(!isThere($strUrl))
	{
		$query = "INSERT INTO `urls` (url, unique_chars) VALUES ('".$strUrl."', '".$strChars."' )";
		mysqli_query($link, $query);
		
		if(mysqli_affected_rows($link)) {
			
		//To show the data, after inserting into DB
		 $query = "SELECT * FROM `urls` WHERE `url`='".$strUrl."'";
		 $row = mysqli_query($link, $query);
		 $result = mysqli_fetch_row($row);
		 return $result[2]."!~!".$result[1];
		} else {
		//problem with the database
		 echo "Sorry, some problem with the database. Please try again.";
		}
	}
	else
	{
		//url is already there. so no need to insert again. Just get the data from database
		$query = "SELECT * FROM `urls` WHERE `url` = '".$strUrl."'";
		$row = mysqli_query($link, $query);
		$result = mysqli_fetch_row($row);
		return $result[2]."!~!".$result[1];
	}
}

function url_list() {
	global $link; //make the link variable in the config.php, global
	$q = "SELECT * FROM `urls` ORDER BY visit_count DESC";
	$r = mysqli_query($link, $q);
	$results = array();
	while($rows = mysqli_fetch_array($r, MYSQLI_ASSOC)){
		$results[] = $rows;
	}
	
	return $results;
}


?>