<?php
if($_FILES["zip_file"]["name"]) {
	$filename = $_FILES["zip_file"]["name"];
	$source = $_FILES["zip_file"]["tmp_name"];
	$type = $_FILES["zip_file"]["type"];
	
	$name = explode(".", $filename);
	$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
	foreach($accepted_types as $mime_type) {
		if($mime_type == $type) {
			$okay = true;
			break;
		} 
	}	
	$continue = strtolower($name[1]) == 'zip' ? true : false;
	if(!$continue) {
		$message = "The file you are trying to upload is not a .zip file. Please try again.";
	}
	$target_path = "/opt/lampp/htdocs/frontend/".$filename;  // change this to the correct site path
	if(move_uploaded_file($source, $target_path)) {
		$zip = new ZipArchive();
		$x = $zip->open($target_path);
		if ($x === true) {
			$zip->extractTo("/opt/lampp/htdocs/frontend/".$name[0]); // change this to the correct site path
			$zip->close();
	
			unlink($target_path);
		}
		$message = "Your .zip file was uploaded and unpacked.";
		$response = file_get_contents("http://127.0.0.1:5000/api/test?folder=".$name[0]);

		$string = file_get_contents("/home/govinda/Desktop/new/pred.json"); //path to pred json file
		$json_temp = json_decode($string,true);

		echo '

		<!DOCTYPE html>
			<html>
			<head>
				<title>Image Classifier</title>
			</head>
			<link rel="stylesheet" href="./css/External/bootstrap.min.css" />
			<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
			<body>';
			
		echo '<div class="container">
		<div class="row">';

		for($i=0;$i<count($json_temp['building']);$i++){

			
		echo ' 
		<div class="col-3 mt-3">
			
			<img  src="./pred/'.$json_temp['name'][$i].'" width=100%>
			

			
				<canvas id="'.$i.'" width="400" height="400"></canvas>
				

				<script>
	

		var ctx = document.getElementById("'.$i.'").getContext("2d");
		var array = ['.$json_temp["building"][$i].','.$json_temp["forest"][$i].','.$json_temp["glacier"][$i].','.$json_temp["mountain"][$i].','.$json_temp["sea"][$i].','.$json_temp["street"][$i].'];
var myChart = new Chart(ctx, {
    type: "pie",
    data: {
        labels: ["building","forest","glacier","mountain","sea","street"],
        datasets: [{
            label: "",
            data: array,
            backgroundColor: [
                "rgba(255, 99, 132, 0.2)",
                "rgba(54, 162, 235, 0.2)",
                "rgba(255, 206, 86, 0.2)",
                "rgba(75, 192, 192, 0.2)",
                "rgba(153, 102, 255, 0.2)",
                "rgba(255, 159, 64, 0.2)"
            ],
            borderColor: [
                "rgba(255, 99, 132, 1)",
                "rgba(54, 162, 235, 1)",
                "rgba(255, 206, 86, 1)",
                "rgba(75, 192, 192, 1)",
                "rgba(153, 102, 255, 1)",
                "rgba(255, 159, 64, 1)"
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});

	

</script>



			
			
		</div>







		';


		}




echo'
</div>
</div>
</body>
</html>';


	} else {	
		$message = "There was a problem with the upload. Please try again.";
	}
}
?>