<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>Image Classifier</title>
  <script src="./js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="./css/External/bootstrap.min.css" />
  <style></style>
</head>
<body>
	<div class="container mt-5">
		<p class="h1 text-center text-justify text-info">Image Classifier</p>
	</div>
	<div class="container mt-5">
		<div class="row justify-content-center" id="inside">
				<form method="post" action="demo.php" enctype="multipart/form-data">
					<div class="col-12 mt-3">
						<label>Choose a zip file for Images: <input type="file" name="zip_file" /></label>
					</div>
					<div class="col-12 mt-3">
					<input type="submit" name="submit" value="Upload" class="w-100" />
					</div>
				</form>
		</div>
	</div>
</body>
</html>


