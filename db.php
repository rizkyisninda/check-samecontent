<?php



class Db {
    
    public function connect() {
        try {
            $db = new PDO("mysql:host=localhost;dbname=coba", "root", "password");
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $db;
        } catch(PDOException $err) {
            echo "ERROR: Unable to connect: " . $err->getMessage();
        }
    }
}
?>
