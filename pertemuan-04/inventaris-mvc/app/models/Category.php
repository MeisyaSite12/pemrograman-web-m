<?php

class Category extends Model
{
    protected string $table = 'categories';

    public function all(): array
    {
        return $this->db->query(
            "SELECT c.*, (SELECT COUNT(*) FROM items i
                          WHERE i.category_id = c.id AND i.deleted_at IS NULL) AS item_count
             FROM categories c WHERE c.deleted_at IS NULL ORDER BY c.name"
        )->fetchAll();
    }

    public function find(int $id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ? AND deleted_at IS NULL");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create(array $data): bool
    {
        return $this->db->prepare(
            "INSERT INTO categories (name, description) VALUES (:name, :description)"
        )->execute($data);
    }

    public function update(int $id, array $data): bool
    {
        $data['id'] = $id;
        return $this->db->prepare(
            "UPDATE categories SET name = :name, description = :description WHERE id = :id"
        )->execute($data);
    }

    // Soft delete: barang di kategori ini dilepas (category_id = NULL)
    public function delete(int $id): bool
    {
        try {
            $this->db->beginTransaction();
            $this->db->prepare("UPDATE items SET category_id = NULL WHERE category_id = ?")->execute([$id]);
            $this->db->prepare("UPDATE categories SET deleted_at = NOW() WHERE id = ?")->execute([$id]);
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            return false;
        }
    }
}