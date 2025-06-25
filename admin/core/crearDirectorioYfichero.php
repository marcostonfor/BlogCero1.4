<?php
// Este archivo ahora solo contiene el formulario HTML.
// La lógica de procesamiento se ha movido a 'procesar_contenido.php'.
?>
<!-- Formulario HTML -->
<form method="post" action="<?php echo BASE_URL; ?>/admin/core/procesar_contenido.php" id="formFornew">
    <input type="hidden" name="form_crear_contenido" value="1">
    <label>Ruta relativa (dentro de MD/):<br>
        <input type="text" name="path" placeholder="ej: docs/manual (opcional)">
    </label><br><br>

    <label>Nombre:<br>
        <input type="text" name="nombre" required>
    </label><br><br>

    <label>Tipo:<br>
        <select name="tipo" required>
            <option value="archivo">Archivo .md</option>
            <option value="carpeta">Carpeta</option>
        </select>
    </label><br><br>

    <button type="submit">Crear</button>
</form>