document.addEventListener('DOMContentLoaded', () => {
    new SeleccionDetector(".archivos");
    // El contenedor de la tabla de archivos
    const contenedorArchivos = document.querySelector('.archivos');
    // El campo de texto donde queremos copiar el nombre
    const inputDestino = document.getElementById('nombre_archivo_mover');
    // Para recordar cuál fue el último elemento seleccionado
    let ultimoSeleccionado = null;

    // Nos aseguramos de que ambos elementos existan en la página
    if (contenedorArchivos && inputDestino) {
        // Usamos delegación de eventos para escuchar clics dentro del contenedor
        contenedorArchivos.addEventListener('click', (event) => {
            const target = event.target;

            // Si el elemento clicado es uno de nuestros spans copiables...
            if (target.classList.contains('archivo-copiable')) {
                // 1. Obtenemos el nombre del archivo del atributo data
                const nombreArchivo = target.dataset.nombreArchivo;

                // 2. Lo ponemos en el valor del input de destino
                inputDestino.value = nombreArchivo;

                // 3. Damos feedback visual
                if (ultimoSeleccionado) {
                    ultimoSeleccionado.classList.remove('selected');
                }
                target.classList.add('selected');
                ultimoSeleccionado = target;
            }
        });
    }
});