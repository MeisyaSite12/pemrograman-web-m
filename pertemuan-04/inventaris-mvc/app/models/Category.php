<?php

class Category extends Model
{
    use SoftDeletes;

    protected string $table = 'categories';

    public function count(): int
    {
        return (int) $this->db->query(
            "SELECT COUNT(*) FROM categories WHERE deleted_at IS NULL"
        )->fetchColumn();
    }

    public function all(): array
    {
        return $this->db->query(
            "SELECT c.*,
                    (SELECT COUNT(*) FROM items i
                     WHERE i.category_id = c.id AND i.deleted_at IS NULL) AS item_count
             FROM categories c
             WHERE c.deleted_at IS NULL
             ORDER BY c.name"
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
            "UPDATE categories SET name = :name, description = :description
             WHERE id = :id AND deleted_at IS NULL"
        )->execute($data);
    }
}