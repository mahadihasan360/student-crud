<?php
include_once "autoload.php";

// student data delete
if(isset($_GET["delete_id"])){
	$delete_id = $_GET["delete_id"];
	$photo_name = $_GET["photo"];

	unlink("photos/".$photo_name);

	delete("students",$delete_id);
	header("location:index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Student Database Systemt</title>
	<!-- ALL CSS FILES  -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/style.css">
	<link rel="stylesheet" href="assets/css/responsive.css">
</head>
<body>
	

	<?php
	
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
		




	// form validation
		if(empty($name) or empty($email) or empty($cell) or empty($username) or empty($location) or empty($age) or empty($gender) or empty($dept)){
			$msg = validate("All fields Are Required!");
		}else if(filter_var($email,FILTER_VALIDATE_EMAIL) == false){
			$msg = validate("Invalid Email Address!");
		}else if(dataCheck("students","email",$email)){
			$msg = validate("Email Already Exists!");
		}else if(dataCheck("students","username",$username)){
			$msg = validate("Username Already Exists!");
		}else if(dataCheck("students","cell",$cell)){
			$msg = validate("Cell Number Already Exists!");
		}else{

			// upload profile photo
			$data = move($_FILES["photo"],"photos/");

			// get function
			$unique_name = $data["unique_name"];
			$err_msg = $data["err_msg"];

			if(empty($err_msg)){
			// data insert
			create("INSERT INTO students (name,email,cell,username,location,age,gender,dept,photo) VALUES ('$name','$email','$cell','$username','$location','$age','$gender','$dept','$unique_name')");

			$msg = validate("Data Send To Database","success");
			}else{
			$msg = $err_msg;
			}
		}

	}
	
	?>
	

	<div class="wrap-table">
	<a class="btn btn-sm btn-primary" data-toggle="modal" href="#add_student_modal">Add new Student</a><br><br>

		<div class="card shadow">
			<div class="card-body">
				<h2>All Students</h2>
				
				<!-- search box -->
				<form class="form-inline" action="" method="POST">
					<div class="form-group ml-auto mb-2">
						<label for="inputPassword2" class="sr-only">Search</label>
						<input name="search" type="text" class="form-control" id="inputPassword2" placeholder="search">
					</div>
					<button name="search_btn" type="submit" class="btn btn-primary mb-2">search</button>
				</form><br>
				<!-- search box -->

				<?php
				if(isset($msg)){
					echo $msg;
				}
				?>
				<table class="table table-striped">
					<thead>
						<tr>
							<th>#</th>
							<th>Name</th>
							<th>Email</th>
							<th>Cell</th>
							<th>Username</th>
							<th>Gender</th>
							<th>Age</th>
							<th>Location</th>
							<th>Photo</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>



                    <?php
					$i=1;
					$data = all("students");

					// search
					if(isset($_POST["search_btn"])){

						$search = $_POST["search"];
					
						$sql = "SELECT * FROM students WHERE name LIKE '%$search%' OR email LIKE '%$search%' OR cell LIKE '%$search%' OR username LIKE '%$search%' OR location LIKE '%$search%'";
						$data = connect()->query($sql);
					
					}



					while($student = $data->fetch_object()) :
					?>





						<tr>
							<td><?php echo $i; $i ++?></td>
							<td><?php echo $student->name;?></td>
							<td><?php echo $student->email;?></td>
							<td><?php echo $student->cell;?></td>
							<td><?php echo $student->username;?></td>
							<td><?php echo $student->gender;?></td>
							<td><?php echo $student->age;?></td>
							<td><?php echo $student->location;?></td>
							<td><img src="photos/<?php echo $student->photo;?>" alt=""></td>
							<td>
								<a class="btn btn-sm btn-info" href="show.php?show_id=<?php echo $student->id;?>">View</a>
								<a class="btn btn-sm btn-warning" href="edit.php?edit_id=<?php echo $student->id;?>">Edit</a>
								<a class="btn btn-sm btn-danger  delete_btn" href="?delete_id=<?php echo $student->id;?>&photo=<?php echo $student->photo;?>">Delete</a>
							</td>
						</tr>
						<?php  endwhile;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	


<!-- student modal -->
<div id="add_student_modal" class="modal fade">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h3>Add New Student</h3>
			</div>
			<div class="modal-body">
				<form action="" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="">Student Name</label>
						<input name="name" value="<?php old("name");?>" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label for="">Email</label>
						<input name="email" value="<?php old("email");?>" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label for="">Cell</label>
						<input name="cell" value="<?php old("cell");?>" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label for="">username</label>
						<input name="username" value="<?php old("username");?>" class="form-control" type="text">
					</div>

					<div class="form-group">
						<label for="">Location</label>
						<select class="form-control" name="location" id="">
							<option value="">--Select--</option>
							<option value="Mirpur">Mirpur</option>
							<option value="Banani">Banani</option>
							<option value="Uttara">Uttara</option>
							<option value="Mohammadpur">Mohammadpur</option>
							<option value="Badda">Badda</option>
							<option value="Gulshan">Gulshan</option>
						</select>
					</div>

					<div class="form-group">
						<label for="">Age</label>
						<input  name="age" value="<?php old("age");?>" class="form-control" type="text">
					</div>
					<div class="form-group">
						<label for="">Gender</label><br>
						<input name="gender" type="radio" checked value="Male" id="Male"><label for="Male">Male</label>
						<input name="gender" type="radio" value="Female" id="Female"><label for="Female">Female</label>
					</div>

					<div class="form-group">
						<label for="">Department</label>
						<select class="form-control" name="dept" id="">
							<option value="">--Select--</option>
							<option value="BBA">BBA</option>
							<option value="CSE">CSE</option>
							<option value="EEE">EEE</option>
							<option value="English">English</option>
							<option value="Math">Math</option>
							<option value="IT">IT</option>
						</select>
					</div>

					<div class="form-group">
						<label for="">Profile Photo</label><br>
						<img id="load_student_photo" style="width: 100px;margin:10px 0" src="" alt="">
						<br>
						<label for="student_photo"><img style="display: block;width:50px;height:50px" src="img/upload.png" alt=""></label>
						<input name="photo" id="student_photo" style="display: none;" class="form-control" type="file">
					</div>

					<div class="form-group">
						<input name="add" class="btn btn-sm btn-primary" type="submit" value="Add Student">
					</div>
				</form>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<!-- student modal -->







	<!-- JS FILES  -->
	<script src="assets/js/jquery-3.4.1.min.js"></script>
	<script src="assets/js/popper.min.js"></script>>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/custom.js"></script>

	<script>
	$("#student_photo").change(function(e){
		let file_url = URL.createObjectURL(e.target.files[0]);
		$("#load_student_photo").attr("src",file_url);
	});

	$(".delete_btn").click(function(){
		
		let confirmation = confirm("Are You Sure??");


		if(confirmation == true){
			return true;
		}else{
			return false;
		}
	});
	</script>
</body>
</html>