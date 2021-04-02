<?php

// data create by create

function create($sql){
    connect()->query($sql);
}

// data create by create

function all($table,$order="DESC"){
    return connect()->query("SELECT * FROM $table ORDER BY id $order");
}

// data create by create

function find($table,$id){
    $data = connect()->query("select * from $table WHERE id = '$id'");
    return $data->fetch_object();
}

// data create by create

function delete($table,$id){
    connect() ->query("DELETE FROM $table WHERE id = '$id'");
}

// data create by create

function update($sql){
    connect()->query($sql);
}


// Data check function

function dataCheck($table,$column,$data){
    $data = connect()->query("SELECT $column FROM $table WHERE $column = '$data'");

    if($data->num_rows > 0){
        return true;
    }else{
        return false;
    }
}



// validate function for error message

function validate($msg,$type="danger"){
    return "<p class='alert alert-$type'>$msg<button class='close'; data-dismiss='alert'>&times;</button> <p>";
}


// file upload function

function move($file, $location = "/", array $type  = ["jpg","png","gif","jpeg"]){
    	// file management
		$file_name = $file["name"];
		$file_tmp_name = $file["tmp_name"];
		$file_arr = explode(".", $file_name);
		$file_ext = end($file_arr);
		$unique_name = md5(time().rand()). "." .$file_ext;

        $msg = "";

        if(in_array($file_ext,$type) == false){
            $msg = validate("Invalid File Formate");
        }else{
        // upload file
        move_uploaded_file($file_tmp_name, $location . $unique_name);
        }

        return [
            "unique_name" => $unique_name,
            "err_msg"     => $msg
        ];
}

?>