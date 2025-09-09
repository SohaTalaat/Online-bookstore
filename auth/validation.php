<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function validate ($data){

    $data=trim($data);
    $data=stripcslashes($data);
    $data=htmlspecialchars($data);
    return $data;
    
}

try{

    $name= validate ($_POST['name']);
    $email= validate ($_POST['email']);
    $password= validate ($_POST['password']);
    $student_id= validate ($_POST['student_id']);
    $phone= validate ($_POST['phone']);
    $address= validate ($_POST['address']);

    

    $errors=[];

    if(empty($name)){
        $errors['name']="name is required";

    } elseif (strlen($name) < 3) {
    $errors['name'] = " name must be at least 3 characters";
    }

    if(empty($address)){
        $errors['address']="address is required";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif ((filter_var($email,FILTER_VALIDATE_EMAIL))) {
        $errors['email'] = "Invalid email";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    

    } elseif (strlen($password) < 6) {
    $errors['password'] = " password must be at least 6";
    }

     if(empty($student_id)){
        $errors['student_id']="student_id is required";
    }
    

   session_start();

//    var_dump ($errors);

    if (count($errors) > 0) {
    $_SESSION['errors'] = $errors;        
    header("Location:register.php");
    }
    else{

        require("user.php");
            $connection = new DB();
            $table = "user";
            $columns = "first_name,last_name,address,username,password,photo";
            $values = "'$first_name','$last_name','$address','$username','$password','$photo'";
            $connection->InsertData($table, $columns, $values);

    }
}catch(PDOException $e)
{
    echo $e->getMessage();
}
?>