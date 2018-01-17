<!DOCTYPE html>
<html lang="en">
<head>
  <title>Codaemon Challenge: Home</title>
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
        <li class="active"><a href="index.php">Home</a></li>
        <li class=""><a href="list.php">List</a>
      </ul><br>
    </div>

    <div class="col-sm-9">
      <h4><small>Home</small></h4>
      <hr>
      <br><br>      

      <h4>Enter Complete Url:</h4>
      <form method="post" action="url_submit.php">
        <div class="form-group">
          <input type="text" name="url" id="url" class="form-control">
        </div>
        <button type="button" class="btn btn-success" onclick="dataSubmit()">Submit</button>
      </form>
      <br><br>
      <div id="result_data"></div>
      <br><br>
      
      <div id="short_url_area" class="hide">
	      <h4>Enter Short Url:</h4>
	      <span name="unique_chars" id="unique_chars" class="hide"></span>
		
      		<input type="text" name="short_url" id="short_url">
      		<button type="button" class="btn btn-success" onclick="redirect(0)">Redirect</button>
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
	        $("#result_data").html("<span style='cursor:pointer; color: blue;' onclick='redirect(1)' >"+actual_data[0]+"</span>");
	        $("#unique_chars").html(actual_data[0]);
	        $("#short_url_area").removeClass("hide");
	    }
	});
}

function redirect(num) {
	var actual_data;
	if(num == 1) {
		actual_data = $("#unique_chars").html();
	} else {
		actual_data = $("#short_url").val();
	}
	$.ajax({
	    type: "POST",
	    url: 'short_url_submit.php',
	    data: {url: actual_data},
	    success: function(data){ 
		   var response = JSON.parse(data);
		   window.location.href = response;
	    }
	});
}
</script>
</body>
</html>
