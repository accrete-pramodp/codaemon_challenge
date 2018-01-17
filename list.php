<?php 
include("functions.php"); //include functions.php where all the functions are defined.
$lists = url_list();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Codaemon Challenge: List</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4>Codaemon Challenge</h4>
      <ul class="nav nav-pills nav-stacked">
        <li class=""><a href="index.php">Home</a></li>
        <li class="active"><a href="list.php">List</a>
      </ul><br>
    </div>

    <div class="col-sm-9">
      <h4><small>List</small></h4>
      <hr>
      <br><br>      

      <div class="container">           
		  <table class="table table-striped" >
		    <thead>
		      <tr>
		        <th class="col-md-4">URL's</th>
		        <th class="col-md-4">Unique Chars</th>
		        <th class="col-md-4">Visited</th>
		      </tr>
		    </thead>
		    <tbody>
		    <?php foreach($lists as $list) { ?>
		      <tr>
		        <td><?php echo $list['url']; ?></td>
		        <td><?php echo $list['unique_chars']; ?></td>
		        <td><?php echo $list['visit_count']; ?></td>
		      </tr>
		     <?php } ?>

		    </tbody>
		  </table>
		</div>
      
     
    </div>
  </div>
</div>

<footer class="container-fluid">
  <p>Footer Text</p>
</footer>


<script language="javascript" type="text/javascript">
function dataSubmit() {
	$.ajax({
	    type: "POST",
	    url: 'url_submit.php',
	    data: {url: $("#url").val()},
	    success: function(data){
		   var response = JSON.parse(data);
		    var actual_data = response.split("!~!");
	        $("#result_data").html("<a href='"+actual_data[1]+"'>"+actual_data[0]+"</a>");
	    }
	});
}
</script>
</body>
</html>
