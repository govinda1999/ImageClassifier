<!DOCTYPE html>
<html>
<head>
	<title>Parameters</title>
	<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  
</head>
<body>
<div class="container">
<div class="justify-content-center">
	<h2>
		Modify Parameters
	</h2>
	<form action="" method="POST">

		<div class="form-group">
			<label>Learning Rate: </label>
			<input type="text" name="lr" class="form-control">
		</div>

		<div class="form-group">
			<label>Epoch: </label>
			<input type="text" name="ep" class="form-control">
		</div>

		<div class="form-group">
			<label>json file:</label>
			<input type="text" name="json" class="form-control">
		</div>

		<div class="form-group">
			<label>h5 file:</label>
			<input type="text" name="h5" class="form-control">
		</div>
 
		<input type="submit" class="btn btn-block" name="para">

	</form>
</div>
</div>
<?php 

	if(isset($_POST['para'])){
		$lr=$_POST['lr'];
		$ep=$_POST['ep'];
		$js=$_POST['json'];
		$h5=$_POST['h5'];

		$response = file_get_contents("http://127.0.0.1:5000/api/retrain?learning_rate=".$lr."&epoch=".$ep."&json_file=".$js."&h_file=".$h5);

	}



 ?>



</body>
</html>