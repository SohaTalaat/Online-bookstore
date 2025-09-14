<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../models/borrow.php';
require_once __DIR__ . '/../models/user.php';

$roleRequired = 'admin';
require_role($roleRequired);

$borrowModel = new Borrow();
$userModel = new User();

// Get filter parameters
$statusFilter = $_GET['status'] ?? 'all';
$studentIdFilter = $_GET['student_id'] ?? '';

// Get borrowed books with filters
$borrowedBooks = $borrowModel->getAllBorrowedBooks($statusFilter, $studentIdFilter);

// Get statistics
$stats = $borrowModel->getBorrowingStats();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Borrowed Books Management</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>

<body>
    <div class="container" style="min-height: 92vh; margin-top: 30px;">
        <h2>Borrowed Books Management</h2>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?= (int)$stats['total_borrows'] ?></div>
                <div class="stat-label">Total Borrows</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= (int)$stats['active_borrows'] ?></div>
                <div class="stat-label">Active Borrows</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?= (int)$stats['returned_borrows'] ?></div>
                <div class="stat-label">Returned Books</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters">
            <h3>Filters</h3>
            <form method="get" class="filter-form">
                <div class="filter-group">
                    <label for="status">Status:</label>
                    <select id="status" name="status">
                        <option value="all" <?= $statusFilter === 'all' ? 'selected' : '' ?>>All</option>
                        <option value="borrowed" <?= $statusFilter === 'borrowed' ? 'selected' : '' ?>>Borrowed</option>
                        <option value="returned" <?= $statusFilter === 'returned' ? 'selected' : '' ?>>Returned</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="student_id">Student ID:</label>
                    <input type="text" id="student_id" name="student_id" placeholder="Search by student ID" value="<?= htmlspecialchars($studentIdFilter) ?>">
                </div>
                <button type="submit" class="btn">Apply Filters</button>
                <a href="borrowed_books.php" class="btn btn-secondary">Clear Filters</a>
            </form>
        </div>

        <!-- Borrowed Books Table -->
        <h3>Borrowing Records</h3>
        <?php if (empty($borrowedBooks)): ?>
            <p>No borrowing records found with the current filters.</p>
        <?php else: ?>
            <table class="borrowed-table">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Student</th>
                        <th>Borrow Date</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($borrowedBooks as $record): ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="<?= htmlspecialchars($record['cover_url'] ?? '../public/assets/book1.jpg') ?>" alt="Book Cover" class="book-cover">
                                    <div>
                                        <div style="font-weight: 500;"><?= htmlspecialchars($record['title']) ?></div>
                                        <div style="color: #6b7280; font-size: 0.9em;"><?= htmlspecialchars($record['author']) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="student_details.php?id=<?= (int)$record['user_id'] ?>" class="student-link">
                                    <?= htmlspecialchars($record['student_name']) ?>
                                </a>
                                <div style="color: #6b7280; font-size: 0.9em;">
                                    ID: <?= htmlspecialchars($record['student_id']) ?>
                                </div>
                                <div style="color: #6b7280; font-size: 0.9em;">
                                    <?= htmlspecialchars($record['student_email']) ?>
                                </div>
                            </td>
                            <td><?= htmlspecialchars($record['borrow_date']) ?></td>
                            <td><?= $record['return_date'] ? htmlspecialchars($record['return_date']) : '-' ?></td>
                            <td>
                                <span class="status-badge <?= $record['status'] === 'borrowed' ? 'status-borrowed' : 'status-returned' ?>">
                                    <?= ucfirst($record['status']) ?>
                                </span>
                            </td>
                            <td>
                                <a href="student_details.php?id=<?= (int)$record['user_id'] ?>" class="btn">View Student</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>