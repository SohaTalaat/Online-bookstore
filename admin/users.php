<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../models/user.php");

$userModel=new User();

if (isset($_GET['student_id']))
{
    $student_id=$_GET['student_id'];
    $student=$userModel->getStudentById($student_id);

}