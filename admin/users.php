<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';
$roleRequired = 'admin';
require_role($roleRequired);
require_once __DIR__ . '/../models/user.php';

$userModel = new User();
$searchResult = null;
$searchError = null;

// Handle search by student ID
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_student_id'])) {
    $studentId = trim($_POST['student_id'] ?? '');
    if (!empty($studentId)) {
        $searchResult = $userModel->getStudentById($studentId);
        if (!$searchResult) {
            $searchError = 'No student found with ID: ' . htmlspecialchars($studentId);
        }
    } else {
        $searchError = 'Please enter a student ID';
    }
}

$students = $userModel->getAllStudents();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .admin-table th,
        .admin-table td {
            border: 1px solid #e5e7eb;
            padding: 10px;
        }

        .admin-table th {
            background: #f9fafb;
            text-align: left;
            font-weight: 600;
        }

        .search-box {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .search-form {
            display: flex;
            gap: 10px;
            align-items: end;
        }

        .search-form input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .search-form button {
            background: #111827;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .student-details {
            background: #fff;
            padding: 15px;
            border-radius: 6px;
            margin-top: 15px;
            border: 1px solid #e5e7eb;
        }

        .btn {
            background: #111827;
            color: #fff;
            padding: 4px 8px;
            text-decoration: none;
            border-radius: 4px;
            font-size: 12px;
        }

        .error {
            color: #dc2626;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>User Management</h2>

        <!-- Search by Student ID -->
        <div class="search-box">
            <h3>Search Student by ID</h3>
            <form method="post" class="search-form">
                <div>
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" placeholder="Enter student ID" required>
                </div>
                <button type="submit" name="search_student_id">Search</button>
            </form>

            <?php if ($searchError): ?>
                <div class="error"><?= $searchError ?></div>
            <?php endif; ?>

            <?php if ($searchResult): ?>
                <div class="student-details">
                    <h4>Student Details</h4>
                    <p><strong>Name:</strong> <?= htmlspecialchars($searchResult['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($searchResult['email']) ?></p>
                    <p><strong>Student ID:</strong> <?= htmlspecialchars($searchResult['student_id']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($searchResult['phone'] ?? 'Not provided') ?></p>
                    <p><strong>Address:</strong> <?= htmlspecialchars($searchResult['address'] ?? 'Not provided') ?></p>
                    <p><strong>Role:</strong> <?= htmlspecialchars($searchResult['role']) ?></p>
                    <a href="student_details.php?id=<?= (int)$searchResult['user_id'] ?>" class="btn">View Full Details</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- All Students List -->
        <h3>All Students</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Student ID</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($students as $s): ?>
                    <tr>
                        <td><?php echo (int)$s['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($s['name']); ?></td>
                        <td><?php echo htmlspecialchars($s['email']); ?></td>
                        <td><?php echo htmlspecialchars($s['student_id'] ?? 'N/A'); ?></td>
                        <td>
                            <a href="student_details.php?id=<?= (int)$s['user_id'] ?>" class="btn">View Details</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>