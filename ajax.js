$(document).ready(function() {
    // Habilita/desabilita o botão com base na entrada de texto
    $('#username').on('input', function() {
        if ($(this).val().length > 0) {
            $('#calculateBtn').prop('disabled', false);
        } else {
            $('#calculateBtn').prop('disabled', true);
        }
    });

    // Envia a requisição AJAX ao clicar no botão Calcular
    $('#calcForm').submit(function(event) {
        event.preventDefault(); // Previne o comportamento padrão do botão

        // Mostra o ícone de carregamento abaixo do formulário
        $('#loadingIcon').show();
        $('#calculateBtn').prop('disabled', true);

        var username = $('#username').val();

        $.ajax({
            url: 'calculadorahoras.php',
            method: 'POST',
            data: { username: username },
            success: function(response) {
                // Insere a resposta na div #resultado e exibe-a
                $('#resultado').html(response).fadeIn();
                $('#calculateBtn').prop('disabled', false);
                // Esconde o ícone de carregamento
                $('#loadingIcon').hide();
            },
            error: function(xhr, status, error) {
                // Exibe mensagem de erro em caso de falha
                $('#resultado').html('<p class="text-danger">Erro ao processar a solicitação. Tente novamente mais tarde.</p>').fadeIn();

                // Esconde o ícone de carregamento
                $('#loadingIcon').hide();
            }
        });
    });
});
