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
            console.log("Nodo seleccionado:", nodo);
            console.log("Contenedor:", this.container);
            console.log("¿Contenedor contiene nodo?", this.container.contains(nodo instanceof Element ? nodo : nodo.parentElement));

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
        new SeleccionDetector(".archivos.subidaPaginas");
new SeleccionDetector(".archivos.subidaMedia");

    }
    catch (e) {
        console.error(e);
    }
});
export { SeleccionDetector };
document.addEventListener("selectionchange", () => {
    const sel = window.getSelection();
    console.log("Selección detectada:", sel.toString());

    if (!sel || sel.isCollapsed) {
        console.log("Nada seleccionado o selección vacía");
        return;
    }

    const texto = sel.toString().trim();
    if (!texto.endsWith(".md")) {
        console.log("Texto seleccionado no termina en .md:", texto);
        return;
    }

    const nodo = sel.anchorNode;
    console.log("Nodo ancla de selección:", nodo);

    let elemento = nodo.nodeType === 3 ? nodo.parentElement : nodo; // nodo 3 = TEXT_NODE

console.log("Elemento base:", elemento);

const contenedor = document.querySelector(".archivos");
console.log("Contenedor:", contenedor);

if (elemento && contenedor.contains(elemento)) {
    console.log("✅ Selección dentro de .archivos:", texto);
} else {
    console.log("❌ Selección fuera de .archivos");
}

    console.log("Elemento padre (tipo Element):", elemento);

  //  const contenedor = document.querySelector(".archivos");
    if (!contenedor) {
        console.log("No existe el contenedor '.archivos'");
        return;
    }
    console.log("Contenedor '.archivos':", contenedor);

    if (elemento && contenedor.contains(elemento)) {
        console.log("✅ Selección dentro del contenedor .archivos:", texto);
        // Aquí iría enviarAlServidor(texto);
    } else {
        console.log("❌ Selección fuera del contenedor .archivos");
    }
});
