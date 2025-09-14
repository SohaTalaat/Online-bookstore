<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function validate($data)
{
    $data = is_string($data) ? $data : '';
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

try {

    $name = validate($_POST['name']);
    $email = validate($_POST['email']);
    $password = validate($_POST['password']);
    $student_id = validate($_POST['student_id']);
    $phone = validate($_POST['phone']);
    $address = validate($_POST['address']);



    $errors = [];

    if (empty($name)) {
        $errors['name'] = "name is required";
    } elseif (strlen($name) < 3) {
        $errors['name'] = " name must be at least 3 characters";
    }

    if (empty($address)) {
        $errors['address'] = "address is required";
    }

    if (empty($email)) {
        $errors['email'] = "Email is required";
    } elseif ((!filter_var($email, FILTER_VALIDATE_EMAIL))) {
        $errors['email'] = "Invalid email";
    }

    if (empty($password)) {
        $errors['password'] = "Password is required";
    } elseif (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters";
    }

    if (empty($student_id)) {
        $errors['student_id'] = "student_id is required";
    }


    session_start();

    //    var_dump ($errors);

    if (count($errors) > 0) {
        $_SESSION['errors'] = $errors;
        header("Location:register.php");
    } else {

        require_once __DIR__ . '/../models/user.php';
        $connection = new User();

        $data = [
            'name'       => $name,
            'email'      => $email,
            'password'   => $password,
            'student_id' => $student_id,
            'role'       => 'student',
            'phone'      => $phone,
            'address'    => $address
        ];

        // unique email check
        if ($connection->findByEmail($email)) {
            $_SESSION['errors'] = ['email' => 'Email already registered'];
            header("Location:register.php");
            exit;
        }

        $connection->createUser($data);
        $_SESSION['flash_success'] = 'Registration successful. Please login.';
        header('Location: login.php');
        exit;
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
