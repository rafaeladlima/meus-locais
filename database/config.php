<?php 

ini_set('display_startup_erros',1);
error_reporting(E_ALL);

class Database{
  private $username = 'root';
  private $password = 'root';
  protected $conn;

    protected function conecta(){
      try{
        $this->conn = new PDO('mysql:host=localhost;port=3307;dbname=regiao', $this->username, $this->password);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return true;

      }catch(PDOException $e){
        echo 'ERROR: ' . $e->getMessage();

      }
    }
    

    
}