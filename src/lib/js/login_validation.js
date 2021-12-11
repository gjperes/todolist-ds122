$(function(){

    $(".form-floating").on("submit", function() {

        let semErro = true;
        
        // Verifica se os inputs estão nulos, sem dados
        if ($("#email-input").val() == "" || $("#email-input") == null) {
            $("#erro-email").html("É necessário inserir o email"); 
            semErro = false;
        } else if ($("#senha-input").val() == "" || $("#senha-input") == null) {
            $("#erro-senha").html("É necessário inserir a senha"); 
            semErro = false;
        }
        
        // Se tiver algum erro, retorna "false" -> não permite o envio do formulário
        return semErro;
    });
    
});