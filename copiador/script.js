document.addEventListener('DOMContentLoaded', () => {

    const fileExplorer = document.getElementById('file-explorer');
    let ultimoSeleccionado = null; // Variable para guardar el último elemento clicado

    // Usamos delegación de eventos para manejar los clics de forma eficiente.
    fileExplorer.addEventListener('click', (event) => {
        const target = event.target;

        // Nos aseguramos de que se ha hecho clic en un SPAN con clase 'file' o 'folder'.
        if (target.matches('span.file') || target.matches('span.folder')) {
            
            // 1. Obtenemos la ruta del atributo 'data-path'.
            const path = target.dataset.path;

            // 2. Determinamos cuál es el input de destino comprobando el radio button seleccionado.
            const radioSeleccionado = document.querySelector('input[name="target_input"]:checked');
            
            if (!radioSeleccionado) {
                alert('Por favor, selecciona un campo de destino primero.');
                return;
            }

            const idInputDestino = radioSeleccionado.value;
            const inputDestino = document.getElementById(idInputDestino);

            // 3. Copiamos la ruta al valor del input.
            if (inputDestino) {
                inputDestino.value = path;
            }

            // 4. Añadimos feedback visual: quitamos la clase 'selected' del anterior y la ponemos en el nuevo.
            if (ultimoSeleccionado) {
                ultimoSeleccionado.classList.remove('selected');
            }
            target.classList.add('selected');
            ultimoSeleccionado = target; // Actualizamos la referencia al último seleccionado.
        }
    });
});