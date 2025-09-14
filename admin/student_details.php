<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../models/borrow.php';

$roleRequired = 'admin';
require_role($roleRequired);

$userModel = new User();
$borrowModel = new Borrow();

$studentId = (int)($_GET['id'] ?? 0);
$student = null;
$borrowedBooks = [];

if ($studentId > 0) {
    $student = $userModel->findById($studentId);
    if ($student && $student['role'] === 'student') {
        $borrowedBooks = $borrowModel->getBorrowedByUser($studentId);
    }
}

if (!$student) {
    $_SESSION['flash_error'] = 'Student not found';
    header('Location: users.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details - <?= htmlspecialchars($student['name']) ?></title>
    <link rel="stylesheet" href="../public/css/style.css">
    <style>
        .student-info {
            background: #f9fafb;
            padding: 20px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .borrowed-books {
            margin: 20px 0;
        }

        .book-item {
            background: #fff;
            padding: 15px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            margin: 10px 0;
            display: flex;
            gap: 15px;
        }

        .book-cover {
            width: 60px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }

        .book-details {
            flex: 1;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }

        .status-borrowed {
            background: #fef3c7;
            color: #92400e;
        }

        .status-returned {
            background: #d1fae5;
            color: #065f46;
        }

        .btn {
            background: #111827;
            color: #fff;
            padding: 8px 16px;
            text-decoration: none;
            border-radius: 4px;
            display: inline-block;
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Student Details</h2>

        <div class="student-info">
            <h3><?= htmlspecialchars($student['name']) ?></h3>
            <p><strong>Email:</strong> <?= htmlspecialchars($student['email']) ?></p>
            <p><strong>Student ID:</strong> <?= htmlspecialchars($student['student_id'] ?? 'Not provided') ?></p>
            <p><strong>Phone:</strong> <?= htmlspecialchars($student['phone'] ?? 'Not provided') ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($student['address'] ?? 'Not provided') ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($student['role']) ?></p>
        </div>

        <div class="borrowed-books">
            <h3>Borrowing History</h3>
            <?php if (empty($borrowedBooks)): ?>
                <p>No books borrowed yet.</p>
            <?php else: ?>
                <?php foreach ($borrowedBooks as $book): ?>
                    <div class="book-item">
                        <img src="<?= htmlspecialchars($book['cover_url'] ?? '../public/assets/book1.jpg') ?>" alt="Book Cover" class="book-cover">
                        <div class="book-details">
                            <h4><?= htmlspecialchars($book['title']) ?></h4>
                            <p><strong>Author:</strong> <?= htmlspecialchars($book['author']) ?></p>
                            <p><strong>Borrowed:</strong> <?= htmlspecialchars($book['borrow_date']) ?></p>
                            <?php if ($book['return_date']): ?>
                                <p><strong>Returned:</strong> <?= htmlspecialchars($book['return_date']) ?></p>
                            <?php endif; ?>
                            <span class="status-badge <?= $book['status'] === 'borrowed' ? 'status-borrowed' : 'status-returned' ?>">
                                <?= ucfirst($book['status']) ?>
                            </span>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <a href="users.php" class="btn">Back to Users</a>
    </div>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>