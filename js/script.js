


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

