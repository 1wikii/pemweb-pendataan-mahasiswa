<?php

// Configurasi untuk koneksi ke mysql database
class Connection
{
    private $host = 'localhost';
    private $DB_name = 'data_mahasiswa';
    private $table_name = 'users';
    private $DB_username = 'root';
    private $DB_password = '';
    public $DB;

    public function getConnection()
    {
        $this->DB = null;

        try {
            // configurasi koneksi ke mysql
            $this->DB = new PDO("mysql:host=$this->host; dbname=$this->DB_name", $this->DB_username, $this->DB_password);
            $this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   // set attribute error PDO untuk handling error lebih mudah
            $this->DB->exec("set names utf8");

        } catch (PDOException $exception) {
            echo "Connection Error : " . $exception->getMessage();
        }
    }


    //  getter untuk menjaga keamanan koneksi ke database mencegah terjadinya hacking ke database
    public function getHostName()
    {
        return $this->host;
    }

    public function getDBName()
    {
        return $this->DB_name;
    }

    public function getTableName()
    {
        return $this->table_name;
    }

    public function setTableName($name)
    {
        $this->table_name = $name;
    }

    public function getUsername()
    {
        return $this->DB_username;
    }

    public function getPassword()
    {
        return $this->DB_password;
    }

}