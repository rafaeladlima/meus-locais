<?php 
ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL);

require_once('config.php');

class Model extends Database{
   
     function listarLocal(){
         $this->conecta();
         
         $select = $this->conn->prepare('select * from locais');
         $select->execute();
         
         $resulSelect = $select->fetchAll(PDO::FETCH_ASSOC);
         
         return $resulSelect;
         
      
        
         //echo json_encode($array);

    }   
    
    function editar(){
        
}
    
    function cadastrar(){
        $this->conecta();
        
        
        
        if (!isset($_POST) || empty($_POST)){
            echo "<script> alert('Preencha Todos os Campos!')</script>" ;
            
        }else{
            
        
        $nome = $_POST['nome'];
        $cep = $_POST['cep'];
        $logradouro = $_POST['logradouro'];
        $complemento = $_POST['complemento'];
        $numero = $_POST['numero'];
        $bairro = $_POST['bairro'];
        $uf = $_POST['uf'];
        $cidade = $_POST['cidade'];
        $data = date('Y-m-d',strtotime($_POST['data']));
            
            
        $select = $this->conn->prepare("SELECT * FROM locais WHERE CEP = {$cep}");
        $select->execute();
        
        if($select->rowCount() > 0){
                header('content-type:application/json');
                
                echo json_encode(false);
        }else{
             $insert = $this->conn->prepare("INSERT INTO locais(id, nome,cep,logradouro,complemento,numero,bairro,uf,cidade,data) 
                                        VALUES (0,
                                        '{$nome}', '{$cep}', '{$logradouro}', '{$complemento}', '{$numero}', '{$bairro}', '{$uf}', '{$cidade}', '{$data}' ) 
                                        ");
            $insert->execute();
            
            
           if($insert->rowCount() > 0){
              
                header('content-type:application/json');
                
                echo json_encode(true);
            }else{
            
                 header('content-type:application/json');
                echo json_encode(false);
            }
            
        }
        
        
            
        }
        
     
        //$insert->execute();
        
       /// header('content-type:application/json');
        

    }
 

    }

   
    $model = new Model();

$model->cadastrar();
   




