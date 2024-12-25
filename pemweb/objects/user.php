<?php

require_once('config/database.php');


class User extends Connection
{

    // Attribut user
    private $username;
    private $password;
    private $notHashedPassword;
    private $date;
    protected $email;

    // Beberapa state proses untuk user
    private $isAccountAlreadyExist;
    private $isUsernameExist;
    private $successCreatingAccount;

    private $user;

    private $verificationStatus;

    /*------------CONSTRUCTOR----------------*/
    public function __construct($email, $password, $username = null)
    {
        $this->email = $email;
        $this->password = $this->hashingPassword($password);
        $this->notHashedPassword = $password;
        $this->username = $username;

        $this->isAccountAlreadyExist = false;
        $this->isUsernameExist = false;
        $this->successCreatingAccount = false;

        $this->getConnection();
    }

    public function SIGNUP()
    {

        /*----------------cek apakah akun sudah ada---------------*/
        if ($this->isAccountAlreadyExist($this->email)) {
            return false;
        }

        try {
            $query = "INSERT INTO " . $this->getTableName() . " (username, password, email)
                  VALUES (:username, :password, :email)";

            // menggunakan prepare dan bind params untuk mencegah SQL injection
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":email", $this->email);


            // menggunakan transaction untuk mengatur proses insert database jika salah bisa rollback
            $this->DB->beginTransaction();
            $stmt->execute();
            $this->DB->commit();

            return true;

        } catch (PDOException $e) {
            $this->DB->rollBack();  // rollback jika ada kesalahan data sehingga tidak masuk ke database

            exit("Gagal sign up : " . $e->getMessage());

        }
    }


    public function LOGIN()
    {
        try {

            $query = "SELECT email, password, username FROM " . $this->getTableName() . " 
                     WHERE email =:email; ";

            // menggunakan prepare dan bind params untuk mencegah SQL injection
            $stmt = $this->DB->prepare($query);
            $stmt->bindParam(":email", $this->email);
            $stmt->execute();

            $this->user = $stmt->fetch(PDO::FETCH_ASSOC);  // fetch data dari database

            // ketika tidak ada data yang match
            if (!$this->user) {
                $this->user = array('password' => "", "email" => "");
                $this->user['password'] = "";
                $this->user['email'] = "";
            }

        } catch (PDOException $e) {
            die("ERROR LOGIN : " . $e->getMessage());
        }

        //  VERIFY Username or Email and Password
        $hashedPassword = $this->user['password'];
        $status = array("email" => false, "password" => false);

        if ($this->user['email'] == $this->email) {
            $status['email'] = true;
        }

        if (password_verify($this->notHashedPassword, $hashedPassword)) {
            $status['password'] = true;
        }

        if ($status['email'] && $status['password']) {
            $this->username = $this->user['username'];
        }

        return $status;
    }


    /*----------------GET-------------------*/
    public function getDateTime()
    {
        $timeZone = new DateTimeZone('Asia/Jakarta');
        $currentTime = new DateTime('now', $timeZone);
        $formattedTime = $currentTime->format('Y-m-d H:i:s');

        return $formattedTime;
    }


    public function getUsername()
    {
        return $this->username;
    }


    public function getEmail()
    {
        return $this->email;
    }

    /*-----------FUNCTION TO MAKE SURE THE PROCESS--------------*/
    public function isAccountAlreadyExist($email)
    {

        $query_db = $this->getDBName();
        $query_table = $this->getTableName();

        $stmt = $this->DB->prepare("SELECT COUNT(*) FROM $query_table WHERE email = :email");
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $result = $stmt->fetchColumn();

        if ($result >= 1) {
            return true;
        }

        return false;
    }

    public function hashingPassword($password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        return $hash;
    }

    public function isPasswordShorterThan8Char()
    {
        if (strlen($this->notHashedPassword) < 8) {
            return true;
        }

        return false;
    }

    public function isUsernameContainSpace()
    {
        for ($i = 0; $i < strlen($this->notHashedPassword); $i++) {
            if ($this->notHashedPassword[$i] == " ") {
                return true;
            }
        }

        return false;
    }

    public function isUsernameContainNumber()
    {
        $number = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        for ($char = 0; $char < strlen($this->username); $char++) {
            for ($num = 0; $num < sizeof($number); $num++) {

                if ($this->username[$char] == $number[$num]) {
                    return true;
                }
            }
        }

        return false;
    }

    public function getIsAccountAlreadyExist()
    {
        return $this->isAccountAlreadyExist;
    }

    public function isUsernameExist()
    {
        return $this->isUsernameExist;
    }

    public function successCreatingAccount()
    {
        return $this->successCreatingAccount;
    }
}