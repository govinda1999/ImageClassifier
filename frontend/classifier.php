<?php

?>

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
		<p class="h1 text-center text-justify text-info">Create New Image Classifier</p>
	</div>
	<div class="container mt-5">
		<div class="row justify-content-center" id="inside">
				<form method="post" action="upload.php" enctype="multipart/form-data">
					<div class="col-12">
					<input type="text" name="cname" placeholder="Enter Classifier Name ..." class="w-100 border-bottom border-top-0 border-left-0 border-right-0 pl-3 rounded-bottom border-danger" />
					</div>
					<div class="col-12 mt-3">
						<label>Choose a zip file for 1st Image: <input type="file" name="zip_file[]" /></label>
					</div>
					<div class="col-12 mt-3">
						<label>Choose a zip file for 2nd Image: <input type="file" name="zip_file[]" /></label>
					</div>
					<div class="col-12 mt-3">
					<input type="submit" name="submit" value="Upload" class="w-100" />
					</div>
				</form>
		</div>
	</div>
</body>
</html>


