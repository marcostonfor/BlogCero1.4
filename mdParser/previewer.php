<?php
require_once __DIR__ . '/Parsedown.php';
require_once __DIR__ . '/../router.php';


/**
 * [Description Previewer]
 */
class Previewer
{ 
    
    /**
     * $Parsedown
     *
     * @var mixed
     */
    private $Parsedown;
    
    /**
     * $markdown
     *
     * @var string
     */
    private string $markdown = "";
    /**
     * $archivo
     *
     * @var string
     */
    private string $archivo;
    
    
    /**
     * __construct
     *
     * @param mixed $Parsedown
     * @param mixed $markdown
     */
    public function __construct($Parsedown, $markdown)
    {
        $this->Parsedown = $Parsedown;
        $this->markdown = $markdown;
    }

    public function __get($name)
    {
        if ($name === 'Parsedown') {
            return $this->Parsedown;
        } elseif ($name === 'markdown') {
            return $this->markdown;
        } elseif ($name === 'archivo') {
            return $this->archivo;
        }
        throw new Exception("Propiedad '$name' no definida");
    }

    public function __set($name, $value)
    {
        if ($name === 'Parsedown') {
            $this->Parsedown = $value;
        } elseif ($name === 'markdown') {
            $this->markdown = $value;
        } elseif ($name === 'archivo') {
            $this->archivo = $value;
        } else {
            throw new Exception("Propiedad '$name' no definida");
        }
    }
    
   
    /**
     * setArchivo
     *
     * @param string $archivo
     * 
     * @return void
     */
    public function setArchivo(string $archivo): void
    {
        $this->archivo = basename($archivo); // Seguridad: evitar rutas arbitrarias
    }
    
    
    /**
     * removeYamlFrontMatter
     *
     * @param mixed $markdown
     * 
     * @return string
     */
    function removeYamlFrontMatter($markdown): string
    {
        $this->markdown = $markdown;
        if (preg_match('/\A---\s*\R(.*?)\R---\s*\R?/s', $markdown, $matches)) {
            return substr($markdown, strlen($matches[0]));
        }
        return $markdown;
    }
    
   
    /**
     * rendermd
     *
     * @param mixed $file
     * 
     * @return string
     */
    public function rendermd($file): string
    {

        $file = __DIR__ . '/../MD/' . $file;

        if (!file_exists($file)) {
            throw new Exception("El archivo Markdown no existe: $file");
        }

        $mdFile = file_get_contents($file);
        $mdFile = $this->removeYamlFrontMatter($mdFile); // Limpieza aquí

        $this->Parsedown = new Parsedown();
        $view = $this->Parsedown->text($mdFile);
        $view = $this->Parsedown->text($mdFile);
        // Reescribe enlaces que apunten a archivos .md para redirigir al mismo script PHP
        $view = preg_replace_callback('/<a href="([^"]+\.md)">/', function ($match) {
            $archivo = urlencode($match[1]);
            return '<a href="usePreviewer.php?md=' . $archivo . '">';
        }, $view);

        return $view;

    }

}
