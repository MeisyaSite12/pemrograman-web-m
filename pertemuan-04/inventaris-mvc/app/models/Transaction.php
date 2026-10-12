<?php

class Transaction extends Model
{
    protected string $table = 'transactions';

    public function create(array $data): bool
    {
        try {
            $this->db->beginTransaction();

            $this->db->prepare(
                "INSERT INTO transactions (item_id, user_id, type, quantity, notes)
                 VALUES (:item_id, :user_id, :type, :quantity, :notes)"
            )->execute([
                ':item_id'  => $data['item_id'],
                ':user_id'  => $data['user_id'],
                ':type'     => $data['type'], // 'IN' atau 'OUT'
                ':quantity' => $data['quantity'],
                ':notes'    => $data['notes'] ?? null,
            ]);

            $op = ($data['type'] === 'IN') ? '+' : '-';
            $this->db->prepare("UPDATE items SET quantity = quantity {$op} :quantity WHERE id = :item_id")
                ->execute([':quantity' => $data['quantity'], ':item_id' => $data['item_id']]);

            $check = $this->db->prepare("SELECT quantity FROM items WHERE id = :item_id");
            $check->execute([':item_id' => $data['item_id']]);
            if ((int) $check->fetchColumn() < 0) {
                $this->db->rollBack();
                return false;
            }

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            Logger::error('Koneksi database gagal', ['error' => $e->getMessage()]);
            return false;
        }
    }
    public function all(): array
{
    return $this->db->query(
        "SELECT t.*, i.code AS item_code, i.name AS item_name, u.full_name AS user_name
         FROM transactions t
         JOIN items i ON t.item_id = i.id
         JOIN users u ON t.user_id = u.id
         ORDER BY t.id DESC"
    )->fetchAll();
}   

    public function recent(int $limit = 5): array
    {
        return $this->db->query(
            "SELECT t.*, i.code AS item_code, i.name AS item_name, u.full_name AS user_name
            FROM transactions t
            JOIN items i ON t.item_id = i.id
            JOIN users u ON t.user_id = u.id
            ORDER BY t.id DESC LIMIT " . (int) $limit
        )->fetchAll();
    }

    public function todayCount(): int
    {
        return (int) $this->db->query(
            "SELECT COUNT(*) FROM transactions WHERE DATE(created_at) = CURDATE()"
        )->fetchColumn();
    }

    public function byItem(int $itemId): array
{
    $stmt = $this->db->prepare(
        "SELECT t.*, u.full_name AS user_name
         FROM transactions t JOIN users u ON t.user_id = u.id
         WHERE t.item_id = ? ORDER BY t.id DESC"
    );
    $stmt->execute([$itemId]);
    return $stmt->fetchAll();
}
}