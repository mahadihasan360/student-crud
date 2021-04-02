<?php
include_once "autoload.php";


// isseting student add form

if(isset($_POST["add"])){

	// get value
	$name = $_POST["name"];
	$email = $_POST["email"];
	$cell = $_POST["cell"];
	$username = $_POST["username"];
	$location = $_POST["location"];
	$age = $_POST["age"];
	$gender = $_POST["gender"];
	$dept = $_POST["dept"];

	$id = $_GET["edit_id"];






// form validation
	if(empty($name) or empty($email) or empty($cell) or empty($username) or empty($location) or empty($age) or empty($gender) or empty($dept)){
		$msg = validate("All fields Are Required!");
	}else if(filter_var($email,FILTER_VALIDATE_EMAIL) == false){
		$msg = validate("Invalid Email Address!");
	}
	else{

		if(!empty($_FILES["new_photo"]["name"])){
			$data = move($_FILES["new_photo"],"photos/");
			$photo_name = $data["unique_name"];
			// unlink("photos/" . $_POST["old_photo"]);
		}else{
			$photo_name = $_POST["old_photo"];
		}

		$updated_at = date("Y-m-d g:i:h", time());
		update("UPDATE students SET name='$name',email='$email',cell='$cell',username='$username',location='$location',age='$age',gender='$gender',dept='$dept',photo='$photo_name',updated_at='$updated_at' WHERE id ='$id'");

		// $msg = validate("Data Updated Successfully","success");
		header("location:index.php");
	}

}



// find edit student data
if(isset($_GET["edit_id"])){
	$id = $_GET["edit_id"];

	$edit_data = find("students",$id);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Edit Data</title>
	<!-- ALL CSS FILES  -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>


	
<div class="container">
	<div class="row">
		<div class="col-lg-6 mx-auto mt-5">
		<a class="btn btn-sm btn-primary" href="index.php">Back</a><br><br>
			<div class="card">
				<div class="card-body">
				<h2>Student Data Edit</h2>
				<?php
				if(isset($msg)){
					echo $msg;
				}
				?>
				<hr>
					<form action="" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label for="">Student Name</label>
							<input name="name" class="form-control" value="<?php echo $edit_data->name;?>" type="text">
						</div>

						<div class="form-group">
							<label for="">Email</label>
							<input name="email" class="form-control" value="<?php echo $edit_data->email;?>" type="text">
						</div>

						<div class="form-group">
							<label for="">Cell</label>
							<input name="cell" class="form-control" value="<?php echo $edit_data->cell;?>" type="text">
						</div>

						<div class="form-group">
							<label for="">username</label>
							<input name="username" class="form-control" value="<?php echo $edit_data->username;?>" type="text">
						</div>

						<div class="form-group">
							<label for="">Location</label>
							<select class="form-control" name="location" id="">
								<option value="">--Select--</option>
								<option <?php echo ($edit_data->location=="Mirpur") ? "selected" : "";?> value="Mirpur">Mirpur</option>
								<option <?php echo ($edit_data->location=="Banani") ? "selected" : "";?> value="Banani">Banani</option>
								<option <?php echo ($edit_data->location=="Uttara") ? "selected" : "";?> value="Uttara">Uttara</option>
								<option <?php echo ($edit_data->location=="Mohammadpur") ? "selected" : "";?> value="Mohammadpur">Mohammadpur</option>
								<option <?php echo ($edit_data->location=="Badda") ? "selected" : "";?> value="Badda">Badda</option>
								<option <?php echo ($edit_data->location=="Gulshan") ? "selected" : "";?> value="Gulshan">Gulshan</option>
							</select>
						</div>

						<div class="form-group">
							<label for="">Age</label>
							<input name="age" class="form-control" value="<?php echo $edit_data->age;?>" type="text">
						</div>
						<div class="form-group">
							<label for="">Gender</label><br>
							<input name="gender" type="radio"<?php echo ($edit_data->gender=="Male") ? "checked" : ""; ?> value="Male" id="Male"><label
								for="Male">Male</label>
							<input name="gender" type="radio"<?php echo ($edit_data->gender=="Female") ? "checked" : ""; ?> value="Female" id="Female"><label
								for="Female">Female</label>
						</div>

						<div class="form-group">
							<label for="">Department</label>
							<select class="form-control" name="dept" id="">
								<option value="">--Select--</option>
								<option <?php echo ($edit_data->dept=="BBA") ? "selected" : "";?> value="BBA">BBA</option>
								<option <?php echo ($edit_data->dept=="CSE") ? "selected" : "";?> value="CSE">CSE</option>
								<option <?php echo ($edit_data->dept=="EEE") ? "selected" : "";?> value="EEE">EEE</option>
								<option <?php echo ($edit_data->dept=="English") ? "selected" : "";?> value="English">English</option>
								<option <?php echo ($edit_data->dept=="Math") ? "selected" : "";?> value="Math">Math</option>
								<option <?php echo ($edit_data->dept=="IT") ? "selected" : "";?> value="IT">IT</option>
							</select>
						</div>

						<div class="form-group">
							<label for="">Profile Photo</label><br>
							<img id="load_student_photo_edit" style="width: 100px;margin:10px 0" src="photos/<?php echo $edit_data->photo;?>" alt="">
							<br>
							<label for="student_photo_edit"><img style="display: block;width:50px;height:50px"
									src="img/upload.png" alt=""></label>
							<input name="new_photo" id="student_photo_edit" style="display: none;" class="form-control"
								type="file">
								<input type="hidden" value="<?php echo $edit_data->photo;?>" name="old_photo">
						</div>

						<div class="form-group">
							<input name="add" class="btn btn-sm btn-primary" type="submit" value="Update Student">
						</div>
					</form>
				</div>
			</div>

		</div>
	</div>
</div>


	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>

	<script>
	$("#student_photo_edit").change(function(e){
		let file_url = URL.createObjectURL(e.target.files[0]);
		$("#load_student_photo_edit").attr("src",file_url);
	});
	</script>
</body>
</html>