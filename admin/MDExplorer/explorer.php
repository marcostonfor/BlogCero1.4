<?php
/**
 * Script para mover archivos desde un directorio de subidas a un destino específico.
 *
 * Este script PHP está diseñado para ser llamado mediante una solicitud POST. Su función principal
 * es tomar un archivo, previamente subido al directorio 'MD/Subidasmd/', y moverlo a una
 * ubicación específica dentro del directorio 'MD/', potencialmente en un subdirectorio.
 *
 * Se implementan múltiples capas de validación y seguridad para asegurar la integridad
 * del sistema de archivos y prevenir operaciones no deseadas o maliciosas:
 * 1.  **Validación de Directorios Base**: Se verifica que los directorios raíz de origen
 *     (`$directorioRaiz`) y el directorio base de destino (`$directorioDestinoBase`)
 *     existan y sean efectivamente directorios.
 * 2.  **Sanitización de Rutas**: La función `limpiarRuta` se utiliza para procesar cualquier
 *     ruta proporcionada por el usuario (como el subdirectorio de destino). Esta función
 *     elimina componentes peligrosos como '..' (directorio padre) para prevenir ataques
 *     de Path Traversal.
 * 3.  **Validación del Archivo de Origen**: Se comprueba que el archivo a mover:
 *     a. Exista realmente.
 *     b. Sea un archivo regular (no un directorio u otro tipo).
 *     c. Esté estrictamente contenido dentro de `$directorioRaiz`. Esto se verifica
 *        comparando la ruta canónica del directorio del archivo con `$directorioRaiz`.
 * 4.  **Validación de la Ruta de Destino**: Se asegura que la ruta completa de destino:
 *     a. Esté estrictamente contenida dentro de `$directorioDestinoBase`.
 *     b. Si el directorio de destino no existe, se valida que la ruta padre del
 *        directorio a crear esté dentro de `$directorioDestinoBase` antes de intentar
 *        la creación.
 * 5.  **Creación Segura de Directorios**: Si el directorio de destino no existe, se intenta
 *     crear recursivamente. Después de la creación, se vuelve a validar que el directorio
 *     recién creado esté dentro de los límites permitidos.
 *
 * El script finaliza mostrando un mensaje de éxito o error y un enlace para volver.
 *
 * @package     BlogCero
 * @subpackage  MDExplorer
 * @since       1.0.0
 */

// Función auxiliar para redirigir con un mensaje
function redirigirConMensaje($mensaje)
{
    $_SESSION['flash_message'] = $mensaje;
    header("Location: " . BASE_URL . "/admin/dashboard.php#subidaPaginas");
    exit;
}
require_once __DIR__ . '/../../router.php';

/**
 * Sección de definición y validación de los directorios base utilizados por el script.
 * Estas rutas son fundamentales para las operaciones de archivos y se verifican al inicio.
 */

/**
 * @var string|false $directorioRaiz Ruta canónica absoluta del directorio de origen para los archivos subidos.
 *                                   Se espera que sea `__DIR__ . /../MD/Subidasmd`.
 *                                   `realpath()` devuelve `false` si la ruta no existe o no es accesible.
 */
$directorioRaíz = realpath(__DIR__ . '/../../MD/Subidasmd');
/**
 * @var string|false $directorioDestinoBase Ruta canónica absoluta del directorio base donde se moverán los archivos.
 *                                          Se espera que sea `__DIR__ . /../MD`.
 *                                          `realpath()` devuelve `false` si la ruta no existe o no es accesible.
 */
$directorioDestinoBase = realpath(__DIR__ . '/../../MD');
/**
 * Validación crítica inicial: Si los directorios base no son válidos, el script no puede continuar.
 */

if (!$directorioRaíz || !is_dir($directorioRaíz)) {
    /** Termina la ejecución si el directorio de origen no existe o no es un directorio. */
    redirigirConMensaje("❌ Error crítico: La carpeta de origen de subidas no es válida.");
}

if (!$directorioDestinoBase || !is_dir($directorioDestinoBase)) {
    /** Termina la ejecución si el directorio de destino base no existe o no es un directorio. */
    redirigirConMensaje("❌ Error crítico: La carpeta de destino base no es válida.");
}

/**
 * Limpia y sanitiza una cadena de ruta de directorio proporcionada por el usuario.
 *
 * Esta función es un componente de seguridad esencial. Su propósito es tomar una cadena
 * que representa una ruta (generalmente de `$_POST` o `$_GET`) y normalizarla de
 * una manera que prevenga ataques de Path Traversal.
 *
 * Cómo funciona:
 * 1. `trim($ruta, '/\\')`: Elimina cualquier barra diagonal (tanto `/` como `\`)
 *    al principio y al final de la cadena de ruta.
 * 2. `explode('/', $ruta)`: Divide la ruta en segmentos basados en la barra diagonal `/`.
 * 3. Itera sobre cada segmento:
 *    - Omite segmentos vacíos (resultantes de barras múltiples como `foo//bar`).
 *    - Omite segmentos que son `.` (directorio actual).
 *    - **Crucialmente, omite segmentos que son `..` (directorio padre). Esto es lo que
 *      previene que un atacante pueda navegar hacia arriba en la estructura de directorios
 *      (ej. `../../etc/passwd`).**
 * 4. `implode('/', $partesLimpias)`: Reconstruye la ruta usando solo los segmentos válidos.
 *
 * @param string $ruta La cadena de ruta de entrada, potencialmente insegura.
 * @return string La ruta sanitizada y segura. Si la entrada estaba vacía o solo contenía
 *                barras, se devuelve una cadena vacía.
 */
function limpiarRuta($ruta)
{
    // Elimina barras iniciales/finales y sanitiza componentes
    /** Paso 1: Eliminar barras diagonales al inicio y al final. */
    $ruta = trim($ruta, '/\\');
    if ($ruta === '') {
        /** Si después de trim, la ruta está vacía (ej. era solo "/" o ""), no hay más que hacer. */
        return ''; // Retorna cadena vacía si solo había barras
    }

    /** Paso 2: Dividir la ruta en sus componentes. */
    $partes = explode('/', $ruta);
    /** @var array $partesLimpias Array para almacenar los componentes válidos de la ruta. */
    $partesLimpias = [];
    /** Paso 3: Iterar sobre cada parte y filtrar las no deseadas. */
    foreach ($partes as $parte) {
        // Omite partes vacías (de barras múltiples) y '.' o '..'
        /**
         * Si la parte está vacía (ej. de 'a//b'), es el directorio actual '.',
         * o es el directorio padre '..', se ignora.
         */
        if ($parte === '' || $parte === '.' || $parte === '..') {
            continue; /** Saltar a la siguiente parte. */
        }
        /**
         * Opcional: Aquí se podría añadir una validación más estricta para los caracteres
         * permitidos en los nombres de directorio/archivo si fuera necesario.
         * Ejemplo: if (!preg_match('/^[a-zA-Z0-9_.-]+$/', $parte)) { continue; // o manejar error }
         */
        $partesLimpias[] = $parte; /** Añadir la parte válida al array. */
    }
    /** Paso 4: Reconstruir la ruta con los componentes limpios, unidos por '/'. */
    return implode('/', $partesLimpias);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $path = limpiarRuta($_POST['path'] ?? ''); // Subdirectorio de destino dentro de MD/
    $nombre = trim($_POST['nombre'] ?? ''); // Nombre del archivo a mover desde Subidasmd/
    $tipo = $_POST['tipo'] ?? '';
    /**
     * Subsección para la obtención y sanitización de parámetros de entrada desde la solicitud POST.
     */
    /**
     * @var string $path El subdirectorio de destino (relativo a `$directorioDestinoBase`)
     *                   proporcionado por el usuario a través de `$_POST['path']`.
     *                   Se sanitiza inmediatamente usando `limpiarRuta`.
     *                   Ejemplo de entrada: "documentos/reportes", "mi carpeta".
     *                   Ejemplo después de limpiarRuta: "documentos/reportes", "mi carpeta".
     *                   Si la entrada es "../fuera", limpiarRuta lo convertirá en "fuera".
     */

    /**
     * Verifica si el nombre del archivo está vacío o si el tipo no es 'archivo'.
     * 
     * - `$nombre === ''`: comprueba si no se ha enviado ningún nombre.
     * - `!in_array($tipo, ['archivo'])`: asegura que el valor de `$tipo` sea exactamente "archivo".
     * 
     * Si alguna de estas condiciones se cumple, significa que los datos recibidos no son válidos
     * y se interrumpe la ejecución del script con un mensaje de error.
     */

    if ($nombre === '' || !in_array($tipo, ['archivo'])) {
        redirigirConMensaje("❌ Parámetros inválidos para mover el archivo.");
    }

    $rutaOrigen = $directorioRaíz . '/' . $nombre;
    $rutaOrigenReal = realpath($rutaOrigen);
    if ($rutaOrigenReal === false || dirname($rutaOrigenReal) !== $directorioRaíz || !is_file($rutaOrigenReal)) {
        /**
         * Finaliza inmediatamente el script con el mensaje "Parámetros inválidos."
         * Esto impide que se siga ejecutando código si los datos no cumplen los requisitos.
         */
        redirigirConMensaje("❌ Archivo de origen no válido o no encontrado en 'Subidasmd/'.");
    }

    // Construir la ruta completa del directorio de destino prevista
    /** 
     * Construye la ruta completa del directorio de destino.
     * Si se proporciona un subdirectorio en `$path`, se agrega a la ruta base.
     */
    $intendedDestDir = $directorioDestinoBase;
    if ($path !== '') {
        $intendedDestDir .= '/' . $path;
    }

    // Seguridad: Verificar que el directorio de destino previsto está dentro del directorio base de destino
    // Obtener la ruta real del directorio de destino previsto
    /** 
     * Obtiene la ruta absoluta (resuelta) del directorio de destino previsto
     * para prevenir rutas relativas maliciosas o enlaces simbólicos.
     */
    $realDestDir = realpath($intendedDestDir);

    /**
     * Valida que la ruta real exista y esté dentro del directorio base permitido.
     * Esto evita acceder fuera del contenedor autorizado de archivos.
     */
    if ($realDestDir === false || strpos($realDestDir, $directorioDestinoBase) !== 0) {
        redirigirConMensaje("❌ Ruta de destino inválida o fuera de la carpeta permitida.");
    }

    // Asegurarse de que el directorio de destino existe (crearlo si es necesario)
    /**
     * Si el directorio no existe, intenta crearlo con permisos seguros.
     * Luego revalida la ruta real en caso de manipulaciones entre `mkdir` y `realpath`.
     */
    if (!is_dir($realDestDir)) {
        // Usar creación recursiva y establecer permisos apropiadamente
        if (!mkdir($intendedDestDir, 0755, true)) {
            redirigirConMensaje("❌ Error al crear la carpeta de destino.");
        }
        // Después de la creación, verificar nuevamente realpath en caso de condiciones de carrera o ataques de symlink durante mkdir
        $realDestDir = realpath($intendedDestDir);
        if ($realDestDir === false || strpos($realDestDir, $directorioDestinoBase) !== 0) {
            redirigirConMensaje("❌ Error de seguridad post-creación de carpeta.");
        }
    }

    // Construir la ruta de destino final usando el directorio de destino real validado
    /**
     * Construye la ruta destino final del archivo, asegurando que está dentro del entorno validado.
     */
    $rutaDestino = $realDestDir . '/' . $nombre;

    // Realizar la operación de movimiento
    // Opcional: Verificar si el archivo de destino ya existe
    // if (file_exists($rutaDestino)) {
    //     die("El archivo de destino ya existe.");
    // }

    /**
     * Mueve el archivo desde la ubicación de origen validada a la ruta destino.
     * Informa el resultado mediante un mensaje HTML.
     */

    if (rename($rutaOrigenReal, $rutaDestino)) {
        $mensaje = "✅ Archivo movido con éxito a: " . htmlspecialchars($rutaDestino);
    } else {
        // Verificar errores específicos si es posible (ej. permisos)
        $mensaje = "❌ Error al mover el archivo. Verifique permisos o si el archivo ya existe.";
    }
    // Redirigir de vuelta al dashboard con el mensaje de resultado
    redirigirConMensaje($mensaje);
}
