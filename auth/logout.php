<?php
session_start();
$_SESSION = [];
session_destroy();
header('Location: /php/BookStore/public/index.php');
exit;
