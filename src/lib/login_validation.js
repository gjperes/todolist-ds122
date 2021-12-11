$(function(){

    $(".form-signin").on("submit", function() {

        let semErro = true;
        
        // TODO: melhorar, se possível usando um RegEx de validação de strings
        // Verifica se os inputs estão nulos, sem dados
        if ($("#email-input").val() == "" || $("#email-input") == null) {
            $("#erro-email").html("É necessário inserir o email"); 
            erro = false;
        } else if ($("#senha-input").val() == "" || $("#senha-input") == null) {
            $("#erro-senha").html("É necessário inserir a senha"); 
            erro = false;
        }
        
        // Se tiver algum erro, retorna "false" -> não permite o envio do formulário
        return semErro;
    });
    
});