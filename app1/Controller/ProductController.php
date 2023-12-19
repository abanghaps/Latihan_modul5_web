<?php

namespace app1\controller;

include "../app1/Config/Database.php";

use Database;

class ProductController
{
    private $db;

    public function __construct()
    {
        // Sediakan detail koneksi database yang diperlukan
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "prak_web5";

        // Koneksi ke database
        $this->db = new Database($host, $username, $password, $database);
    }

    public function index()
    {
        // Implementasi operasi READ
        $sql = "SELECT produk.*, kategori.jenis as kategori_jenis FROM produk 
        JOIN kategori ON produk.kategori_id = kategori.id";
        $result = $this->db->getConnection()->query($sql);

        $produk = [];

        while ($row = $result->fetch_assoc()) {
            $produk[] = $row;
        }

        return json_encode($produk);
    }

    public function getById($id)
    {
        // Implementasi operasi READ berdasarkan ID
        $sql = "SELECT * FROM produk WHERE id=?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $rental = $result->fetch_assoc();
            return json_encode($rental);
        } else {
            return json_encode(['error' => 'produk not found']);
        }
    }

    public function insert()
    {
        // Implementasi operasi CREATE
        $data = json_decode(file_get_contents("php://input"), true);
        $nama_produk = $data['nama_produk'];
        $kategori_id = $data['kategori_id'];
    
        // Periksa apakah kategori_id ada dalam tabel kategori
        if (!$this->isCategoryIdValid($kategori_id)) {
            return json_encode(['error' => 'kategori_id tidak ada di database']);
        }
    
        // Fix SQL Injection: Gunakan prepared statement
        $sql = "INSERT INTO produk (nama_produk, kategori_id) VALUES (?, ?)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("si", $nama_produk, $kategori_id);
        
        // Eksekusi kueri
        if ($stmt->execute()) {
            return json_encode(['message' => 'produk created successfully']);
        } else {
            // Tanggapan jika kueri tidak berhasil
            return json_encode(['error' => 'Failed to create produk']);
        }
    }
    
    // Fungsi untuk memeriksa apakah kategori_id valid
    private function isCategoryIdValid($kategori_id)
    {
        $sql = "SELECT id FROM kategori WHERE id=?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("i", $kategori_id);
        $stmt->execute();
        $stmt->store_result();
    
        // Kembalikan true jika kategori_id valid, false jika tidak
        return $stmt->num_rows > 0;
    }
    


    public function update($id)
    {
        // Implementasi operasi UPDATE
        $data = json_decode(file_get_contents("php://input"), true);
        $nama_produk = $data['nama_produk'];
        $kategori_id = $data['kategori_id'];
       

        // Fix SQL Injection: Gunakan prepared statement
        $sql = "UPDATE produk SET nama_produk=?, kategori_id=? WHERE id=?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("sii", $nama_produk, $kategori_id, $id);
        $result = $stmt->execute();

        if ($result) {
            return json_encode(['message' => 'produk updated successfully']);
        } else {
            return json_encode(['error' => 'Failed to update produk']);
        }
    }

    public function delete($id)
    {
        // Implementasi operasi DELETE
        // Fix SQL Injection: Gunakan prepared statement
        $sql = "DELETE FROM produk WHERE id=?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        if ($result) {
            return json_encode(['message' => 'produk deleted successfully']);
        } else {
            return json_encode(['error' => 'Failed to delete produk']);
        }
    }
}
?>
