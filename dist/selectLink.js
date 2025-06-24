"use strict";
document.addEventListener("selectionchange", () => {
    const selection = window.getSelection();
    if (!selection || selection.isCollapsed)
        return; // Nada seleccionado
    const range = selection.getRangeAt(0);
    const container = range.commonAncestorContainer;
    // Buscar si el nodo pertenece a un <a href="Subidasmd/...">
    let element = container instanceof Element ? container : container.parentElement;
    while (element && element !== document.body) {
        if (element instanceof HTMLAnchorElement && element.href.includes("Subidasmd/")) {
            console.log("🟢 Link seleccionado:", element.href);
            // Aquí puedes activar lo que necesites
            // Por ejemplo, enviar al servidor:
            fetch("/procesar_seleccion.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ link: element.href })
            });
            break; // Ya lo encontramos
        }
        element = element.parentElement;
    }
});
