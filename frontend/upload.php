<?php
include './config.php';
if(isset($_POST['submit'])) {
	$file1="";
	$file2="";
	for($i=0;$i<count($_FILES["zip_file"]["name"]);$i++){
	$filename = $_FILES["zip_file"]["name"][$i];
	$source = $_FILES["zip_file"]["tmp_name"][$i];
	$type = $_FILES["zip_file"]["type"][$i];
	
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

	$target_path = "/home/govinda/Desktop/Image/".$filename;  // path to exact image
	if(move_uploaded_file($source, $target_path)) {
		$zip = new ZipArchive();
		$x = $zip->open($target_path);
		if ($x === true) {
			$zip->extractTo("/home/govinda/Desktop/Image/".$name[0]); // path to exact image
			$zip->close();
	
			unlink($target_path);
		}
		$message = "Your .zip file was uploaded and unpacked.";
		if($i==0){
			$file1=$name[0];
		}else{
			$file2=$name[0];
		}
	} else {	
		$message = "There was a problem with the upload. Please try again.";
	}
  }
  $cname = $_POST["cname"];
  // echo $cname;
  // echo $file1;
  echo "http://127.0.0.1:5000/api/train?file1=".$file1."&file2=".$file2;
  $response = file_get_contents("http://127.0.0.1:5000/api/train?file1=".$file1."&file2=".$file2);
}
?>