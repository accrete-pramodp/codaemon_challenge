<?php 
include("functions.php"); //include functions.php where all the functions are defined.
$url = create($_POST["url"]); //call the function create()

 echo json_encode($url);
?>
