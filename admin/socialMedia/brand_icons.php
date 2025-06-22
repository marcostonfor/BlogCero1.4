<?php
// Mover los includes al principio para que BASE_URL y el Singleton estén siempre disponibles.
require_once __DIR__ . '/../../router.php';
require_once __DIR__ . '/../../system_login/dbSingleton/databaseSingleton.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $iconosSeleccionados = isset($_POST['opciones_control']) ? $_POST['opciones_control'] : [];

    // Definiciones de iconos (nombre => [clase, unicode_hex])
    // Asegúrate de que estos coincidan con los 'value' de tus checkboxes
    // y que el unicode sea solo la parte hexadecimal (ej. 'f082' para Facebook).
    $iconDefinitions = [
        'facebook' => ['clase' => 'fa', 'unicode' => 'f082'],
        'twitter' => ['clase' => 'fa', 'unicode' => 'f099'],
        'instagram' => ['clase' => 'fa', 'unicode' => 'f16d'],
        'linkedin' => ['clase' => 'fa', 'unicode' => 'f0e1'],
        'github' => ['clase' => 'fa', 'unicode' => 'f09b'],
        'youtube' => ['clase' => 'fa', 'unicode' => 'f167'],
        'pinterest' => ['clase' => 'fa', 'unicode' => 'f0d2'],
        'tumbler' => ['clase' => 'fa', 'unicode' => 'f173'], // Considerar corregir a 'tumblr' si es un typo
        'flicker' => ['clase' => 'fa', 'unicode' => 'f16e'], // Considerar corregir a 'flickr' si es un typo
        'vine' => ['clase' => 'fa', 'unicode' => 'f1ca'],
        'reddit' => ['clase' => 'fa', 'unicode' => 'f1a1'],
        'skype' => ['clase' => 'fa', 'unicode' => 'f17e'],
        'soundcloud' => ['clase' => 'fa', 'unicode' => 'f1be'],
        'whatsapp' => ['clase' => 'fa', 'unicode' => 'f232'],
        'stackoverflow' => ['clase' => 'fa', 'unicode' => 'f16c'],
        'behance' => ['clase' => 'fa', 'unicode' => 'f17d'],
        'spotify' => ['clase' => 'fa', 'unicode' => 'f1bc'],
        'vimeo' => ['clase' => 'fa', 'unicode' => 'f27d'],
    ];

    $pdo = null; // Inicializar pdo para que esté disponible en el bloque catch
    try {
        // Obtener la conexión a través del Singleton, eliminando la conexión hardcodeada.
        $pdo = DatabaseSingleton::getInstance()->getConnection();
        $pdo->beginTransaction();

        // 1. Marcar todos los iconos existentes como no publicados inicialmente
        $pdo->exec("UPDATE social_media SET publicado = 0");

        if (!empty($iconosSeleccionados)) {
            // 2. Insertar/Actualizar y publicar solo los seleccionados
            // Asumimos que la tabla social_media tiene una clave única en 'nombre'
            $stmt = $pdo->prepare("
                INSERT INTO social_media (nombre, clase, unicode, publicado) 
                VALUES (:nombre, :clase, :unicode, 1) 
                ON DUPLICATE KEY UPDATE 
                    clase = VALUES(clase), 
                    unicode = VALUES(unicode), 
                    publicado = 1
            ");

            foreach ($iconosSeleccionados as $nombreIcono) {
                if (isset($iconDefinitions[$nombreIcono])) {
                    $definicion = $iconDefinitions[$nombreIcono];
                    $stmt->execute([
                        ':nombre' => $nombreIcono,
                        ':clase' => $definicion['clase'],
                        ':unicode' => $definicion['unicode']
                    ]);
                }
            }
        }
        $pdo->commit();

        // Redirigir de vuelta al dashboard para ver los cambios y evitar reenvío del formulario.
        header('Location: ' . BASE_URL . '/admin/dashboard.php');
        exit;

    } catch (PDOException $e) {
        if ($pdo && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        die("Error en base de datos: " . htmlspecialchars($e->getMessage()));
    }
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<form method="post" action="<?php echo BASE_URL; ?>/admin/socialMedia/brand_icons.php" class="social-media">
    <fieldset>
        <!-- Facebook -->
        <label><input type="checkbox" name="opciones_control[]" value="facebook">
            <i style="font-size:24px" class="fa">&#xf082;</i></label>

        <!-- Twitter -->
        <label><input type="checkbox" name="opciones_control[]" value="twitter">
            <i style="font-size:24px" class="fa">&#xf099;</i></label>

        <!-- Instagram -->
        <label><input type="checkbox" name="opciones_control[]" value="instagram">
            <i style="font-size:24px" class="fa">&#xf16d;</i></label>

        <!-- Linkedin -->
        <label><input type="checkbox" name="opciones_control[]" value="linkedin">
            <i style="font-size:24px" class="fa">&#xf0e1;</i></label>

        <!-- Git-Hub -->
        <label><input type="checkbox" name="opciones_control[]" value="github">
            <i style="font-size:24px" class="fa">&#xf09b;</i></label>
    </fieldset>
    <fieldset>
        <!-- YouTube -->
        <label><input type="checkbox" name="opciones_control[]" value="youtube">
            <i style="font-size:24px" class="fa">&#xf167;</i></label>

        <!-- Pinterest -->
        <label><input type="checkbox" name="opciones_control[]" value="pinterest">
            <i style="font-size:24px" class="fa">&#xf0d2;</i></label>

        <!-- Tumbler -->
        <label><input type="checkbox" name="opciones_control[]" value="tumbler">
            <i style="font-size:24px" class="fa">&#xf173;</i></label>

        <!-- Flicker -->
        <label><input type="checkbox" name="opciones_control[]" value="flicker">
            <i style="font-size:24px" class="fa">&#xf16e;</i></label>

        <!-- Vine -->
        <label><input type="checkbox" name="opciones_control[]" value="vine">
            <i style="font-size:24px" class="fa">&#xf1ca;</i></label>
    </fieldset>
    <fieldset>
        <!-- Reddit -->
        <label><input type="checkbox" name="opciones_control[]" value="reddit">
            <i style="font-size:24px" class="fa">&#xf1a1;</i></label>

        <!-- Skype -->
        <label><input type="checkbox" name="opciones_control[]" value="skype">
            <i style="font-size:24px" class="fa">&#xf17e;</i></label>

        <!-- SoundCloud -->
        <label><input type="checkbox" name="opciones_control[]" value="soundcloud">
            <i style="font-size:24px" class="fa">&#xf1be;</i></label>

        <!-- Whatsapp -->
        <label><input type="checkbox" name="opciones_control[]" value="whatsapp">
            <i style="font-size:24px" class="fa">&#xf232;</i></label>

        <!-- StackOverflow -->
        <label><input type="checkbox" name="opciones_control[]" value="stackoverflow">
            <i style="font-size:24px" class="fa">&#xf16c;</i></label>
    </fieldset>
    <fieldset>
        <!-- Behance -->
        <label><input type="checkbox" name="opciones_control[]" value="behance">
            <i style="font-size:24px" class="fa">&#xf17d;</i></label>

        <!-- Spotify -->
        <label><input type="checkbox" name="opciones_control[]" value="spotify">
            <i style="font-size:24px" class="fa">&#xf1bc;</i></label>

        <!-- Vimeo -->
        <label><input type="checkbox" name="opciones_control[]" value="vimeo">
            <i style="font-size:24px" class="fa">&#xf27d;</i></label>
    </fieldset>
    <button type="submit">Enviar</button>
    <button type="reset">Eliminar</button>
</form>

<script>
    document.querySelectorAll('input[type="checkbox"]').forEach(function (checkbox) {
        checkbox.addEventListener('change', function () {
            const maxSeleccionados = 5;
            const seleccionados = document.querySelectorAll('input[type="checkbox"]:checked').length;
            if (seleccionados > maxSeleccionados) {
                this.checked = false; // Desmarca el checkbox actual
                alert('Solo puedes seleccionar un máximo de ' + maxSeleccionados + ' iconos.');
            }
        });
    });
    /**
   * Elimina un ítem específico (<li>) de la lista mostrada.
   * Se llama desde el botón '×' junto a cada ítem.
   */
    function eliminarItemLista(botonEliminar) {
        const listItem = botonEliminar.parentElement; // El <li> es el padre del botón
        listItem.remove(); // Elimina el <li> del DOM
    }

    /**
     * Elimina la lista entera (<ul>) del DOM.
     */
    function eliminarListaEnteraDOM() {
        const lista = document.getElementById('lista-iconos-generada');
        if (lista) {
            lista.remove(); // Elimina el <ul> completo del DOM
        }
    }
</script>