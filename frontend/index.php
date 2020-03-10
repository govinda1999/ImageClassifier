<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <title>Image Classifier</title>
  <script src="./js/jquery2.js"></script>
  <script src="./js/bootstrap.min.js"></script>
  <script src="./main.js"></script>
  <link rel="stylesheet" href="./css/External/bootstrap.min.css" />
  <style></style>
</head>
<body>
	<div class="container mt-5">
		<p class="h1 text-center text-justify">Image Classifier</p>
	</div>
	<div class="container mt-5">
		<div class="row">
			<div class="col-12 ">
				<a href="classifier.php" class="btn btn-outline-primary rounded-top rounded-left rounded-right rounded-bottom">Create New Classifier</a>
			</div>
		</div>
		<div class="row" id="classifier">
			<div class="col-md-6 mt-5">
				<div class="card">
  					<div class="card-body">
    					<p class="card-title h2" style="padding: 10px 0 10px 100px">Original model</p>
    					<div class="row">
    						<div class="col-4">
    							<a href="./personal.php" class="btn btn-primary">Single Image</a>
    						</div>
	    					<div class="col-4">
	    					<a href="./image128.php" class="btn btn-primary">Upload Zip File</a>
	    					</div>
	    					<div class="col-4">
	    						<a href="./parameter.php" class="btn btn-primary">Retrain</a>
	    					</div>
	    					
    					</div>
  					</div>
				</div>
			</div> 
		</div>
	</div>
</body>
</html>