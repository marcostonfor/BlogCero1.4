<?php

function getIcon($item, $fullPath)
{
    if (is_dir($fullPath)) {
        return "&#x1f4c2;"; // Carpeta abierta
    }

    $extension = pathinfo($item, PATHINFO_EXTENSION);

    // Iconos según la extensión
    switch (strtolower($extension)) {
        case 'txt':
            return "&#x1f4dc;"; // Documento
        case 'md':
            return "<i class='fa-brands fa-markdown'></i>";
        case 'png':
        case 'jpg':
        case 'jpeg':
        case 'svg':
            return "<i class='fa-solid fa-image'></i>"; // Imagen
        case 'php':
            return "<i class='fa-solid fa-file-code'></i>";
        case 'html':
        case 'js':
        case 'css':
            return "<i class='fa-solid fa-code'></i>"; // Código
        default:
            return "&#x1f4c4;"; // Archivo genérico
    }
}

// Obtener el directorio actual
$currentDir = isset($_GET['dir']) ? realpath($_GET['dir']) : getcwd();

if (!$currentDir || !is_dir($currentDir)) {
    die("Directorio no válido.");
}

// Escanear el directorio
$items = scandir($currentDir);

echo "<h4>Víendo: &#x1f440; " . htmlspecialchars($currentDir) . "</h4>";


echo "<div class='grid-container'>";
foreach ($items as $item) {
    if ($item === '.' || $item === '..')
        continue;
    $fullPath = $currentDir . DIRECTORY_SEPARATOR . $item;
    $icon = getIcon($item, $fullPath);

    echo "<div class='grid-item'>";
    echo "<div class='icon'>$icon</div>";
    if (is_dir($fullPath)) {
        echo "<a href='?dir=" . urlencode($fullPath) . "'>$item</a>";
    } else {
        $urlPath = str_replace($_SERVER['DOCUMENT_ROOT'], '', $fullPath);
        echo "<a href='$urlPath'>$item</a>";
    }
    echo "</div>";
}
echo "</div>";

echo "<style>";
echo "
    h4 {
        font-size: 12pt;
        width: fit-content;
        margin: 3vh 1vw;
        text-shadow: 0.1vw 0.1vw 3px hsl(19, 100%, 50%);
    }
    .grid-container {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 10px;
        width: 85%;
        margin: auto auto;
    }
    .grid-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 10px;
        text-align: center;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
        transition: transform 0.2s, background-color 0.2s;
    }
    .grid-item:hover {
        transform: scale(1.05);
        background-color: #eaeaea;
    }
    .icon {
        font-size: 2rem;
        margin-bottom: 10px;
    }
    a {
        text-decoration: none;
        color: #007bff;
        font-weight: bold;
    }
    a:hover {
        text-decoration: underline;
    }
    .back-link {
        display: block;
        margin: 20px 0;
        text-align: left;
    }
";
echo "</style>";

echo "<script src='https://kit.fontawesome.com/fa49ba9e26.js' crossorigin='anonymous'></script>";