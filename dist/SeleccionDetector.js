"use strict";
class SeleccionDetector {
    constructor(selector) {
        const contenedor = document.querySelector(selector);
        if (!contenedor) {
            throw new Error(`El selector '${selector}' no corresponde a ningún elemento del DOM.`);
        }
        this.container = contenedor;
        this.init();
    }
    init() {
        console.log("🎯 Detector iniciado");
        document.addEventListener("selectionchange", () => {
            const sel = window.getSelection();
            if (!sel || sel.isCollapsed)
                return;
            const texto = sel.toString().trim();
            if (!texto.endsWith(".md"))
                return;
            const nodo = sel.anchorNode;
            if (nodo && this.container.contains(nodo instanceof Element ? nodo : nodo.parentElement)) {
                console.log("📄 Archivo seleccionado:", texto);
                this.enviarAlServidor(texto);
            }
        });
    }
    enviarAlServidor(nombreArchivo) {
        fetch("recibir.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ archivo: nombreArchivo })
        })
            .then((res) => res.ok ? console.log("✅ Enviado correctamente") : console.error("❌ Error al enviar"))
            .catch((err) => console.error("❌ Fallo en la red:", err));
    }
}
// Esperamos al DOM
window.addEventListener("DOMContentLoaded", () => {
    try {
        new SeleccionDetector(".archivos");
    }
    catch (e) {
        console.error(e);
    }
});
