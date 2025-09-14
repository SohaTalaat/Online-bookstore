<?php
require_once __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/../models/book.php';
require_once __DIR__ . '/../includes/auth.php';
$roleRequired = 'admin';
require_role($roleRequired);

$bookModel = new Book();

// Handle create/update/delete
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'create') {
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'author' => trim($_POST['author'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'total_copies' => (int)($_POST['total_copies'] ?? 1),
            'available_copies' => (int)($_POST['available_copies'] ?? 1),
            'cover_url' => trim($_POST['cover_url'] ?? ''),
        ];
        $bookModel->createBook($data);
        header('Location: books.php');
        exit;
    } elseif ($action === 'update') {
        $id = (int)($_POST['book_id'] ?? 0);
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'author' => trim($_POST['author'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'total_copies' => (int)($_POST['total_copies'] ?? 1),
            'available_copies' => (int)($_POST['available_copies'] ?? 1),
            'cover_url' => trim($_POST['cover_url'] ?? ''),
        ];
        if ($id > 0) {
            $bookModel->updateBook($id, $data);
        }
        header('Location: books.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id > 0) {
        $bookModel->deleteBook($id);
    }
    header('Location: books.php');
    exit;
}

$stmt = $bookModel->getAllBooks();
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Books</title>
    <link rel="stylesheet" href="../public/css/style.css">
    <link rel="stylesheet" href="../public/css/responsive.css">
    <link rel="stylesheet" href="../public/css/all.min.css">
    <style>
        .admin-table {
            width: 100%;
            border-collapse: collapse;
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

        form.inline {
            display: inline;
        }

        .admin-form {
            margin: 20px 0;
            background: #fff;
            padding: 16px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
        }

        .admin-form input,
        .admin-form textarea {
            width: 100%;
            margin: 6px 0;
            padding: 10px;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
        }

        .admin-form button,
        .btn {
            background: #111827;
            color: #fff;
            border: none;
            padding: 10px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .admin-form button:hover,
        .btn:hover {
            background: #1f2937;
        }

        details summary {
            cursor: pointer;
            color: #111827;
        }
    </style>
</head>

<body>
    <div class="container" style="margin-top: 20px;">
        <h2>Manage Books</h2>

        <h3>Create New Book</h3>
        <form class="admin-form" method="post">
            <input type="hidden" name="action" value="create">
            <input type="text" name="title" placeholder="Title" required>
            <input type="text" name="author" placeholder="Author" required>
            <textarea name="description" placeholder="Description"></textarea>
            <input type="number" name="total_copies" placeholder="Total Copies" min="1" value="1" required>
            <input type="number" name="available_copies" placeholder="Available Copies" min="0" value="1" required>
            <input type="url" name="cover_url" placeholder="Cover URL">
            <button type="submit">Create</button>
        </form>

        <h3>Books List</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cover</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Available/Total</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($books as $b): ?>
                    <tr>
                        <td><?php echo (int)$b['book_id']; ?></td>
                        <td>
                            <img src="<?php echo htmlspecialchars($b['cover_url'] ?? ''); ?>" alt="" style="width:50px;height:70px;object-fit:cover;">
                        </td>
                        <td><?php echo htmlspecialchars($b['title']); ?></td>
                        <td><?php echo htmlspecialchars($b['author']); ?></td>
                        <td><?php echo (int)$b['available_copies']; ?>/<?php echo (int)$b['total_copies']; ?></td>
                        <td>
                            <form class="inline" method="get">
                                <input type="hidden" name="delete" value="<?php echo (int)$b['book_id']; ?>">
                                <button type="submit" onclick="return confirm('Delete this book?')">Delete</button>
                            </form>

                            <details>
                                <summary>Edit</summary>
                                <form method="post" style="margin-top:8px;">
                                    <input type="hidden" name="action" value="update">
                                    <input type="hidden" name="book_id" value="<?php echo (int)$b['book_id']; ?>">
                                    <input type="text" name="title" value="<?php echo htmlspecialchars($b['title']); ?>" required>
                                    <input type="text" name="author" value="<?php echo htmlspecialchars($b['author']); ?>" required>
                                    <textarea name="description"><?php echo htmlspecialchars($b['description'] ?? ''); ?></textarea>
                                    <input type="number" name="total_copies" min="1" value="<?php echo (int)$b['total_copies']; ?>" required>
                                    <input type="number" name="available_copies" min="0" value="<?php echo (int)$b['available_copies']; ?>" required>
                                    <input type="url" name="cover_url" value="<?php echo htmlspecialchars($b['cover_url'] ?? ''); ?>">
                                    <button type="submit">Save</button>
                                </form>
                            </details>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php require_once __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>