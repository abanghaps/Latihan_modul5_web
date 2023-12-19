<?php

require_once 'Controller.php';

class KategoriController extends Controller
{
    public function create($data)
    {
        $name = $data['name'];
        $description = $data['description'];

        // Fix SQL Injection: Gunakan prepared statement
        $sql = "INSERT INTO kategori (name, description) VALUES (?, ?)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("ss", $name, $description);
        $result = $stmt->execute();

        if ($result) {
            return ['message' => 'kategori created successfully'];
        } else {
            return ['error' => 'Failed to create kategori'];
        }
    }

    public function read()
    {
        $sql = "SELECT * FROM kategori";
        $result = $this->db->getConnection()->query($sql);

        $kategori = [];

        while ($row = $result->fetch_assoc()) {
            $kategori[] = $row;
        }

        return $kategori;
    }

    public function update($data)
    {
        $id = $data['id'];
        $name = $data['name'];
        $description = $data['description'];

        // Fix SQL Injection: Gunakan prepared statement
        $sql = "UPDATE kategori SET name=?, description=? WHERE id=?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("ssi", $name, $description, $id);
        $result = $stmt->execute();

        if ($result) {
            return ['message' => 'kategori updated successfully'];
        } else {
            return ['error' => 'Failed to update kategori'];
        }
    }

    public function delete($id)
    {
        // Fix SQL Injection: Gunakan prepared statement
        $sql = "DELETE FROM kategori WHERE id=?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        if ($result) {
            return ['message' => 'kategori deleted successfully'];
        } else {
            return ['error' => 'Failed to delete kategori'];
        }
    }
}
?>
