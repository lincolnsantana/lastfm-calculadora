const scrollableDiv = document.getElementById('result');
let isDragging = false;
let startX, scrollLeft;

scrollableDiv.addEventListener('mousedown', (e) => {
    isDragging = true;
    startX = e.pageX - scrollableDiv.offsetLeft;
    scrollLeft = scrollableDiv.scrollLeft;
    scrollableDiv.style.cursor = 'grabbing';
    //scrollableDiv.classList.add('no-select');
});

document.addEventListener('mousemove', (e) => {
    if (!isDragging) return;
    e.preventDefault();
    const x = e.pageX - scrollableDiv.offsetLeft;
    const walk = (x - startX) * 2; // Ajuste a velocidade do scroll
    scrollableDiv.scrollLeft = scrollLeft - walk;
});

document.addEventListener('mouseup', () => {
    isDragging = false;
    scrollableDiv.style.cursor = 'grab';
    scrollableDiv.classList.remove('no-select');
});

scrollableDiv.addEventListener('mouseleave', () => {
    isDragging = false;
    scrollableDiv.style.cursor = 'grab';
    scrollableDiv.classList.remove('no-select');
});

const containerResult = document.getElementById('container-result');
const rowResult = document.getElementById('row-result');
const result = document.getElementById('result');
const colResult = document.getElementById('col-result');


// Função para aplicar classes com base na resolução da tela
function applyClassBasedOnResolution() {
    if (window.matchMedia("(max-width: 375px)").matches) {

        containerResult.classList.add('container');
        containerResult.classList.remove('container-fluid');
        containerResult.classList.remove('text-left');
        
        rowResult.classList.add('row-gap-3');
        

        result.classList.remove('result');
        result.classList.remove('d-flex');
        result.classList.remove('flex-nowrap');
        result.classList.remove('overflow-auto');
        result.classList.remove('h-100');
        colResult.classList.remove('no-select');

        
        result.classList.add('p-0');
        colResult.classList.add('container');
        colResult.classList.add('p-0');
        colResult.classList.add('flex-column');
        colResult.classList.add('row-gap-2');
    
        // Seleciona todas as imagens dentro dos containers com a classe 'container card-album'
        const images = document.querySelectorAll('.container.card-album img.img-fluid');

        // Itera por todos os elementos selecionados e altera a classe
        images.forEach(img => {
            img.classList.remove('img-fluid'); 
            img.classList.remove('mb-4'); 
            img.classList.add('img-mobile'); 
        });


    } else {
        
        containerResult.classList.add('container-fluid');
        containerResult.classList.add('text-left');

        containerResult.classList.remove('container');
        rowResult.classList.remove('row-gap-3');
        result.classList.remove('p-0');
        colResult.classList.remove('container');
        colResult.classList.remove('flex-column');
        colResult.classList.remove('row-gap-2');

        const images2 = document.querySelectorAll('.container.card-album img.img-mobile');

        // Itera por todos os elementos selecionados e altera a classe
        images2.forEach(img => {
            img.classList.remove('img-mobile'); 
            img.classList.add('img-fluid'); 
            img.classList.add('mb-4'); 
            
        });

        
        result.classList.add('result');
        result.classList.add('d-flex');
        result.classList.add('flex-nowrap');
        result.classList.add('overflow-auto');
        result.classList.add('h-100');
        colResult.classList.add('no-select');
        
    }
}

// Chamar a função inicialmente para definir a classe correta com base na resolução atual
applyClassBasedOnResolution();

// Adicionar um ouvinte de eventos para redimensionamento da janela
window.addEventListener('resize', applyClassBasedOnResolution);
