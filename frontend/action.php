<?php
include 'config.php';
if(isset($_POST['fetch_classifier'])){
	$sql = "select * from classifier order by id desc ";
	$query = mysqli_query($link, $sql);
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) {
        	$id = $row['id'];
            $name = $row['name'];
            $acc = $row['acc'];
            echo '<div class="col-md-4 mt-5">
					<div class="card">
  					<div class="card-body">
    					<p class="card-title h2 text-center text-capitalize" >'.$name.'</p>
    					<p class="card-title h6 text-center">Accurary '.$acc.'</p>
    					<div class="row">
    						<div class="col-6">
    							<a href="./personal.php?'.$id.'" class="btn btn-primary">Single Image</a>
    						</div>
	    					<div class="col-6">
	    					<a href="./image128.php?'.$id.'" class="btn btn-warning">Upload Zip File</a>
	    					</div>
	    					<div class="col-12 mt-3">
	    						<a href="./parameter.php?'.$id.'" class="btn btn-success btn-block">Retrain</a>
	    					</div>	
    					</div>
  					</div>
				</div>
			</div> ';
        }
    }
}
?>