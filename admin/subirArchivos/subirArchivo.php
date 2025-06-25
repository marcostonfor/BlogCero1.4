<?php
require_once __DIR__ . '/../../router.php'; // Incluimos el router para tener BASE_URL

// Función para mostrar la estructura de directorios de forma recursiva
function mostrarEstructuraDirectorio($directorioRaiz, $subRutaActual = '')
{
    $htmlLista = '';
    $rutaAbsolutaActual = rtrim($directorioRaiz . DIRECTORY_SEPARATOR . $subRutaActual, DIRECTORY_SEPARATOR);

    // @ para suprimir warnings si el directorio no es legible, aunque $directorioRaiz ya está validado
    $elementos = @scandir($rutaAbsolutaActual);

    if ($elementos === false)
        return ''; // No se pudo leer el directorio

    $subdirectoriosEncontrados = false;
    foreach ($elementos as $elemento) {
        if ($elemento === '.' || $elemento === '..')
            continue;

        $rutaAbsolutaElemento = $rutaAbsolutaActual . DIRECTORY_SEPARATOR . $elemento;
        if (is_dir($rutaAbsolutaElemento)) {
            if (!$subdirectoriosEncontrados) {
                $htmlLista .= '<ul>';
                $subdirectoriosEncontrados = true;
            }
            $rutaRelativaParaMostrar = trim($subRutaActual . DIRECTORY_SEPARATOR . $elemento, DIRECTORY_SEPARATOR);
            $htmlLista .= '<li><i class="fa fa-folder"></i> ' . htmlspecialchars($rutaRelativaParaMostrar);
            $htmlLista .= mostrarEstructuraDirectorio($directorioRaiz, $rutaRelativaParaMostrar); // Llamada recursiva
            $htmlLista .= '</li>';
        }
    }
    if ($subdirectoriosEncontrados)
        $htmlLista .= '</ul>';
    return $htmlLista;
}
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css"
    integrity="sha512-1sCRPdkRXhBV2PBLUdRb4tMg1w2YPf37qatUFeS7zlBy7jJI8Lf4VHwWfZZfpXtYSLy85pkm9GaYVYMfw5BC1A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
    integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">


<!-- Este archivo ahora es un componente. La estructura HTML principal la proporciona dashboard.php -->
<div class="container">
    <div class="row mt-5">
        <div class="col-sm-12 col-md-5 subir">
            <form enctype="multipart/form-data" action="<?php echo BASE_URL; ?>/admin/subirArchivos/subida.php"
                method="POST">
                <input type="hidden" name="MAX_FILE_SIZE" value="30000000" />
                <h5><i class="fa fa-file"></i> Seleccione el archivo a subir: </h5>
                <hr />
                <input name="fichero_usuario[]" type="file" multiple />
                <button class="btn btn-success mt-2" type="submit"><i class="fa fa-upload"></i> Subir
                    Archivo</button>
            </form>
        </div>

        <div class="col-sm-12 col-md-6  archivos">
            <h5><i class="fa fa-archive "></i> Archivos cargados al servidor</h5>
            <hr />
            <?php $dir_subida = realpath(__DIR__ . '/../../MD/Subidasmd');
            $carpeta = glob($dir_subida . '/*.md');
            echo "<table class='table-responsive' border='1'>";
            echo "<tr>
				<th>
				<h6>Nombre del Archivo</h6>
				</th> 
				<th>
				<h6>Tamaño</h6>
				</th>
				</tr>";
            foreach ($carpeta as $archivo) {
                $nombre = basename($archivo);
                echo "<tr><td>$nombre</td><td>" . filesize($archivo) . " bytes</td></tr>";
            }
            echo "</table>";
            ?>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-md-6 moveFile"> <!-- Columna para el formulario de mover archivos -->
            <h5><i class="fa fa-share-square"></i> Mover archivo de Subidasmd/ a MD/</h5>
            <hr />
            <div id="moveFileIU">
                <form action="<?php echo BASE_URL; ?>/admin/MDExplorer/explorer.php" method="post" class="">
                    <div class="form-group">
                        <label for="nombre_archivo_mover">Nombre del archivo (en Subidasmd/):</label>
                        <input type="text" class="form-control" name="nombre" id="nombre_archivo_mover"
                            placeholder="ejemplo.md" required>
                    </div>
                    <div class="form-group">
                        <label for="ruta_destino">Ruta de destino (dentro de MD/, ej: subcarpeta1/sub2):</label>
                        <input type="text" class="form-control" name="path" id="ruta_destino"
                            placeholder="opcional, ej: docs/privado">
                    </div>
                    <input type="hidden" name="tipo" value="archivo">
                    <button type="submit" class="btn mt-2"><i class="fa fa-share-square"></i> Mover
                        Archivo</button>
                </form>
                <hr />
                <div class="col-md-6"> <!-- Columna para la estructura de directorios -->
                    <h5><i class="fa fa-sitemap"></i> Estructura de MD/ (para referencia)</h5>
                    <hr />
                    <div class="directorio-estructura">
                        <?php
                        $directorioDestinoBase = realpath(__DIR__ . '/../../MD');
                        if (isset($directorioDestinoBase) && is_dir($directorioDestinoBase)) {
                            echo mostrarEstructuraDirectorio($directorioDestinoBase);
                        } else {
                            echo "<p>No se pudo acceder al directorio base MD/ para mostrar la estructura.</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
    body {
        background-color: #f5e7d6;
    }

    .container {
        transform: scale(0.8, 0.8);
    }

    .btn {
        background-color: #dc143c;
    }

    .subir {
        border: 0.0625rem solid #8f6d74;
        padding: 1.25rem;
        width: auto;
        border-radius: 1rem;
        min-height: 15rem;
        margin: auto;
        background-color: #eb2d53;
        color: #99ccff;
        margin-bottom: 5px;
    }

    .archivos {
        border: 0.0625rem solid #89EA53;
        padding: 0.7rem;
        width: auto;
        min-height: 15rem;
        border-radius: 1rem;
        margin: auto;
        background-color: #00664d;
        color: antiquewhite;
    }

    .moveFile {
        border: 0.0625rem solid #4682b4;
        padding: 1rem;
        width: auto;
        min-height: 15rem;
        border-radius: 1rem;
        margin: auto;
        margin-bottom: 6rem;
        background-color: #000066;
        color: azure;
        text-align: center;
    }

    #moveFileIU {
        display: flex;
        justify-content: space-around;
        align-items: baseline;
    }

    #nombre_archivo_mover,
    #ruta_destino {
        width: 20vw;
    }

    .directorio-estructura {
        max-height: 300px;
        overflow-y: auto;
        border: 0.0625rem solid #ddd;
        padding: 0.7rem;
        border-radius: 1rem;
        background-color: rgb(187, 187, 219);
        margin-top: 2rem;
    }

    .directorio-estructura ul {
        list-style-type: none;
        padding-left: 1em;
        /* Indentación para subniveles */
    }

    .directorio-estructura>ul {
        /* Sin padding-left para el primer nivel */
        padding-left: 0;
    }

    .directorio-estructura li {
        padding: 2px 0;
    }
</style>