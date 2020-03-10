<?php
    include './config.php';

    /*
    if(isset($_GET['id'])){
        $query="SELECT * FROM classifier WHERE id='$_GET['id']'";
        $query=mysqli_query($link,$query);
        $row=mysqli_fetch_array();
        $_SESSION['json']=$row['json_file'];
        $_SESSION['h5']=$row['h_file'];
    }
    */


?>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
  <link rel="stylesheet" type="text/css" href="style1.css">
  <title>Image Classifier</title>

<body>
	<div class="container">
		<div class="row">
			<div class="col-6">
				<h1> Add Images for Testing</h1>
			 	<div style="text-align: center;">
					<form action="" enctype="multipart/form-data" method="POST">

						<input type="file" name="file" >
						<input type="submit" name="img_submit" value="submit">
				
					</form>
				
<?php
	
	if(isset($_COOKIE['img'])){
		echo "<img src='".$_COOKIE["img"]."'>";
		
		$string = file_get_contents("/home/govinda/Desktop/new/api.json"); //path to backend api.json
		$json_temp = json_decode($string,true);

		echo '<div style="width: 300px;height: 300px;margin: 40px 20px 0 450px">
				<canvas id="myChart" width="400" height="400"></canvas>
				</div>';

		echo "<script>
	

		var ctx = document.getElementById('myChart').getContext('2d');
		var array = [".$json_temp['building'].",".$json_temp['forest'].",".$json_temp['glacier'].",".$json_temp['mountain'].",".$json_temp['sea'].",".$json_temp['street']."];
var myChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['building','forest','glacier','mountain','sea','street'],
        datasets: [{
            label: '# of Votes',
            data: array,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
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

	

</script>";


	}

?>

		</div>

		</div>
 

</div>
</div>

</body>

<?php
	if(isset($_POST['img_submit'])){
			 $filename=$_FILES["file"]["name"];
		     $fileTmpname=$_FILES['file']['tmp_name'];
		     $filesize=$_FILES["file"]["size"];
		     $fileerror=$_FILES["file"]["error"];
		     $filetype=$_FILES["file"]["type"];
		     $filenamearray=explode('.',$filename);
		     $fileExt=strtolower(end($filenamearray));
		     $allowed=array('jpg','jpeg','png');


	if(in_array($fileExt,$allowed))
     {
         if($fileerror==0)
         {
           
                 $filenewname=date('d-m-Y-H-i-s')."-".$_FILES["file"]["name"];//
                 $destination='upload/'.$filenewname;
                 move_uploaded_file($fileTmpname,$destination);
                
                //$query="INSERT INTO test_image values('','random','$filenewname')";
                //mysqli_query($con,$query);

                //mysqli_insert_id($con);
                 $response = file_get_contents("http://127.0.0.1:5000/api/image?source=".$filenewname);
                 $json = json_decode($response);
                $folder="./upload/".$filenewname;
                if(isset($_COOKIE['img'])){
                		unset($_COOKIE['img']);
                	 	setcookie('img',$folder,time()+2*24*60*60);
            	}
               
               setcookie('img',$folder,time()+2*24*60*60);
               echo "<script>window.location = '/frontend/personal.php'</script>";

                
               
          
         }
         else
         {
             echo "error in uploadin";
         }

     }
     else
     {
         echo "you cant upload this file type";
     }

	}

?>



</head>

</html>

