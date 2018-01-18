<?php
// Connect to MySQL
$link = mysqli_connect('localhost', 'root', '');
if (!$link) {
    die('Could not connect: ' . mysqli_error());
}

// Make tinyurl2 the current database
$db_selected = mysqli_select_db( $link, 'tinyurl2');

if (!$db_selected) {
  // If we couldn't, then it either doesn't exist, or we can't see it.
  $sql = 'CREATE DATABASE tinyurl2';

  if (mysqli_query($link, $sql)) {
     // echo "Database my_db created successfully\n";
      
      $tsql = 'CREATE TABLE `urls` (
		  `uid` int(11) NOT NULL,
		  `url` varchar(1024) DEFAULT NULL,
		  `unique_chars` varchar(25) NOT NULL,
		  `visit_count` int(11) NOT NULL DEFAULT 0
		)';
      
      mysqli_select_db($link, 'tinyurl2');
      $retval = mysqli_query( $link, $tsql );
       
      if(! $retval ) {
      	die('Could not create table: ' . mysqli_error($link));
      }
       
      echo "Table urls created successfully in tinyurl2 Database\n";
      
  } else {
      echo 'Error creating database: ' . mysqli_error($link) . "\n";
  }
}

mysqli_close($link);
?>