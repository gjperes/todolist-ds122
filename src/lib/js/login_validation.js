$(function(){

    console.log("JavaScript ok")

    $("#form-login").submit( function(event) {

        // Verifica se os inputs estão nulos, sem dados
        if ($("#email-input").val() == "" || $("#email-input") == null) {
            $("#erro-email").html("É necessário inserir o email") 
            return false
        } else if ($("#senha-input").val() == "" || $("#senha-input") == null) {
            $("#erro-senha").html("É necessário inserir a senha")
            return false
        }
        
        // Se tiver algum erro, retorna "false" -> não permite o envio do formulário
        return true
    });

});