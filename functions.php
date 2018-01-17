<?php 
include("config.php");
function generate_chars()
{
 $num_chars = 4; //max length of random chars
 $i = 0;
 $my_keys = "123456789abcdefghijklmnopqrstuvwxyz"; //keys to be chosen from
 $keys_length = strlen($my_keys);
 $url  = "";
 while($i<$num_chars)
 {
  $rand_num = mt_rand(1, $keys_length-1);
  $url .= $my_keys[$rand_num];
  $i++;
 }
 return $url;
}

function isUnique($chars)
{
	//check the uniqueness of the chars
	global $link;
	$query = "SELECT * FROM `urls` WHERE `unique_chars`='".$chars."'";
	$row = mysqli_query($link, $query);
	if( mysqli_num_rows($row)>0 ){
		return false;
	} else {
		return true;
	}
}

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

function visit_count($url) {
	global $link;
	$query = "SELECT visit_count FROM `urls` WHERE `url`='".$url."'";
	$r = mysqli_query($link, $query);
	$row = mysqli_fetch_row($r);
	return $row[0];
}

function redirect($url) {
	global $link;
	$query = "SELECT url FROM `urls` WHERE `unique_chars`='".$url."'";
	$r = mysqli_query($link, $query);
	if(mysqli_num_rows($r)>0){
		$row = mysqli_fetch_row($r);
		
		$count = visit_count($row[0]) + 1;		
		$q = "UPDATE `urls` set visit_count='".$count."' where  `unique_chars`='".$url."'";
		$res = mysqli_query($link, $q);		
	} else {
		$row = 'Sorry! Record not matched';
	}
	return $row[0];
}

function create($receivedUrl)
{
	global $link; //make the link variable in the config.php, global
	global $config; //make the $config array in the config.php, global
	$chars = generate_chars(); //generate random characters
	/* We check the uniqueness of the characters. The following loop
	 continues until it generates unique characters */
	while( !isUnique($chars) )
	{
		$chars = generate_chars();
	}
	$url = $receivedUrl;//get the url
	$url = trim($url);//trim it to remove whitespace
	$url = mysqli_real_escape_string($link, $url);//sanitize data
	

	/* Now we check whether the url is already there in the database. */
	if(!isThere($url))
	{
		//url is not in the database
		$q = "INSERT INTO `urls` (url, unique_chars) VALUES ('".$url."', '".$chars."' )";
		$r = mysqli_query($link, $q); //insert into the database
		if(mysqli_affected_rows($link)){
		 //ok, inserted. now get the data
		 $q = "SELECT * FROM `urls` WHERE `url`='".$url."'";
		 $r = mysqli_query($link, $q);
		 $row = mysqli_fetch_row($r);
		 return $row[2]."!~!".$row[1]; //$row[2] is where the random chars are
		}else{
		//problem with the database
		 echo "Sorry, some problem with the database. Please try again.";
		}
	}
	else
	{
		//url is already there. so no need to insert again. Just get the data from database
		$q = "SELECT * FROM `urls` WHERE `url` = '".$url."'";
		$r = mysqli_query($link, $q);
		$row = mysqli_fetch_row($r);
		return $row[2]."!~!".$row[1];
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