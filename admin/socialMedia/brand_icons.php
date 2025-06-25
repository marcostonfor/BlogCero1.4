<?php
// Este archivo ahora solo contiene el formulario HTML.
// La lógica de procesamiento se ha movido a 'procesar_iconos.php'.
?>
<!-- El formulario ahora envía los datos a un script de procesamiento dedicado -->
<form method="post" action="<?php echo BASE_URL; ?>/admin/socialMedia/procesar_iconos.php" class="social-media">
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