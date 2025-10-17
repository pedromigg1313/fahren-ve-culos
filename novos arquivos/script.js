function mostrarTexto(event, texto) {
    event.preventDefault(); // evita recarregar a página

    const elemento = document.getElementById('textoCard');
    if (elemento) {
        // atualiza o texto
        elemento.textContent = texto;

        // garante que o texto apareça (se estava oculto)
        elemento.style.display = 'block';
    }
}

