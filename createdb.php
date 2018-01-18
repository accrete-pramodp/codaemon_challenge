<?php
// Connect to MySQL
$link = mysqli_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysqli_error());
}

// Make tinyurl as the current database
$db_selected = mysqli_select_db( $link, 'tinyurl');

// If not any database is selected
if (!$db_selected) {
  $sql = 'CREATE DATABASE tinyurl';

  if (mysqli_query($link, $sql)) {

// Table creation, if database is there       
      $tsql = 'CREATE TABLE `urls` (
		  `uid` int(11) NOT NULL,
		  `url` varchar(1024) DEFAULT NULL,
		  `unique_chars` varchar(25) NOT NULL,
		  `visit_count` int(11) NOT NULL DEFAULT 0
		)';
      
      mysqli_select_db($link, 'tinyurl');
      $retval = mysqli_query( $link, $tsql );
       
      if(! $retval ) {
      	die('Could not create table: ' . mysqli_error($link));
      }
       
      echo "Table urls created successfully in tinyurl Database\n";
      
  } else {	// If unable to create database
      echo 'Error creating database: ' . mysqli_error($link) . "\n";
  }
}

mysqli_close($link);
?>