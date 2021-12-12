// Validação frontend da página de Cadastro do usuário (register.php)

$(function(){

    console.log("JavaScript ok")

    const formID = "#form-register"
    const elements = [
        ["#nome-input", "#erro-nome", "É necessário preencher o nome"],
        ["#email-input", "#erro-email", "É necessário preencher o email"],
        ["#senha-input", "#erro-senha", "É necessário preencher a senha"],
        ["#confirme-senha-input", "#erro-confirme-senha", "É necessário confirmar a senha"]
    ]


    $(formID).submit( function() {
        
        for(let index in elements) {
        
            let elementsID = elements[index][0]
            let elementsError = elements[index][1]
            let elementsHTML = elements[index][2]
            
            // Verifica se os inputs estão nulos, sem dados
            if($(elementsID).val() == "" || $(elementsID) == null) {
                $(elementsError).html(elementsHTML)
                return false
            }

        }

        return true
    });
    
});