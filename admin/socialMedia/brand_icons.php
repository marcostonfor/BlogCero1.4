<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
// Mover los includes al principio para que BASE_URL y el Singleton estén siempre disponibles.
require_once __DIR__ . '/../../router.php';
require_once ROOT_PATH . '/system_login/dbSingleton/databaseSingleton.php';

if (!isset($_SESSION['user_id'])) {
    die('No hay usuario logueado.');
}
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $iconosSeleccionados = isset($_POST['opciones_control']) ? $_POST['opciones_control'] : [];

    // Definiciones de iconos (nombre => [clase, unicode_hex])
    // Asegúrate de que estos coincidan con los 'value' de tus checkboxes
    // y que el unicode sea solo la parte hexadecimal (ej. 'f082' para Facebook).
    // Nota: Se asume Font Awesome 5+ debido al kit.fontawesome.com script.
    // El icono 'vine' ha sido eliminado en Font Awesome 5+.
    $iconDefinitions = [
        'facebook' => ['clase' => 'fa-brands fa-facebook-f'],
        'twitter' => ['clase' => 'fa-brands fa-twitter'],
        'instagram' => ['clase' => 'fa-brands fa-instagram'],
        'linkedin' => ['clase' => 'fa-brands fa-linkedin-in'],
        'github' => ['clase' => 'fa-brands fa-github'],
        'youtube' => ['clase' => 'fa-brands fa-youtube'],
        'pinterest' => ['clase' => 'fa-brands fa-pinterest'],
        'tumbler' => ['clase' => 'fa-brands fa-tumblr'],
        'flicker' => ['clase' => 'fa-brands fa-flickr'],
        'reddit' => ['clase' => 'fa-brands fa-reddit'],
        'skype' => ['clase' => 'fa-brands fa-skype'],
        'soundcloud' => ['clase' => 'fa-brands fa-soundcloud'],
        'whatsapp' => ['clase' => 'fa-brands fa-whatsapp'],
        'stackoverflow' => ['clase' => 'fa-brands fa-stack-overflow'],
        'behance' => ['clase' => 'fa-brands fa-behance'],
        'spotify' => ['clase' => 'fa-brands fa-spotify'],
        'vimeo' => ['clase' => 'fa-brands fa-vimeo-v'],
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
            $stmt = $pdo->prepare("
    INSERT INTO social_media (nombre, clase, publicado, user_id) 
    VALUES (:nombre, :clase, 1, :user_id) 
    ON DUPLICATE KEY UPDATE 
        clase = VALUES(clase), 
        publicado = 1,
        user_id = VALUES(user_id)
");
            foreach ($iconosSeleccionados as $nombreIcono) {
                if (isset($iconDefinitions[$nombreIcono])) {
                    $definicion = $iconDefinitions[$nombreIcono];
                    $stmt->execute([
                        ':nombre' => $nombreIcono,
                        ':clase' => $definicion['clase'],
                        ':user_id' => $user_id // Asegúrate de tener este valor disponible
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
<!-- Nota: El script de Font Awesome 5+ (kit) anula la hoja de estilos de FA 4.7.0.
     Se recomienda eliminar la línea de FA 4.7.0 si solo se usa el kit. -->
<form method="post" action="<?php echo BASE_URL; ?>/admin/socialMedia/brand_icons.php" class="social-media">
    <fieldset>
        <!-- Facebook -->
        <label><input type="checkbox" name="opciones_control[]" value="facebook">
            <i class="fa-brands fa-facebook-f"></i></label>

        <!-- Twitter -->
        <label><input type="checkbox" name="opciones_control[]" value="twitter">
            <i class="fa-brands fa-twitter"></i></label>

        <!-- Instagram -->
        <label><input type="checkbox" name="opciones_control[]" value="instagram">
            <i class="fa-brands fa-instagram"></i></label>

        <!-- Linkedin -->
        <label><input type="checkbox" name="opciones_control[]" value="linkedin">
            <i class="fa-brands fa-linkedin-in"></i></label>

        <!-- Git-Hub -->
        <label><input type="checkbox" name="opciones_control[]" value="github">
            <i class="fa-brands fa-github"></i></label>
    </fieldset>
    <fieldset>
        <!-- YouTube -->
        <label><input type="checkbox" name="opciones_control[]" value="youtube">
            <i class="fa-brands fa-youtube"></i></label>

        <!-- Pinterest -->
        <label><input type="checkbox" name="opciones_control[]" value="pinterest">
            <i class="fa-brands fa-pinterest"></i></label>

        <!-- Tumbler -->
        <label><input type="checkbox" name="opciones_control[]" value="tumbler">
            <i class="fa-brands fa-tumblr"></i></label>

        <!-- Flicker -->
        <label><input type="checkbox" name="opciones_control[]" value="flicker">
            <i class="fa-brands fa-flickr"></i></label>
        <!-- Nota: El icono 'Vine' fue eliminado en Font Awesome 5+. Si lo necesitas, considera usar una versión anterior de FA o un icono personalizado. -->
        <!-- <label><input type="checkbox" name="opciones_control[]" value="vine"><i class="fa-brands fa-vine"></i></label> -->
    </fieldset>
    <fieldset>
        <!-- Reddit -->
        <label><input type="checkbox" name="opciones_control[]" value="reddit">
            <i class="fa-brands fa-reddit"></i></label>

        <!-- Skype -->
        <label><input type="checkbox" name="opciones_control[]" value="skype">
            <i class="fa-brands fa-skype"></i></label>

        <!-- SoundCloud -->
        <label><input type="checkbox" name="opciones_control[]" value="soundcloud">
            <i class="fa-brands fa-soundcloud"></i></label>

        <!-- Whatsapp -->
        <label><input type="checkbox" name="opciones_control[]" value="whatsapp">
            <i class="fa-brands fa-whatsapp"></i></label>

        <!-- StackOverflow -->
        <label><input type="checkbox" name="opciones_control[]" value="stackoverflow">
            <i class="fa-brands fa-stack-overflow"></i></label>
    </fieldset>
    <fieldset>
        <!-- Behance -->
        <label><input type="checkbox" name="opciones_control[]" value="behance">
            <i class="fa-brands fa-behance"></i></label>

        <!-- Spotify -->
        <label><input type="checkbox" name="opciones_control[]" value="spotify">
            <i class="fa-brands fa-spotify"></i></label>

        <!-- Vimeo -->
        <label><input type="checkbox" name="opciones_control[]" value="vimeo">
            <i class="fa-brands fa-vimeo-v"></i></label>
    </fieldset>
    <button type="submit">Enviar</button>
    <button type="reset">Eliminar</button>
</form>
<script src="https://kit.fontawesome.com/539486a65b.js" crossorigin="anonymous"></script>
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