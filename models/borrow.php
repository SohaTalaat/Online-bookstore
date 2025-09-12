<?php

require_once __DIR__ . '/basemodel.php';
require_once __DIR__ . '/book.php';

class Borrow extends BaseModel
{
    protected $table = 'user_book';

    public function borrowBook(int $userId, int $bookId)
    {
        $this->db->beginTransaction();
        try {
            // Check availability
            $bookModel = new Book();
            $book = $bookModel->getBookById($bookId);
            if (!$book || (int)$book['available_copies'] <= 0) {
                $this->db->rollBack();
                return ['ok' => false, 'message' => 'Book not available'];
            }

            // Insert borrow record
            $sql = "INSERT INTO {$this->table} (user_id, book_id, status) VALUES (:user_id, :book_id, 'borrowed')";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId, ':book_id' => $bookId]);

            // Decrement available copies
            $ok = $bookModel->decrementAvailable($bookId);
            if (!$ok) {
                $this->db->rollBack();
                return ['ok' => false, 'message' => 'Failed to update availability'];
            }

            $this->db->commit();
            return ['ok' => true];
        } catch (Throwable $e) {
            $this->db->rollBack();
            return ['ok' => false, 'message' => $e->getMessage()];
        }
    }

    public function returnBook(int $userId, int $bookId)
    {
        $this->db->beginTransaction();
        try {
            // Update borrow record
            $sql = "UPDATE {$this->table}
                    SET status = 'returned', return_date = NOW()
                    WHERE user_id = :user_id AND book_id = :book_id AND status = 'borrowed'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':user_id' => $userId, ':book_id' => $bookId]);

            if ($stmt->rowCount() === 0) {
                $this->db->rollBack();
                return ['ok' => false, 'message' => 'No active borrow found'];
            }

            // Increment available copies
            $bookModel = new Book();
            $bookModel->incrementAvailable($bookId);

            $this->db->commit();
            return ['ok' => true];
        } catch (Throwable $e) {
            $this->db->rollBack();
            return ['ok' => false, 'message' => $e->getMessage()];
        }
    }

    public function getBorrowedByUser(int $userId)
    {
        $sql = "SELECT ub.*, b.title, b.author, b.cover_url
                FROM {$this->table} ub
                JOIN books b ON b.book_id = ub.book_id
                WHERE ub.user_id = :user_id
                ORDER BY ub.borrow_date DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
