<?php

require_once('config/database.php');
class Mahasiswa extends Connection
{
    // atribut mahasiswa
    private $nim;
    private $nama;
    private $jenis_kelamin;
    private $prodi;

    public function __construct()
    {
        $this->getConnection();
        $this->setTableName('mahasiswa');
    }


    public function getMahasiswa()
    {
        $query = "SELECT *,DATE_FORMAT(created_at, '%d/%m/%Y') AS date_added FROM " . $this->getTableName();

        $stmt = $this->DB->prepare($query);
        $stmt->execute();

        $mahasiswa = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $mahasiswa;
    }


    public function isAccountAlreadyExist($nim)
    {
        $query_table = $this->getTableName();

        $stmt = $this->DB->prepare("SELECT COUNT(*) FROM $query_table WHERE nim = :nim");
        $stmt->bindParam(":nim", $nim);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        if ($result >= 1) {
            return true;
        }

        return false;
    }


    public function addMahasiswa($nim, $nama, $jenis_kelamin, $status)
    {
        try {
            $this->DB->beginTransaction();

            $query = "INSERT INTO " . $this->getTableName() . " (nim, nama, jenis_kelamin, status) VALUES (:nim, :nama, :jenis_kelamin, :status)";

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':nim', $nim);
            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':jenis_kelamin', $jenis_kelamin);
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            $this->DB->commit();

        } catch (PDOException $e) {
            $this->DB->rollBack();  // rollback jika ada kesalahan data sehingga tidak masuk ke database

            exit("Gagal tambah mahasiswa : " . $e->getMessage());

        }
    }

    public function updateMahasiswa($id, $nim, $nama, $jenis_kelamin, $status)
    {
        try {
            $this->DB->beginTransaction();

            $query = "UPDATE " . $this->getTableName() .
                " SET nim = :nim, nama = :nama, jenis_kelamin = :jenis_kelamin, status = :status WHERE id = :id";

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':nim', $nim);
            $stmt->bindParam(':nama', $nama);
            $stmt->bindParam(':jenis_kelamin', $jenis_kelamin);
            $stmt->bindParam(':status', $status);
            $stmt->execute();

            $this->DB->commit();

        } catch (PDOException $e) {
            $this->DB->rollBack();  // rollback jika ada kesalahan data sehingga tidak masuk ke database

            exit("Gagal update mahasiswa : " . $e->getMessage());
        }
    }

    public function deleteMahasiswa($id)
    {
        try {
            $this->DB->beginTransaction();

            $query = "DELETE FROM " . $this->getTableName() . " WHERE id = :id";

            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            $this->DB->commit();

        } catch (PDOException $e) {
            $this->DB->rollBack();  // rollback jika ada kesalahan data sehingga tidak masuk ke database

            exit("Gagal hapus mahasiswa : " . $e->getMessage());

        }
    }


}