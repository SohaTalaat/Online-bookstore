<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';
$roleRequired = 'admin';
require_role($roleRequired);
require_once __DIR__ . '/../models/user.php';

$userModel = new User();
$students = $userModel->getAllStudents();
?>
<div class="container">
    <h2>Users</h2>
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($students as $s): ?>
                <tr>
                    <td><?php echo (int)$s['user_id']; ?></td>
                    <td><?php echo htmlspecialchars($s['name']); ?></td>
                    <td><?php echo htmlspecialchars($s['email']); ?></td>
                    <td><?php echo htmlspecialchars($s['role']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require("../models/user.php");

$userModel = new User();

if (isset($_GET['student_id'])) {
    $student_id = $_GET['student_id'];
    $student = $userModel->getStudentById($student_id);
}
