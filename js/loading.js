document.addEventListener('DOMContentLoaded', function() {
    // Seleciona o formulário e o botão de envio
    const form = document.querySelector('form');
    const submitButton = form.querySelector('button[type="submit"]');

    // Adiciona um evento de click ao botão de envio
    submitButton.addEventListener('click', function(event) {
        //event.preventDefault(); // Previne o envio padrão do formulário

        // Oculta o formulário
        const userForm = document.getElementById('user-form');
        userForm.style.display = 'none';

        // Mostra a div com id result-div
        const resultDiv = document.getElementById('loading-div');
        resultDiv.style.display = 'block';
    });
});