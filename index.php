<?php
//ini_set('display_errors',1);
//ini_set('display_startup_erros',1);
//error_reporting(E_ALL);

define('ROOT_PATH', dirname(__FILE__));
include ROOT_PATH.'/database/model.php';
?>


<!DOCTYPE html>
<html>
    <head>
         <link rel="stylesheet" href="./fontawesome-free-5.13.1-web/css/all.css">
        <link rel="stylesheet" href="./css/style.css">
        <meta charset="utf-8">
    </head>
    <title>Meus locais</title>
    
<body>
    <header>
        <h2>Meus locais - visitados</h2>
    </header>
    
    <div id="wrapper">
  
    <table id="tabela" border="1">
        
        <thead id="thead-table">
      <tr>
          
       <th>Local</th>
       <th>Visitou em</th>
       <th>Menu</th>
      </tr>
        </thead>
        <tbody>
            <?php 
            $resul = $model->listarLocal();
            if( array($resul) )
            ?>
              <?php 
                 foreach($resul as $key=>$l){
              ?>
                   <tr>
                     <td><?php echo $l['nome'];?></td>
                     <td><?php $data = DateTime::createFromFormat('Y-m-d',$l['data']);
                         echo $data->format('d/m/   Y');
                         ?>
                     </td>
                     <td>
                       <a class="editar" id="<?php echo $l['id'];?>" title="editar"><i class="fa fa-compass" aria-hidden="true"></i></a>
                       <a onclick ="delete();" title="excluir"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                 </tr>
               <?php }?>
           
        </tbody>
     
    </table>
    <div class="btn-add">
        <a onclick="abrirModal();"><span>criar novo local</span></a>
    </div>
        
</div>
    
    <div id="cadastrar" class="modal">
           <div class='modal-header'>
               <h2>Novo local</h2>
               <a onclick="fecharModal();"><span class="close">X</span></a>
        </div>
            
            
            <form name="form-cadastro" id="form">
                
               <fielset class="form-group">
                   <fieldset class="group">
                         <div class="input">
                       <label for="nome">Nome:</label> <input type="text" name="nome" id="nome" required>
                   </div>
                          <div class="input">
                          <label for="cep">CEP:</label> <input type="text" name="cep" id="cep" value="" size="10" maxlength="9" required>
                      </div>
                         <div class="input">
                          <label for="rua">Logradouro:</label> <input type="text" id="rua" name="logradouro" required>
                      </div>
                   </fieldset>
                 
                  
                  <fieldset class="group">
                   
                      <div class="input">
                          <label for="complemento">Complemento:</label><input type="text"  id="complemento" name="complemento" required>
                      </div>
                      <div class="input">
                          <label for="numero">Nº:</label><input type="text" id="numero" name="numero" required>
                      </div>
                      <div class="input">
                          <label for="bairro">Bairro:</label><input type="text" id="bairro" name="bairro" required>
                      </div>
                   </fieldset>
                
                   <fieldset class="group">
                             <div class="input">
                          <label for="uf">UF:</label>
                                 <input name="uf" type="text" id="uf" size="2" />
                      </div>
                      <div class="input">  
                          <label for="cidade">Cidade:</label><input type="text"  id="cidade"name="cidade" required>
                      </div>
                 </fieldset>
                   
                   <div class="input">
                       <label for="data">Data:</label><input type="date"  id="data" name="data" required>   
                   </div>
                </fielset>
                
                
                <div class="btn-enviar"><span id="envia">cadastrar</span></div>
                  <div class="btn-editar"><span id="edita">editar</span></div>
                
            </form>      
        </div>
        
</body>
</html>
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="crossorigin="anonymous"></script>
            


<script>
    

$(".editar").on('click',function(e){
        var id = $(this).attr('id');
         $('.modal').css('opacity','1');
         $('.btn-enviar').css('opacity','0');
    
         $.ajax({
        url:'database/model.php/editar/',
        type:'post',
        dataType:'json',
             data:{
                 'id': id
                 },
        beforeSend: function(d){
            console.log('id antes de ser enviado: '+id);
        },
        success:function(resposta){

        }, 

        error:function(resposta){
            console.log('ocorreu algum erro');
            console.log(resposta);
        }

    });
        
});
    
    function abrirModal(){
      
         
       //    $('#tabela').css('opacity','0.4');  
           $('.btn-editar').css('opacity','0');
           $('.btn-add').css('opacity','0.4');  
           $('.modal').css('opacity','1'); 
    }
    
    function fecharModal(){
        console.log(fechar);
        $('#cadastrar').css('opacity','0');
        
    }
    
    
            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#rua").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#uf").val("");
               
            }
    
    
   $('document').ready(function() {
          $('#criar').click(function(e){
          e.preventDefault();
           console.log('oii');
       });
       
    
       
    $('#cep').blur(function(){
        var cep =  $(this).val().replace(/\D/g, '');
        
          var cep = $(this).val().replace(/\D/g, '');
        console.log('cep: ' + cep);
        

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#rua").val("...");
                        $("#bairro").val("...");
                        $("#cidade").val("...");
                        $("#uf").val("...");
                      

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                var rua = $("#rua").val(dados.logradouro);
                                var bairro = $("#bairro").val(dados.bairro);
                                var cidade = $("#cidade").val(dados.localidade);
                                var uf = $("#uf").val(dados.uf);
                                
                                if(dados.uf == 'MG'){
                                     $('#uf').css('background','#2f7fae');
                                     $('#uf').css('color','#ffffff');
                                    
                                    
                                }
                                
                            
                                
                                
                             
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                     alert("Favor informar o CEP para a consulta.");
                    limpa_formulário_cep();
                }
        
        
        
    });
 
       
       //  var local = $('#nome').val(''); 
         //var complemento = $('#complemento').val(''); 
         //var numero = $('#numero').val('');
       
     
    

       
       $('#envia').click(function(e){
           
           e.preventDefault();
           console.log('envia');
           if($('#nome').val() == ''){
               alert('campo obrigatorio');
               return;
           }if($('#complemento').val() == ''){
                alert('campo obrigatorio');
               
                
           }if($('#numero').val() == ''){
                alert('campo obrigatorio');
               return;
           }if($('#data').val() == ''){
               alert('data obrigatoria');
               return;
           

           }else{
             
               //ajax
             $.ajax({
               method: "POST",
               type: 'application/json; charset=utf-8',
               url: "database/model.php/cadastrar/",
               data: {
                    'nome': $('#nome').val(),
                    'cep' : $('#cep').val(),
                    'logradouro': $('#rua').val(),
                     'complemento': $('#complemento').val(),
                   'numero': $('#numero').val(),
                   'bairro': $('#bairro').val(),
                   'uf': $('#uf').val(),
                   'cidade': $('#cidade').val(),
                   'data': $('#data').val()
                     },
            error: function(e){
                console.log('error' + e);
            },
                 success: function(e){
                     
                     if(e == true){
                          $('#cadastrar').hide();
                          alert('cadastrado com sucesso');                         
                          setInterval(function(){
                            location.reload();
                          },2000);
                     }else{
                          $('#cadastrar').hide();
                          alert('já existe esse local registrado');
                          setInterval(function(){
                            location.reload();
                          },2000);
                        
                         
                         
                     }
                     
                 }
              });
           }
           if($('#complemento').val() == ''){
             alert('obrigatorio');
           }if($('#numero').val() == ''){
            alert('obrigatorio');
           }
                       
                       

           
          
           
       });
       
    
    
       
});

</script>