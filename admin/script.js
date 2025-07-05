// Función global para cambiar de pestaña, llamada por los botones.
function openTab(evt, tabName) {
    // Ocultar todo el contenido de las pestañas
    const tabcontent = document.getElementsByClassName("tabcontent");
    for (let i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Quitar la clase "active" de todos los botones de pestaña
    const tablinks = document.getElementsByClassName("tablinks");
    for (let i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Mostrar la pestaña actual y añadir la clase "active" al botón
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
}

// Se ejecuta cuando el DOM está completamente cargado.
document.addEventListener("DOMContentLoaded", function () {

    // Lógica para inicializar las pestañas
    function initTabs() {
        const hash = window.location.hash.substring(1);
        let buttonToClick;

        if (hash) {
            // Busca un botón que corresponda al hash en la URL.
            buttonToClick = document.querySelector(`.tablinks[onclick*="'${hash}'"]`);
        }

        // Si no se encuentra un botón para el hash (o no hay hash), usa el predeterminado.
        if (!buttonToClick) {
            buttonToClick = document.getElementById("defaultOpen");
        }

        console.log("Botón a hacer clic:", buttonToClick);
        // Simula un clic en el botón para abrir la pestaña correcta.
        if (buttonToClick) {
            buttonToClick.click();
        }
    }

    // Lógica para manejar los mensajes flash que se desvanecen
    function initFlashMessages() {
        const flash = document.querySelector(".flash-message");
        if (flash) {
            setTimeout(() => {
                flash.style.transition = "opacity 0.6s ease";
                flash.style.opacity = 0;
                // Espera a que termine la transición para eliminar el elemento.
                setTimeout(() => flash.remove(), 600);
            }, 5000); // 5 segundos
        }
    }

    // Lógica para los checkboxes de iconos de redes sociales
    function initSocialMediaCheckboxes() {
        // Usar un selector más específico para evitar conflictos
        const checkboxes = document.querySelectorAll('#socialMedia input[type="checkbox"]');
        checkboxes.forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                const maxSeleccionados = 5;
                const seleccionados = document.querySelectorAll('#socialMedia input[type="checkbox"]:checked').length;
                if (seleccionados > maxSeleccionados) {
                    this.checked = false; // Desmarca el checkbox actual
                    alert('Solo puedes seleccionar un máximo de ' + maxSeleccionados + ' iconos.');
                }
            });
        });
    }

    // Lógica para el componente 'copiador' (explorador de archivos y previsualización)
    function initCopiador() {
        const fileExplorer = document.getElementById('file-explorer');
        if (!fileExplorer) {
            return; // Si el explorador no está en la pestaña actual, no hacer nada.
        }

        // --- LÓGICA PARA COPIAR RUTAS AL HACER CLIC ---
        fileExplorer.addEventListener('click', (e) => {
            // Asegurarse de que se hizo clic en un span con data-path
            if (e.target.tagName === 'SPAN' && e.target.dataset.path) {
                const path = e.target.dataset.path;

                // Obtener el input de destino que está seleccionado
                const targetRadio = document.querySelector('input[name="target_input"]:checked');
                if (targetRadio) {
                    const targetInputId = targetRadio.value;
                    const targetInput = document.getElementById(targetInputId);
                    if (targetInput) {
                        targetInput.value = path;
                    }
                }
            }
        });

        // --- LÓGICA PARA LA PREVISUALIZACIÓN DE IMÁGENES AL PASAR EL RATÓN ---
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        const previewLink = document.getElementById('preview-link'); // Obtenemos el nuevo enlace

        // Solo continuar si los elementos de previsualización existen
        if (previewContainer && previewImage && previewLink) {
            // Usamos delegación de eventos en el explorador para más eficiencia
            fileExplorer.addEventListener('mouseover', (e) => {
                const link = e.target.closest('[data-preview]');
                if (link) {
                    const imageUrl = link.getAttribute('data-preview');
                    previewImage.src = imageUrl;
                    previewLink.href = imageUrl; // Asignamos la URL al enlace
                    previewContainer.style.display = 'block';
                }
            });

            fileExplorer.addEventListener('mousemove', (e) => {
                // Solo mover si la previsualización está visible
                if (previewContainer.style.display === 'block') {
                    const mouseX = e.pageX;
                    const mouseY = e.pageY;
                    previewContainer.style.left = (mouseX + 15) + 'px';
                    previewContainer.style.top = (mouseY + 15) + 'px';
                }
            });

            fileExplorer.addEventListener('mouseout', (e) => {
                const link = e.target.closest('[data-preview]');
                if (link) {
                    previewContainer.style.display = 'none';
                    previewImage.src = '';
                    previewLink.href = ''; // Limpiamos el enlace
                }
            });
        }
    }

    // Inicializar funcionalidades initTabs(); initFlashMessages(); initSocialMediaCheckboxes();

});